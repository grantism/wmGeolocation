wmGeolocation
==============
wmGeolocation is a simple Joomla plugin to help determine and expose the users geolocation using their IP address.

## Usage
This plugin can be accessed from anywhere using the following code:
```php
$geolocation = Factory::getApplication()->get('wmGeolocation');

// Get the ISO code for the users country
$geolocation->getCountryIsoCode();
```

## Installation
- Download and install from the `Extensions > Manage > Install` page of joomla.

## Keywords
joomla, plugin, geoip, geolocation
