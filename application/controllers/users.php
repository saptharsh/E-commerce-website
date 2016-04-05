<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function register() {

        // Validation Rules
        /*
         * trim => takes of extra white spaces
         */
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[16]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            // Show registeration view
            $data['main_content'] = 'register';
            $this->load->view('layouts/main', $data);
        } else {
            if ($this->user_model->register()) {
                /* stays only on the redirected page and is unsetted automatically */
                $this->session->set_flashdata('registered', 'You are now registered and can login');
                redirect('products');
            }
        }
    }
    
    public function login() {
        
        // trim => removes the white spaces from the beginning and end of the string
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[16]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[50]');
        
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        
        $user_id = $this->user_model->login($username, $password);
        
        // print_r($user_id);
        // die();
        // Validate User
        if($user_id){
            // Create array of user data to be used in application, after login() returns TRUE
            $data = array(
                        'userid' => $user_id->userid,
                        'username' => $username,
                        'logged_in' => true,
                        'role' => $user_id->role
            );
            
            // print_r($data);
            // die();
            // Set SESSION userdata
            $this->session->set_userdata($data);
            
            // Set message
            $this->session->set_flashdata('pass_login', 'You are now loggen in!');
            
            /* Admin is taken to the proper page */
            if($user_id->role == "admin") {
                redirect('admin');
            }
            redirect('products');
        } else {
            // Set error on Invalid login attempt
            $this->session->set_flashdata('fail_login', 'Please enter the correct username and password');
            redirect('products');
        }
        
    }
    
    
    public function logout() {
        
        // Unset user data
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role');
        $this->session->sess_destroy();
        
        redirect('products');
        
    }

}