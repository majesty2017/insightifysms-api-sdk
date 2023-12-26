# Insightify SMS PHP SDK

The Insightify SMS PHP SDK provides a suitable approach to the Insightify SMS API from applications written in PHP. It includes pre-defined set of classes and functions for API resource that initialize themselves from  API responses.

The library provides other features. For Example:
1. Easy configuration path for fast setup and use
2. Helpers for pagination.

You can sign up for an Insightify SMS account at [insightifysms.com](https://insightifysms.com)

## Prerequisites
PHP ^8.0 and later

## Installation
Via [Composer](http://getcomposer.org/)
```
$ composer require insightifysms/insightifysms-api-sdk
```

Via Git Bash
```
git clone https://github.com/majesty2017/insightifysms-api-sdk.git
```

## Documentation
Please see [https://insightifysms.com/developer](https://insightifysms.com/developer) for up-to-date documentation

## Usage

### Step 1:
If you install the insightify SMS PHP SDK via Git Clone then load the insightify SMS PHP API class file and use namespace.

```php
require_once '/path/to/src/InsightifySMS.php';
use Insightify\InsightifySMS;
```

If you install insightify SMS PHP SDK via [Composer](http://getcomposer.org/) require the autoload.php file in the index.php of your project or whatever file you need to use insightify SMS PHP API classes.

```php
require __DIR__ . '/vendor/autoload.php';
use use Insightify\InsightifySMS;
```

The insightify SMS PHP SDK endpoints are RESTful, and consume and return JSON. All Http endpoints requires an API Key in the request header.

For more information on how to get an API Key visit [here](https://app.insightifysms.com/developers) to copy or generate new key for authorization. 

## HTTP ENDPOINTS
* https://app.insightifysms.com/api/v3/sms/send
* https://app.insightifysms.com/api/v3/sms/{uid}
* https://app.insightifysms.com/api/v3/sms
* https://app.insightifysms.com/api/v3/me
* https://app.insightifysms.com/api/v3/balance
* https://app.insightifysms.com/api/v3/contacts
* https://app.insightifysms.com/api/v3/contacts/{group_id}/show/
* https://app.insightifysms.com/api/v3/contacts/{group_id}
* https://app.insightifysms.com/api/v3/contacts/{group_id}/store
* https://app.insightifysms.com/api/v3/contacts/{group_id}/search/{uid}
* https://app.insightifysms.com/api/v3/contacts/{group_id}/update/{uid}
* https://app.insightifysms.com/api/v3/contacts/{group_id}/delete/{uid}
* https://app.insightifysms.com/api/v3/contacts/{group_id}/all


### Step 2:
Instantiate the InsightifySMSPHPAPI
```php
$client = new Insightify\InsightifySMS();
```

## Send SMS
```php
$api_key = "Enter Your API Key here";

$url = "https://app.insightifysms.com/api/v3/sms/send";

$recipients = "233500000000,233540000000";
$message = "Hello world";
$senderid = "Enter your approved sender ID here";

$response = $client->send_sms($url, $api_key, $senderid, $recipients, $message);
```


## Check SMS Credit Balance
```php
$api_key = "Enter Your API Key here";

$url = "https://app.insightifysms.com/api/v3/balance";

$get_credit_balance = $client->check_balance($url, $api_key);
```


## View Profile
```php
$api_key = "Enter Your API Key here";

$url = "https://app.insightifysms.com/api/v3/me";

$get_profile = $client->profile($url, $api_key);
```

## Status Code

| Status | Message |
| --- | --- |
| `ok`  | Successfully Send |
| `100` | Bad gateway requested |
| `101` | Wrong action |
| `102` | Authentication failed |
| `103` | Invalid phone number |
| `104` | Phone coverage not active |
| `105` | Insufficient balance |
| `106` | Invalid Sender ID |
| `107` | Invalid SMS Type |
| `108` | SMS Gateway not active |
| `109` | Invalid Schedule Time |
| `110` | Media url required |
| `111` | SMS contain spam word. Wait for approval |