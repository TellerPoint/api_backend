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
class Purchase_model extends TellerPoint_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    protected $_table_name = 't_transactions';
    protected $_primary_key = 'id';
    protected $_order_by = 'datecreated desc';
    
    public $_rules = array(
        'mercid' => array(
            'field' => 'merchant_id',
            'label' => 'Merchant Id',
            'rules' => 'required|trim|numeric'
        ),
         'proid' => array(
            'field' => 'product_id',
            'label' => 'Product Id',
            'rules' => 'required|trim|numeric'
        ),
         'phone' => array(
            'field' => 'customer_phone',
            'label' => 'Phone',
            'rules' => 'required|trim'
        ),
         'qty' => array(
            'field' => 'qty',
            'label' => 'Quantity',
            'rules' => 'required|trim|numeric'
        ),
         'amt' => array(
            'field' => 'amount',
            'label' => 'Amount',
            'rules' => 'required|trim|numeric'
        )
    );
    
    public $_sms_validation_rules = array(
            array(
                'field' => 'smsCode',
                'label' => 'Sms Code',
                'rules' => 'required|trim|numeric'
            ),
            array(
                'field' => 'transaction_id',
                'label' => 'Transaction Id',
                'rules' => 'required|trim|numeric'
            )
        );
}
