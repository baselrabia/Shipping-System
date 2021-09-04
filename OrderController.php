<?php


class OrderController 
{

// store order

    public function store()
    {

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'total' => Cart::total(),
            'status' => 'pending'
        ]);
        $shipping = Order::create([
            'user_id' => auth()->user()->id,
            'total' => Cart::total(),
            'status' => 'pending'
        ]);

    }


    /*
    * POST request /webhock for update order shipping status
    *
    **/
    public function webhock(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:ShippingCompanies,id',
            'order_id' => 'required|exists:Orders,id',
            'status' =>'required'
        ]);

        $shipping = shipping::where('order_id', $request->order_id)->where('company_id',$request->company_id)->first();
        
        $shipping->update([ 'status' => $request->status]);

        '/webhock'
        //with change 
        //extra in order .. schemless 
    }


}
