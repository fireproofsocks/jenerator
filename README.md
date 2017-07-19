# Jenerator

This package generates JSON objects from [JSON Schema](http://json-schema.org/) definitions and fills them with random fake data.  This is useful for creating sample seed data that must be in a specific structure, e.g. useful for API 
responses.


## Commands

```
php jenerator example:show path/to/schema.json
```

See http://docopt.org/

## Supported Formats


### Standard Formats

- date-time
- email
- hostname
- ipv4
- ipv6
- uri

// http://json-schema.org/latest/json-schema-validation.html#rfc.section.8.3.7
// - 8.3.7. uri-reference
// Examples: https://tools.ietf.org/html/rfc3986#section-1.1.2
uri-reference
    // TODO: mix this up so we aren't just duplicating the 'uri' keyword
    // Examples:
    // ftp://ftp.is.co.za/rfc/rfc1808.txt
    // http://www.ietf.org/rfc/rfc2396.txt
    // ldap://[2001:db8::7]/c=GB?objectClass?one
    // mailto:John.Doe@example.com
    // news:comp.infosystems.www.servers.unix
    // tel:+1-816-555-1212
    // telnet://192.0.2.16:80/
    // urn:oasis:names:specification:docbook:dtd:xml:4.1.2
// - 8.3.8. uri-template
// https://tools.ietf.org/html/rfc6570
uri-template
    // Examples:
    // http://example.com/~{username}/
    // http://example.com/dictionary/{term:1}/{term}
    // http://example.com/search{?q,lang}
// - 8.3.9. json-pointer
// https://tools.ietf.org/html/rfc6901
json-pointer
    // Examples
    // ""           // the whole document
    // "/foo"       ["bar", "baz"]
    // "/foo/0"     "bar"
    // "/"          0
    // "/a~1b"      1
    // "/c%d"       2
    // "/e^f"       3
    // "/g|h"       4
    // "/i\\j"      5
    // "/k\"l"      6
    // "/ "         7
    // "/m~0n"      8
});

### Custom Formats

These are not supported by the official JSON Schema spec.  Validators _should_ ignore these custom formats and any 
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
//        iban
//            return (new Payment(Factory::create(getLocale())))->iban($countryCode);
//        });
- swiftbic

## Limitations

- The jenerator does not support the "not" keyword
- Unreliable support for the "oneOf" keyword
- No support for depends on keyword

## TODO prior to release:

1. List all formats in the README
X 2. Support for pattern + patternProperties
X 3. Support for de-referencing + merging schemas
4. Simplify JsonAccessor interface functions
5. Simplify dependency injection (avoid injecting the entire container)
6. Tests written and passing
X 7. Array: unique items

## Improvements Desired

- improved `allOf` handling
- improved `oneOf` handling
- improved `arrayUnique`