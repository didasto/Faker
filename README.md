# Didasto Faker
___
## Installation
___
Add the *faker* library to your `composer.json` file:
```bash
    composer require didasto/faker
```

## Usage
___
To use this with Faker, you must add the Didasto/Faker class to the Faker generator:
```php
<?php
$faker = \Faker\Factory::create();
$faker->addProvider(new \Faker\DE\PersonalIdCardProvider($faker));
// Any who you want

$faker->idCardNumber(); // Get a valid PersonalIdCardNumber
```
