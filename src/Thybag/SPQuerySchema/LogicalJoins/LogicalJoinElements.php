<?php
    /**
     * Created by PhpStorm.
     * User: vsposato
     * Date: 5/3/14
     * Time: 8:00 PM
     */

    namespace Thybag\SPQuerySchema\LogicalJoins;

    use Thybag\SPQuerySchema\SPQuerySchema;
    use Thybag\SPQuerySchema\DataElements\ValueElements;

    class LogicalJoinElements extends SPQuerySchema {

        public static function ArrayJoinWithAnd( $fieldReferencesArray = array() ) {

            // Check to see how many conditions there are, as Logical Joins can only have 2 items in them
            $countOfTopLevelItems = count($fieldReferencesArray);

            $numberOfAndsNeeded = (int) ceil($countOfTopLevelItems / 2);

            $countOfLoops = 1;
            // Loop through each parent element and start building array
            foreach ($fieldReferencesArray as $comparisonKey => $definitionArray ) {
                // Handle Field References
                if (array_key_exists('FieldRef', $definitionArray)) {
                    // Get a Field Ref XML back from the Field Ref XML Class

                }


            }
        }
    }