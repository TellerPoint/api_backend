<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FarmLite_Model
 *
 * @author Maxwell
 */
class TellerPoint_Model extends CI_Model {
    
    protected $_table_name = '';
    protected $_primary_key = '';
    protected $_order_by = '';
    public $_rules = array();

    function __construct() {
        parent::__construct();
    }    
    
    public function get_all($id = NULL, $single = FALSE){
		
        if ($id != NULL) {
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        }
        else if($single == TRUE) {
            $method = 'unbuffered_row';
        }
        else {
            $method = 'result';
        }

        if (trim($this->_order_by) !== FALSE) {
                $this->db->order_by($this->_order_by);
        }
        return $this->db->get($this->_table_name)->$method();
    }
    
    public function get_join($join_table_name_and_key, $join_table_fields, $single = FALSE){
	$data_fields = '';
        
        if(is_array($join_table_fields)){
            foreach($join_table_fields as $fields){                
                $data_fields .= ','.$fields;
            }
            $data_fields = substr_replace($data_fields, '', 0, 1);
        }
        else $data_fields = $join_table_fields;

        $this->db->select($this->_table_name.'.*, '. $data_fields);
        
        foreach ($join_table_name_and_key as $join_table_name => $join_table_key)
            $this->db->join($join_table_name, $join_table_name.'.'.$join_table_key . ' = ' . $this->_table_name.'.'.$join_table_key);
        
        return $this->get_all(NULL, $single);
    }
    
    public function get_where($where, $single = FALSE){
            $this->db->where($where);
            return $this->get_all(NULL, $single);
    }
    
    public function save_update($data, $id = NULL){
        
        $insert_id = 0;
        $now = 'CURRENT_TIMESTAMP';//'UTC_TIMESTAMP()'; - For MySql
        $id || $this->db->set('datecreated', $now, false);
        $this->db->set('datemodified', $now, false);
        
        // Insert
        if ($id === NULL) {
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $insert_id = $this->db->insert_id();
        }
        // Update
        else {
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
            $insert_id = $this->db->affected_rows();
        }
        
        return $insert_id;
    }
	
    public function delete($id, $where = null){

        if($where != null){
            $this->db->where($where)->delete($this->_table_name);
            return $this->db->affected_rows();
        }
               
        $this->db->where($this->_primary_key, $id)->delete($this->_table_name);
        return $this->db->affected_rows();
    }
        
    public function generate_unique_id(){
         $mstime = str_replace(".", "", microtime());
         $times = explode(" ", $mstime);
         $id = str_replace(".", "", uniqid("", true)) . $times[0]; 
         return $id;
    }
   
}
