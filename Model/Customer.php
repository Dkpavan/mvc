<?php
Ccc::loadFile("Model/Core/Table.php");

class Model_Customer extends Table 
{
    public function __construct()
    {
        $this->setTableName("customer");
        $this->setPrimaryKey("customerId");
    }

   
}
