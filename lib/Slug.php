<?php

class Slug {
    public static function generate($str, $replace=array(), $delimiter='-')
    {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $text = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $text);
        $text = strtolower(trim($text, '-'));
        $text = preg_replace("/[\/_|+ -]+/", $delimiter, $text);
        
        if(substr($text, -1) == '-') {
            $text = trim($text, '-');
        }
        return $text;
    }
}