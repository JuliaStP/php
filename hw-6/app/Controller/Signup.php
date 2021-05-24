<?php

namespace App\Controller;

use Base\AbstractController;

class Signup extends AbstractController
{
    public function index()
    {
        return $this->view->render('signup.phtml');
    }
}