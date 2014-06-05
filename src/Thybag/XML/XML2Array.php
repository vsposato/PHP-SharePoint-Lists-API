<?php
    /**
     * XML2Array: A class to convert XML to array in PHP
     * It returns the array which can be converted back to XML using the Array2XML script
     * It takes an XML string or a DOMDocument object as an input.
     *
     * See Array2XML: http://www.lalit.org/lab/convert-php-array-to-xml-with-attributes
     *
     * Author : Lalit Patel
     * Website: http://www.lalit.org/lab/convert-xml-to-array-in-php-xml2array
     * License: Apache License 2.0
     *          http://www.apache.org/licenses/LICENSE-2.0
     * Version: 0.1 (07 Dec 2011)
     * Version: 0.2 (04 Mar 2012)
     * 			Fixed typo 'DomDocument' to 'DOMDocument'
     *
     * Usage:
     *       $array = XML2Array::createArray($xml);
     */

    class XML2Array {

        private static $xml = null;
        private static $encoding = 'UTF-8';

        /**
         * Initialize the root XML node [optional]
         * @param $version
         * @param $encoding
         * @param $format_output
         */
        public static function init($version = '1.0', $encoding = 'UTF-8', $format_output = true) {
            self::$xml = new DOMDocument($version, $encoding);
            self::$xml->formatOutput = $format_output;
            self::$encoding = $encoding;
        }

        /**
         * Convert an XML to Array
         *
         * @param     $input_xml
         *
         * @param int $maximumConversionDepth
         *
         * @throws Exception
         * @internal param string $node_name - name of the root node to be converted
         * @internal param array $arr - aray to be converterd
         * @return DOMDocument
         */
        public static function &createArray($input_xml, $maximumConversionDepth = 1000) {
            $xml = self::getXMLRoot();
            if(is_string($input_xml)) {
                $parsed = $xml->loadXML($input_xml);
                if(!$parsed) {
                    throw new Exception('[XML2Array] Error parsing the XML string.');
                }
            } else {
                if(get_class($input_xml) != 'DOMDocument') {
                    throw new Exception('[XML2Array] The input XML object should be of type: DOMDocument.');
                }
                $xml = self::$xml = $input_xml;
            }
            $array[$xml->documentElement->tagName] = self::convert($xml->documentElement, 0,$maximumConversionDepth);
            self::$xml = null;    // clear the xml node in the class for 2nd time use.
            return $array;
        }

        /**
         * Convert an Array to XML
         *
         * @param mixed $node - XML as a string or as an object of DOMDocument
         * @param int   $depth
         *
         * @param int   $maxDepth
         *
         * @return mixed
         */
        private static function &convert($node, $depth = 0, $maxDepth = 3) {
            echo $depth . "\n";
            echo $maxDepth . "\n";


            $output = array();
            if ($maxDepth < $depth) {
                return $output;
            }

            switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
                $output['@cdata'] = trim($node->textContent);
                break;

            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;

            case XML_ELEMENT_NODE:

                // for each child node, call the covert function recursively
                for ($loopCounter=0, $childNodeCount=$node->childNodes->length; $loopCounter<$childNodeCount; $loopCounter++) {
                    $child = $node->childNodes->item($loopCounter);
                    $childConvertResult = self::convert($child, ($depth + 1), $maxDepth);
                    if(isset($child->tagName)) {
                        $childTagName = $child->tagName;

                        // assume more nodes of same kind are coming
                        if(!isset($output[$childTagName])) {
                            $output[$childTagName] = array();
                        }
                        $output[$childTagName][] = $childConvertResult;
                    } else {
                        //check if it is not an empty text node
                        if($childConvertResult !== '') {
                            $output = $childConvertResult;
                        }
                    }
                }

                if(is_array($output)) {
                    // if only one node of its kind, assign it directly instead if array($value);
                    foreach ($output as $childTagName => $childConvertResult) {
                        if(is_array($childConvertResult) && count($childConvertResult)==1) {
                            $output[$childTagName] = $childConvertResult[0];
                        }
                    }
                    if(empty($output)) {
                        //for empty nodes
                        $output = '';
                    }
                }

                // loop through the attributes and collect them
                if($node->attributes->length) {
                    $attributeArray = array();
                    foreach($node->attributes as $attrName => $attrNode) {
                        $attributeArray[$attrName] = (string) $attrNode->value;
                    }
                    // if its an leaf node, store the value in @value instead of directly storing it.
                    if(!is_array($output)) {
                        $output = array('@value' => $output);
                    }
                    $output['@attributes'] = $attributeArray;
                }
                break;
            }
            return $output;
        }

        /*
         * Get the root XML node, if there isn't one, create it.
         */
        private static function getXMLRoot(){
            if(empty(self::$xml)) {
                self::init();
            }
            return self::$xml;
        }
    }
?>