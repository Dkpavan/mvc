<?php 

Ccc::loadFile("Model/Payment.php");
Ccc::loadFile("Controller/Core/Abstract.php");
 
class Controller_Payment extends Controller_Core_Abstract
{ 
    protected $payments = [];
    protected $payment = null;
    public function setPayments($payments = null)
    {
        if(!$payments){
            $payment = new Model_Payment();
            $payments = $payment->fetchAll("SELECT * from `payment`"); 
       }
        $this->payments = $payments;
        return $this;
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function setPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }

    public function getPayment()
    {
        return $this->payment;
    }

    public function gridAction()
    {
        $this->setPayments();
        require "View/payment/grid.phtml";
    }

    public function addAction()
    {
        try {
            $payment = new Model_Payment();
            $this->setPayment($payment);

            require "View/payment/form.phtml";

        }
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
            
        }
    }

    public function editAction()
    {
        try {
            $id = $this->getRequest()->getParams('id');
            $payment = new Model_Payment();
            $payment = $payment->load($id);

            if(!$payment->getId()){
                throw new Exception("Invalid Id", 1);     
            }
            $this->setPayment($payment);
            require "View/payment/form.phtml";
            
        } 
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
           
        }      
    }

    public function saveAction()
    {
        try {
            if(!$this->getRequest()->isPost()){
                throw new Exception("Invalid request", 1);
            }

            $postData = $this->getRequest()->getPost('payment');
            if(!$postData){
                throw new Exception("No data Posted", 1);
            }

            $id =   $this->getRequest()->getParams('id');
            $payment = new Model_Payment();
            if($id){
                $payment = $payment->load($id);

                if(!$payment->getId()){
                    throw new Exceptionta("No Id found", 1);
                }

            }
            else{
                $payment->createdDate = date('Y-m-d H:i:s');
            }

            $Payment['methodId'] = $id;
            $paymentData = array_merge($postData,$Payment);
            $payment->setData($paymentData);
           
            if($payment->save()){

                if($id){
                    $this->getMessage()->setSuccess("Updated Successfully");
                }
                else{
                    $this->getMessage()->setSuccess("Insert Successfully");
                }
            }
            else{
                if($id){
                    $this->getMessage()->setFailure("Unable to Update ");
                }
                else{
                    $this->getMessage()->setFailure("Unable to Insert");
                }
            }
            $this->redirect('grid');
        } 
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
        }
    }

    public function deleteAction()
    {
        try {
            $id = $this->getRequest()->getParams('id');
            $payment = new Model_Payment();
            $payment = $payment->load($id);
            if(!$payment->getId()){
                throw new Exception("Record not found", 1);
            }
            if($payment->delete()){
                $this->getMessage()->setSuccess("Deleted Successfully");
                $this->redirect('grid');
            }
        }
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
        }
    }
}