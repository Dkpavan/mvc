<?php

class Model_Core_Session  
{
    protected $nameSpace = 'Core';

    public function __construct()
    {
        $this->sessionStart();
        $this->setNameSpace('Core');
    }

    public function setNameSpace($nameSpace)
    {
        $this->nameSpace = $nameSpace;
        return $this;
    }

    public function resetNameSpace()
    {
        $_SESSION[$this->getNameSpace()] = [];
        return $this;
    }

    public function getNameSpace()
    {
        return $this->nameSpace;
    }

    public function sessionStart()
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        return $this;
    }

    public function sessionDestroy()
    {
        session_destroy();
        return $this;
    }

    public function __set($key, $value)
    {
        $_SESSION[$this->getNameSpace()][$key] = $value;
        return $this;
    }

    public function __get($key)
    {
        if(!array_key_exists($key,$_SESSION[$this->getNameSpace()])){
            return false;
        }
        return $_SESSION[$this->getNameSpace()][$key];
    }

    public function __unset($key)
    {
        if(array_key_exists($key,$_SESSION[$this->getNameSpace()])){
           unset($_SESSION[$this->getNameSpace()][$key]);
        }
        return $this;
    }

    public function getId()
    {
        return session_id();
    }

  




}
