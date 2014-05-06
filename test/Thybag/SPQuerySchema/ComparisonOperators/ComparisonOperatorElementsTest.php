<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 5/5/14
 * Time: 8:26 PM
 */

namespace test\Thybag\SPQuerySchema\ComparisonOperators;

chdir(dirname(__FILE__));
require_once('../../../../SharePointAPI.php');

use Thybag\SPQuerySchema\ComparisonOperators\ComparisonOperatorElements;


class ComparisonOperatorElementsTest extends \PHPUnit_Framework_TestCase {

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
     * testBuildComparison
     *
     * @dataProvider buildComparisonProvider
     * @covers Thybag\SPQuerySchema\ComparisonOperators\ComparisonOperatorElements::buildComparison()
     *
     * @param array $buildDefinition
     * @param       $expectedResult
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public function testBuildComparison ( $buildDefinition = array(), $expectedResult ) {

        $returnResults = ComparisonOperatorElements::buildComparison( $buildDefinition );

        $this->assertEquals( $expectedResult, $returnResults );

    }

    public function buildComparisonProvider() {

        $beginsWithXMLStringXML = <<<XML1
<BeginsWith><FieldRef Name="_LastName" /><Value Type="Text">Smith</Value></BeginsWith>
XML1;
        $dateRangesOverlapStringXML = <<<XML2
<DateRangesOverlap><FieldRef Name="PromDate" /><Value Type="DateTime">2014-04-01</Value></DateRangesOverlap>
XML2;
        $dateRangesOverlapStringXMLIncludeTime = <<<XML3
<DateRangesOverlap><FieldRef Name="PromDate" /><Value Type="DateTime" IncludeTimeValue="True">2014-04-01 08:00</Value></DateRangesOverlap>
XML3;
        $inStringXML = <<<XML4
<In><FieldRef Name="_LastName" /><Values><Value Type="Text">Smith</Value><Value Type="Text">Pence</Value></Values></In>
XML4;

        $inStringXMLWithXMLIsland = <<<XML5
<In><FieldRef Name="_LastName" /><Values><Value Type="Text">Smith</Value><Value Type="Text">Pence</Value></Values><XML><SetVar Name="GlobalVar" Scope="Request">Bar</SetVar></XML></In>
XML5;

        return array(
            array(
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
                $beginsWithXMLStringXML
            ),
            array(
                array(
                    'DateRangesOverlap' => array(
                        'FieldRef' => array(
                            'Name' => 'PromDate'
                        ),
                        'Value'    => array(
                            'Type'  => 'DateTime',
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
                            'Name' => 'PromDate'
                        ),
                        'Value'    => array(
                            'Type'             => 'DateTime',
                            'Value'            => '2014-04-01 08:00',
                            'IncludeTimeValue' => 'True'
                        )
                    )
                ),
                $dateRangesOverlapStringXMLIncludeTime
            ),
            array(
                array(
                    'In' => array(
                        'FieldRef' => array(
                            'Name' => '_LastName'
                        ),
                        'Values'   => array(
                            array(
                                'Value' => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Smith'
                                )
                            ),
                            array(
                                'Value' => array(
                                    'Type'  => 'Text',
                                    'Value' => 'Pence',
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
                            'Name' => '_LastName'
                        ),
                        'Values'   => array(
                            array(
                                'Type'  => 'Text',
                                'Value' => 'Smith'
                            ),
                            array(
                                'Type'  => 'Text',
                                'Value' => 'Pence',
                            )
                        ),
                        'XML'      => array(
                            '<SetVar Name="GlobalVar" Scope="Request">Bar</SetVar>'
                        )
                    )
                ),
                $inStringXMLWithXMLIsland
            ),
            // Test an invalid comparison operator - should return false
            array(
                array(
                    'InWrong' => array(
                        'FieldRef' => array(
                            'Name' => '_LastName'
                        ),
                        'Values'   => array(
                            array(
                                'Type'  => 'Text',
                                'Value' => 'Smith'
                            ),
                            array(
                                'Type'  => 'Text',
                                'Value' => 'Pence',
                            )
                        ),
                        'XML'      => array(
                            '<SetVar Name="GlobalVar" Scope="Request">Bar</SetVar>'
                        )
                    )
                ),
                FALSE
            ),
            // Test a blank submission - should return FALSE
            array(
                array(),
                FALSE
            ),
        );


    }
}
 