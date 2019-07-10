<?php

namespace src\controllers;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends BaseController
{
    public function index()
    {
        $response = new RedirectResponse('/docs/index.html');
        $response->send();
    }
}
