<?php

class Admin_model extends CI_Model {

    public function __construct() {

        // Call the CI_Model constructor
        parent::__construct();
    }

    // Get All products
    public function get_AllProducts() {

        $this->db->select('*');
        $this->db->from('products');
        $query = $this->db->get();
        return $query->result();
    }

    // inserting the product
    public function insertGame($data) {

        $this->db->insert('products', $data);
    }

    // Updating the products
    public function updateGame($id, $formEle) {

        $result = $this->db->update('products', $formEle, array('productid' => $id));

        // return 1(True) on successful updation of DB
        return $result;
    }

    // Deleting a product
    public function deleteGame($id) {

        $this->db->delete('products', array('productid' => $id));
    }

    public function uplaod_gameImg($img) {

        
        
        
    }

}
