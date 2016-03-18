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
class Merchants_model extends TellerPoint_Model {

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
         'vfvendor' => array(
            'field' => 'merchant_vfvendor',
            'label' => 'VfCash Vendor Name',
            'rules' => 'required|trim'
        ),
         'vfpassword' => array(
            'field' => 'merchant_vfpassword',
            'label' => 'Password',
            'rules' => 'required|trim|alpha_numeric'
        ),
         'vfcode' => array(
            'field' => 'merchant_vfcode',
            'label' => 'Vodafone Cash Code',
            'rules' => 'required|trim|numeric|is_unique[t_merchants.merchant_vfcode]'
        ),
         'vfpin' => array(
            'field' => 'merchant_vfpin',
            'label' => 'Vodafone Cash Pin',
            'rules' => 'required|trim|numeric'
        ),
         'vftoken' => array(
            'field' => 'merchant_vftoken',
            'label' => 'Vodafone Cash Token',
            'rules' => 'required|trim'
        )
    );
        
}
