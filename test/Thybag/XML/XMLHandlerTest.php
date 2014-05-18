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
        public function testConvertXMLToArray( $inputXML, $expectedArrayResults ) {

            $xmlToArrayObject = new XMLHandler();

            $results = $xmlToArrayObject->convertXmlToArray($inputXML);

            foreach ($results as $key => $result) {
                $this->assertArrayHasKey($key, $expectedArrayResults);
            }

        }

        public function XmlToArrayProvider() {

            return array(
                array(

                )
            );
        }
    }
 