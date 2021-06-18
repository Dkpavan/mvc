<?php
Ccc::loadFile("Model/Core/Table.php");

class Model_Address extends Table 
{
    public function __construct()
    {
        $this->setTableName("address");
        $this->setPrimaryKey("addressId");
        
    }
}
