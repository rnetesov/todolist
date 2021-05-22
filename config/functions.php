<?php

function d($var,$caller=null)
{
    if(!isset($caller)){
        $array = debug_backtrace(1);
        $caller = array_shift($array);
    }
    echo '<code>File: '.$caller['file'].' / Line: '.$caller['line'].'</code>';
    echo '<pre>';
    yii\helpers\VarDumper::dump($var, 10, true);
    echo '</pre>';
}

function dd($var)
{
    $array = debug_backtrace(1);
    $caller = array_shift($array);
    d($var,$caller);
    die();
}