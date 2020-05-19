<?php

namespace App\Controller;

use App\Entity\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
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
     * @Route("/account/{id}", name="account_details")
     */
    public function show($id) {

        $account = $this->getDoctrine()->getRepository(Account::class)->find($id);

        return $this->render('accounts/account_details.html.twig', [
            'account' => $account
        ]);

    }

}
