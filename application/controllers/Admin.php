<?php

class Admin extends CI_Controller {

    public function index() {

        $data['allProducts'] = $this->admin_model->get_AllProducts();
        $data['main_content'] = "admin_view";

        $this->load->view('layouts/main', $data);
    }

    public function insertGame() {

        $insertForm = array(
            'category_id' => $this->input->post('catID'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('desc'),
            'image' => $this->input->post('image'),
            'price' => $this->input->post('price')
        );

        $path = base_url()."assets/images/products/";
        $upload = array(
            'gameImg' => $this->input->post('gameImage'),
            'gameImgSize' => $this->input->post('imgSize'),
            'gameImgType' => $this->input->post('imgType'),
            'gameImgName' => $this->input->post('imgName')
        );
        
        // print_r($insertForm);
        //print_r($upload);
        //print_r($path);
        //die();
        
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $tenp = explode(".", $upload['gameImg']);
        $extension = end($tenp);
            
            //print_r($extension);
            //print_r($upload);
            //print_r($path);
            
            //die();
        
        if((($upload['gameImgType'] == "image/gif")
            || ($upload['gameImgType'] == "image/jpeg")
            || ($upload['gameImgType'] == "image/jpg")
            || ($upload["gameImgType"] == "image/pjpeg")
            || ($upload["gameImgType"] == "image/x-png")
            || ($upload["gameImgType"] == "image/png")) 
            && ($upload["gameImgSize"] < 5000000)  
            && in_array($extension, $allowedExts))    {
        
            //print_r($upload);
            //print_r($path);
            //die();
            
            move_uploaded_file($_FILES["gameImage"]["tmp_name"], $path.$upload['gameImgName']);
            
            //move_uploaded_file($_FILES["avatar"]["tmp_name"], "images/avatars/" . $_FILES["avatar"]["name"]);
            //redirect('register.php', 'File uploaded successfully', 'success');
        }
        
        die();
        
        $this->admin_model->uplaod_gameImg($upload);
        $this->admin_model->insertGame($insertForm);
        
    }

    public function update($id) {

        $form = array(
            'category_id' => $this->input->post('categoryID'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('desc'),
            'image' => $this->input->post('image'),
            'price' => $this->input->post('price')
        );

        // Checking Form elements: This will be returned to success function of AJAX
        //print_r($form);
        //die();

        $this->admin_model->updateGame($id, $form);
    }

    public function delete($id) {

        // Cheking AJAX
        //print_r($id);
        //die();

        $this->admin_model->deleteGame($id);
    }

}
