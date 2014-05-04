<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 5/3/14
 * Time: 7:59 PM
 */

namespace Thybag\SPQuerySchema;


class SPQuerySchema {


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