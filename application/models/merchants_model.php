<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of super_user_model
 *
 * @author Maxwell
 */
class merchants_model extends TellerPoint_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    protected $_table_name = 't_merchants';
    protected $_primary_key = 'id';
    protected $_order_by = 'datecreated desc';
    public $_rules = array(
        'name' => array(
            'field' => 'merchant_name',
            'label' => 'Merchant Name',
            'rules' => 'required|trim'
        ),
         'email' => array(
            'field' => 'merchant_email',
            'label' => 'Merchant Email',
            'rules' => 'required|trim|is_unique[t_merchants.merchant_email]|valid_email'
        ),
         'phone' => array(
            'field' => 'merchant_phone',
            'label' => 'Merchant Phone',
            'rules' => 'required|trim|numeric'
        ),
         'logo' => array(
            'field' => 'merchant_logo',
            'label' => 'Merchant Logo',
            'rules' => 'required|trim'
        ),
         'password' => array(
            'field' => 'merchant_password',
            'label' => 'Password',
            'rules' => 'required|trim|alpha_numeric'
        ),
         'vfcode' => array(
            'field' => 'merchant_vfcode',
            'label' => 'Vodafone Cash Code',
            'rules' => 'required|trim|numeric'
        )
    );
        
}
