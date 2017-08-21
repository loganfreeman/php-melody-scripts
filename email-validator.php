<?php
<<<CONFIG
packages:
    - "nojacko/email-validator: ~1.0"
CONFIG;

$validator = new \EmailValidator\Validator();

echo $validator->isValid('example@google.com');              // true
$validator->isValid('abuse@google.com');                // false
$validator->isValid('example@example.com');             // false

$validator->isSendable('example@google.com');           // true
$validator->isSendable('abuse@google.com');             // true
$validator->isSendable('example@example.com');          // false

$validator->isEmail('example@example.com');             // true
$validator->isEmail('example@example');                 // false

$validator->isExample('example@example.com');           // true
$validator->isExample('example@google.com');            // false
$validator->isExample('example.com');                   // null

$validator->isDisposable('example@example.com');        // false
$validator->isDisposable('example@mailinater.com');     // true
$validator->isDisposable('example.com');                // null

$validator->isRole('example@example.com');              // false
$validator->isRole('abuse@example.com');                // true
$validator->isRole('example.com');                      // null

$validator->hasMx('example@example.com');               // false
$validator->hasMx('example@google.com');                // true
$validator->hasMx('example.com');                       // null
