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

        public static function ArrayJoinWithAnd( $comparisonOperatorDefinitions = array() ) {

            if ( ! isset($comparisonOperatorDefinitions['And']) || count($comparisonOperatorDefinitions) != 1 ) {
                throw new \InvalidArgumentException("Must be a single And array provided to this function!");
            }

            // Check to see how many conditions there are, as Logical Joins can only have 2 items in them
            $countOfTopLevelItems = count($comparisonOperatorDefinitions);

            $numberOfAndsNeeded = (int) ceil($countOfTopLevelItems / 2);

            $countOfLoops = 1;
            // Loop through each parent element and start building array
            foreach ($comparisonOperatorDefinitions as $comparisonOperatorKey => $comparisonOperatorValue ) {

            }
        }
    }