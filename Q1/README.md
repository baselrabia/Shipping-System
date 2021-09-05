
### At The First
we need to integrate with different sets of shipping companies and make it easy to integrate with new ones despite the difference in the integration 

so here is what I was thinking about 

at first, we will use a strategy pattern by creating an interface that includes all the common functionality that we will use with any shipping company, and every new company should implement this interface 

if there is a company that had additional functionality we can create a separate interface for this class so we will keep the interface segregation applied in our design 

we have a base class which is `ShippingCompany` it has in its constructor injection for the company that we wanna use so just by passing an object from the company 
to the base class, we can use all the functionality as we can see a simple example for that at the end of the file `ShippingCompanies.php` 
 
So when we need to add a new shipping company we don't have to modify our old code we are open for extension which applied the second principle in `SOLID` `O/C` open-closed principle so we are open for extension, but closed for modification

<hr>

### Going throw the consideration 

By looking at the models file `Models.php` we can see the layers between the store, shipping company, order, and shipping, the relation between them, and the DB columns that we can think about in the fillable variable 

1- so we can see that store can have one or many options for the shipping company by creating `many to many ` relation and creating a pivot table for that `ShippingCompany_store`

2- also the shipping model had a type property that tells us if the order was shipped by a company or it had a custom delivery option 

3- when our order is ready to go we will update the shipping status to be ready and you can find the `static boot method` had an override in the model to get the benefit of the event `Saved` so when our shipping getting to be saved in creating or updating and the status changed to be ready we can despatch a `ReadyShippingEvent` then in the listener we can but whatever logic we want like sending a request to the shipping company to create a shipping order from their side.


4- every time the shipping company update the order from their side it will send a request to our webhook API which validate the coming request and make sure to update the exact shipping record for the upcoming status, you can see an example of that in the `ShippingController` in `controller.php`

5- for the fees point, I assumed that the company had fixed fees at first so when we are attaching the company to our store in the pivot table there's a column for the fee we can add whatever we want, or if there is  a calculation logic for the fees in the company class we can override that in our store model by whatever way but I think this point needs more clarification.

6- for the city point, I assumed there is a city model which had the name of the cities and we can create a pivot table `shippingcompany_city` for the companies so we can know the supported cities for the company, and we can do the same for the store to see which cities the store cover, also we can use a `morph` relation despite building 2 separated tables from this table when we attaching a company to our store we can validate if the company supports the cities that the store support or not.

#### also, there's another solution despite the first one,

we can create  a table that had city_id, store_id, company_id so from this table we can know the subset that the store covers from the cities that supported by the shipping company 

<hr>

#### I know there isn't a perfect solution, but I hope I was close in my thinking design for the demanded solution, 

#### Waiting for your feedback ASAP
