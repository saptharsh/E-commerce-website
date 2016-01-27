<?php

//Convention => controllers are plural
class Products extends CI_Controller {

    public function index() {
        /* Loading Model */
        $data['products'] = $this->product_model->get_products();
        
        /* Loading View */
        // Array of arrays
        // $data['greet] = "Hi!";
        $data['main_content'] = "product_view";
        
        // Load View, $data => values that can be passed to the view
        // $this->load->view('products_view', $data);
        $this->load->view('layouts/main', $data);
    }

    public function details($id) {
        // Get Product Details
        $data['product'] = $this->product_model->get_product_details($id);
        
        // Load View
        $data['main_content'] = "detail_view";
        $this->load->view('layouts/main', $data);
    }
    
    public function category() {
        
    }
    
}








