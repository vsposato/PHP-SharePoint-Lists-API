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

/**
 * Written simply to be able to test the protected functionality of the ComparisonOperatorElements class
 *
 * Class inheritComparisonOperatorElements
 * @package test\Thybag\SPQuerySchema\ComparisonOperators
 *
 * @author  Vincent Sposato <vsposato@ufl.edu>
 * @version 1.0
 */
class inheritComparisonOperatorElements extends ComparisonOperatorElements {
    /**
     *
     * buildSingleDefinition
     *
     * Instance method to allow use of the build comparison function from an instantiated class
     *
     * @param array $singleComparisonDefinition
     * @return bool|string
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public function buildSingleDefinition($singleComparisonDefinition = array())
    {

        return self::_buildSingleDefinition($singleComparisonDefinition);

    }
    /**
     * buildMultipleDefinition
     *
     * Instance method to allow use of the build comparison function from an instantiated class
     *
     * @param array $multipleComparisonDefinition
     * @return bool|string
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public function buildMultipleDefinition($multipleComparisonDefinition = array())
    {

        return self::_buildMultipleDefinition($multipleComparisonDefinition);

    }

}

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
     * @covers Thybag\SPQuerySchema\ComparisonOperators\ComparisonOperatorElements::_buildMultipleDefinition()
     * @covers Thybag\SPQuerySchema\ComparisonOperators\ComparisonOperatorElements::_buildSingleDefinition()
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

    /**
     *
     * testBuildSingleEmptyArray
     *
     * @covers Thybag\SPQuerySchema\ComparisonOperators\ComparisonOperatorElements::_buildSingleDefinition()
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public function testBuildSingleEmptyArray () {

        $comparisonOperatorClass = new inheritComparisonOperatorElements();

        $returnResults = $comparisonOperatorClass->buildSingleDefinition(array());

        $this->assertFalse($returnResults);

        unset($comparisonOperatorClass);

    }

    /**
     *
     * testBuildMultipleEmptyArray
     *
     * @covers Thybag\SPQuerySchema\ComparisonOperators\ComparisonOperatorElements::_buildMultipleDefinition()
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public function testBuildMultipleEmptyArray () {

        $comparisonOperatorClass = new inheritComparisonOperatorElements();

        $returnResults = $comparisonOperatorClass->buildMultipleDefinition(array());

        $this->assertFalse($returnResults);

        unset($comparisonOperatorClass);

    }

    /**
     * Provides data for the comparison tests
     *
     * @return array
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public function buildComparisonProvider() {

        $beginsWithXMLStringXML = <<<XML1
<BeginsWith><FieldRef Name="_LastName" /><Value Type="Text">Smith</Value></BeginsWith>
XML1;
        $beginsWithXMLStringXMLDouble = <<<XML1
<BeginsWith><FieldRef Name="_LastName" /><Value Type="Text">Smith</Value></BeginsWith><BeginsWith><FieldRef Name="_LastName" /><Value Type="Text">Smith</Value></BeginsWith>
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
                            '_attributes' => array(
                                'Name' => '_LastName'
                            )
                        ),
                        'Value'    => array(
                            '_attributes' => array(
                                'Type'  => 'Text',
                            ),
                            'Value' => 'Smith'
                        )
                    )
                ),
                $beginsWithXMLStringXML
            ),
            // Test no elements in array for comparison - should fail
            array(
                array(
                    'BeginsWith' => array(
                        'FieldRef' => array(
                            '_attributes' => array(
                                'Name' => '_LastName'
                            )
                        ),
                        'Value'    => array(
                            'Bogus'
                        )
                    )
                ),
                FALSE
            ),
            // Test no elements in array for comparison - should fail
            array(
                array(
                    'BeginsWith' => array(
                        'FieldRef' => array(
                            '_attributes' => array(
                                'Name' => '_LastName'
                            )
                        ),
                        'Value'
                    )
                ),
                FALSE
            ),
            // Test elements in array, but no elements under the array for comparison - should fail
            array(
                array(
                    'BeginsWith' => array(
                        'FieldRef'
                    )
                ),
                FALSE
            ),
            // Test elements in array, but no elements under the array for comparison - should fail
            array(
                array(
                    'BeginsWith' => array(
                        'FieldRef' => array(
                            'Bogus'
                        )
                    )
                ),
                FALSE
            ),
            // Test multiple elements in array - should pass
            array(
                array(
                    array(
                        'BeginsWith' => array(
                            'FieldRef' => array(
                                '_attributes' => array(
                                    'Name' => '_LastName'
                                )
                            ),
                            'Value'    => array(
                                '_attributes' => array(
                                    'Type'  => 'Text'
                                ),
                                'Value' => 'Smith'
                            )
                        )
                    ),
                    array(
                        'BeginsWith' => array(
                            'FieldRef' => array(
                                '_attributes' => array(
                                    'Name' => '_LastName'
                                )
                            ),
                            'Value'    => array(
                                '_attributes' => array(
                                    'Type'  => 'Text',
                                ),
                                'Value' => 'Smith'
                            )
                        )
                    )
                ),
                $beginsWithXMLStringXMLDouble
            ),
            // Test multiple elements in array - should pass
            array(
                array(
                    array(
                        'BeginsWith'
                    ),
                    array(
                        'BeginsWith'
                    )
                ),
                FALSE
            ),
            array(
                array(
                    'DateRangesOverlap' => array(
                        'FieldRef' => array(
                            '_attributes' => array(
                                'Name' => 'PromDate'
                            )
                        ),
                        'Value'    => array(
                            '_attributes' => array(
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
                    'DateRangesOverlap' => array(),
                ),
                FALSE
            ),
            array(
                array(
                    'DateRangesOverlap' => array(
                        'FieldRef' => array(
                            '_attributes' => array(
                                'Name' => 'PromDate'
                            )
                        ),
                        'Value'    => array(
                            '_attributes' => array(
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
                            '_attributes' => array(
                                'Name' => '_LastName'
                            )
                        ),
                        'Values'   => array(
                            array(
                                'Value' => array(
                                    '_attributes' => array(
                                        'Type'  => 'Text'
                                    ),
                                    'Value' => 'Smith'
                                )
                            ),
                            array(
                                'Value' => array(
                                    '_attributes' => array(
                                        'Type'  => 'Text'
                                    ),
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
                            '_attributes' => array(
                                'Name' => '_LastName'
                            )
                        ),
                        'Values'
                    )
                ),
                FALSE
            ),
            array(
                array(
                    'In' => array(
                        'FieldRef' => array(
                            '_attributes' => array(
                                'Name' => '_LastName'
                            )
                        ),
                        'Values'   => array(
                            'Bogus'
                        )
                    )
                ),
                FALSE
            ),
            array(
                array(
                    'In' => array(
                        'FieldRef' => array(
                            '_attributes' => array(
                                'Name' => '_LastName'
                            )
                        ),
                        'Values'   => array(
                            array(
                                '_attributes' => array(
                                    'Type'  => 'Text',
                                ),
                                'Value' => 'Smith'
                            ),
                            array(
                                '_attributes' => array(
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
            ),
            // Test an invalid comparison operator - should return false
            array(
                array(
                    'InWrong' => array(
                        'FieldRef' => array(
                            '_attributes' => array(
                                'Name' => '_LastName'
                            )
                        ),
                        'Values'   => array(
                            array(
                                '_attributes' => array(
                                    'Type'  => 'Text',
                                ),
                                'Value' => 'Smith'
                            ),
                            array(
                                '_attributes' => array(
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
 