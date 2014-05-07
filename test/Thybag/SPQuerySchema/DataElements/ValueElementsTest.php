<?php
    /**
     * Created by PhpStorm.
     * User: vsposato
     * Date: 5/4/14
     * Time: 3:58 PM
     */

    namespace test\Thybag\SPQuerySchema\DataElements;

    chdir(dirname(__FILE__));
    require_once('../../../../SharePointAPI.php');

    use Thybag\SPQuerySchema\DataElements\ValueElements;

    /**
     * Class is meant to be used to test a static function that has a path that could not be touched
     * through the static calling function
     *
     * Class inheritValueElements
     * @package test\Thybag\SPQuerySchema\DataElements
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    class inheritValueElements extends ValueElements {

        /**
         * Used to test a single possibility that could not be tested in another way
         *
         * @param $fieldReferenceDefinitionArray
         * @return array|bool
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function validateFieldRefKeys($fieldReferenceDefinitionArray) {
            return self::_validateFieldRefKeys($fieldReferenceDefinitionArray);
        }
    }
    class ValueElementsTest extends \PHPUnit_Framework_TestCase {

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
         * testCreateFieldRef
         *
         * @dataProvider fieldRefProvider
         * @covers Thybag\SPQuerySchema\DataElements\ValueElements::ArrayFieldRef()
         * @covers Thybag\SPQuerySchema\DataElements\ValueElements::_validateFieldRefKeys()
         *
         * @param $arrayToBeConverted
         * @param $expectedResult
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function testArrayFieldRef( $arrayToBeConverted, $expectedResult ) {

            $returnResults = ValueELements::ArrayFieldRef( $arrayToBeConverted );

            $this->assertEquals( $expectedResult, $returnResults );

        }

        /**
         * testCreateFieldRefUnsuccessful-EmptyArray
         *
         * @covers Thybag\SPQuerySchema\DataElements\ValueElements::_validateFieldRefKeys()
         *
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function testCreateFieldRefUnsuccessful() {

            $valueElementsChildClass = new inheritValueElements();

            $returnResults = $valueElementsChildClass->validateFieldRefKeys( array() );

            $this->assertEquals( FALSE, $returnResults );

        }

        /**
         * testArrayValuesXML
         *
         * @dataProvider valuesArrayProvider
         * @covers Thybag\SPQuerySchema\DataElements\ValueElements::ArrayValuesXML()
         *
         * @param $arrayToBeConverted
         * @param $expectedResult
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function testArrayValuesXML( $arrayToBeConverted, $expectedResult ) {

            $returnResults = ValueElements::ArrayValuesXML( $arrayToBeConverted );

            $this->assertEquals( $expectedResult, $returnResults );
        }

        /**
         * testArrayValueXML
         *
         * @dataProvider valueArrayProvider
         * @covers Thybag\SPQuerySchema\DataElements\ValueElements::ArrayValueXML()
         *
         * @param $arrayToBeConverted
         * @param $expectedResult
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function testArrayValueXML( $arrayToBeConverted, $expectedResult ) {

            $returnResults = ValueElements::ArrayValueXML( $arrayToBeConverted );

            $this->assertEquals( $expectedResult, $returnResults );
        }

        /**
         * testXMLElement
         *
         * @dataProvider xmlXMLProvider
         * @covers Thybag\SPQuerySchema\DataElements\ValueElements::XMLElement()
         *
         * @param $xmlStringToTest
         * @param $expectedResult
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function testXMLElement( $xmlStringToTest, $expectedResult ) {

            $returnResults = ValueElements::XMLElement( $xmlStringToTest );

            $this->assertEquals( $expectedResult, $returnResults );

        }

        public function xmlXMLProvider() {
            $xmlString = <<<XML1
<Values><Value Type="Integer">1</Value><Value Type="Boolean">True</Value></Values>
XML1;
            $xmlStringReturn = <<<XML1
<XML><Values><Value Type="Integer">1</Value><Value Type="Boolean">True</Value></Values></XML>
XML1;

            $xmlString2 = <<<XML2
<Values><Value Type="Text">This is test text!</Value></Values>
XML2;
            $xmlString2Return = <<<XML2
<XML><Values><Value Type="Text">This is test text!</Value></Values></XML>
XML2;

            $xmlString3 = <<<XML3
<Values><Value Type="Boolean">True</Value></Values>
XML3;
            $xmlString3Return = <<<XML3
<XML><Values><Value Type="Boolean">True</Value></Values></XML>
XML3;

            $xmlString4 = "";
            $xmlString4Return = "<XML></XML>";

            return array(
                array($xmlString, $xmlStringReturn),
                array($xmlString2, $xmlString2Return),
                array($xmlString3, $xmlString3Return),
                array($xmlString4, $xmlString4Return),
            );
        }

        /**
         * valuesArrayProvider
         *
         * Provides data for the testArrayValuesXML functionality
         *
         * @return array
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function valuesArrayProvider() {
            $xmlString = <<<XML1
<Values><Value Type="Integer">1</Value><Value Type="Boolean">True</Value></Values>
XML1;
            $xmlString2 = <<<XML2
<Values><Value Type="Text">This is test text!</Value></Values>
XML2;
            $xmlString3 = <<<XML3
<Values><Value Type="Boolean">True</Value></Values>
XML3;

            return array(
                array(
                    array(
                        'Values' => array(
                            array(
                                'Value' => array(
                                    'Type'  => 'Integer',
                                    'Value' => 1
                                )
                            ),
                            array(
                                'Value' => array(
                                    'Type'  => 'Boolean',
                                    'Value' => 'True'
                                )
                            )
                        )
                    ),
                    $xmlString
                ),
                // Test missing Values key, but properly formatted the rest of the way - should pass
                array(
                    array(
                        array(
                            'Value' => array(
                                'Type'  => 'Integer',
                                'Value' => 1
                            )
                        ),
                        array(
                            'Value' => array(
                                'Type'  => 'Boolean',
                                'Value' => 'True'
                            )
                        )
                    ),
                    $xmlString
                ),
                // Test missing Values key, but not properly formatted the rest of the way - should fail
                array(
                    array(
                        array(
                            'ValueNot' => array(
                                'Type'  => 'Integer',
                                'Value' => 1
                            )
                        ),
                        array(
                            'ValueNot' => array(
                                'Type'  => 'Boolean',
                                'Value' => 'True'
                            )
                        )
                    ),
                    FALSE
                ),
                array(
                    array(
                        'Values' => array(
                            array(
                                'Value' => array(
                                    'Type'  => 'GuidWrong',
                                    'Value' => '{AC0923-CD0923-DD092A}'
                                )
                            ),
                            array(
                                'Value' => array(
                                    'Type'  => 'Text',
                                    'Value' => "This is test text!"
                                )
                            )
                        )
                    ),
                    $xmlString2
                ),
                array(
                    array(
                        'Values' => array(
                            array(
                                'Value' => array(
                                    'Type'  => 'GuidWrong',
                                    'Value' => '{AC0923-CD0923-DD092A}'
                                )
                            ),
                            array(
                                'Value' => array(
                                    'Type'  => 'Boolean',
                                    'Value' => "True"
                                )
                            ),
                            array(
                                'Value' => array(
                                    'Type'  => 'WorkflowStatusWrong',
                                    'Value' => "NotHere"
                                )
                            )
                        )
                    ),
                    $xmlString3
                ),
                array(
                    array(
                        'Value' => array(
                            array(
                                'Value' => array(
                                    'Type'  => 'GuidWrong',
                                    'Value' => '{AC0923-CD0923-DD092A}'
                                )
                            ),
                            array(
                                'Value' => array(
                                    'Type'  => 'Boolean',
                                    'Value' => "True"
                                )
                            ),
                            array(
                                'Value' => array(
                                    'Type'  => 'WorkflowStatusWrong',
                                    'Value' => "NotHere"
                                )
                            )
                        )
                    ),
                    FALSE
                ),
                array(
                    array(
                        'Values' => array(
                            array(
                                'Value' => array(
                                    'Type'  => 'GuidWrong',
                                    'Value' => '{AC0923-CD0923-DD092A}'
                                )
                            ),
                            array(
                                'Value' => array(
                                    'Type'  => 'WorkflowStatusWrong',
                                    'Value' => "NotHere"
                                )
                            )
                        )
                    ),
                    FALSE
                ),
                array(
                    'BadData',
                    FALSE
                )
            );

        }

        /**
         * valueArrayProvider
         *
         * Provides data for the testArrayValueXML functionality
         *
         * @return array
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function valueArrayProvider() {
            $xmlString = <<<XML1
<Value Type="Boolean">True</Value>
XML1;
            $xmlString2 = <<<XML2
<Value Type="Text">This is test text!</Value>
XML2;
            $xmlString3 = <<<XML3
<Value Type="Boolean">True</Value>
XML3;
            $xmlString4 = <<<XML4
<Value Type="DateTime" IncludeTimeValue="True">True</Value>
XML4;
            $xmlString5 = <<<XML5
<Value Type="DateTime" IncludeTimeValue="False">True</Value>
XML5;

            return array(
                array(
                    array(
                        'Value' => array(
                            'Type'  => 'Boolean',
                            'Value' => 'True'
                        )
                    ),
                    $xmlString
                ),
                // Test with missing main value key, but rest is correct - should pass
                array(
                    array(
                        'Type'  => 'Boolean',
                        'Value' => 'True'
                    ),
                    $xmlString
                ),
                // Test with missing main value key, and rest is wrong - should fail
                array(
                    array(
                        'TypeNot'  => 'Boolean',
                        'ValueNot' => 'True'
                    ),
                    FALSE
                ),
                array(
                    array(
                        'Value' => array(
                            'Type'  => 'Text',
                            'Value' => "This is test text!"
                        )
                    ),
                    $xmlString2
                ),
                array(
                    array(
                        'Value' => array(
                            'Type'  => 'Boolean',
                            'Value' => "True"
                        )
                    ),
                    $xmlString3
                ),
                array(
                    array(
                        'Value' => array(
                            'Type'             => 'DateTime',
                            'Value'            => "True",
                            'IncludeTimeValue' => "True"
                        )
                    ),
                    $xmlString4
                ),
                array(
                    array(
                        'Value' => array(
                            'Type'             => 'DateTime',
                            'Value'            => "True",
                            'IncludeTimeValue' => "False"
                        )
                    ),
                    $xmlString5
                ),
                array(
                    array(
                        'Value' => array(
                            'Types' => 'Boolean',
                            'Value' => "True"
                        )
                    ),
                    FALSE
                ),
                array(
                    array(
                        'Value' => array(
                            'Type'   => 'Boolean',
                            'Values' => "True"
                        )
                    ),
                    FALSE
                ),
                array(
                    array(
                        'Value' => array(
                            'Type'  => 'BooleanWrong',
                            'Value' => "True"
                        )
                    ),
                    FALSE
                ),
                array(
                    'BadData',
                    FALSE
                )
            );
        }

        /**
         * fieldRefProvider
         *
         * Provides data for the testArrayFieldRef functionality
         *
         * @return array
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function fieldRefProvider() {
            $xmlString = <<<XML1
<FieldRef Alias="Last Name" Ascending="True" CreateURL="http://www.example.com" DisplayName="Customer Last Name" Explicit="False" Format="TestFormat" ID="{AC0923-CD0923-DD092A}" Key="Primary" Name="_LastName" />
XML1;
            $xmlString2 = <<<XML2
<FieldRef Alias="First Name" Ascending="False" DisplayName="Customer First Name" Explicit="True" Name="_FirstName" />
XML2;

            return array(
                array(
                    array(
                        'FieldRef' => array(
                            'Alias'       => 'Last Name',
                            'Ascending'   => TRUE,
                            'CreateURL'   => 'http://www.example.com',
                            'DisplayName' => 'Customer Last Name',
                            'Explicit'    => FALSE,
                            'Format'      => 'TestFormat',
                            'ID'          => '{AC0923-CD0923-DD092A}',
                            'Key'         => 'Primary',
                            'Name'        => '_LastName'
                        )
                    ), $xmlString
                ),
                // Test properly formatted array with no valid keys, should return false
                array(
                    array(
                        'FieldRef' => array(
                            'AliasNot'       => 'Last Name',
                            'AscendingNot'   => TRUE,
                            'CreateURLNot'   => 'http://www.example.com',
                            'DisplayNameNot' => 'Customer Last Name',
                            'ExplicitNot'    => FALSE,
                            'FormatNot'      => 'TestFormat',
                            'IDNot'          => '{AC0923-CD0923-DD092A}',
                            'KeyNot'         => 'Primary',
                            'NameNot'        => '_LastName'
                        )
                    ), FALSE
                ),
                array(
                    // Test array missing field ref key with valid keys in it, should return correct string
                    array(
                        'Alias'       => 'Last Name',
                        'Ascending'   => TRUE,
                        'CreateURL'   => 'http://www.example.com',
                        'DisplayName' => 'Customer Last Name',
                        'Explicit'    => FALSE,
                        'Format'      => 'TestFormat',
                        'ID'          => '{AC0923-CD0923-DD092A}',
                        'Key'         => 'Primary',
                        'Name'        => '_LastName'
                    ), $xmlString
                ),
                // Test array missing field ref key with no valid keys in it, should return false
                array(
                    array(
                        'AliasNot'       => 'Last Name',
                        'AscendingNot'   => TRUE,
                        'CreateURLNot'   => 'http://www.example.com',
                        'DisplayNameNot' => 'Customer Last Name',
                        'ExplicitNot'    => FALSE,
                        'FormatNot'      => 'TestFormat',
                        'IDNot'          => '{AC0923-CD0923-DD092A}',
                        'KeyNot'         => 'Primary',
                        'NameNot'        => '_LastName'
                    ), FALSE
                ),
                array(
                    array(
                        'FieldRefs' => array(
                            'Alias'       => 'Last Name',
                            'Ascending'   => TRUE,
                            'CreateURL'   => 'http://www.example.com',
                            'DisplayName' => 'Customer Last Name',
                            'Explicit'    => FALSE,
                            'Format'      => 'TestFormat',
                            'ID'          => '{AC0923-CD0923-DD092A}',
                            'Key'         => 'Primary',
                            'Name'        => '_LastName'
                        )
                    ), FALSE
                ),
                array(
                    array(
                        'FieldRef' => array(
                            'Alias'       => 'First Name',
                            'Ascending'   => FALSE,
                            'DisplayName' => 'Customer First Name',
                            'Explicit'    => TRUE,
                            'Format'      => '',
                            'Name'        => '_FirstName'
                        )
                    ), $xmlString2
                ),
                array(
                    'BadData',
                    FALSE
                ),
            );
        }

    }
 