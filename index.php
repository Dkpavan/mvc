<?php 

include "Controller/Core/Front.php";


 class Ccc  
 {
    public static function init()
    {
        Controller_Core_Front::init();
    }

    public static function loadFile($file)
    {
        require_once getcwd()."/".$file;

    }
 }
 
 Ccc::init();
