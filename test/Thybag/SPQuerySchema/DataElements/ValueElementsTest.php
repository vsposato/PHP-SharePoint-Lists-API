<?php
    /**
     * Created by PhpStorm.
     * User: vsposato
     * Date: 5/4/14
     * Time: 3:58 PM
     */

    namespace test\Thybag\SPQuerySchema\DataElements;

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
         * @covers ValueElements::ArrayFieldRef()
         * 
         * @param $arrayToBeConverted
         * @param $expectedResult
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public function testCreateFieldRef( $arrayToBeConverted, $expectedResult ) {

            $returnResults = ValueELements::ArrayFieldRef( $arrayToBeConverted );

            echo $returnResults . "\n";
            echo $expectedResult . "\n";
            $this->assertEquals( $expectedResult, $returnResults );

        }

        public function fieldRefProvider() {
            $xmlString = <<<XML1
<FieldRef Alias="Last Name" Ascending="True" CreateURL="http://www.example.com" DisplayName="Customer Last Name" Explicit="False" Format="TestFormat" ID="{AC0923-CD0923-DD092A}" Key="Primary" Name="_LastName" />
XML1;
            $xmlString2 = <<<XML2
<FieldRef Alias="First Name" Ascending="False" DisplayName="Customer First Name" Explicit="True" Format="" Name="_FirstName" />
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
 