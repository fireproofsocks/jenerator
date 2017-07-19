<?php

namespace Jenerator\Provider;

use Faker\Factory;
use Faker\Provider\Address;
use Faker\Provider\Barcode;
use Faker\Provider\Color;
use Faker\Provider\DateTime;
use Faker\Provider\File;
use Faker\Provider\Image;
use Faker\Provider\Internet;
use Faker\Provider\Lorem;
use Faker\Provider\Payment;
use Faker\Provider\Person;
use Faker\Provider\PhoneNumber;
use Faker\Provider\Miscellaneous;
use Faker\Provider\UserAgent;
use Faker\Provider\Uuid;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

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
            // http://json-schema.org/latest/json-schema-validation.html#rfc.section.8.3.3
            // see https://dunglas.fr/2014/11/php-7-introducing-a-domain-name-validator-and-making-the-url-validator-stricter/
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

        // http://json-schema.org/latest/json-schema-validation.html#rfc.section.8.3.7
        // - 8.3.7. uri-reference
        // Examples: https://tools.ietf.org/html/rfc3986#section-1.1.2
        $container['uri-reference'] = $container->protect(function($accessor) {
            // TODO: mix this up so we aren't just duplicating the 'uri' keyword
            // Examples:
            $examples = [
                 'ftp://ftp.is.co.za/rfc/rfc1808.txt',
                 'http://www.ietf.org/rfc/rfc2396.txt',
                 'ldap://[2001:db8::7]/c=GB?objectClass?one',
                 'mailto:John.Doe@example.com',
                 'news:comp.infosystems.www.servers.unix',
                 'tel:+1-816-555-1212',
                 'telnet://192.0.2.16:80/',
                 'urn:oasis:names:specification:docbook:dtd:xml:4.1.2'
            ];
            return $examples[array_rand($examples)];
            //return (new Internet(Factory::create(getLocale())))->url();
        });
        // - 8.3.8. uri-template
        // https://tools.ietf.org/html/rfc6570
        $container['uri-template'] = $container->protect(function($accessor) {
            // Examples:
            $examples = [
                'http://example.com/~{username}/',
                'http://example.com/dictionary/{term:1}/{term}',
                'http://example.com/search{?q,lang}'
            ];
            return $examples[array_rand($examples)];
        });
        // - 8.3.9. json-pointer
        // https://tools.ietf.org/html/rfc6901
        $container['json-pointer'] = $container->protect(function($accessor) {
            $examples = [
                '',
                '/foo',
                '/foo/0',
                '/',
                '/a~1b',
                '/c%d',
                '/e^f',
                '/g|h',
                '/i\\j',
                '/k\"l',
                '/ ',
                '/m~0n'
            ];

            return $examples[array_rand($examples)];
        });

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

        // Images
        $container['image-url'] = $container->protect(function($accessor) {
            // imageUrl($width = 640, $height = 480, $category = null, $randomize = true, $word = null, $gray = false)
            $width = $accessor->getKeyword('width', 480);
            $height = $accessor->getKeyword('height', 640);
            return (new Image(Factory::create(getLocale())))->imageUrl($width , $height);
        });

        // File
        $container['mime-type'] = $container->protect(function($accessor) {
            return (new File(Factory::create(getLocale())))->mimeType();
        });
        $container['file-extension'] = $container->protect(function($accessor) {
            // no dot
            return (new File(Factory::create(getLocale())))->fileExtension();
        });


        $container['user-agent'] = $container->protect(function($accessor) {
            return (new UserAgent(Factory::create(getLocale())))->userAgent();
        });


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

        // I18N (internationalization)
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

        // Algorithms : hashes etc
        $container['md5'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->md5();
        });
        $container['sha1'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->sha1();
        });
        $container['sha256'] = $container->protect(function($accessor) {
            return (new Miscellaneous(Factory::create(getLocale())))->sha256();
        });
        $container['uuid'] = $container->protect(function($accessor) {
            return (new Uuid(Factory::create(getLocale())))->uuid();
        });

        // Text
        $container['paragraphs'] = $container->protect(function($accessor) {
            return (new Lorem(Factory::create(getLocale())))->paragraph();
        });

        // Date/time
        $container['unix-timestamp'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->unixTime();
        });
        $container['date'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->date();
        });
        $container['time'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->time();
        });
        $container['am-pm'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->amPm();
        });
        $container['day-of-week'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->dayOfWeek();
        });
        $container['monthname'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->monthName();
        });
        $container['year'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->year();
        });
        $container['timezone'] = $container->protect(function($accessor) {
            return (new DateTime(Factory::create(getLocale())))->timezone();
        });

        // Colors
        $container['color-hex'] = $container->protect(function($accessor) {
            return (new Color(Factory::create(getLocale())))->hexColor();
        });
        $container['color-rgb'] = $container->protect(function($accessor) {
            return (new Color(Factory::create(getLocale())))->rgbColor();
        });
        $container['color-name'] = $container->protect(function($accessor) {
            return (new Color(Factory::create(getLocale())))->colorName();
        });

        // Barcodes
        $container['isbn-10'] = $container->protect(function($accessor) {
            return (new Barcode(Factory::create(getLocale())))->isbn10();
        });
        $container['isbn-13'] = $container->protect(function($accessor) {
            return (new Barcode(Factory::create(getLocale())))->isbn13();
        });
        $container['ean-8'] = $container->protect(function($accessor) {
            return (new Barcode(Factory::create(getLocale())))->ean8();
        });
        $container['ean-13'] = $container->protect(function($accessor) {
            return (new Barcode(Factory::create(getLocale())))->ean13();
        });

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
            $faker = Factory::create(getLocale());
            return $faker->country;
            // This format appears to be broken in Faker?
            //return (new Address(Factory::create(getLocale())))->country();
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
        $container['iban'] = $container->protect(function($accessor) {
            $countryCode = $accessor->getKeyword('countryCode', 'US');
            return (new Payment(Factory::create(getLocale())))->iban($countryCode);
        });
        $container['swiftbic'] = $container->protect(function($accessor) {
            return (new Payment(Factory::create(getLocale())))->swiftBicNumber();
        });
    }
}