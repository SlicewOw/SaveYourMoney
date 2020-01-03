<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route(
     *    "/account/{account_id}",
     *    name="account",
     *    requirements={"account_id" = "[0-9]+"}
     * )
     */
    public function index($account_id = null)
    {

        if (is_null($account_id)) {
            $account_id = 'unknown account id';
        }

        return $this->render('account/index.html.twig', [
            'account_id' => $account_id
        ]);
    }
}
