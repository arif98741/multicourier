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

### Step 3:

Set **.env** configuration for individual couriers

```PATHAO_CLIENT_ID=XXX 
PATHAO_CLIENT_SECRET="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
PATHAO_USERNAME="xxxx@example.com"
PATHAO_PASSWORD="xxxxxx"
PATHAO_GRANT_TYPE="password"

ECOURIER_API_KEY='xxx'
ECOURIER_API_SECRET='xxx'
ECOURIER_USER_ID='xxxx'
ECOURIER_ENVIRONMENT='xxxx'
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
$response = $courier->placeOrder();


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

# Available Methods to Interact with Provider's Api
### _getInstance()_
### _getConfig()_
### _setConfig()_
### _getParams()_
### _setParams()_
### _getProvider()_
### _setProvider()_
### _getCities()_
### _getThanas()_
### _trackOrder()_
### _trackChildOrder()_
### _getPackages()_
### _placeOrder()_
### _cancelOrder()_
### _cancelChildOrder()_
### _fraudStatusCheck()_
### _getAreas()_
### _getPostCodes()_
### _getBranches()_
### _printLabel()_
### _boostSms()_
### _topupSms()_
### _topTransactionStatus()_
### _topupOtp()_

#### Currently Supported Courier Gateways

* **ECourier**
* **Pathao**

<p align="center" >
<img src="https://raw.githubusercontent.com/arif98741/multicourier/master/img/ecourier.png">
<img  src="https://raw.githubusercontent.com/arif98741/multicourier/master/img/pathao.png">
</p>


We are continuously working in this open source library for adding more Bangladeshi courier companies. If you feel something
is missing then make a issue regarding that. Your can pull request to **dev** branch. 
If you want to contribute in this library, then you are highly welcome to
do that....
read blog from here <br>
https://dev.to/arif98741/bangladeshi-courier-company-api-integration-in-laravel-using-xenon-multicourier-package-4m12
