<?php
include_once "iMethod.php";
class Method {

	protected $params;
	protected $data;

	function __construct( $a = null) {
		// $a:
		// example $a = array ( "method" => "chartdata", "devices", "startdate", "enddate", "type");

		if ( $a ) {
			$this->param = $a;
			$data = array();
			$method = $a["method"];
			$count = count($a);

			foreach ( $a as $key => $value) {
				if ( is_numeric($key) ) {
					$key = $value;
					$value = isset($_REQUEST[$value]) ? $_REQUEST[$value] : null;
				}
				else {
					$value = isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
				}
				$data[$key] = $value;
			}
			$this->data = $data;
		}
	}

	function getData() {
		return $this->data;
	}

	function getOption($option) {
		if (!empty($this->data[$option])) {
			return $this->data[$option];
		}
		else
			return null;
	}
	function setOption($option, $data) {
		if (!empty($this->data[$option])) {
			$this->data[$option] = $data;
		}
	}
	function getMethod() {
		if ( $this->data == null ) {
			return (isset($_REQUEST["method"]) ? $_REQUEST["method"] : null);
		}
		else {
			return empty($this->data["method"]) ? null : $this->data["method"];
		}
	}
    function runMethod(iMethod $cls) {
    //function runMethod($cls) {
        if ( $this->param ) {
            $d = $this->getData();
            $method = $this->param["method"];
            //echo "runMethod's d:";
            //var_dump($d);
            return $cls->$method($d);
        }
        else {
            return null;
        }
    }
}

?>