<?php
Ccc::loadFile("Model/Core/Table.php");

class Model_Category extends Table 
{
    const  STATUS_ENABLED =  '0';
    const  STATUS_ENABLED_LBL =  'Enabled';
    const  STATUS_DISABLED =  '1';
    const  STATUS_DISABLED_LBL =  'Disabled';

    public function __construct()
    {
        $this->setTableName("category");
        $this->setPrimaryKey("categoryId");
    }

    public function getIdName()
    {
        return $this->getId();
    }

    public function  updateCategoryPathId()
    {
        if (!$this->parentId) {
            $pathId = $this->categoryId;
        } else {
            $parent = new $this;
            $parent->load($this->parentId);
            $pathId = $parent->pathIds."/".$this->categoryId;
           
        }
        $this->pathIds = $pathId;
        return $this->save();
    }

    public function updateChildrenPathIds()
    {
        $query = "SELECT * from `{$this->getTableName()}` where `pathIds` like '%{$this->categoryId}/%' ORDER BY `pathIds` ASC";
        $categories = $this->fetchAll($query);
        foreach($categories as $childCategory){
            $category = new $this;
            $category->load($childCategory->categoryId);
            if($category->parentId == $this->categoryId){
                $category->parentId = $this->parentId;
            }
            $category->updateCategoryPathId();
        }
    }

    public function getStatusOptions()
    {
        return [
            self::STATUS_ENABLED => self::STATUS_ENABLED_LBL,
            self::STATUS_DISABLED => self::STATUS_DISABLED_LBL,
        ];
    }
}
