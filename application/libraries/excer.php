<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/libraries/make.php"; 
 
class Excer extends Make { 
    function __construct($config=array()){
        if (count($config) > 0){
			$this->initialize($config);
		}
    }
    function initialize($config = array()){
		foreach ($config as $key => $val){
			if (isset($this->$key)){
				$this->$key = $val;
			}
		}
	}
	function sample(){
		
	}
}