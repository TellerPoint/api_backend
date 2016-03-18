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
class Migration_Create_Merchants extends CI_Migration {

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
            'merchant_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'merchant_phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'merchant_logo' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'merchant_vfcode' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'merchant_vfpin' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'merchant_vfpassword' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'merchant_vftoken' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'merchant_vfvendor' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE
            ),
            'account_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
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
        $this->dbforge->create_table('t_merchants');
    }

    public function down() {
        $this->dbforge->drop_table('t_merchants');
    }

}
