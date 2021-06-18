<?php
Ccc::loadFile("Model/Category.php");
Ccc::loadFile("Controller/Core/Abstract.php");

class Controller_Category extends Controller_Core_Abstract
{
    protected $categorys = [];
    protected $category = null;

    public function setCategorys(array $categorys = null)
    {
        if (!$categorys) {
            $category = new Model_Category();
            $categorys = $category->fetchAll("select * from `category`");
        }
        $this->categorys = $categorys;
        return $this;
    }

    public function getCategorys()
    {
        return $this->categorys;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function gridAction()
    {
        $this->setCategorys();
        require "View/category/grid.phtml";
    }

    public function addAction()
    {
        try {
            $category = new Model_Category();
            $this->setCategorys();
            $this->setCategory($category);
            require "View/category/form.phtml";
        }
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect("grid");
        }

    }

    public function editAction()
    {
        try {
            $id = $this->getRequest()->getParams("id");
            $category = new Model_Category();
            $category = $category->load($id);

            if(!$category->getId()){
                throw new Exception("Record not found", 1);
            }

            $this->setCategory($category);
            $this->setCategorys();
            require "View/category/form.phtml";
        } 
        catch (Exception $e) {
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

            $postData = $this->getRequest()->getPost('Category');
            if(!$postData){
                throw new Exception("No data posted.", 1);
            }

            $id = $this->getRequest()->getParams('id');
            $category = new Model_Category();

            if ($id) { 
                $category = $category->load($id);
                if (!$category) {
                    throw new Exception("unable to find record", 1);     
                }
               
                $Category['categoryId'] = $category->categoryId;
                $data = array_merge($postData,$Category);
                $category = $category->setData($data);
                $category->updateCategoryPathId();
                $category = $category->updateChildrenPathIds();
            }
            else{
                $category->setData($postData);
                $category->save();
                $lastInsertId = $category->categoryId;
                $category->load($lastInsertId);
                $category = $category->updateCategoryPathId();
            }

            if($category){
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

    public function deleteAction()
    {
        try {
            $id = $this->getRequest()->getParams('id');
            $category = new Model_Category();
            $category = $category->load($id);
            if(!$category->getId()){
                throw new Exception("Record not found", 1);  
            }

            //------------current category delete with all the chlid----------//
            if ($this->getRequest()->getParams('delete') == 'all') {
                $condition = "`pathIds` like '%/{$id}' or `pathIds` like '{$id}/%' or `pathIds` like '%/{$id}/%' or `pathIds` = '{$id}'";
                $query = "DELETE from `category` where {$condition}";
                $result = $category->delete($query);
            }
    
            //------------ only current category delete----------//
            if ($this->getRequest()->getParams('delete') == 'one') {
                $category = $category->load($id);
                $category->updateChildrenPathIds();
                $result = $category->delete();
            }

            if ($result) {
                $this->getMessage()->setSuccess("Deleted Successfully");
                $this->redirect("grid");
            }
        }
        catch (Exception $e) {
            $this->getMessage()->setFailure($e->getMessage());
            $this->redirect('grid');
        }
    } 
        
}


