<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 5/3/14
 * Time: 8:16 PM
 */

namespace test\Thybag\SPQuerySchema\LogicalJoins;

chdir(dirname(__FILE__));
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
     * testStaticArrayJoinWithAnd_WithValidXML
     *
     * @dataProvider arrayAndProvider
     * @covers Thybag\SPQuerySchema\LogicalJoins\LogicalJoinElements::ArrayJoinWithAnd()
     *
     * @param $inputCAMLArray
     * @param $expectedReturn
     */
    public function testStaticArrayJoinWithAnd_WithValidXML($inputCAMLArray, $expectedReturn) {

        $resultCAML = LogicalJoinElements::ArrayJoinWithAnd($inputCAMLArray);

        $this->assertXmlStringEqualsXmlString($expectedReturn, $resultCAML);
    }

    public function arrayAndProvider() {
        $expectedReturn1 = <<<XML
<And>
    <BeginsWith>
        <FieldRef name="LastName" />
        <Value type="Integer">1</Value>
    </BeginsWith>
</And>
XML;

        return array(
            array(
                array(
                    'BeginsWith' => array(
                        'FieldRef' => array(
                            'name' => 'LastName'
                        ),
                        'Value' => array(
                            'type' => 'Integer',
                            'value' => 1
                        )
                    )),
                $expectedReturn1
            )
        );
    }

}
 