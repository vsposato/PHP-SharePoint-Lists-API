<?php
    /**
     * Created by PhpStorm.
     * User: vsposato
     * Date: 5/3/14
     * Time: 8:07 PM
     */

    namespace Thybag\SPQuerySchema\DataElements;

    use Thybag\SPQuerySchema\SPQuerySchema;
    use Thybag\XML\XMLHandler;

    class ValueElements extends SPQuerySchema {

        /**
         * $fieldRefKeys
         *
         * This is a listing of each of the FieldRef attributes, and what type of value they are
         *
         * @var array
         */
        public static $fieldRefKeys = array(
            'Alias'       => 'String',
            'Ascending'   => 'Boolean',
            'CreateURL'   => 'URL',
            'DisplayName' => 'String',
            'Explicit'    => 'Boolean',
            'Format'      => 'String',
            'ID'          => 'String',
            'Key'         => 'String',
            'List'        => 'String',
            'Name'        => 'String',
            'RefType'     => 'String',
            'ShowField'   => 'String',
            'TextOnly'    => 'Boolean',
            'Type'        => 'String'
        );

        /**
         * $valueTypeWhiteList
         *
         * This is a listing of all Value types that are available to be used.
         *
         * @var array
         */
        public static $valueTypeWhiteList = array(
            'Integer',
            'Text',
            'Note',
            'DateTime',
            'Counter',
            'Choice',
            'Lookup',
            'LookupMulti',
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

        /**
         * _validateFieldRefKeys
         *
         * @static
         *
         * Takes in an array formatted for field definition, and returns a FieldRef XML tag
         *
         * @see     http://msdn.microsoft.com/en-us/library/office/ms442728(v=office.14).aspx
         *
         * @param array $fieldReferenceDefinition
         *
         * @return array|bool
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        protected static function _validateFieldRefKeys( $fieldReferenceDefinition = array() ) {
            // Check to make sure we received a populated array
            if ( !is_array( $fieldReferenceDefinition ) || empty( $fieldReferenceDefinition ) ) {
                return FALSE;
            }

            // Loop through each of the items in the array, and remove any unnecessary keys
            foreach ( $fieldReferenceDefinition as $fieldRefKey => $fieldRefValue ) {
                if ( !array_key_exists( $fieldRefKey, self::$fieldRefKeys ) ) {
                    // Unknown attributes need to be removed
                    unset( $fieldReferenceDefinition[$fieldRefKey] );
                } else {
                    if ( !SPQuerySchema::validateElements( $fieldRefValue, self::$fieldRefKeys[$fieldRefKey] ) ) {
                        // Didn't validate - so we can remove it as well
                        unset( $fieldReferenceDefinition[$fieldRefKey] );
                    }
                }
            }

            // Did any elements manage to get through
            if ( count( $fieldReferenceDefinition ) > 0 ) {
                // Didn't get rid of all of the elements, so return the remaining array
                return $fieldReferenceDefinition;
            } else {
                // Nothing made it through - send back a false to indicate failure
                return FALSE;
            }

        }

        /**
         * ArrayValueXML
         *
         * @static
         *
         * Takes in an array formatted in the following format:
         *
         *  array(
         *      'Value' => array(
         *          'Type' => 'Integer', (REQUIRED)
         *          'Value' => 1, (REQUIRED)
         *          'IncludeTimeValue' => 'True'|'False' (OPTIONAL)
         *      )
         *  );
         *
         * It will return a Value XML tag with all of the data needed.
         *
         * @see     http://msdn.microsoft.com/en-us/library/office/ms441886(v=office.14).aspx
         *
         * @param array $valueElementDefinition
         *
         * @return bool|string
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public static function ArrayValueXML( $valueElementDefinition = array() ) {

            // If the field ref key is not there, but it is an array let's attempt to fix the mistake
            if ( ( !isset( $valueElementDefinition['Value'] ) && is_array( $valueElementDefinition ) )
                || ( isset( $valueElementDefinition['Value'] ) && !is_array( $valueElementDefinition['Value'] ) )
            ) {
                // Make a Field Ref key, and make it equal to the passed in array
                $tempValueElementDefinition['Value'] = $valueElementDefinition;
                $valueElementDefinition = $tempValueElementDefinition;
                unset( $tempValueElementDefinition );
            }

            if ( !isset( $valueElementDefinition['Value'] ) ) {
                // We didn't get a properly formatted array
                return FALSE;
            }

            if ( !isset( $valueElementDefinition['Value']['@attributes'] ) ) {
                $valueElementDefinition['Value']['@attributes'] = NULL;
            }

            if ( ( ( is_array( $valueElementDefinition['Value']['@attributes'] )
                    && ( !array_key_exists( 'Type', $valueElementDefinition['Value']['@attributes'] ) ) ) )
                || !array_key_exists( 'Value', $valueElementDefinition['Value'] )
            ) {
                return FALSE;
            }

            if ( !in_array( $valueElementDefinition['Value']['@attributes']['Type'], self::$valueTypeWhiteList ) ) {
                return FALSE;
            }

            $xmlReturn = new XMLHandler();
            $xmlStringReturn = $xmlReturn->convertArrayToXML( $valueElementDefinition, FALSE, FALSE );

            return $xmlStringReturn;

        }

        /**
         * ArrayValuesXML
         *
         * @static
         *
         * Takes in an array formatted in the following format:
         * array('Values' => array(
         *  array(
         *      'Type' => 'Integer',
         *      'Value' => 1
         *  )
         * );
         *
         * It will return a Values XML string with multiple Value elements within it
         *
         * @see     http://msdn.microsoft.com/en-us/library/office/ff625794(v=office.14).aspx
         *
         * @param array $valuesElementDefinition
         *
         * @return bool|string $xmlReturn
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public static function ArrayValuesXML( $valuesElementDefinition = array() ) {

            // If the field ref key is not there, but it is an array let's attempt to fix the mistake
            if ( !isset( $valuesElementDefinition['Values'] ) && is_array( $valuesElementDefinition ) ) {
                // Make a Field Ref key, and make it equal to the passed in array
                $valuesElementDefinition['Values'] = $valuesElementDefinition;
            }

            if ( !isset( $valuesElementDefinition['Values'] ) ) {
                // We didn't get a properly formatted array
                return FALSE;
            }

            $xmlStringReturn = "<Values>";

            $valueCounter = 0;

            foreach ( $valuesElementDefinition['Values'] as $valueKey => $valueArray ) {
                $tempReturn = self::ArrayValueXML( $valueArray );
                if ( $tempReturn === FALSE ) {
                    continue;
                }
                $xmlStringReturn .= $tempReturn;

                $valueCounter++;
            }

            if ( $valueCounter === 0 ) {
                return FALSE;
            }

            $xmlStringReturn .= "</Values>";

            return $xmlStringReturn;

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

            // If the field ref key is not there, but it is an array let's attempt to fix the mistake
            if ( !isset( $fieldReferenceDefinition['FieldRef'] ) && is_array( $fieldReferenceDefinition ) ) {
                // Make a Field Ref key, and make it equal to the passed in array
                $tmpFieldReferenceDefinition['FieldRef'] = $fieldReferenceDefinition;
                $fieldReferenceDefinition = $tmpFieldReferenceDefinition;
            }

            if ( isset( $fieldReferenceDefinition['FieldRef'] )
                && isset( $fieldReferenceDefinition['FieldRef']['@attributes'] )
            ) {
                // Validate the elements of the array are in correct format
                $validatedFieldRefElements = self::_validateFieldRefKeys( $fieldReferenceDefinition['FieldRef']['@attributes'] );
            } else {
                // We didn't get a formed array in, so return false
                return FALSE;
            }

            // If we didn't get any elements back, then we return false
            if ( !$validatedFieldRefElements ) {
                return FALSE;
            }

            $xmlReturn = new XMLHandler();
            $xmlStringReturn = $xmlReturn->convertArrayToXML( $fieldReferenceDefinition, FALSE, FALSE );

            // Return the XML String
            return $xmlStringReturn;
        }

        /**
         * XMLElement
         *
         * @static
         *
         * Function will take in an a string containing an XML string, and wrap it in an XML tag set
         *
         * @param $XMLString
         *
         * @return bool|string
         *
         * @author  Vincent Sposato <vsposato@ufl.edu>
         * @version 1.0
         */
        public static function XMLElement( $XMLString ) {
            if ( empty( $XMLString ) || !isset( $XMLString ) ) {
                $XMLString = "";
            }
            return "<XML>" . $XMLString . "</XML>";
        }

    }