<?php
    namespace Thybag\XML;

    define( "NODE_SEPERATOR", "#*#" );
    define( "LINE_SEPERATOR", "!#=#!" );
    define( "ERROR_STYLE", "color:#fff;background-color:#ff0000;font-weight:bold;padding:5px;margin:5px;" );

    /**
     * This class interchange String, XML, JSON and Array into each other.
     *
     * @author  Rochak Chauhan
     * @package XMLHandler
     * @version beta
     */
    class XMLHandler {
        private $errorLog = array();

        /**
         * Function to display last error for debugging purpose
         *
         * @access public
         *
         * @param bool $showHtml
         *
         * @return string
         */
        public function displayLastError( $showHtml = TRUE ) {
            $return = "No errors were encountered.";
            $c = count( $this->errorLog );
            if ( $c > 0 ) {
                $i = $c - 1;
                if ( $showHtml ) {
                    $return = "<div style='" . ERROR_STYLE . "'>" . $this->errorLog[$i] . "</div>";
                } else {
                    $return = $this->errorLog[$i] . "\n";
                }
            }
            echo $return;
        }

        /**
         * Function to display complete error log for debugging purpose
         *
         * @access public
         *
         * @param bool $showHtml
         *
         * @return string
         */
        public function displayErrorLog( $showHtml = TRUE ) {
            $return = "No errors were encountered.";
            $c = count( $this->errorLog );
            if ( $c > 0 ) {
                $return = "";
                for ( $i = 0; $i < $c; $i++ ) {
                    if ( $showHtml ) {
                        $return .= "<div style='" . ERROR_STYLE . "'>" . $this->errorLog[$i] . "</div>";
                    } else {
                        $return = $this->errorLog[$i] . "\n";
                    }
                }
            }
            echo $return;
        }

        /**
         * Function to recursively parse Xml Content
         *
         * @param mixed $ret
         *
         * @access private
         * @return array on success and false on failure
         */
        private function parseXml( $ret ) {
            $return = FALSE;
            if ( is_object( $ret ) ) {
                $ret = (array)$ret;
                $this->parseXml( $ret );
            }
            if ( is_array( $ret ) ) {
                foreach ( $ret as $k => $v ) {
                    if ( is_object( $v ) ) {
                        $return[$k] = $this->parseXml( $v );
                    } else {
                        $return[$k] = $v;
                    }
                }
            }

            return $return;
        }

        /**
         * Function to convert XML into Array
         *
         * @param string $xmlContent
         *
         * @access public
         * @return array on success and false on failure
         */
        public function convertXmlToArray( $xmlContent ) {
            $return = FALSE;
            $ret = simplexml_load_string( $xmlContent );
            if ( $ret === FALSE ) {
                $this->errorLog[] = "Invalid XML content: $xmlContent in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                return FALSE;
            } else {
                $return = $this->parseXml( $ret );
                if ( $return === FALSE ) {
                    $this->errorLog[] = "Failed to parse XML content in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                    return FALSE;
                }
            }

            return $return;
        }

        /**
         * Function to recursively parse Array Content
         *
         * @param $array
         *
         * @internal param mixed $ret
         *
         * @access   private
         * @return string(xml) on success and false on failure
         */
        private function parseArray( $array ) {
            $return = "";
            if ( is_array( $array ) ) {
                foreach ( $array as $k => $v ) {
                    if ( trim( $k ) == "" ) {
                        $this->errorLog[] = "Array needs to be associative as parameter in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                        return FALSE;
                    } else {
                        if ( is_numeric( $k ) ) {
                            $k = "nodeValue$k";
                        }
                        if ( is_array( $v ) ) {
                            if (array_key_exists("@attributes", $v)) {
                                $return .= "<$k " . $this->parseAttributes($v['@attributes']) . ">";
                                unset($v['@attributes']);
                            } else {
                                $return .= "<$k>";
                            }
                            $return .= $this->parseArray( $v ) . "</$k>";
                        } else {
                            $return .= "<$k>$v</$k>";
                        }
                    }
                }
            } else {
                $this->errorLog[] = "Invalid array in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                return FALSE;
            }

            return $return;
        }

        private function parseAttributes($array) {
            $return = "";
            if (is_array($array)) {
                foreach ($array as $attribute => $attributeValue) {
                    if (is_array($attribute)) {
                        $this->errorLog[] = "Invalid array in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                        return "";
                    }
                    $return .= $attribute . '="' . $attributeValue . '" ';
                }
            } else {
                $this->errorLog[] = "Invalid array in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                return "";
            }
            return $return;
        }
        /**
         * Function to convert an associative array into XML
         *
         * @param string $array
         *
         * @param string $rootNodeName
         *
         * @access public
         * @return string(xml) on success and false on failure
         */
        public function convertArrayToXML( $array, $rootNodeName = "XMLHandler" ) {
            $return = "<?xml version='1.0' encoding='ISO-8859-1'?><{$rootNodeName}>";
            $return .= $this->parseArray( $array );
            $return .= "</{$rootNodeName}>";

            return $return;
        }

        /**
         * Function to convert an JSON into XML
         *
         * @param string $json
         *
         * @access public
         * @return string(xml) on success and false on failure
         */
        public function convertJsonToXML( $json ) {
            if ( !is_string( $json ) ) {
                $this->errorLog[] = "The first parameter should to be string in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                return FALSE;
            }
            $array = json_decode( $json, TRUE );
            if ( $array === FALSE ) {
                $this->errorLog[] = "Failed to decode JSON in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                return FALSE;
            } else {
                return $this->convertArrayToXML( $array );
            }
        }

        /**
         * Function to convert an JSON into array
         *
         * @param string $json
         *
         * @access public
         * @return array on success and false on failure
         */
        public function convertJsonToArray( $json ) {
            if ( !is_string( $json ) ) {
                $this->errorLog[] = "The first parameter should to be string in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                return FALSE;
            }
            $array = json_decode( $json, TRUE );
            if ( $array === FALSE ) {
                $this->errorLog[] = "Failed to decode JSON in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;
                return FALSE;
            } else {
                return $array;
            }
        }


        /**
         * Function to parse String and convert it into array
         *
         * @param        $string
         * @param string $inputArray
         *
         * @internal param array $array
         *
         * @access   public
         * @return array on success and false on failure
         * @todo     refactor  the code from line 205-222  (automate it)
         */
        public function convertStringToArray( $string, &$inputArray = "" ) {
            $lines = explode( LINE_SEPERATOR, $string );
            foreach ( $lines as $value ) {
                $items = explode( NODE_SEPERATOR, $value );
                if ( sizeof( $items ) == 2 ) {
                    $inputArray[$items[0]] = $items[1];
                } elseif ( sizeof( $items ) == 3 ) {
                    $inputArray[$items[0]][$items[1]] = $items[2];
                } elseif ( sizeof( $items ) == 4 ) {
                    $inputArray[$items[0]][$items[1]] [$items[2]] = $items[3];
                } elseif ( sizeof( $items ) == 5 ) {
                    $inputArray[$items[0]][$items[1]] [$items[2]][$items[3]] = $items[4];
                } elseif ( sizeof( $items ) == 6 ) {
                    $inputArray[$items[0]][$items[1]] [$items[2]][$items[3]][$items[4]] = $items[5];
                } elseif ( sizeof( $items ) == 7 ) {
                    $inputArray[$items[0]][$items[1]] [$items[2]][$items[3]][$items[4]][$items[5]] = $items[6];
                }
            }

            return $inputArray;
        }

        /**
         * Function to parse Array and convert it into string
         *
         * @param        $inputArray
         * @param string $outputString
         * @param string $parentKey
         *
         * @internal param array $array
         *
         * @access   private
         * @return string on success and false on failure
         */
        private function convertArrayToString( $inputArray, &$outputString = "", &$parentKey = "" ) {
            if ( is_array( $inputArray ) ) {
                if ( trim( $parentKey ) == "" ) {
                    $parentKey = LINE_SEPERATOR;
                }
                foreach ( $inputArray as $key => $value ) {
                    if ( is_array( $value ) ) {
                        $parentKey .= $key . NODE_SEPERATOR;
                        $this->convertArrayToString( $value, $outputString, $parentKey );
                        $parentKey = "";
                    } else {
                        $outputString .= $parentKey . $key . NODE_SEPERATOR . $value . LINE_SEPERATOR;
                    }
                }
            } else {
                $this->errorLog[] = "Invalid array in function: " . __FUNCTION__ . " on line: " . __LINE__ . " in filename= " . __FILE__;

                return FALSE;
            }

            return $outputString;
        }

        /**
         * Function to convert XML into string
         *
         * @param string $xml
         *
         * @return string on success and false on failure
         */
        public function convertXmltoString( $xml ) {
            $array = $this->convertXmlToArray( $xml );
            if ( $array === FALSE ) {
                return FALSE;
            } else {
                return $this->convertArrayToString( $array );
            }
        }
    }

?>