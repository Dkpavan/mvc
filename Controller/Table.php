<?php
require "./Model/Table.php";
class Controller_Table
{
    protected $model;
    public function __construct()
    {
        $this->model = new Table();
    }

    public function gridAction()
    {
        $this->model->customerId = "";
        $this->model->name = "prin";
        $this->model->email = "acb@gmail.com";
        $this->model->contact = "123456789";
        $this->model->gender = "male";
   
         echo "<pre>";
         print_r($this->model->save());

        echo "<pre>";
        print_r($this->model->getData());
        // print_r($this->model->loadData(48));
    }
}
