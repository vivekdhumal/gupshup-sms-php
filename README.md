## Gupshup SMS PHP

This package will allow user to send Text SMS using  [Gupshup.io](https://www.gupshup.io) service

### Requirement

PHP VERSION >= 7.3

### Install Using Composer
```bash
composer require vivekdhumal/gupshup-sms-php
```

### Implementation

```php
<?php

require_once 'vendor/autoload.php';

use Vivekdhumal\GupshupSMS\GupshupMessage;

$userid = 'Your user id';
$password = 'Your password';
$mask = 'Your Company Sender ID / Mask';
$entityId = 'Your company Entity ID if required'; // optional
$entityId = 'Your registered SMS Template ID if required'; // optional

$sms = new GupshupMessage($userid, $password, $mask, $entityId, $templateId);

$response = $sms->to($mobile)
            ->message($message)
            ->send();

var_dump($response->status, $response->message, $response->details, 
$response->id, $response->phone);

```