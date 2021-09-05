<?php

## --------------------- STORE MODEL ------------------------

class Store
{
    private $fillable = ['name', 'description', 'address', 'phone', 'email', 'website', 'logo', 'cover', 'lat', 'lng', 'user_id'];
    
    public function shippingComapnies()
    {
        return $this->belongsToMany('ShippingCompany', "shippingCompany_store")->withPivot('fees');
    }

    public function orders()
    {
        return $this->hasMany('Order');
    }
}


## --------------------- Shipping Company MODEL  ------------------

class ShippingCompany
{
    private $fillable = ['name', 'description', 'address', 'phone', 'email', 'website', 'logo', 'cover', 'lat', 'lng', 'user_id'];

    public function stores()
    {
        return $this->belongsToMany( 'Store', "shippingCompany_store")->withPivot('fees');
    }

    public function shippings()
    {
        return $this->hasMany('Shipping');
    }
    
}
 

## --------------------- Order MODEL ------------------------


class Order
{

    private $fillable = [
            'user_id',
            'shipping_company_id', //nullable
            'store_id',
            'shipping_id', //
            'status',
            'total_price',
            'total_weight',
            'total_quantity',
            'total_shipping_price',
            'total_tax',
            'total_discount',
            'total_final_price',
            'payment_method',
            'payment_status',
            'payment_id',
            'extra' //json
        ];

    public function store()
    {
        return $this->belongsTo('Store');
    }

    public function shipping()
    {
        return $this->hasOne('Shipping');
    }
}



## --------------------- Shipping MODEL ------------------------


class Shipping
{
    private $fillable = [ 
        'order_id',
        'shipping_company_id', //nullable
        'shipping_type', // custome delivery option => 1: company, 2: custom delivery 3: pickup
        'tracking_code',
        'shipping_price',
        'shipping_weight',
        'shipping_weight_unit',
        'shipping_quantity',
        'shipping_address',
        'status'
    ];

    public static function boot()
    {
        parent::boot();

        static::Saved(function ($model) { //in create and update 
            if ($model->wasChanged('status') && $model->status == 'ready') {
                dispatch(new ReadyShipmentEvent($model));
            }
        });

        // whenever order shipping is being ready the "ReadyShipmentEvent" will be dispatched
        // and the "ReadyShipmentlistener" will send the reuest to the the shipping company to create shipment from their side 

    } 


    public function shippingComapny()
    {
        return $this->belongsTo('ShippingCompany');
    }
    
    public function order()
    {
        return $this->belongsTo('Order');
    }



     
}



## --------------------- City MODEL ------------------------



class City 
{

    private $fillable = ['name', 'lat', 'lng', 'country_id'];


    public function country()
    {
        return $this->belongsTo('Country');
    }

    public function shippingCompanies()
    {
        return $this->belongsToMany('ShippingCompany');
    }

    public function stores()
    {
        return $this->belongsToMany('Store');
    }

 


}
