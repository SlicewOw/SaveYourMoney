<?php

namespace App\Controller;

use App\Entity\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
