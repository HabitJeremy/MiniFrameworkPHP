<?php

namespace MagicMonkey\Framework\Tool\Cleaner;

/**
 * Class Cleaner
 * @package MagicMonkey\Framework\Tool\Cleaner
 */
class Cleaner
{
    /**
     * @param $array
     */
    public function cleaningToInsert(&$array)
    {
        foreach ($array as $key => $value) {
            //$array[$key] = nl2br(trim(strip_tags(htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false))));
            if ($value != null) {
                $array[$key] = nl2br(trim(strip_tags($value)));
            }
        }
    }
}
