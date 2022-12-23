# Fatoora Zatca

# Install

```
mkdir packages
mkdir AbdelrahmanBl
git clone https://github.com/AbdelrahmanBl/fatoora-zatca.git fatoora-zatca
```

# Library

For gettting the x509 certificate you must install phpseclib/phpseclib

```
composer require phpseclib/phpseclib:~3.0
```

# Config

First add FatooraZatcaServiceProvider to your app.php

```
'providers' => [
    /*
    * Package Service Providers...
    */
    Bl\FatooraZatca\FatooraZatcaServiceProvider::class,
]
```

To publish the configuration file 
```
php artisan vendor:publish --tag=fatoora-zatca
```

use in your .env file the variable ZATCA_ENVIRONMENT=local|production
