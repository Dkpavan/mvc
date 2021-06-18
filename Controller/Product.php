<?php 
Ccc::loadFile("Model/Product.php");
Ccc::loadFile("Controller/Core/Abstract.php");

class Controller_Product extends Controller_Core_Abstract
{
    protected $products= [];
    protected $product = null;

    public function setProducts(array $products = null)
    {
       if(!$products){
            $product = new Model_Product();
            $products = $product->fetchAll("SELECT * from `product`"); 
       }
       $this->products = $products;
       return $this;
    
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProduct($product)
    {
       $this->product = $product;
       return $this;
    
    }

    public function getProduct()
    {
        return $this->product;
    }
    
    public function gridAction()
    {
        $this->setProducts();
        require "View/product/grid.phtml";

    }

    public function addAction()
    {
        try {
            $product = new Model_Product();
            $this->setProduct($product);

            require "View/product/form.phtml";
            
        } catch (Exception $e) {
           $this->getMessage()->setFailure($e->getMessage());
           $this->redirect("grid");
        }
    }

    public function editAction()
    {
        try {
            $id = $this->getRequest()->getParams('id');
            $product = new Model_Product();
            $product = $product->load($id);
    
            if(!$product->getId()){
                throw new Exception("invalid Id", 1);     
            }
    
            $this->setProduct($product);
            require "View/product/form.phtml";
            
        } catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
           
        }
       
    }

    public function saveAction()
    {
        try {
            
            if (!$this->getRequest()->isPost()) {
                throw new Exception("invalid request", 1);

            }

            $postData = $this->getRequest()->getPost('Product');
            if(!$postData){
                throw new Exception("No data posted", 1);
               
            }
            
            $id = $this->getRequest()->getParams('id');
            $product = new Model_Product(); 
            if($id){
                $product = $product->load($id);

                if(!$product->getId()){
                    throw new Exception("No Id found", 1);
                }
                
                $product->updatedDate = date('Y-m-d H:i:s');
            }
            else{
                $product->createdDate = date('Y-m-d H:i:s');
            }
           
            $Product['productId'] = $id;
            $data = array_merge($postData,$Product);
            $product->setData($data);
            if($product->save()){
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
            
            $this->redirect("grid");

        } catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
        }
    }

    public function deleteAction()
    {
        try {
        
            $id = $this->getRequest()->getParams('id');
            $product = new Model_Product();
            $product = $product->load($id);
            if(!$product->getId()){
                throw new Exception("No record found", 1);  
            }

            if( $product->delete()){
                $this->getMessage()->setSuccess("Deleted Successfully");
                $this->redirect("grid");
            }
        } 
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
      
        }
    }
}
