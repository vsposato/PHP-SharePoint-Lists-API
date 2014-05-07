<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 5/4/14
 * Time: 4:09 PM
 */

namespace test\Thybag\SPQuerySchema;

chdir(dirname(__FILE__));

require_once('../../../SharePointAPI.php');

use Thybag\SPQuerySchema\SPQuerySchema;

class SPQuerySchemaTest extends \PHPUnit_Framework_TestCase {

    public static function setUpBeforeClass() {
    
    }

    protected function setUp() {
        parent::setUp();
    }

    protected function tearDown() {

        parent::tearDown();
    }

    public static function tearDownAfterClass() {

    }

    /**
     *
     * @dataProvider booleanProvider
     * @covers Thybag\SPQuerySchema\SPQuerySchema::validateElements()
     * @covers Thybag\SPQuerySchema\SPQuerySchema::validateBoolean()
     *
     * @param $elementToValidate
     * @param $expectedReturn
     */
    public function testValidateElements_Boolean($elementToValidate, $expectedReturn) {
        $returnResults = SPQuerySchema::validateElements($elementToValidate, "Boolean");

        $this->assertEquals($returnResults, $expectedReturn);
    }

    /**
     *
     * @dataProvider stringProvider
     * @covers Thybag\SPQuerySchema\SPQuerySchema::validateElements()
     * @covers Thybag\SPQuerySchema\SPQuerySchema::validateString()
     *
     * @param $elementToValidate
     * @param $expectedReturn
     */
    public function testValidateElements_String($elementToValidate, $expectedReturn) {
        $returnResults = SPQuerySchema::validateElements($elementToValidate, "String");

        $this->assertEquals($returnResults, $expectedReturn);
    }

    /**
     *
     * @dataProvider urlProvider
     * @covers Thybag\SPQuerySchema\SPQuerySchema::validateElements();
     * @covers Thybag\SPQuerySchema\SPQuerySchema::validateURL();
     *
     * @param $elementToValidate
     * @param $expectedReturn
     */
    public function testValidateELements_URL($elementToValidate, $expectedReturn) {
        $returnResults = SPQuerySchema::validateElements($elementToValidate, "URL");

        $this->assertEquals($returnResults, $expectedReturn);
    }

    public function booleanProvider() {

        return array(
            array(0, FALSE),
            array(FALSE, TRUE),
            array(TRUE, TRUE),
            array("Dog", FALSE),
            array(34, FALSE)
        );
    }

    public function stringProvider() {

        return array(
            array(0, FALSE),
            array(0.25, FALSE),
            array(FALSE, FALSE),
            array(TRUE, FALSE),
            array("Dog", TRUE),
            array("The #1 Dog Book!", TRUE)
        );
    }

    public function urlProvider() {
        return array(
            array("http://www.google.com", TRUE),
            array("www.google.com", FALSE),
            array("google", FALSE),
            array("https://www.bankofamerica.ru/pathToFile", TRUE),
            array("ssh://www.bankofamerica.ru/pathToFile", FALSE),
            array("https://02dog\\/pathToFile", FALSE),
        );
    }
}
 