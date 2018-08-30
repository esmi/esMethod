<?php
//require __DIR__ . '/vendor/autoload.php';
include_once "../src/iMethod.php";
include_once "../src/method.php";
include_once "../src/methodUtils.php";


class ex1 {

    use methodUtils;
    function echo($r) {
        var_dump($r);
        return ($r);
    }
    function get_data($r) {
        return array(
            "status" => 'OK',
            'data' => 'this is data.'
        );
    }

    function allMethod() {
        return  [
            ["method" => "echo", "format" => "json", "data"],
			["method" => "get_data", "format" => "json", "data"],

			//end element:
			["method" => "notrun" ]
        ];
    }
    function status($try=false) {
        if ($try)
            return parent::status();
        else
            return true;
        //return parent::status();
    }
    function error() {
        return parent::error();
    }
}
?>
