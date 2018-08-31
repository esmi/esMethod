<?php
require __DIR__ . '/../vendor/autoload.php';

include_once "ex1.php";

$cls = new ex1();
$_REQUEST['method'] = "echo1";
$_REQUEST['data'] = array(
    'data1' => "data1",
    'data2' => 'data2'
);
$cls->run();
//echo test
?>
