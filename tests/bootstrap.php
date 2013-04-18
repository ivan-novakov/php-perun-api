<?php
require __DIR__ . '/../vendor/autoload.php';

define('TESTS_ROOT_DIR', __DIR__);

//----------
function _dump($value)
{
    error_log(print_r($value, true));
}