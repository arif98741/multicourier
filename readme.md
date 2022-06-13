This is a courier api endpoints library for interacting such as e-courier, dhl, pathao etc


# Installation

### Step 1:

```
composer require xenon/multicourier
```

### Step 2:

Then, publish the package

```
php artisan vendor:publish --provider=Xenon\MultiCourier\MultiCourierServiceProvider
```


Otherwise, if you want more control, you can use the underlying sender object. This will not touch any laravel facade or
service provider.

#### Sample Code Requesting to E-courier

<pre>
use Xenon\MultiCourier\Provider\ECourier;
use Xenon\MultiCourier\Courier;


$courier = Courier::getInstance();
$courier->setProvider(ECourier::class, 'local'); /* local/production */
$courier->setConfig([
    'API-KEY' => 'xxx',
    'API-SECRET' => 'xxxx',
    'USER-ID' => 'xxxx',
]);
$courier->setParams(['city'=>'Dhaka']);
$thanas = $courier->getThanas(); //get thana
$cities = $courier->getCities(); //get city
</pre>

<pre>
//place order
use Xenon\MultiCourier\Provider\ECourier;
use Xenon\MultiCourier\Courier;


$courier = Courier::getInstance();
$courier->setProvider(ECourier::class, 'local'); /* local/production */
$courier->setConfig([
    'API-KEY' => 'xxx',
    'API-SECRET' => 'xxx',
    'USER-ID' => 'xxx',
]);
$courier->setParams(['ecr' => 'ECR38786912120622']);
$orderData = array(
    'recipient_name' => 'XXXXX',
    'recipient_mobile' => '017XXXXX',
    'recipient_city' => 'Dhaka',
    'recipient_area' => 'Badda',
    'recipient_thana' => 'Badda',
    'recipient_address' => 'Full Address',
    'package_code' => '#XXXX',
    'product_price' => '1500',
    'payment_method' => 'COD',
    'recipient_landmark' => 'DBBL ATM',
    'parcel_type' => 'BOX',
    'requested_delivery_time' => '2019-07-05',
    'delivery_hour' => 'any',
    'recipient_zip' => '1212',
    'pick_hub' => '18490',
    'product_id' => 'DAFS',
    'pick_address' => 'Gudaraghat new mobile',
    'comments' => 'Please handle carefully',
    'number_of_item' => '3',
    'actual_product_price' => '1200',
    'pgwid' => 'XXX',
    'pgwtxn_id' => 'XXXXXX'
);

$courier->setParams($orderData);
$cities = $courier->placeOrder();


</pre>


#### Sample Code Requesting to Pathao

<pre>
use Xenon\MultiCourier\Courier;
use Xenon\MultiCourier\Provider\Pathao;

$courier = Courier::getInstance();
$courier->setProvider(Pathao::class, 'local'); /* local/production */
$courier->setMethod('get');
$courier->setRequestEndpoint('cities/1/zone-list', []); //second param should be array. its optional. you should form params here
$response = $courier->send();
</pre>




#### Currently Supported Courier Gateways

* ECourier
* Pathao


We are continuously working in this open source library for adding more Bangladeshi courier companies. If you feel something
is missing then make a issue regarding that. If you want to contribute in this library, then you are highly welcome to
do that....
