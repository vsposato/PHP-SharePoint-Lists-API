<?php
    /**
     * Created by PhpStorm.
     * User: vsposato
     * Date: 5/3/14
     * Time: 8:00 PM
     */

    namespace Thybag\SPQuerySchema\LogicalJoins;

    use Thybag\SPQuerySchema\SPQuerySchema;

    class LogicalJoinElements extends SPQuerySchema {




        public static function CAMLJoinWithAnd( \SimpleXMLElement $fieldReferencesCAML ) {

            // Get an AND XML
            print_r($fieldReferencesCAML->asXML());
            $CAMLJoinWithAndString = "<And>" . $fieldReferencesCAML->asXML() . "</And>";

            $CAMLJoinWithAnd = new \SimpleXMLElement($CAMLJoinWithAndString);

            return $CAMLJoinWithAnd;

        }

        public static function ArrayJoinWithAnd( $fieldReferencesArray = array() ) {

            // Check to make sure
        }
    }