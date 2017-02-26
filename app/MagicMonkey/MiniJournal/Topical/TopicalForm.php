<?php
/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 06/02/2017
 * Time: 15:46
 */

namespace MagicMonkey\MiniJournal\Topical;

use MagicMonkey\Tools\Inheritance\BaseForm;

class TopicalForm extends BaseForm
{
    const LSTVALIDSTATUS = array("brouillon", "publie");

    protected $topical;

    public function __construct()
    {
        parent::__construct("topical");
        $this->topical = new Topical();
    }
}
