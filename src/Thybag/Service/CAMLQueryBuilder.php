<?php
/**
 * Created by PhpStorm.
 * User: vsposato
 * Date: 4/30/14
 * Time: 6:37 PM
 */

namespace Thybag\Service;


class CAMLQueryBuilder {


    /**
     * This will hold the final CAML Query XML object
     * @var instanceOf SimpleXMLElement
     */
    protected $CAML_Query;

    protected $conditionsArray = array(
        'LOGICALJOIN' => array(
            'FIELDDEF' => array(
                'COMPARISONOPERATOR' => array(
                    'VALUETYPE' => array(
                        'VALUE(S)' => array(

                        )
                    )
                )
            )
        )
    );
    public function __construct( $conditionsArray = array() ) {

    }

    public function addCondition() {

    }

} 