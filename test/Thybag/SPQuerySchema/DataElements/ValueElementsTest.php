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


        public function valuesArrayProvider() {
            $xmlString = <<<XML
<Values><Value Type="Integer">1</Value><Value Type="Boolean">True</Value></Values>
XML;
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
                                'Type'  => 'Integer',
                                'Value' => 1
                            ),
                            array(
                                'Type'  => 'Boolean',
                                'Value' => 'True'
                            )
                        )
                    ),
                    $xmlString
                ),
                array(
                    array(
                        'Values' => array(
                            array(
                                'Type'  => 'GuidWrong',
                                'Value' => '{AC0923-CD0923-DD092A}'
                            ),
                            array(
                                'Type'  => 'Text',
                                'Value' => "This is test text!"
                            )
                        )
                    ),
                    $xmlString2
                ),
                array(
                    array(
                        'Values' => array(
                            array(
                                'Type'  => 'GuidWrong',
                                'Value' => '{AC0923-CD0923-DD092A}'
                            ),
                            array(
                                'Type'  => 'Boolean',
                                'Value' => "True"
                            ),
                            array(
                                'Type'  => 'WorkflowStatusWrong',
                                'Value' => "NotHere"
                            )
                        )
                    ),
                    $xmlString3
                ),
                array(
                    array(
                        'Value' => array(
                            array(
                                'Type'  => 'GuidWrong',
                                'Value' => '{AC0923-CD0923-DD092A}'
                            ),
                            array(
                                'Type'  => 'Boolean',
                                'Value' => "True"
                            ),
                            array(
                                'Type'  => 'WorkflowStatusWrong',
                                'Value' => "NotHere"
                            )
                        )
                    ),
                    FALSE
                ),
                array(
                    array(
                        'Values' => array(
                            array(
                                'Type'  => 'GuidWrong',
                                'Value' => '{AC0923-CD0923-DD092A}'
                            ),
                            array(
                                'Type'  => 'WorkflowStatusWrong',
                                'Value' => "NotHere"
                            )
                        )
                    ),
                    FALSE
                )
            );

        }

        public function valueArrayProvider() {
            $xmlString = <<<XML
<Value Type="Boolean">True</Value>
XML;
            $xmlString2 = <<<XML2
<Value Type="Text">This is test text!</Value>
XML2;
            $xmlString3 = <<<XML3
<Value Type="Boolean">True</Value>
XML3;
            $xmlString4 = <<<XML4
<Value Type="DateTime" IncludeTimeValue="True">True</Value>
XML4;

            return array(
                array(
                    array(
                        'Type'  => 'Boolean',
                        'Value' => 'True'
                    ),
                    $xmlString
                ),
                array(
                    array(
                        'Type'  => 'Text',
                        'Value' => "This is test text!"
                    ),
                    $xmlString2
                ),
                array(
                    array(
                        'Type'  => 'Boolean',
                        'Value' => "True"
                    ),
                    $xmlString3
                ),
                array(
                    array(
                        'Type'  => 'DateTime',
                        'Value' => "True",
                        'IncludeTimeValue' => "True"
                    ),
                    $xmlString4
                ),
                array(
                    array(
                        'Types'  => 'Boolean',
                        'Value' => "True"
                    ),
                    FALSE
                ),
                array(
                    array(
                        'Type'  => 'Boolean',
                        'Values' => "True"
                    ),
                    FALSE
                ),
                array(
                    array(
                        'Type'  => 'BooleanWrong',
                        'Value' => "True"
                    ),
                    FALSE
                )
            );

        }
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
            );
        }

    }
 