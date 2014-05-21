<?php
    /**
     * Created by PhpStorm.
     * User: vsposato
     * Date: 5/18/14
     * Time: 1:59 PM
     */

    namespace test\Thybag\XML;

    chdir( dirname( __FILE__ ) );

    require_once( '../../../SharePointAPI.php' );

    use Thybag\XML\XMLHandler;


    class XMLHandlerTest extends \PHPUnit_Framework_TestCase {

        public static function setUpBeforeClass() {

        }

        protected function setUp() {
            parent::setUp();
        }


        protected function tearDown() {

        }

        public static function tearDownAfterClass() {

        }

        /**
         * testConvertXMLToArray
         *
         * @dataProvider XmlToArrayProvider
         *
         * @param $inputXML
         * @param $expectedArrayResults
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function testConvertXMLToArray( $expectedArrayResults, $inputXML  ) {

            $xmlToArrayObject = new XMLHandler();

            $resultArray = $xmlToArrayObject->convertXmlToArray($inputXML);
            if (array_key_exists('Root', $resultArray)) {
                array_shift($resultArray);
            }
            foreach ($resultArray as $key => $result) {
                $this->assertArrayHasKey($key, $expectedArrayResults);
            }
        }

        /**
         * testConvertArrayToXML
         *
         * @dataProvider XmlToArrayProvider
         *
         * @param $inputArray
         * @param $expectedXML
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function testConvertArrayToXML($inputArray, $expectedXML) {

            $xmlToArrayObject = new XMLHandler();
            $resultXML = $xmlToArrayObject->convertArrayToXML($inputArray, 'Root');

            $this->assertXmlStringEqualsXmlString($expectedXML,$resultXML);
        }

        public function XmlToArrayProvider() {
            $beginsWithXMLStringXML = <<<XML1
<Root><BeginsWith><FieldRef Name="_LastName" /><Value Type="Text">Smith</Value></BeginsWith></Root>
XML1;
            $beginsWithXMLStringXMLDouble = <<<XML1
<Root><BeginsWith><FieldRef Name="_LastName" /><Value Type="Text">Smith</Value></BeginsWith><BeginsWith><FieldRef Name="_LastName" /><Value Type="Text">Smith</Value></BeginsWith></Root>
XML1;
            $dateRangesOverlapStringXML = <<<XML2
<Root><DateRangesOverlap><FieldRef Name="PromDate" /><Value Type="DateTime">2014-04-01</Value></DateRangesOverlap></Root>
XML2;
            $dateRangesOverlapStringXMLIncludeTime = <<<XML3
<Root><DateRangesOverlap><FieldRef Name="PromDate" /><Value Type="DateTime" IncludeTimeValue="True">2014-04-01 08:00</Value></DateRangesOverlap></Root>
XML3;
            $inStringXML = <<<XML4
<Root><In><FieldRef Name="_LastName" /><Values><Value Type="Text">Smith</Value><Value Type="Text">Pence</Value></Values></In></Root>
XML4;
            $inStringXMLWithXMLIsland = <<<XML5
<Root><In><FieldRef Name="_LastName" /><Values><Value Type="Text">Smith</Value><Value Type="Text">Pence</Value></Values><XML><SetVar Name="GlobalVar" Scope="Request">Bar</SetVar></XML></In></Root>
XML5;

            return array(
                array(
                    array(
                        'BeginsWith' => array(
                            'FieldRef' => array(
                                '@attributes' => array(
                                    'Name' => '_LastName'
                                )
                            ),
                            'Value'    => array(
                                '@attributes' => array(
                                    'Type'  => 'Text',
                                ),
                                'Value' => 'Smith'
                            )
                        )
                    ),
                    $beginsWithXMLStringXML
                ),
                array(
                    array(
                        array(
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    '@attributes' => array(
                                        'Name' => '_LastName'
                                    )
                                ),
                                'Value'    => array(
                                    '@attributes' => array(
                                        'Type'  => 'Text'
                                    ),
                                    'Value' => 'Smith'
                                )
                            ),
                            'BeginsWith' => array(
                                'FieldRef' => array(
                                    '@attributes' => array(
                                        'Name' => '_LastName'
                                    )
                                ),
                                'Value'    => array(
                                    '@attributes' => array(
                                        'Type'  => 'Text',
                                    ),
                                    'Value' => 'Smith'
                                )
                            )
                        )
                    ),
                    $beginsWithXMLStringXMLDouble
                ),
                array(
                    array(
                        'DateRangesOverlap' => array(
                            'FieldRef' => array(
                                '@attributes' => array(
                                    'Name' => 'PromDate'
                                )
                            ),
                            'Value'    => array(
                                '@attributes' => array(
                                    'Type'  => 'DateTime',
                                ),
                                'Value' => '2014-04-01'
                            )
                        )
                    ),
                    $dateRangesOverlapStringXML
                ),
                array(
                    array(
                        'DateRangesOverlap' => array(
                            'FieldRef' => array(
                                '@attributes' => array(
                                    'Name' => 'PromDate'
                                )
                            ),
                            'Value'    => array(
                                '@attributes' => array(
                                    'Type'             => 'DateTime',
                                    'IncludeTimeValue' => 'True'
                                ),
                                'Value'            => '2014-04-01 08:00'
                            )
                        )
                    ),
                    $dateRangesOverlapStringXMLIncludeTime
                ),
                array(
                    array(
                        'In' => array(
                            'FieldRef' => array(
                                '@attributes' => array(
                                    'Name' => '_LastName'
                                )
                            ),
                            'Values'   => array(
                                array(
                                    'Value' => array(
                                        '@attributes' => array(
                                            'Type'  => 'Text'
                                        ),
//                                        'Value' => 'Smith'
                                        'Smith'
                                    )
                                ),
                                array(
                                    'Value' => array(
                                        '@attributes' => array(
                                            'Type'  => 'Text'
                                        ),
//                                        'Value' => 'Pence',
                                        'Pence',
                                    )
                                )
                            )
                        )
                    ),
                    $inStringXML
                ),
                array(
                    array(
                        'In' => array(
                            'FieldRef' => array(
                                '@attributes' => array(
                                    'Name' => '_LastName'
                                )
                            ),
                            'Values'   => array(
                                array(
                                    '@attributes' => array(
                                        'Type'  => 'Text',
                                    ),
                                    'Value' => 'Smith'
                                ),
                                array(
                                    '@attributes' => array(
                                        'Type'  => 'Text',
                                    ),
                                    'Value' => 'Pence',
                                )
                            ),
                            'XML'      => array(
                                '<SetVar Name="GlobalVar" Scope="Request">Bar</SetVar>'
                            )
                        )
                    ),
                    $inStringXMLWithXMLIsland
                )
            );
        }
    }
 