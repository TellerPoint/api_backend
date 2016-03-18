<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of purchase
 *
 * @author Maxwell
 */
class purchase extends TellerPoint_Controller {

    //put your code here

    function __construct($config = 'rest') {
        parent::__construct($config);

        $this->load->model('purchase_model');
        $this->load->model('merchants_model');
    }

    public function data_post() {

        $purchase_data = $this->array_from_verb();
        $_rules = $this->purchase_model->_rules;

        $this->form_validation->set_rules($_rules);
        if ($this->form_validation->run()) {

            $_mid = $purchase_data['merchant_id'];
            $merchant_data = $this->merchants_model->get_all($_mid);

            if (!count($merchant_data))
                $this->response("Merchant Not Found", 404);

            //save transaction data 
            $purchase_data['status'] = 'Pending';
            $tranid = $this->purchase_model->save_update($purchase_data);
            
            //post to the vodafone url to send sms to customer
            $post_array = array(
                'vendor' => $merchant_data->merchant_vfvendor,
                'phone' => $purchase_data['customer_phone'],
                'amount' => $purchase_data['product_amount']
            );

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, config_item('vfcash_api_url') . 'SendSMS.php');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_array);

            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);

            if (curl_errno($curl_handle) || trim($buffer) != 'success')
                $this->response(curl_error($curl_handle), REST_Controller::HTTP_EXPECTATION_FAILED);

            $this->response($this->purchase_model->get_all($tranid));
            
        } else
            $this->response(strip_tags(validation_errors()), 400);
    }

    public function validate_post() {
        $validation_data = $this->array_from_verb();
        $this->form_validation->set_rules($this->purchase_model->_sms_validation_rules);
        
         if ($this->form_validation->run()) {
             
            $transaction_data = $this->purchase_model->get_all($validation_data['transaction_id']);
            if(!count($transaction_data)) $this->response ('Invalid Transaction Id', 404);
            
            $merchant_data = $this->merchants_model->get_all($transaction_data->merchant_id);
            if (!count($merchant_data))$this->response("Merchant Not Found", 404);
             
            $post_array = array(
                'smsCode' => $validation_data['smsCode'],
                'merchantCode' => $merchant_data->merchant_vfcode,
                'vfPIN' => $merchant_data->merchant_vfpin
            );

            //post to the vodafone url to send sms to client
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, config_item('vfcash_api_url') . 'SMSValidation.php');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_array);

            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);

            if (curl_errno($curl_handle))
                $this->response(curl_error($curl_handle), REST_Controller::HTTP_EXPECTATION_FAILED);

            //update the transaction to success
            $this->purchase_model->save_update(array('status' => 'Approved'), $validation_data['transaction_id']);
            
            //return the product detail with the transaction info
            $this->load->model('products_model');
            $result = $this->products_model->get_all($transaction_data->product_id);
            $result->transaction = $this->purchase_model->get_all($validation_data['transaction_id']);
            
            $this->response($result);
                    
         } else
            $this->response(strip_tags(validation_errors()), 400);
    }
}
