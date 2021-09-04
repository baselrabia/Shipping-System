<?php



class Store
{
    private $fillable = ['name', 'description', 'address', 'phone', 'email', 'website', 'logo', 'cover', 'lat', 'lng', 'user_id'];
    
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
    private $fillable = ['name', 'description', 'address', 'phone', 'email', 'website', 'logo', 'cover', 'lat', 'lng', 'user_id'];

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

    private $fillable = [
            'user_id',
            'shipping_company_id',
            'store_id',
            'shipping_id',
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
            'payment_id'
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

class Shipping
{
    private $fillable = [ 
        'order_id',
        'shipping_company_id',
        'shipping_type', // custome delivery option => 1: company, 2: custom delivery 3: pickup
        'tracking_code',
        'shipping_price',
        'shipping_weight',
        'shipping_weight_unit',
        'shipping_quantity',
        'shipping_address',
        'status'
    ];

    public function shippingComapny()
    {
        return $this->belongsTo('ShippingCompany');
    }
    
    public function order()
    {
        return $this->belongsTo('Order');
    }
     
}
