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
use Xenon\MultiCourier\Sender;


$sender = Sender::getInstance();
        $sender->setProvider(ECourier::class,'production');
        $sender->setConfig([
            'API-KEY' => 'XXX',
            'API-SECRET' => 'XXX',
            'USER-ID' => 'XXXX',
        ]);
        $sender->setRequestEndpoint('packages', ['city' => 'Tangail']);
        $response = $sender->send();
        echo $response->getData();
</pre>




#### Currently Supported Courier Gateways

* ECourier


We are continuously working in this open source library for adding more Bangladeshi sms gateway. If you feel something
is missing then make a issue regarding that. If you want to contribute in this library, then you are highly welcome to
do that....
