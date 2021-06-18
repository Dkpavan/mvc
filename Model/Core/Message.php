<?php

Ccc::loadFile("Model/Core/Session.php");

class Model_Core_Message
{
    protected $session = null;

    public function setSession()
    {
        $this->session = new Model_Core_Session();
        return $this;
    }
    
    public function getSession()
    {
        if(!$this->session){
            $this->setSession();
        }
        return $this->session;
    }

    public function setSuccess($massage)
    {
        $this->success = $massage;
        return $this;
        
    }

    
    public function getSuccess()
    {
        return $this->success;
    }
    
    public function clearSuccess()
    {
        unset($this->success);
        return $this;
    }

    public function setFailure($failure)
    {
        $this->failure = $failure;
        return $this;
    }

    public function getFailure()
    {
        return $this->failure;
    }

    public function clearFailure()
    {
        unset($this->failure);
        return $this;
    }

    public function setNotice($notice)
    {
        $this->notice = $notice;
        return $this;
    }

    public function getNotice()
    {
        return $this->notice;
    }

    public function clearNotice()
    {
        unset($this->notice);
        return $this;
    }

}


