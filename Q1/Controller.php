<?php




class StoreController
{



    /*
    *  attach Shipping Company to Store
    *  
    **/
    public function attachShippingCompany(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:ShippingCompanies,id',
            'store_id' => 'required|exists:stores,id',
         ]);

        $store = Store::find( $request->store_id );

        $store->shipping_companies()->attach( $request->company_id, ['fee' => $request->fee] );

        // you can customize the shipping fee by adding a new column to the pivot table 
    
    }




}



class ShippingController 
{

 

    /*
    * POST request '/webhock' for update order shipping status
    *
    * Every time the shpping company send a webhook, the order status will be updated from our side 
    * Also we should but the '/webhock' in the except list in 'VerifyCsrfToken.php' to be excluded from CSRF verification.
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

        // Other Logic here
    }


}
