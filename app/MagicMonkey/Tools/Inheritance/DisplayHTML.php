<?php

namespace MagicMonkey\Tools\Inheritance;

/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 24/02/2017
 * Time: 10:11
 */

abstract class DisplayHTML
{
    protected $startContent;
    protected $endContent;

    protected function __construct()
    {
        $this->startContent = "<div class='row'><div class='cell-12'>";
        $this->endContent = "</div></div>";
    }

    public function listAll($dataList, $htmlPath)
    {
        return $this->createView($dataList, $htmlPath);
    }

    /* show one */
    public function showOne($dataObj, $htmlPath)
    {
        return $this->createView($dataObj, $htmlPath);

    }

    private function createView($data, $htmlPath){
        ob_start();
        $fullPath = APP_BASEFILE . DIRECTORY_SEPARATOR . $htmlPath;
        include $fullPath;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /* action not found */
    public function notFound()
    {
        ob_start();
        include 'ui/commonViews/not-found.html';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
