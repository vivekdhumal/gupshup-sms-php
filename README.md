## Gupshup SMS PHP

This package will manages to send Text SMS using  [Gupshup.io](https://www.gupshup.io) service

### Version - v1.0

### Requirement

- PHP VERSION >= 7.3
- Gupshup.io Account

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
$templateId = 'Your registered SMS Template ID if required'; // optional

$sms = new GupshupMessage($userid, $password, $mask, $entityId, $templateId);

$response = $sms->to('+91XXXXXXXXXX')
            ->message('Your message')
            ->send();

var_dump($response->status, $response->message, $response->details, 
$response->id, $response->phone);

```