<?php
/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 10/02/2017
 * Time: 09:27
 */

namespace MagicMonkey\MiniJournal\Topical;

use MagicMonkey\Tools\HttpFoundation\Request;
use MagicMonkey\Tools\HttpFoundation\Response;
use MagicMonkey\Tools\Inheritance\BaseController;

class TopicalController extends BaseController
{

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }
}
