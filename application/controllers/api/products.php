<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of products
 *
 * @author Maxwell
 */
class products extends TellerPoint_Controller {
    //put your code here
      //put your code here
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('products_model');
    }

    public function data_get() {
        $id = $this->get('id');
        
        if ($id == NULL){
            $result = $this->products_model->get_all();
            $this->response($result);
        }
        else{
            $result = $this->products_model->get_all($id);
            if(count($result)){
               $this->response($result, 200);
            }
        }
         $this->response(NULL, 404);
    }

    public function data_post() {

        //You are posting data for registering the merchant
        $product_data = $this->array_from_verb('post');
 
        $v_rules = $this->products_model->_rules;
        $this->form_validation->set_rules($v_rules);

        if ($this->form_validation->run()) {

            $id = $this->products_model->save_update($product_data);

            $this->response($this->products_model->get_all($id), REST_Controller::HTTP_OK);
        } else
            $this->response(strip_tags(validation_errors()), REST_Controller::HTTP_BAD_REQUEST);
    }

    public function data_put() {
        //update record
        $id = $this->put('id');
 
        if ($id) {
            $merchant_data = $this->array_from_verb('put');
            $update_id = $this->products_model->save_update($merchant_data, $id);

            $result = $this->products_model->get_all($id);
            if(count($result))$this->response($result, 200);
        }

        $this->response(null, 404);
    }

    public function data_delete() {
        //delete record
        $id = $this->get('id');
        if ($id) {
            $done = $this->products_model->delete($id);
            if ($done)
                $this->response($this->products_model->get_all(), 200);
        }

        $this->response(null, 404);
    }

}
