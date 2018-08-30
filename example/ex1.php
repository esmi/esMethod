<?php
//require __DIR__ . '/vendor/autoload.php';
include_once "../src/abstractMethod.php";
include_once "../src/iMethod.php";
include_once "../src/method.php";
include_once "../src/methodUtils.php";

class ex1 implements IMethod {

    use methodUtils;
    function echo1($r) {
        return ($r);
    }
    function getdata($r) {
        return array(
            "status" => 'OK',
            'data' => 'this is data.'
        );
    }

    function allMethod() {
        return  array(
            array("method" => "echo1", "format" => "json", "data"),
			array("method" => "getdata", "format" => "json", "data"),

			//end element:
			array("method" => "notrun" )
        );
    }
}
?>
