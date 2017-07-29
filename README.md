# Jenerator

[![Build Status](https://travis-ci.org/fireproofsocks/jenerator.svg?branch=master)](https://travis-ci.org/fireproofsocks/jenerator) [![codecov](https://codecov.io/gh/fireproofsocks/jenerator/branch/master/graph/badge.svg)](https://codecov.io/gh/fireproofsocks/jenerator)

This package generates JSON objects from [JSON Schema](http://json-schema.org/) definitions and fills them with random fake data.  This is useful for creating sample seed data that must be in a specific structure, e.g. useful for API 
responses.

The functionality is similar to the [json-schema-faker](https://github.com/json-schema-faker/json-schema-faker) 
NodeJs package.

## Installation

The recommended way to install this code is via [Composer](https://getcomposer.org/)

## Usage

### In Code

```php
<?php
require 'vendor/autoload.php';

```

### Command Line

For command line usage, move into the `jenerator/` directory and call its command.

```
php jenerator example:show path/to/schema.json
```

## Supported Formats


### Standard Formats

The JSON Schema spec defines some formats that all compliant validators _should_ respect.  Jenerator will produce 
appropriately formatted mock data for each of these standard formats  

- date-time
- email
- hostname
- ipv4
- ipv6
- uri
- uri-reference See http://json-schema.org/latest/json-schema-validation.html#rfc.section.8.3.7 and https://tools.ietf.org/html/rfc3986#section-1.1.2
- uri-template See https://tools.ietf.org/html/rfc6570
- json-pointer See https://tools.ietf.org/html/rfc6901

### Custom Formats

The following formats are custom and are not defined by the official JSON Schema spec.  They exist solely to 
facilitate the generation of realistic mock data.  Compliant validators _should_ ignore these custom formats and any 
other custom keywords they may reference.  Using a custom format is useful way to have this library generate example 
data of that format, but it is recommended that you include other other validation keywords that will ensure that any 
example data will properly validate.  For example, you may use a schema such as this to indicate a year:

 ```
 {
    "type": "string",
    "format": "year"
 }
 ```
 
 But you should include some other keywords that other validators will respect, e.g. 
 
 ```
 {
     "type": "string",
     "format": "year",
     "pattern": "\d{4}"
  }
 ```
 
 
 
#### Internet
        
- macaddress
- tld
- slug
- password
- username

#### Phone

- phonenumber
- phonenumber-e164 // https://en.wikipedia.org/wiki/E.164
- imei // http://en.wikipedia.org/wiki/International_Mobile_Station_Equipment_Identity

#### Images

- image-url supports keywords for "width" and "height" to specify integer dimensions.
    

#### File
- mime-type
- file-extension // no dot
- user-agent

#### People

- person-title
- person-name
- person-firstname
- person-lastname

#### I18N (internationalization)

- language-code
- country-code-2 // (see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
- country-code-3 // (see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3)
- currency-code
- locale

#### Algorithms : hashes etc
- md5
- sha1
- sha256
- uuid

#### Text
- paragraphs

#### Date/time
- unix-timestamp
- date
- time
- am-pm
- day-of-week
- monthname
- year
- timezone

#### Colors
- color-hex
- color-rgb
- color-name

#### Barcodes
- isbn-10
- isbn-13
- ean-8
- ean-13

#### Address
- address-city
- address-streetaddress
- address-streetname
- address-postcode
- address-country

#### Latitude/Longitude
- latitude
- longitude
- coordinates

#### Payment

- creditcard-number
- creditcard-type
- creditcard-exp-date

// TODO:
//        iban
//            return (new Payment(Factory::create(getLocale())))->iban($countryCode);
//        });

- swiftbic

## Known Limitations

**The jenerator does not support the "not" keyword.** The value generator will generate a value, but it does not 
attempt to validate the result against any schema defined in the the `not` keyword; it does not attempt to 
re-generate a value if the generated value validates against the `not` schema. 

**Unreliable support for the "oneOf" keyword.**  The value generator will pick one of the listed schemas, but it does
 not validate the generated value against the other schemas and re-generate 
 
**No support for `dependencies` keyword**

**`arrayUnique` may remove items from an array that may cause the array size to fall below the `minItems` requirement.
