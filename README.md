# Jenerator

This package generates JSON objects from [JSON Schema](http://json-schema.org/) definitions and fills them with random fake data.  This is useful for creating sample seed data that must be in a specific structure, e.g. useful for API 
responses.

See http://docopt.org/

## Not Yet Implemented

- Support for "not" keyword.
- Support for regular expressions, e.g. "pattern" and "patternProperties"
- Support for formats: 
    - 8.3.7. uri-reference
    - 8.3.8. uri-template
    - 8.3.9. json-pointer


## Nice to Have: Custom Formats 

- macaddress
- tld
- domain (hostname)
- slug
- password
- username
- phonenumber-us 555-123-546
- phonenumber +555123546
- mime-type
- file-extension (no dot)
- file (an absolute path to a temp file)
- user-agent
- uuid (e.g. 7e57d004-2b97-0e7a-b45f-5387367791cd)
- person-title
- person-firstname
- person-lastname
- person-gender (male, female, null)
- language-code
- country-code-2 (see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
- country-code-3 (see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3)
- currency-code
- locale
- md5
- sha1
- sha256
- paragraphs
- unix-timestamp
- date (e.g. 2008-11-27)
- time (e.g. 23:59:59)
- ampm (e.g. am)
- day-of-week (e.g. Wednesday)
- monthname 
- year
- timezone
- color-hex
- color-rgb
- color-name
- isbn-10
- isbn-13

- address-city
- address-street
- address-postcode
- address-country
- latitude
- longitude
- coordinates (lat, lng as a string)

- creditcard-number
- creditcard-type
- creditcard-exp-date (as m/y)
- swiftbic


## Supported Regex Generator Functions

- 0-9
- a-z
- a-zA-Z
- 0-9a-zA-Z