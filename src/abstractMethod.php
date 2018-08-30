<?php
namespace Esmi\WebMethod;

include_once "iMethod.php";
include_once "methodUtils.php";

interface allMethod {
    public function allMethod();
}

abstract class abstractMethod implements IMethod, allMethod{
    use methodUtils;
}
