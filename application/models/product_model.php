<?php
//Convention => models are singular
class Product_model extends CI_Model {

    // Get All products
    public function get_products() {
        
        $this->db->select('*');
        $this->db->from('products');
        $query = $this->db->get();
        return $query->result();
    }
    
    // Getting single product details
    public function get_product_details($id) {
        
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('productid', $id);
        $query = $this->db->get();
        
        // Returning single row
        return $query->row();
    }
    
    // Getting categories
    public function get_categories() {
        
        $this->db->select('*');
        $this->db->from('categories');
        $query = $this->db->get();
        return $query->result();
    }
    
    // Getting popular products
    public function get_popular() {
        // Using aliases in the SQL
        
        $this->db->select('P.*, COUNT(O.product_id) as total');
        $this->db->from('orders AS O');
        $this->db->join('products AS P', 'O.product_id = P.productid', 'INNER');
        $this->db->group_by('O.product_id');
        $this->db->order_by('total', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    
    // Adding Order details coming from cart Controller
    public function add_order($order_data) {
        
        $result = $this->db->insert('orders', $order_data);
        return $result;
    }
    
    
    
}
















