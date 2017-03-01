<?php

namespace MagicMonkey\Framework\Inheritance;

abstract class AbstractHtml
{

    protected function __construct()
    {
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

    private function createView($data, $htmlPath)
    {
        ob_start();
        $fullPath = APP_BASEFILE . DS . $htmlPath;
        include $fullPath;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /* action not found */
    public function notFound()
    {
        http_response_code(404);
        ob_start();
        include 'ui/layout/commonViews/not-found.html';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
