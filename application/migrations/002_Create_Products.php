<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of 001_Migration_Create_Merchants
 *
 * @author Maxwell
 */
class Migration_Create_Products extends CI_Migration {

    //put your code here

    public function up() {
        
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
                'null' => FALSE
            ),
            'merchant_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'product_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'product_desc' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'product_img' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'product_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'product_amount' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => TRUE
            ),
            'datecreated' => array(
                'type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
            ),
            'datemodified' => array(
                'type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
            )
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('t_products');
    }

    public function down() {
        $this->dbforge->drop_table('t_products');
    }

}
