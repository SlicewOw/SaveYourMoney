<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\FinancialMovement;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TransactionsController extends AbstractController
{

    /**
     * @Route("/transactions/{id}", name="account_transactions")
     */
    public function index($id)
    {

        $account = $this->getAccountById($id);

        $transactions = $this->getDoctrine()->getRepository(FinancialMovement::class)->findBy(
            ['account_id' => $id],
            ['date' => 'DESC']
        );

        return $this->render('transactions/index.html.twig', [
            'account' => $account,
            'transactions' => $transactions
        ]);

    }

    private function getAccountById($id) {
        return $this->getDoctrine()->getRepository(Account::class)->find($id);
    }

}
