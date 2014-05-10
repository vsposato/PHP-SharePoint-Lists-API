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

        $this->assertEquals($expectedReturn, $resultCAML);
    }

    public function arrayAndProvider() {
        $expectedReturn1 = <<<XML1
<And>
    <BeginsWith>
        <FieldRef name="LastName"/>
        <Value type="Integer">1</Value>
    </BeginsWith>
</And>
XML1;

        $beginsWithXMLStringXMLDouble = <<<XML1
<And>
    <BeginsWith>
        <FieldRef Name="_LastName"/>
        <Value Type="Text">Smith</Value>
    </BeginsWith>
    <BeginsWith>
        <FieldRef Name="_FirstName"/>
        <Value Type="Text">John</Value>
    </BeginsWith>
</And>
XML1;
        $beginsWithXMLStringXMLTriple = <<<XML2
<And>
    <And>
        <BeginsWith>
            <FieldRef Name="_LastName"/>
            <Value Type="Text">Smith</Value>
        </BeginsWith>
        <BeginsWith>
            <FieldRef Name="_FirstName"/>
            <Value Type="Text">John</Value>
        </BeginsWith>
    </And>
    <And>
        <BeginsWith>
            <FieldRef Name="_MiddleName"/>
            <Value Type="Text">Q</Value>
        </BeginsWith>
    </And>
</And>
XML2;
        $beginsWithXMLStringXMLQuadruple = <<<XML2
<And>
    <And>
        <BeginsWith>
            <FieldRef Name="_LastName"/>
            <Value Type="Text">Smith</Value>
        </BeginsWith>
        <BeginsWith>
            <FieldRef Name="_FirstName"/>
            <Value Type="Text">John</Value>
        </BeginsWith>
    </And>
    <And>
        <BeginsWith>
            <FieldRef Name="_MiddleName"/>
            <Value Type="Text">Q</Value>
        </BeginsWith>
        <BeginsWith>
            <FieldRef Name="City"/>
            <Value Type="Text">Gainesville</Value>
        </BeginsWith>
    </And>
</And>
XML2;
        $beginsWithXMLStringXMLQuintuple = <<<XML2
<And>
    <And>
        <And>
            <BeginsWith>
                <FieldRef Name="_LastName"/>
                <Value Type="Text">Smith</Value>
            </BeginsWith>
            <BeginsWith>
                <FieldRef Name="_FirstName"/>
                <Value Type="Text">John</Value>
            </BeginsWith>
        </And>
        <And>
            <BeginsWith>
                <FieldRef Name="_MiddleName"/>
                <Value Type="Text">Q</Value>
            </BeginsWith>
            <BeginsWith>
                <FieldRef Name="City"/>
                <Value Type="Text">Gainesville</Value>
            </BeginsWith>
        </And>
    </And>
    <And>
        <BeginsWith>
            <FieldRef Name="State"/>
            <Value Type="Text">Florida</Value>
        </BeginsWith>
    </And>
</And>
XML2;


        return array(
            array(
                array(
                    'And' => array(
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'name' => 'LastName'
                                ),
                                'Value'    => array(
                                    'type'  => 'Integer',
                                    'value' => 1
                                )
                            )
                        )
                    )
                ),
                $expectedReturn1
            ),
            array(
                array(
                    'And' => array(
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        )
                    )
                ),
                $beginsWithXMLStringXMLDouble
            ),
            array(
                array(
                    'And' => array(
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        )
                    )
                ),
                $beginsWithXMLStringXMLTriple
            ),
            array(
                array(
                    'And' => array(
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => 'City'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Gainesville'
                                )
                            )
                        )
                    )
                ),
                $beginsWithXMLStringXMLQuadruple
            ),
            array(
                array(
                    'And' => array(
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => '_LastName'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => 'City'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Gainesville'
                                )
                            )
                        ),
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    'Name' => 'State'
                                ),
                                'Value'    => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Florida'
                                )
                            )
                        )
                    )
                ),
                $beginsWithXMLStringXMLQuintuple
            )
        );
    }

}
 