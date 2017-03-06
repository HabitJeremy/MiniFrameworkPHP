<?php

namespace MagicMonkey\MiniJournal\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Inheritance\AbstractController;

/**
 * Class PageController
 * @package MagicMonkey\MiniJournal\Controller
 */
class PageController extends AbstractController
{
    /**
     * IndexController constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Permet d'afficher la page "a propos"
     */
    public function about()
    {
        $this->render("page/vAbout.html.twig");
    }
}
