<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 5/3/14
 * Time: 7:59 PM
 */

namespace Thybag\SPQuerySchema;


class SPQuerySchema {



    /**
     * buildCAMLQuery
     *
     * @static
     *
     * Takes in an array for a Query, and will output the XML to satisfy that Query
     *
     * Will not validate that you are using correct structure - i.e., you cannot have more than 2 elements inside a
     * logical operator.
     *
     * @example
     * This is not valid
     * <And>
     *      <BeginsWith>
     *          <FieldRef Name="Last Name" Type="Text"></FieldRef>
     *          <Value Type="Text">AL</Value>
     *      </BeginsWith>
     *      <BeginsWith>
     *          <FieldRef Name="Last Name" Type="Text"></FieldRef>
     *          <Value Type="Text">AL</Value>
     *      </BeginsWith>
     *      <BeginsWith>
     *          <FieldRef Name="Last Name" Type="Text"></FieldRef>
     *          <Value Type="Text">AL</Value>
     *      </BeginsWith>
     * </And>
     *
     * This is valid ->
     * <And>
     *      <BeginsWith>
     *          <FieldRef Name="Last Name" Type="Text"></FieldRef>
     *          <Value Type="Text">AL</Value>
     *      </BeginsWith>
     *      <BeginsWith>
     *          <FieldRef Name="Last Name" Type="Text"></FieldRef>
     *          <Value Type="Text">AL</Value>
     *      </BeginsWith>
     * </And>
     * <And>
     *      <BeginsWith>
     *          <FieldRef Name="Last Name" Type="Text"></FieldRef>
     *          <Value Type="Text">AL</Value>
     *      </BeginsWith>
     * </And>
     *
     * @param array $camlQueryArray
     *
     * @return bool|string
     *
     * @author  Vincent Sposato <vsposato@ufl.edu>
     * @version 1.0
     */
    public static function buildCAMLQuery( array $camlQueryArray ) {

        if ( !is_array( $camlQueryArray ) ) {
            return FALSE;
        }
        $camlQueryReturn = "";

        $comparisonOperators = array_flip( array_keys( ComparisonOperatorElements::$operatorDefinitions ) );

        foreach ( $camlQueryArray as $queryKey => $queryArray ) {
            if ( in_array( $queryKey, array( 'And', 'Or' ), TRUE ) ) {
                $camlQueryReturn .=
                    "<" . $queryKey . ">" . self::buildCAMLQuery( $queryArray ) . "</" . $queryKey . ">";
            }
            if ( array_key_exists( $queryKey, $comparisonOperators ) ) {
                $camlQueryReturn .= ComparisonOperatorElements::buildComparison( array( $queryKey => $queryArray ) );
            }
            if ( is_numeric( $queryKey ) ) {
                $camlQueryReturn .= self::buildCAMLQuery( $queryArray );
            }
        }
        return $camlQueryReturn;
    }

    public static function validateElements( $elementToBeValidated, $validationType) {
        // Make sure that we got both parameters
        If ( (empty($elementToBeValidated) && ! is_bool($elementToBeValidated) ) || empty($validationType)) {
            return FALSE;
        };

        switch ($validationType) {
            Case "Boolean":
                return self::validateBoolean($elementToBeValidated);
                break;
            Case "URL":
                return self::validateURL($elementToBeValidated);
                break;
            Case "String":
                return self::validateString($elementToBeValidated);
                break;
            default:
                return FALSE;
        }
    }

    /**
     * validateBoolean
     *
     * Returns whether or not the passed in variable is a valid boolean
     *
     * @param $booleanToValidate
     * @return bool
     */
    protected static function validateBoolean( $booleanToValidate ) {

        return is_bool($booleanToValidate);
    }

    /**
     * validateString
     *
     * Returns whether or not the passed in variable is a valid string
     *
     * @param $stringToValidate
     * @return bool
     */
    protected static function validateString ( $stringToValidate ) {

        return is_string($stringToValidate);
    }

    /**
     * validateURL
     *
     * Returns whether or not the passed in variable is a valid URL - including http or https
     *
     * @param $URLToValidate
     * @return bool
     */
    protected static function validateURL($URLToValidate) {

      if ( in_array( parse_url( $URLToValidate, PHP_URL_SCHEME ), array( 'http', 'https' ) ) ) {
            if (filter_var($URLToValidate, FILTER_VALIDATE_URL) !== FALSE) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }

    }

} 