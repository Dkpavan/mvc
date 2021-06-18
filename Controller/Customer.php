<?php
Ccc::loadFile("Model/Customer.php");
Ccc::loadFile("Model/Address.php");
Ccc::loadFile("Controller/Core/Abstract.php");
 
class Controller_Customer extends Controller_Core_Abstract
{ 
    protected $customers = [] ;
    protected $customer = null ;
    protected $shippingAddress = null ;
    protected $billingAddress = null ;

    public function setCustomers(array $customers = null)
    {
       if(!$customers){
            $customer = new Model_Customer();
            $query = "SELECT* from `customer` join `address` where customer.customerId = address.customerId";
            $customers = $customer->fetchAll($query); 
       }
       $this->customers = $customers;
       return $this;
    
    }

    public function getCustomers()
    {
        return $this->customers;
    }

    public function setCustomer($customer)
    {
       $this->customer = $customer;
       return $this;
    
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setShippingAddress($addressId)
    {
        $address = new Model_Address();
        $address = $address->load($addressId);
        $this->shippingAddress = $address;
        return $this;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    public function setBillingAddress($addressId)
    {
        $address = new Model_Address();
        $address = $address->load($addressId);
        $this->billingAddress = $address;
        return $this;
    }

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function gridAction()
    {
        $customer = new Model_Customer();
        $query = "SELECT   * , customer.customerId from `customer` left join `address` on customer.billingAddressId = address.addressId ";
        $customers = $customer->fetchAll($query);  
        $this->setCustomers($customers);
        require "View/customer/grid.phtml";
    }

    public function addAction()
    {
        try {
            $customer = new Model_Customer();
            $this->setCustomer($customer);
            $this->setBillingAddress(null);
            $this->setShippingAddress(null);
            require "View/customer/form.phtml";
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
            if(!$id){
                throw new Exception("Id not found", 1);    
            }
            $customer = new Model_Customer();
            $condition = "customerId ='{$id}' ";
            $query =  "SELECT   *  from `customer` where {$condition}";
            $customer = $customer->fetchRow($query);
            if(!$customer){
                throw new Exception("Unable to find record", 1);      
            }
            $this->setShippingAddress($customer->shippingAddressId);
            $this->setBillingAddress($customer->billingAddressId);
            $this->setCustomer($customer);
            require "View/customer/form.phtml";

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
            
            $postData = $this->getRequest()->getPost('Customer');
            if(!$postData){
                throw new Exception("No data posted.", 1);
            }
            
            $id = (int) $this->getRequest()->getParams('id');
            $customer = new Model_Customer();
            if($id){
                $customer = $customer->load($id);
                
                if(!$customer->getId()){
                    throw new Exception("No Id found", 1);     
                }

                $customer->updatedDate = date('Y-m-d H:i:s');
                $this->_saveBillingAddress($customer);
                $this->_saveShippingAddress($customer);
            }
            else{
                $customer->createdDate = date('Y-m-d H:i:s');
            }

            $Customer['customerId'] = $customer->customerId;
            $customerData = array_merge($postData,$Customer);
            $customer->setData($customerData);
    
            if($customer->save()){
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
        } 
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
        }
    }

    protected function _saveBillingAddress($customer){
        try {
            $addresss = $this->getRequest()->getPost('billing'); //always start variable name like camelcase.
            if(!$addresss){
                return false;
            }
            
            $addressId = (int) $customer->billingAddressId;
            $address = new Model_Address();
            
            if($addressId){
                $address = $address->load($addressId);
                $address->setPrimaryKey("customerId");
                //if address have created or updated date then we will do like this here
            }
    
            $Address['customerId'] = $customer->customerId;
            $addressData = array_merge($addresss,$Address);
            $address->setData($addressData);
            if(!$address->save()){
                throw new Exception('unable to save billing address.');
            }
    
            $customer->billingAddressId = $address->addressId;
            $customer->save();
            
        } catch (Exception $e) {
            $this->getMessage()->setSuccess($e->getMessage());
            $this->redirect("grid");
        }
       
    }

    public function _saveShippingAddress($customer){
        try {
            $addresss = $this->getRequest()->getPost('shipping');
        
            if(!$addresss){
                return false;
            }
    
            $addressId = (int) $customer->shippingAddressId;
            $address = new Model_Address();
           
            if($addressId){
                $address = $address->load($addressId);
                $address->setPrimaryKey('customerId');
            }
            $Address['customerId'] = $customer->customerId;
            $addressData = array_merge($addresss,$Address);
            $address->setData($addressData);
    
    
            if(!$address->save()){
                throw new Exception('unable to save shipping address.');
            }
    
            $customer->shippingAddressId = $address->addressId;
            $customer->save();

        } catch (Exception $e) {
            $this->getMessage()->setSuccess($e->getMessage());
            $this->redirect("grid");
         }
       
    }


    public function deleteAction()
    {
       try {
            $id = $this->getRequest()->getParams('id');
            $address = new Model_Address();
            $address->setPrimaryKey("customerId");
            $address = $address->load($id);
            
            if(!$address->getId()){
                throw new Exception("No record found", 1);  
            }
            
            if($address->delete()){
                $customer = new Model_Customer();
                $customer->delete();
                $this->getMessage()->setSuccess("Deleted Successfully");
                $this->redirect("grid");
            }
       } 
       catch (Exception $e){
            $this->getMessage()->setSuccess($e->getMessage());
            $this->redirect("grid");
       }       
    } 
}

