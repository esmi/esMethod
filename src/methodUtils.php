<?php
namespace Esmi\WebMethod;

trait methodUtils
{
    function format($r, $res) {
        if (isset($r['format'])) {
            $format = $r['format'];
            switch ($format) {
                case 'json': $res = json_encode($res); break;
                default:
            }
            return $res;
        }
        else {
            return $res;
        }
    }
    function echo2($r, $target) {
        if (isset($r['format'])) {
            $format = $r['format'];
            if ( isset($r['echo'])) {
            	$echo = $r['echo'];
            	if ( $echo )
		            $this->echoTarget($target, $format);

            }
            else {

	            $this->echoTarget($target, $format);
            }
        }
        else {
        }

    }
    //
    // isEcho:
    //	$a = $cls->run();
	//	
	//	$r = $cls->getMethod();
	//	if ( !($cls->isEcho($r)))
	//				 ^^^^^^^^^^
	//		$cls->echoTarget($a, 'json');
	//
    function isEcho($r=null) {
    	if (!$r) {
    		$r = $this->getMethod();
    	}
        if (isset($r['echo'])) {
        	return $r['echo'];
        }
        else
        	return true;

    }
	/*
		if dont echo
		$r = $cls->getMethod();

		// $cls->setEcho() usage:
		$r = $cls->setEcho(); 	// set echo to true,
		$r = $cls->setEcho($r); // set echo to true.
		$r = $cls->setEcho($r,false) // set echo to false.

		// save run result.
		$r = $cls->setEcho($r,false) // set echo to false.
		$a = $cls->run();
		$target['data1'] = $a;
	*/    
    function setEcho($r=null,$f=true) {
    	if (!$r) {
    		$r = $this->getMethod();
    	}
    	$r['echo'] = $f;
    	return $r;
    }
    function echoTarget($target, $format) {

        $type = gettype($target);

        if ($format == "json") {
            switch ($type) {

                case "boolean":
                case "integer":
                case "double":
                case "string":
                        echo $target; break;
                case "array":
                        echo json_encode($target); break;
                case "object":
                case "resource":
                case "NULL":
                case "unknown type":
                        echo "target is [" . $type . "]"; break;
                default:
            }
        }
        if ($format == "buffer") {
            switch ($type) {

                case "array":
                        if (isset($target['buffer']))
                            echo $target['buffer']; 
                        else {
                            //echo "target['buffer] in not set....";
                            //var_dump( $target);
                            echo json_encode($target);

                        }

                        break;
                case "boolean":
                case "integer":
                case "double":
                case "string":
                case "array":
                case "object":
                case "resource":
                case "NULL":
                case "unknown type":
                        echo "target type is [" . $type . "], not support 'buffer' format"; break;
                default:
            }
        }
    }
    function getMethod($rq=null) {
    	if (!$rq) {
            if (!isset($_SERVER["HTTP_HOST"])) {
                echo $argv[1] . "\r\n";
                parse_str($argv[1], $_GET);
                parse_str($argv[1], $_POST);
            }
    		$rq = $_REQUEST['method'];
            var_dump($_GET);
            var_dump($_POST);
            var_dump($_REQUEST);
    	}
        foreach( $this->allMethod() as $r ) {
            if ( isset($r['method'])) {
                if ($r['method'] == $rq ) {
                    return $r;
                }
            }
            else
                break;
        }
        return null;
    }
    function error($err=null) {
    	if ( !$err ) {
			return ['status' => 'error', 'message' => '有錯誤發生' ];
    	}
		else
			return [ 'status' => 'error', 'message' => $err];
    }

    function status() 	 {  return true;    }


    //---->>>> impletement: iMethod's method():
    function method($rq) {	return $this->runMethod($rq);    }


    function runMethod($rq) {
        foreach( $this->allMethod() as $r ) {
            if ($r['method'] == $rq ) {
                $m = new Method($r);
                $res = $m->runMethod($this);
                return $res;
            }
        }
        return ['status' => 'error', 'message' =>"No such method:{$r['method']}"];
    }

    function run() {

		if ( $this->status() ) {

			$rq = isset( $_REQUEST['method']) ? $_REQUEST['method'] : '';
			$r = $this->getMethod($rq);
			//var_dump($r);
			//var_dump($rq);
			if ($r) {

				$res =  $this->method($rq);
				//var_dump($res);
				if ($res) {
					if (isset($r['format']))
						$this->echo2($r, $res);
				}
				else {
					$d = $r['method'];
					$t = gettype($res);
					$c = get_class($this);
					$msg = "class[$c],method[$d]: return type($t)";
					$isEcho =  (isset($r['echo'])) ? $r['echo']: true;
					
					if ( $isEcho )
						$this->echo2(["format" => 'json'], $this->error( $msg ));
				}
				return $res;
			}
			else {
				// not such method defined in class:
				$c = get_class($this);
				$res = [
						'status' => "No such method", 
						"message" => ("can't run '". $rq . "', method not defined in $c::allMethod().")
					];
				$this->echo2(["format" => 'json'], $res);
				return $res;

			}
		}
		else {
		    $msg = "class[" . get_class($this) . "]: status() return false";
			$res = $this->error($msg);
			$this->echo2(["format" => 'json'], $res);
		}
		return $res;
    }

}
?>