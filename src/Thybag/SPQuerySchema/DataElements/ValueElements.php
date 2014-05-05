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

    protected static $xmlReturn = '';

    protected static function _validateFieldRefKeys( $fieldReferenceDefinition = array() ) {
        // Check to make sure we received a populated array
        if (! is_array($fieldReferenceDefinition) || empty($fieldReferenceDefinition)) {
            return FALSE;
        }

        $xmlReturn = "<FieldRef ";
        // Loop through each of the items in the array, and remove any unnecessary keys
        foreach ($fieldReferenceDefinition as $fieldRefKey => $fieldRefValue ) {
            if ( ! array_key_exists($fieldRefKey, self::$fieldRefKeys) ) {
                // Unknown attributes need to be removed
                unset($fieldReferenceDefinition[$fieldRefKey]);
            } else {
                if (SPQuerySchema::validateElements($fieldRefValue, self::$fieldRefKeys[$fieldRefKey])) {
                    $xmlReturn .= $fieldRefKey . "=\"" . $fieldRefValue . "\" ";
/*                    if (self::$fieldRefKeys[$fieldRefKey] === 'String') {
                        $xmlReturn .= $fieldRefKey . "=\"" . $fieldRefValue . "\" ";
                    } else {
                        $xmlReturn .= $fieldRefKey . "=" . $fieldRefValue . " ";
                    }*/
                }
            }
        }

        $xmlReturn .= "/>";
        return $xmlReturn;

    }
    public static function ArrayFieldRef( $fieldReferenceDefinition = array() ) {

    }

} 