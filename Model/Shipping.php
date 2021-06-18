<?php

Ccc::loadFile("Model/Core/Table.php");

class Model_Shipping extends Table 
{
    const  STATUS_ENABLED =  '0';
    const  STATUS_ENABLED_LBL =  'Enabled';
    const  STATUS_DISABLED =  '1';
    const  STATUS_DISABLED_LBL =  'Disabled';

    public function __construct()
    {
        $this->setTableName("shipping");
        $this->setPrimaryKey("methodId");
    }

    public function getStatusOptions()
    {
        return [
            self::STATUS_ENABLED => self::STATUS_ENABLED_LBL,
            self::STATUS_DISABLED => self::STATUS_DISABLED_LBL,
        ];
    }
}
