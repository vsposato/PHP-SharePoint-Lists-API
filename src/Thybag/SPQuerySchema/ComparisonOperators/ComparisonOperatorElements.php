<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 5/4/14
 * Time: 11:19 AM
 */

namespace Thybag\SPQuerySchema\ComparisonOperators;

use Thybag\SPQuerySchema\SPQuerySchema;
use Thybag\SPQuerySchema\DataElements\ValueElements;

class ComparisonOperatorElements extends SPQuerySchema
{

    public static $operatorDefinitions = array(
        'BeginsWith' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'Contains' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'DateRangesOverlap' => array(
            'FieldRef',
            'Value'
        ),
        'Eq' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'Geq' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'Gt' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'In' => array(
            'FieldRef',
            'Values',
            'XML'
        ),
        'Includes' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'IsNotNull' => array(
            'FieldRef'
        ),
        'IsNull' => array(
            'FieldRef'
        ),
        'Leq' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'Lt' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'Neq' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
        'NotIncludes' => array(
            'FieldRef',
            'Value',
            'XML'
        ),
    );

    /**
     * buildComparison
     *
     * @static
     *
     * Takes in an array of 1 or more comparison definitions, and returns back an XML string formed for a query
     *
     *
     * @param array $comparisonDefinition
     *
     * @return bool|string
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public static function buildComparison($comparisonDefinition = array())
    {

        if (empty($comparisonDefinition) || !is_array($comparisonDefinition)) {
            return FALSE;
        }

        // Start the return string by setting it to False, this will allow us to catch any unexpected results and fail gracefully
        $xmlReturn = FALSE;

        if (count($comparisonDefinition) == 1) {
            $xmlReturn = self::_buildSingleDefinition($comparisonDefinition);
        } elseif (count($comparisonDefinition) > 1) {
            $xmlReturn = self::_buildMultipleDefinition($comparisonDefinition);
        }

        return $xmlReturn;
    }

    /**
     *
     * buildSingleDefinition
     *
     * Instance method to allow use of the build comparison function from an instantiated class
     *
     * @param array $singleComparisonDefinition
     * @return bool|string
     */
    public function buildSingleDefinition($singleComparisonDefinition = array())
    {

        return self::_buildSingleDefinition($singleComparisonDefinition);

    }

    /**
     * _buildSingleDefinition
     *
     * @static
     *
     * Takes in a single array for a comparison operator definition and returns a fully developed XML string
     * Will return false in case of one of the core items not being right, or any other perceived issue
     * Called by _buildMultipleDefinition
     *
     * @param array $singleComparisonDefinition
     *
     * @return bool|string
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    protected static function _buildSingleDefinition($singleComparisonDefinition = array())
    {

        // If the array is empty, or the array is not an array
        if (empty($singleComparisonDefinition) || !is_array($singleComparisonDefinition)) {
            return FALSE;
        }


        // Loop through each of the definitions
        foreach ($singleComparisonDefinition as $comparisonKey => $comparisionValueArray) {
            // Since there is only 1 definition and it is not valid, return false to indicate failure
            if (!isset(self::$operatorDefinitions[$comparisonKey])) {
                return FALSE;
            } else {
                // Set the target comparison operator to a variable, for easy access later
                $targetComparisonOperator = self::$operatorDefinitions[$comparisonKey];
            }

            // If there is not an array in the comparison array, then we need to return false to indicate failure
            If ((empty($comparisionValueArray) || !is_array($comparisionValueArray))) {
                continue;
            }

            $xmlString = '<' . $comparisonKey . '>';
            foreach ($targetComparisonOperator as $elementValueArrays) {
                Switch ($elementValueArrays) {
                    Case "FieldRef":
                        if (isset($comparisionValueArray['FieldRef']) && is_array($comparisionValueArray['FieldRef'])) {
                            // The field ref is set, and it is an array - which is what the field ref builder is looking for
                            $fieldRefReturn = ValueElements::ArrayFieldRef($comparisionValueArray['FieldRef']);
                            if ($fieldRefReturn !== FALSE) {
                                // We received a valid response - append it to our eventual return string
                                $xmlString .= $fieldRefReturn;
                                // Conserve memory - event though not much
                                unset($fieldRefReturn);
                            } else {
                                // We received a failure, but this is a required item - just fail
                                return FALSE;
                            }
                        } else {
                            // We either did not get a field ref array or it was not an array - since this is a required item - fail
                            return FALSE;
                        }
                        break;
                    Case "Value":
                        if (isset($comparisionValueArray['Value']) && is_array($comparisionValueArray['Value'])) {
                            // The Value key is set, go get the well-formed object
                            $valueReturn = ValueElements::ArrayValueXML($comparisionValueArray['Value']);
                            If ($valueReturn !== FALSE) {
                                // We received a valid response - append it to our eventual return string
                                $xmlString .= $valueReturn;
                                // Conserve memory - event though not much
                                unset($valueReturn);
                            } else {
                                // We received a failure, but this is a required item - just fail
                                return FALSE;
                            }
                        } else {
                            // We either did not get a value array or it was not an array - since this is a required item - fail
                            return FALSE;
                        }
                        break;
                    Case "Values":
                        if (isset($comparisionValueArray['Values']) && is_array($comparisionValueArray['Values'])) {
                            // The Values key is set, go get the well-formed object
                            $valueReturn = ValueElements::ArrayValuesXML($comparisionValueArray['Values']);
                            If ($valueReturn !== FALSE) {
                                // We received a valid response - append it to our eventual return string
                                $xmlString .= $valueReturn;
                                // Conserve memory - event though not much
                                unset($valueReturn);
                            } else {
                                // We received a failure, but this is a required item - just fail
                                return FALSE;
                            }
                        } else {
                            // We either did not get a values array or it was not an array - since this is a required item - fail
                            return FALSE;
                        }

                        break;
                    Case "XML":
                        if (isset($comparisionValueArray['XML']) && is_array($comparisionValueArray['XML'])) {
                            // The XML key is set, go get the well-formed object
                            $xmlReturn = ValueElements::XMLElement($comparisionValueArray['XML'][0]);
                            If ($xmlReturn !== FALSE) {
                                // We received a valid response - append it to our eventual return string
                                $xmlString .= $xmlReturn;
                                // Conserve memory - event though not much
                                unset($xmlReturn);
                            } else {
                                // We received a failure, but this is a required item - just fail
                                return FALSE;
                            }

                        } else {
                            // We either did not get an XML array or it was not an array - since this is not a required item - continue
                            continue;
                        }
                        break;
                    Default:
                        // We shouldn't get here, but just in case continue
                        continue;
                }
            }
            // Close the XML String with the correct comparison tag, and return the results
            $xmlString .= '</' . $comparisonKey . '>';

            // Return the results
            return $xmlString;
        }
    }

    /**
     * buildMultipleDefinition
     *
     * Instance method to allow use of the build comparison function from an instantiated class
     *
     * @param array $multipleComparisonDefinition
     * @return bool|string
     */
    public function buildMultipleDefinition($multipleComparisonDefinition = array())
    {

        return self::_buildMultipleDefinition($multipleComparisonDefinition);

    }

    /**
     * _buildMultipleDefinition
     *
     * @static
     *
     * Takes in a numeric indexed array of definitions and returns back an XML string to represent the
     * multiple comparison operators
     *
     * @param array $multipleComparisonDefinition
     *
     * @return bool|string
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    protected static function _buildMultipleDefinition($multipleComparisonDefinition = array())
    {
        // If the array is empty, or the array is not an array
        if (empty($multipleComparisonDefinition) || !is_array($multipleComparisonDefinition)) {
            return FALSE;
        }

        // Set the return XMLString to False, this will allow us to catch any unexpected conditions
        $xmlString = FALSE;

        // Loop through each definition, and get back the results and append if needed
        foreach ($multipleComparisonDefinition as $singleComparisonDefinition) {
            // Get the results back
            $tempResults = self::_buildSingleDefinition($singleComparisonDefinition);

            // Did it fail, if so continue on
            if ($tempResults === FALSE) {
                continue;
            }

            // Append the string to the running string
            $xmlString .= $tempResults;

            // Conserve memory - no matter how little
            unset($tempResults);
        }

        // Return the results
        return $xmlString;

    }

} 