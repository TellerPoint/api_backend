<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of merchant
 *
 * @author Maxwell
 */
class Merchants extends TellerPoint_Controller {

    //put your code here
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('merchants_model');
    }

    public function data_get() {
        $this->load->model('products_model');
        $id = $this->get('id');
        
        if ($id == NULL){
            $result = $this->merchants_model->get_all();
            $result = (array) $result;
            
            foreach ($result as $value) {
               $value->products = $this->products_model->get_where(array('merchant_id'=>$value->id));                  
            }
            
            $data = array("merchants" => $result);
            $this->response($data);
        }
        else{
            $result = $this->merchants_model->get_all($id);
            if(count($result)){
               $result = (array) $result; 
               $result['products'] = $this->products_model->get_where(array('merchant_id'=>$result['id']));
               
               //$data = array("merchants" => $result);
               $this->response($result);
            }
        }
         $this->response(array("message" => "Resource Not Found"), 404);
    }

    public function data_post() {

        //You are posting data for registering the merchant
        $merchant_data = $this->array_from_verb('post');

        $v_rules = $this->merchants_model->_rules;
        $this->form_validation->set_rules($v_rules);

        if ($this->form_validation->run()) {

            //process the upload
            $id = $this->merchants_model->save_update($merchant_data);

            $this->response($this->merchants_model->get_all($id), REST_Controller::HTTP_OK);
        } else{
            $error = array("message" => strip_tags(validation_errors()));
            $this->response($error, REST_Controller::HTTP_BAD_REQUEST);
        }
            
    }

    public function data_put() {
        //update record
        $id = $this->put('id');
 
        if ($id) {
            $merchant_data = $this->array_from_verb('put');
            $update_id = $this->merchants_model->save_update($merchant_data, $id);

            $result = $this->merchants_model->get_all($id);
            if(count($result))$this->response($result, 200);
        }

        $this->response(array("message" => "Resource Not Found"), 404);
    }

    public function data_delete() {
        //delete record
        $id = $this->get('id');
        if ($id) {
            $done = $this->merchants_model->delete($id);
            
            //also delete the product and transaction of the merchant
            $this->load->model('products_model');
            $this->load->model('purchase_model');
             
            $this->products_model->delete(null, array("merchant_id" => $id));
            $this->purchase_model->delete(null, array("merchant_id" => $id));
            
            if ($done)
                $this->response($this->merchants_model->get_all(), 200);
        }

        $this->response(array("message" => "Resource Not Found"), 404);
    }

    public function products_get() {
        $this->load->model('products_model');
        
        $mid = $this->get('mid');
        $pid = $this->get('pid');
        
        $mid || $this->response(array("message" => "Resource Not Found"), 404);
                
        if ($pid == NULL){
            $result = $this->products_model->get_where(array('merchant_id'=>$mid));
            $this->response(array('products' => $result));
        }
        else{
            $result = $this->products_model->get_where(array('id' =>$pid, 'merchant_id'=>$mid));
            $this->response($result, 200);
        }
         $this->response(array("message" => "Resource Not Found"), 404);
    }
}
