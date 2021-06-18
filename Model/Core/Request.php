<?php

class Model_Core_Request  
{
    
    public function getPost($key = null, $default = null)
    {
        if($key == null){
            return $_POST;
        }

        if(!array_key_exists($key,$_POST)){
            return $default;
        }
        
        return $_POST[$key];    
    }
    

    public function getParams($key = null, $default = null)
    {
       if($key == null){
           return $_GET;
       }
       
       if(!array_key_exists($key,$_GET)){
            return $default;
        }
          
        return $_GET[$key];
    }

    public function getControllerName()
    {
        return $this->getParams('c','index');
    }

    public function getActionName()
    {
        return $this->getParams('a','index');
    }

    public function isPost()
    {
        if(!isset($_SERVER['REQUEST_METHOD']) == 'post'){
            return false;
        }
        return true;
    }

    public function isGet()
    {
        if($_SERVER['REQUEST_METHOD'] != 'GET'){
            return false;
        }
        return true;
    }
       
}
