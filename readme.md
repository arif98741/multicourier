Xenon\LaravelBDSms is a sms gateway package for sending text message to Bangladeshi mobile numbers using several
gateways for <strong>Laravel</strong>. You should use <strong>composer 2</strong> for latest updates of this package.

<p><img src="https://img.shields.io/github/issues/arif98741/laravelbdsms">
<img src="https://img.shields.io/github/forks/arif98741/laravelbdsms">
<img src="https://img.shields.io/github/stars/arif98741/laravelbdsms">
   <img src="https://img.shields.io/github/license/arif98741/laravelbdsms">
</p>

# Installation

### Step 1:

```
composer require xenon/laravelbdsms
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
