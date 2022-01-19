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

### Step 4:

Set env configuration for individual couriers
PATHAO_CLIENT_ID=XXX
PATHAO_CLIENT_SECRET="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
PATHAO_USERNAME="xxxx@example.com"
PATHAO_PASSWORD="xxxxxx"
PATHAO_GRANT_TYPE="password"

ECOURIER_API_KEY='xxx'
ECOURIER_API_SECRET='xxx'
ECOURIER_USER_ID='xxxx'
ECOURIER_ENVIRONMENT='xxxx'

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
$courier->setMethod('get');
$courier->setRequestEndpoint('city-list', []); //second param should be array. its optional. you should form params here
$response = $courier->send();
echo $response->getData();
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
