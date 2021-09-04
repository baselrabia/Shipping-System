<?php


interface ShippingContract
{
    public function doLogic($request);
}

interface AnotherLogicContract
{
     public function anotherlogic($request);
}

class XShipping implements ShippingContract {
    public function doLogic($request) {
        // code here
        echo "XShipping Logic" . PHP_EOL;

    }
}

class YShipping implements ShippingContract, AnotherLogicContract {
    public function doLogic($request)
    { 
        // code here
        echo "YShipping Logic"  . PHP_EOL;
    }
    public function anotherlogic($request)
    {
        // code here
        echo "YShipping Another Logic" . PHP_EOL;

    }
}

class ShippingCompany implements ShippingContract
{
    public $company;

    function __construct(ShippingContract $company)
    {
        $this->company = $company;
        //$this->company = new (request()->input('company'))();
    }

    public function doLogic($request)
    {
        return $this->company->doLogic($request);
    }


    public function setcompany(ShippingContract $company)
    {
        $this->company = $company;
    }
}

$request = ['request' => 'request'];
$service = new ShippingCompany(new XShipping());
$service->doLogic($request);
// $service->anotherlogic($request);
 

$service->setcompany(new YShipping());
$service->doLogic($request);
$service->company->anotherlogic($request);
