<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 5/3/14
 * Time: 8:16 PM
 */

namespace test\Thybag\SPQuerySchema\LogicalJoins;

require_once('../../../../SharePointAPI.php');

use Thybag\SPQuerySchema\LogicalJoins\LogicalJoinElements;

class LogicalJoinElementsTest extends \PHPUnit_Framework_TestCase {

    public static function setUpBeforeClass() {
    }

    protected function setUp() {

    }

    protected function tearDown() {

    }

    public static function tearDownAfterClass() {

    }

    /**
     * testStaticCAMLJoinWithAnd_WithValidXML
     *
     * @dataProvider simpleXmlAndProvider
     * @covers LogicalJoinElements::CAMLJoinWithAnd
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public function testStaticCAMLJoinWithAnd_WithValidXML(\SimpleXMLElement $comparisonOperators, \SimpleXMLElement $expectedReturn) {

        $actualReturnResults = LogicalJoinElements::CAMLJoinWithAnd($comparisonOperators);

        $this->assertXmlStringEqualsXmlString($expectedReturn->asXML(), $actualReturnResults->asXML());
    }

    public function testStaticArrayJoinWithAnd_WithValidXML() {

    }
    public function arrayAndProvider() {
        return [
            [
                []
            ],
        ];
    }
    public function simpleXmlAndProvider() {
        $firstAndXMLString = <<<XML
<Gt>
  <FieldRef Name = "Field_Name"/>
  <Value Type = "Integer">1</Value>
  <XML />
</Gt>
XML;

        $firstAndXMLElement = New \SimpleXMLElement($firstAndXMLString);

        $firstAndXMLStringExpected = "<And>" . $firstAndXMLString . "</And>";
        $firstAndXMLElementExpected = New \SimpleXMLElement($firstAndXMLStringExpected);

        return [
            [$firstAndXMLElement, $firstAndXMLElementExpected]
        ];
    }
}
 