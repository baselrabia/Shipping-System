<?php



class Store
{

    public function shippingComapnies()
    {
        return $this->hasMany('ShippingCompany');
    }

    public function orders()
    {
        return $this->hasMany('Order');
    }
}



class ShippingCompany
{

    public function stores()
    {
        return $this->belongsToMany('Store');
    }

    public function shippings()
    {
        return $this->hasMany('Shipping');
    }
    
}
 


class Order
{

    public function store()
    {
        return $this->belongsTo('Store');
    }

    public function shipping()
    {
        return $this->hasOne('Shipping');
    }
}

class Shipping
{

    public function shippingComapny()
    {
        return $this->belongsTo('ShippingCompany');
    }
    
    public function order()
    {
        return $this->belongsTo('Order');
    }
     
}
