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
class products_model extends TellerPoint_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    protected $_table_name = 't_products';
    protected $_primary_key = 'id';
    protected $_order_by = 'datecreated desc';
    
    public $_rules = array(
        'mercid' => array(
            'field' => 'merchant_id',
            'label' => 'Merchant Id',
            'rules' => 'required|trim|numeric'
        ),
         'name' => array(
            'field' => 'product_name',
            'label' => 'Product Name',
            'rules' => 'required|trim'
        ),
         'desc' => array(
            'field' => 'product_desc',
            'label' => 'Description',
            'rules' => 'required|trim'
        ),
         'img' => array(
            'field' => 'product_img',
            'label' => 'Image',
            'rules' => 'required|trim'
        ),
         'code' => array(
            'field' => 'product_code',
            'label' => 'Product Code',
            'rules' => 'required|trim|is_unique[t_products.product_code]'
        ),
         'amt' => array(
            'field' => 'product_amount',
            'label' => 'Amount',
            'rules' => 'required|trim|numeric'
        )
    );
    
}
