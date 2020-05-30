<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\FinancialMovement;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccountsController extends AbstractController
{
    /**
     * @Route("/accounts", name="accounts")
     */
    public function index()
    {

        $accounts = $this->getDoctrine()->getRepository(Account::class)->findAll();

        return $this->render('accounts/index.html.twig', [
            'controller_name' => 'AccountsController',
            'accounts' => $accounts
        ]);

    }

    /**
     * @Route("/account/new"), name="new_account"
     * @Method({"GET", "POST"})
     */
    public function new(Request $request) {

        $account = new Account();

        $form_builder = $this->createFormBuilder($account);
        $form_builder->add(
            'account_name',
            TextType::class,
            array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Name of the account (e.g. Giro)'
                ),
                'required' => true
            )
        );
        $form_builder->add(
            'start_amount',
            NumberType::class,
            array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => '12.345 EUR'
                ),
                'required' => false
            )
        );
        $form_builder->add(
            'save',
            SubmitType::class,
            array(
                'label' => 'Save new account',
                'attr' => array('class' => 'btn btn-success')
            )
        );

        $form = $form_builder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $account = $form->getData();
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($account);
            $entity_manager->flush();

            return $this->redirectToRoute("accounts");

        }

        return $this->render('accounts/new_account.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/account/edit/{id}"), name="edit_account"
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {

        $account = $this->getAccountById($id);

        $form_builder = $this->createFormBuilder($account);
        $form_builder->add(
            'account_name',
            TextType::class,
            array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Name of the account (e.g. Giro)'
                ),
                'required' => true
            )
        );
        $form_builder->add(
            'start_amount',
            NumberType::class,
            array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => '12.345 EUR'
                ),
                'required' => true
            )
        );
        $form_builder->add(
            'save',
            SubmitType::class,
            array(
                'label' => 'Update account',
                'attr' => array('class' => 'btn btn-success')
            )
        );

        $form = $form_builder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->flush();

            return $this->redirectToRoute("accounts");

        }

        return $this->render('accounts/edit_account.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/account/delete/{id}", name="delete_account")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {

        $account = $this->getAccountById($id);

        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->remove($account);
        $entity_manager->flush();

        $response = new Response();
        $response->send();

    }

    /**
     * @Route("/account/transaction/{id}", name="account_transaction")
     * @Method({"GET", "POST"})
     */
    public function transaction(Request $request, $id) {

        $transaction = new FinancialMovement();
        $account = $this->getAccountById($id);

        $datetime_format = 'Y-m-d';
        $today = date($datetime_format);

        $transaction->setDateToToday();

        $form_builder = $this->createFormBuilder($transaction);
        $form_builder->add(
            'date',
            DateType::class,
            array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => $today
                ),
                'required' => true,
                'widget' => 'single_text',
                'input' => 'datetime'
            )
        );
        $form_builder->add(
            'amount',
            NumberType::class,
            array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => '0.00 EUR',
                    'min' => 0.01,
                ),
                'required' => true
            )
        );
        $form_builder->add(
            'category',
            TextType::class,
            array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Category of transaction (e.g. AmazonPrime)'
                ),
                'required' => true
            )
        );
        $form_builder->add(
            'account_id',
            HiddenType::class,
            array(
                'data' => $account->getId()
            )
        );
        $form_builder->add(
            'save',
            SubmitType::class,
            array(
                'label' => 'Save transaction',
                'attr' => array('class' => 'btn btn-success')
            )
        );

        $form = $form_builder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $transaction = $form->getData();
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($transaction);
            $entity_manager->flush();

            return $this->redirectToRoute('accounts');

        }

        return $this->render('accounts/new_transaction.html.twig', array(
            'form' => $form->createView(),
            'account' => $account
        ));

    }

    /**
     * @Route("/account/{id}", name="account_details")
     */
    public function show($id) {

        $account = $this->getAccountById($id);

        $transactions = $this->getDoctrine()->getRepository(FinancialMovement::class)->findBy(
            ['account_id' => $id]
        );

        $income = 0;
        $outcome = 0;
        foreach ($transactions as $transaction) {

            $amount = $transaction->getAmount();
            if ($amount < 0) {
                $outcome += $amount;
            } else {
                $income += $amount;
            }

        }

        $balance = $income + $outcome;

        return $this->render('accounts/account_details.html.twig', [
            'account' => $account,
            'transactions' => $this->getTransactionsByAccountId($id),
            'income' => $income,
            'outcome' => $outcome,
            'balance' => $balance,
            'current_month' => date('F'),
            'income_of_current_month_per_day' => implode(',', array(rand(1, 100), rand(1, 100), rand(1, 100))),
            'outcome_of_current_month_per_day' => implode(',', array(rand(1, 100), rand(1, 100), rand(1, 100)))
        ]);

    }

    private function getTransactionsByAccountId($account_id, $limit=10) {

        return $this->getDoctrine()->getRepository(FinancialMovement::class)->findBy(
            ['account_id' => $account_id],
            ['date' => 'DESC'],
            $limit,
            0
        );

    }

    private function getAccountById($id) {
        return $this->getDoctrine()->getRepository(Account::class)->find($id);
    }

}
