<?php

namespace Jenerator\Provider;

use Faker\Factory;
use Faker\Provider\Address;
use Faker\Provider\Base;
use Faker\Provider\DateTime;
use Faker\Provider\Internet;
use Faker\Provider\Lorem;
use Faker\Provider\Payment;
use Faker\Provider\Person;
use Faker\Provider\PhoneNumber;
use Faker\Provider\Miscellaneous;
use Faker\Provider\UserAgent;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

// See https://www.shellhacks.com/linux-define-locale-language-settings/

/**
 * Class FormatFakerProvider
 *
 * Define callbacks for each supported format: the key in the container should match the format exactly.
 * All functions are passed an instance of the jsonAccessor for the schema or sub-schema which contains the
 * "format" keyword, so this may be used to read the neighboring properties.
 *
 * @see https://spacetelescope.github.io/understanding-json-schema/reference/string.html
 * @package Jenerator\Provider
 */
class FormatFakerProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container)
    {
        // Standard Formats
        $container['date-time'] = $container->protect(function($accessor) {
            return DateTime::iso8601();
        });
        $container['email'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->email();
        });
        $container['hostname'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->domainName();
        });
        $container['ipv4'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->ipv4();
        });
        $container['ipv6'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->ipv6();
        });
        $container['uri'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->url();
        });

        // - 8.3.7. uri-reference
        // - 8.3.8. uri-template
        // - 8.3.9. json-pointer

        // Custom Formats
        // Internet
        $container['macaddress'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->macAddress();
        });
        $container['tld'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->tld();
        });
        // domain (see hostname)
        $container['slug'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->slug();
        });
        $container['password'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->password();
        });
        $container['username'] = $container->protect(function($accessor) {
            return (new Internet(Factory::create(getLocale())))->userName();
        });

        // Phone
        $container['phonenumber'] = $container->protect(function($accessor) {
            return (new PhoneNumber(Factory::create(getLocale())))->phoneNumber();
        });
        // https://en.wikipedia.org/wiki/E.164
        $container['phonenumber-e164'] = $container->protect(function($accessor) {
            return (new PhoneNumber(Factory::create(getLocale())))->e164PhoneNumber();
        });
        // http://en.wikipedia.org/wiki/International_Mobile_Station_Equipment_Identity
        $container['imei'] = $container->protect(function($accessor) {
            return (new PhoneNumber(Factory::create(getLocale())))->imei();
        });


    //    - mime-type
    //    - file-extension (no dot)
    //- file (an absolute path to a temp file)
        $container['user-agent'] = function ($c) {
            return (new UserAgent(Factory::create(getLocale())))->userAgent();
        };
    //- uuid (e.g. 7e57d004-2b97-0e7a-b45f-5387367791cd)

        $container['person-title'] = $container->protect(function($accessor) {
            return (new Person(Factory::create(getLocale())))->title();
        });
        $container['person-name'] = $container->protect(function($accessor) {
            return (new Person(Factory::create(getLocale())))->name();
        });
        $container['person-firstname'] = $container->protect(function($accessor) {
            return (new Person(Factory::create(getLocale())))->firstName();
        });
        $container['person-lastname'] = $container->protect(function($accessor) {
            return (new Person(Factory::create(getLocale())))->lastName();
        });
        //- person-gender (male, female, null)

        $container['language-code'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->languageCode();
        });
        // (see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
        $container['country-code-2'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->countryCode();
        });
        //-  (see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3)
        $container['country-code-3'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->countryISOAlpha3();
        });
        $container['currency-code'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->currencyCode();
        });
        $container['locale'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->locale();
        });

        // Algorithms : hashes
        $container['md5'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->md5();
        });
        $container['sha1'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->sha1();
        });
        $container['sha256'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->sha256();
        });

        // Text
        $container['paragraphs'] = $container->protect(function($accessor) {
            return (new Lorem(Factory::create(getLocale())))->paragraph();
        });

    //- unix-timestamp
    //- date (e.g. 2008-11-27)
    //- time (e.g. 23:59:59)
    //- ampm (e.g. am)
    //- day-of-week (e.g. Wednesday)
    //- monthname
    //- year
        $container['timezone'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->timezone();
        });

    //- color-hex
    //- color-rgb
    //- color-name

    //- isbn-10
    //- isbn-13
    //
        // Address
        $container['address-city'] = $container->protect(function($accessor) {
            return (new Address(Factory::create(getLocale())))->city();
        });
        $container['address-streetaddress'] = $container->protect(function($accessor) {
            return (new Address(Factory::create(getLocale())))->streetAddress();
        });
        $container['address-streetname'] = $container->protect(function($accessor) {
            return (new Address(Factory::create(getLocale())))->streetName();
        });
        $container['address-postcode'] = $container->protect(function($accessor) {
            return (new Address(Factory::create(getLocale())))->postcode();
        });
        $container['address-country'] = $container->protect(function($accessor) {
            return (new Address(Factory::create(getLocale())))->country();
        });

        // Latitude/Longitude
        $container['latitude'] = $container->protect(function($accessor) {
            return (new Address(Factory::create(getLocale())))->latitude();
        });
        $container['longitude'] = $container->protect(function($accessor) {
            return (new Address(Factory::create(getLocale())))->longitude();
        });
        $container['coordinates'] = $container->protect(function($accessor) {
            return implode(',', array_values((new Address(Factory::create(getLocale())))->localCoordinates()));
        });

        // Payment
        $container['creditcard-number'] = $container->protect(function($accessor) {
            return (new Payment(Factory::create(getLocale())))->creditCardNumber();
        });
        $container['creditcard-type'] = $container->protect(function($accessor) {
            return (new Payment(Factory::create(getLocale())))->creditCardType();
        });
        $container['creditcard-exp-date'] = $container->protect(function($accessor) {
            return (new Payment(Factory::create(getLocale())))->creditCardExpirationDateString();
        });
//        $container['iban'] = $container->protect(function($accessor) {
//            return (new Payment(Factory::create(getLocale())))->iban($countryCode);
//        });
        $container['swiftbic'] = $container->protect(function($accessor) {
            return (new Payment(Factory::create(getLocale())))->swiftBicNumber();
        });
    }
}