<?php
require __DIR__ . '/../vendor/autoload.php';

use Esmi\EsMethod;

class ex1 implements \Esmi\EsMethod\IMethod {

    use \Esmi\esMethod\methodUtils;
    //use methodUtils;
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
