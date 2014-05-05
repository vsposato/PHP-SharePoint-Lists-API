<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 5/3/14
 * Time: 8:07 PM
 */

namespace Thybag\SPQuerySchema\DataElements;

use Thybag\SPQuerySchema\SPQuerySchema;

class ValueElements extends SPQuerySchema {

    public static $fieldRefKeys = array(
        'Alias' => 'String',
        'Ascending' => 'Boolean',
        'CreateURL' => 'URL',
        'DisplayName' => 'String',
        'Explicit' => 'Boolean',
        'Format' => 'String',
        'ID' => 'String',
        'Key' => 'String',
        'List' => 'String',
        'Name' => 'String',
        'RefType' => 'String',
        'ShowField' => 'String',
        'TextOnly' => 'Boolean',
        'Type' => 'String'
    );

    public static $valueTypeWhiteList = array(
        'Integer',
        'Text',
        'Note',
        'DateTime',
        'Counter',
        'Choice',
        'Lookup',
        'Boolean',
        'Number',
        'Currency',
        'URL',
        'Computed',
        'Threading',
        'Guid',
        'MultiChoice',
        'GridChoice',
        'Calculated',
        'File',
        'Attachments',
        'User',
        'Recurrence',
        'CrossProjectLink',
        'ModStat',
        'Error',
        'ContentTypeId',
        'PageSeparator',
        'ThreadIndex',
        'WorkflowStatus',
        'AllDayEvent',
        'WorkflowEventType',
        'Geolocation',
        'OutcomeChoice',
        'MaxItems'
    );

    protected static function _validateFieldRefKeys( $fieldReferenceDefinition = array() ) {
        // Check to make sure we received a populated array
        if (! is_array($fieldReferenceDefinition) || empty($fieldReferenceDefinition)) {
            return FALSE;
        }

        // Loop through each of the items in the array, and remove any unnecessary keys
        foreach ($fieldReferenceDefinition as $fieldRefKey => $fieldRefValue ) {
            if ( ! array_key_exists($fieldRefKey, self::$fieldRefKeys) ) {
                // Unknown attributes need to be removed
                unset($fieldReferenceDefinition[$fieldRefKey]);
            } else {
                if (! SPQuerySchema::validateElements($fieldRefValue, self::$fieldRefKeys[$fieldRefKey])) {
                    // Didn't validate - so we can remove it as well
                    unset($fieldReferenceDefinition[$fieldRefKey]);
                }
            }
        }

        // Did any elements manage to get through
        if (count($fieldReferenceDefinition) > 0) {
            // Didn't get rid of all of the elements, so return the remaining array
            return $fieldReferenceDefinition;
        } else {
            // Nothing made it through - send back a false to indicate failure
            return FALSE;
        }

    }

    public static function ArrayValueXML ( $valueElementDefinition = array() ) {

        if (! array_key_exists('Type', $valueElementDefinition) || ! array_key_exists('Value', $valueElementDefinition)) {
            return FALSE;
        }

        if (! in_array($valueElementDefinition['Type'], self::$valueTypeWhiteList)) {
            return FALSE;
        }

        $xmlReturn = "<Value Type=\"" . $valueElementDefinition['Type'] . "\"";

        if (isset($valueElementDefinition['IncludeTimeValue'])) {
            if ($valueElementDefinition['IncludeTimeValue'] == TRUE) {
                $xmlReturn .= " IncludeTimeValue=\"True\"";
            } elseif ($valueElementDefinition['IncludeTimeValue'] == FALSE) {
                $xmlReturn .= " IncludeTimeValue=\"False\"";
            }
        }
        $xmlReturn .= ">" . $valueElementDefinition['Value'] . "</Value>";

        return $xmlReturn;

    }

    public static function ArrayValuesXML( $valuesElementDefinition = array() ) {

        if (! isset($valuesElementDefinition['Values'])) {
            // We didn't get a properly formatted array
            return FALSE;
        }

        $xmlReturn = "<Values>";

        $valueCounter = 0;

        foreach ($valuesElementDefinition['Values'] as $valueArray) {
            $tempReturn = self::ArrayValueXML($valueArray);
            if ($tempReturn === FALSE) {
                continue;
            }
            $xmlReturn .= $tempReturn;

            $valueCounter++;
        }

        if ($valueCounter === 0) {
            return FALSE;
        }

        $xmlReturn .= "</Values>";

        return $xmlReturn;

    }
    /**
     * ArrayFieldRef
     *
     * @static
     *
     * Function will take in an array of attributes for the fieldRef element, and output them as an XML
     * string for use in query definitions
     *
     * @param array $fieldReferenceDefinition
     *
     * @return bool|string
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public static function ArrayFieldRef( $fieldReferenceDefinition = array() ) {

        if (isset($fieldReferenceDefinition['FieldRef'])) {
            // Validate the elements of the array are in correct format
            $validatedFieldRefElements = self::_validateFieldRefKeys($fieldReferenceDefinition['FieldRef']);
        } else {
            // We didn't get a formed array in, so return false
            return FALSE;
        }

        // If we didn't get any elements back, then we return false
        if (!$validatedFieldRefElements) {
            return FALSE;
        }

        // Define the XML string holder
        $xmlReturn = "<FieldRef ";

        // Loop through elements and make an XML string
        foreach ($validatedFieldRefElements as $fieldRefKey => $fieldRefValue) {
            if (self::$fieldRefKeys[$fieldRefKey] === "Boolean") {
                // Need to convert a boolean back to a String value - otherwise we will get 1 or 0, rather than
                // TRUE or FALSE
                $booleanValue = ($fieldRefValue) ? "True" : "False";
                $xmlReturn .= $fieldRefKey . "=\"" . $booleanValue . "\" ";
            } else {
                // Normal strings can just be added
                $xmlReturn .= $fieldRefKey . "=\"" . $fieldRefValue . "\" ";
            }
        }

        // Close the XML string
        $xmlReturn .= "/>";

        // Return the XML String
        return $xmlReturn;
    }

} 