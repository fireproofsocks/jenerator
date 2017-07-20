<?php

namespace JeneratorTest\FormatFaker;

use Jenerator\FormatFaker\FormatFakerFactoryInterface;
use JeneratorTest\TestCase;

use DateTime;

class FormatFakerFunctionsTest extends TestCase
{
    /**
     * @var FormatFakerFactoryInterface
     */
    protected $faker;

    protected function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function setUp()
    {
        $this->faker = $this->container->make(FormatFakerFactoryInterface::class);
    }

    /**
     * @expectedException \Jenerator\Exceptions\FormatFakerNotDefinedException
     */
    public function testFormatFakerNotDefinedExceptionThrownForUndefinedFormat()
    {
        $this->faker->getFakeDataForFormat('does-not-exist', $this->getSchemaAccessor());
    }

    public function testDateTime()
    {
        $actual = $this->faker->getFakeDataForFormat('date-time', $this->getSchemaAccessor());
        $this->assertTrue($this->validateDate($actual, \DateTime::ISO8601));
    }

    public function testEmail()
    {
        $actual = $this->faker->getFakeDataForFormat('email', $this->getSchemaAccessor());
        $this->assertTrue((bool)filter_var($actual, FILTER_VALIDATE_EMAIL));
    }

    public function testHostname()
    {
        // TODO: this is pretty poor
        $actual = $this->faker->getFakeDataForFormat('hostname', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testIpv4()
    {
        $actual = $this->faker->getFakeDataForFormat('ipv4', $this->getSchemaAccessor());
        $this->assertTrue((bool)filter_var($actual, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    }

    public function testIpv6()
    {
        $actual = $this->faker->getFakeDataForFormat('ipv6', $this->getSchemaAccessor());
        $this->assertTrue((bool)filter_var($actual, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6));
    }

    public function testUri()
    {
        $actual = $this->faker->getFakeDataForFormat('uri', $this->getSchemaAccessor());
        $this->assertTrue((bool)filter_var($actual, FILTER_VALIDATE_URL));
    }

    public function testUriReference()
    {
        // TODO
        $actual = $this->faker->getFakeDataForFormat('uri-reference', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testUriTemplate()
    {
        // TODO
        $actual = $this->faker->getFakeDataForFormat('uri-template', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testJsonPointer()
    {
        // TODO
        $actual = $this->faker->getFakeDataForFormat('json-pointer', $this->getSchemaAccessor());
        $this->assertTrue(is_string($actual)); // this may actually be an empty string
    }

    public function testMacAddress()
    {
        $actual = $this->faker->getFakeDataForFormat('macaddress', $this->getSchemaAccessor());
        $this->assertTrue((bool)filter_var($actual, FILTER_VALIDATE_MAC));
    }

    public function testTld()
    {
        $actual = $this->faker->getFakeDataForFormat('tld', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testSlug()
    {
        // TODO
        $actual = $this->faker->getFakeDataForFormat('slug', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testPassword()
    {
        $actual = $this->faker->getFakeDataForFormat('password', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testUsername()
    {
        $actual = $this->faker->getFakeDataForFormat('username', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testPhoneNumber()
    {
        $actual = $this->faker->getFakeDataForFormat('phonenumber', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testPhoneNumberE164()
    {
        $actual = $this->faker->getFakeDataForFormat('phonenumber-e164', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testImei()
    {
        $actual = $this->faker->getFakeDataForFormat('imei', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testImageUrlDefaults()
    {
        $actual = $this->faker->getFakeDataForFormat('image-url', $this->getSchemaAccessor());
        $this->assertTrue(strpos($actual, 'http://lorempixel.com/480/640/') === 0);
    }
    public function testImageUrlDimensions()
    {
        $actual = $this->faker->getFakeDataForFormat('image-url', $this->getSchemaAccessor(['width' => 333, 'height' => 444]));
        $this->assertTrue(strpos($actual, 'http://lorempixel.com/333/444/') === 0);
    }

    public function testMimeType()
    {
        $actual = $this->faker->getFakeDataForFormat('mime-type', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testFileExtension()
    {
        $actual = $this->faker->getFakeDataForFormat('file-extension', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testUserAgent()
    {
        $actual = $this->faker->getFakeDataForFormat('user-agent', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testPersonTitle()
    {
        $actual = $this->faker->getFakeDataForFormat('person-title', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testPersonName()
    {
        $actual = $this->faker->getFakeDataForFormat('person-name', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testPersonFirstname()
    {
        $actual = $this->faker->getFakeDataForFormat('person-firstname', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testPersonLastname()
    {
        $actual = $this->faker->getFakeDataForFormat('person-lastname', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testLanguageCode()
    {
        $actual = $this->faker->getFakeDataForFormat('language-code', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
        $this->assertEquals(strlen($actual), 2);
    }
    public function testCountryCode2()
    {
        $actual = $this->faker->getFakeDataForFormat('country-code-2', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
        $this->assertEquals(strlen($actual), 2);
    }
    public function testCountryCode3()
    {
        $actual = $this->faker->getFakeDataForFormat('country-code-3', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
        $this->assertEquals(strlen($actual), 3);
    }
    public function testCurrencyCode()
    {
        $actual = $this->faker->getFakeDataForFormat('currency-code', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
        $this->assertEquals(strlen($actual), 3);
    }
    public function testLocale()
    {
        $actual = $this->faker->getFakeDataForFormat('locale', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testMd5()
    {
        $actual = $this->faker->getFakeDataForFormat('md5', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
        $this->assertEquals(32, strlen($actual));
    }

    public function testSha1()
    {
        $actual = $this->faker->getFakeDataForFormat('sha1', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
        $this->assertEquals(40, strlen($actual));
    }

    public function testSha256()
    {
        $actual = $this->faker->getFakeDataForFormat('sha256', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
        $this->assertEquals(64, strlen($actual));
    }

    public function testUuid()
    {
        $actual = $this->faker->getFakeDataForFormat('uuid', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
        $this->assertEquals(36, strlen($actual));
    }
    public function testParagraphs()
    {
        $actual = $this->faker->getFakeDataForFormat('paragraphs', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testUnixTimestamp()
    {
        $actual = $this->faker->getFakeDataForFormat('unix-timestamp', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testDate()
    {
        $actual = $this->faker->getFakeDataForFormat('date', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testTime()
    {
        $actual = $this->faker->getFakeDataForFormat('time', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testAmPm()
    {
        $actual = $this->faker->getFakeDataForFormat('am-pm', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testDayOfWeek()
    {
        $actual = $this->faker->getFakeDataForFormat('day-of-week', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testMonthname()
    {
        $actual = $this->faker->getFakeDataForFormat('monthname', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testYear()
    {
        $actual = $this->faker->getFakeDataForFormat('year', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testTimezone()
    {
        $actual = $this->faker->getFakeDataForFormat('timezone', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testColorHex()
    {
        $actual = $this->faker->getFakeDataForFormat('color-hex', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testColorRgb()
    {
        $actual = $this->faker->getFakeDataForFormat('color-rgb', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testColorName()
    {
        $actual = $this->faker->getFakeDataForFormat('color-name', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testIsbn10()
    {
        $actual = $this->faker->getFakeDataForFormat('isbn-10', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testIsbn13()
    {
        $actual = $this->faker->getFakeDataForFormat('isbn-13', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testEan8()
    {
        $actual = $this->faker->getFakeDataForFormat('ean-8', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testEan13()
    {
        $actual = $this->faker->getFakeDataForFormat('ean-13', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testAddressCity()
    {
        $actual = $this->faker->getFakeDataForFormat('address-city', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testAddressStreetAddress()
    {
        $actual = $this->faker->getFakeDataForFormat('address-streetaddress', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testAddressStreetname()
    {
        $actual = $this->faker->getFakeDataForFormat('address-streetname', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testAddressPostcode()
    {
        $actual = $this->faker->getFakeDataForFormat('address-postcode', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testAddressCountry()
    {
        $actual = $this->faker->getFakeDataForFormat('address-country', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testLatitude()
    {
        $actual = $this->faker->getFakeDataForFormat('latitude', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testLongitude()
    {
        $actual = $this->faker->getFakeDataForFormat('longitude', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testCoordinates()
    {
        $actual = $this->faker->getFakeDataForFormat('coordinates', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }

    public function testCreditCardNumber()
    {
        $actual = $this->faker->getFakeDataForFormat('creditcard-number', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testCreditCardType()
    {
        $actual = $this->faker->getFakeDataForFormat('creditcard-type', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testCreditCardExpDate()
    {
        $actual = $this->faker->getFakeDataForFormat('creditcard-exp-date', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testIbanDefault()
    {
        $actual = $this->faker->getFakeDataForFormat('iban', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
    public function testIbanWithCountryCode()
    {
        $actual = $this->faker->getFakeDataForFormat('iban', $this->getSchemaAccessor(['countryCode' => 'DE']));
        $this->assertNotEmpty($actual);
    }
    public function testSwiftbic()
    {
        $actual = $this->faker->getFakeDataForFormat('swiftbic', $this->getSchemaAccessor());
        $this->assertNotEmpty($actual);
    }
}