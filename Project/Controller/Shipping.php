<?php 

Ccc::loadFile("Model/Shipping.php");
Ccc::loadFile("Controller/Core/Abstract.php");
 
class Controller_Shipping extends Controller_Core_Abstract
{ 
    protected $shippings = [];
    protected $shipping = null;
    public function setShippings($shippings = null)
    {
        if(!$shippings){
            $shipping = new Model_Shipping();
            $shippings = $shipping->fetchAll("SELECT * from `shipping`"); 
       }
        $this->shippings = $shippings;
        return $this;
    }

    public function getShippings()
    {
        return $this->shippings;
    }

    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
        return $this;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    public function gridAction()
    {
        $this->setShippings();
        require "View/shipping/grid.phtml";
    }

    public function addAction()
    {
        try {
            $shipping = new Model_Shipping();
            $this->setShipping($shipping);
            require "View/shipping/form.phtml";

        }
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('grid');
        }
    }

    public function editAction()
    {
        try {
            $id = $this->getRequest()->getParams('id');
            $shipping = new Model_Shipping();
            $shipping = $shipping->load($id);

            if(!$shipping->getId()){
                throw new Exception("Invalid Id", 1);     
            }
            $this->setShipping($shipping);
            require "View/shipping/form.phtml";
        } 
        catch (Exception $e) {
           $this->getMessage()->setFailure($e->getMessage());
           $this->redirect('grid');
        }
       
    }

    public function saveAction()
    {
        try {
            if(!$this->getRequest()->isPost()){
                throw new Exception("Invalid request", 1);
            }

            $postData = $this->getRequest()->getPost('shipping');
            if(!$postData){
                throw new Exception("No data Posted", 1);
            }

            $id =   $this->getRequest()->getParams('id');
            $shipping = new Model_Shipping();
            if($id){
                $shipping = $shipping->load($id);

                if(!$shipping->getId()){
                    throw new Exceptionta("No Id found", 1);
                }

            }
            else{
                $shipping->createdDate = date('Y-m-d H:i:s');
            }

            $Shipping['methodId'] = $id;
            $shippingData = array_merge($postData,$Shipping);
            $shipping->setData($shippingData);

            if($shipping->save()){
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

        } catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('grid');
        }
    }

    public function deleteAction()
    {
        try {
            $id = $this->getRequest()->getParams('id');
            $shipping = new Model_Shipping();
            $shipping = $shipping->load($id);

            if(!$shipping->getId()){
                throw new Exception("Record not found", 1);
            }
            if($shipping->delete()){
                $this->getMessage()->setSuccess("Deleted Successfully");
            }
            $this->redirect('grid');

        } catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('grid');
        }
    }


}