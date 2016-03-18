<?php

require(APPPATH . '/libraries/REST_Controller.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TellerPoint_Controller
 *
 * @author Maxwell
 */
class TellerPoint_Controller extends REST_Controller {

    //put your code here

    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    public function array_from_verb($verb = 'post') {

        $data = array();

        foreach ($this->$verb() as $key => $value) {
            $data[$key] = $_POST[$key] = $value;
        }
        return $data;
    }

}
