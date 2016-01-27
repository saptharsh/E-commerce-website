<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller{
    public $paypal_data = '';
    /* $tax and $shipping are set in config.php */
    public $tax;
    public $shipping;
    public $total = 0;
    public $grand_total;
    
    // Cart index (VIEW)
    public function index() {
        
        $data['main_content'] = 'cart_view';
        $this->load->view('layouts/main', $data);
        
    }
    
    // Add to Cart
    public function add() {
        
        // Item Data from the Hidden FORM elements, using input library. From product_view and detail_view
        $data = array(
            'id' => $this->input->post('item_number'),
            'qty' => $this->input->post('qty'),    
            'price' => $this->input->post('price'),    
            'name' => $this->input->post('title')    
        );
        
        // Testing
        /*
        print_r($data);
        die();
        */
        
        // Insert into Cart, cart is the Model Class: Where insert() is the method in it 
        $this->cart->insert($data);
        
        redirect('products');
        
    }
    
    // Update Cart
    public function update($in_cart = NULL) {
        // Fetching all the Post data
        $data = $_POST;
        $this->cart->update($data);
        
        // Show Cart Page
        redirect('cart');
        
    }
    
    // Processing Form (PayPal) on clicking Checkout Form cart_view
    public function process() {
        
        if($_POST){
            //print_r($this->input->post('item_name'));
            //print_r($_POST);
            //die();
            foreach ($this->input->post('item_name') as $key => $value) {
                
                $this->tax =$this->config->item('tax');
                $this->shipping = $this->config->item('shipping');
                // Fetching by Item_names => Item_price and the Item_quantity
                $item_id = $this->input->post('item_code')[$key];
                $product = $this->product_model->get_product_details($item_id);
                
                
                //Assign Data To Paypal
		$this->paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($product->title);
		$this->paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item_id);
		$this->paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($product->price);
		$this->paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($this->input->post('item_qty')[$key]);
				
                //print_r($this->paypal_data);
                //die();
                
                // Multiplying item's Price * item's Quantity
                $subtotal = ($product->price * $this->input->post('item_qty')[$key]);
                $this->total = $this->total + $subtotal;
                
                //print_r($this->paypal_data);
                //print_r("/n total=> ".$this->total);
                //die();
                
		$paypal_product['items'][] = array(
			'itm_name'  =>$product->title,
			'itm_price' => $product->price,
			'itm_code'  => $item_id,
			'itm_qty'   => $this->input->post('item_qty')[$key]
		);
                
                //print_r($paypal_product['items']);
                //die();
                
                // Create Order Array
                $order_data = array(
                        'product_id' 	=> $item_id,
                        'user_id'  	=> $this->session->userdata('userid'),
                        'transaction_id'=> 8234038,
                        'qty'           => $this->input->post('item_qty')[$key],
                        'price'      	=> $subtotal,
                        'address'   	=> $this->input->post('address'),
                        'address2'      => $this->input->post('address2'),
                        'city'      	=> $this->input->post('city'),
                        'state'      	=> $this->input->post('state'),
                        'zipcode'      	=> $this->input->post('zipcode')
		);
                
                //print_r($order_data);
                //die();
            
                // Add order Data into DB
                $this->product_model->add_order($order_data);    
                
            } 
            /*
             * End of process()
             */
            // All the print_r($str); Was put here when the code was built
            
            
            //Get Grand Total
            $this->grand_total = $this->total + $this->tax + $this->shipping;
            
            //Create Array Of Costs
            $paypal_product['assets'] = array(
                    'tax_total'     =>$this->tax,
                    'shipping_cost' =>$this->shipping,
                    'grand_total'   =>$this->total
                    );
			
            //print_r($paypal_product['assets']);
            //die();
            
            //Session Array For Later, When Users Pays and Returns from the PayPal
            $_SESSION["paypal_products"] = $paypal_product;
            
            // print_r($paypal_product);
            // die();
            
            //Send Paypal Params
            $padata =   '&METHOD=SetExpressCheckout'.
                	'&RETURNURL='.urlencode($this->config->item('paypal_return_url')).
			'&CANCELURL='.urlencode($this->config->item('paypal_cancel_url')).
			'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
			$this->paypal_data.
			'&NOSHIPPING=0'.
			'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this->total).
			'&PAYMENTREQUEST_0_TAXAMT='.urlencode($this->tax).
			'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($this->shipping).
			'&PAYMENTREQUEST_0_AMT='.urlencode($this->grand_total).
			'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($this->config->item('paypal_currency_code')).
			'&LOCALECODE=GB'. //PayPal pages to match the language on your website.
			'&LOGOIMG=https://localhost:444/PHPApps/GamersShop/assets/images/logo.jpg'. //Custom logo
			'&CARTBORDERCOLOR=FFFFFF'.
			'&ALLOWNOTE=1';
            
// STEP 1   //(SETTING UP OF EXPRESS CHECKOUT)
            //Execute "SetExpressCheckOut" 
            $httpParsedResponseAr = $this->paypal->PPHttpPost('SetExpressCheckout', 
                    $padata, $this->config->item('paypal_api_username'), 
                    $this->config->item('paypal_api_password'), 
                    $this->config->item('paypal_api_signature'), $this->config->item('paypal_mode'));
	
            //Respond according to message we receive from Paypal
            if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || 
                    "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
        	
                //Redirect user to PayPal store with Token received.
		$paypal_url ='https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
		header('Location: '.$paypal_url);
            } else{
		//Show error message
		print_r($httpParsedResponseAr);
		die(urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]));			
            }
	
            
        } /* if($_POST) ENDS */

        
        /*
         * Redirecting to my website
         */
        //Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
	if(!empty($this->input->get('token')) && !empty($this->input->get('PayerID'))){
            //we will be using these two variables to execute the "DoExpressCheckoutPayment"
            //Note: we haven't received any payment yet.
			
            $token = $this->input->get('token');
            $payer_id = $this->input->get('PayerID');
			
            //Get Session info
            $paypal_product = $_SESSION["paypal_products"];
            $this->paypal_data = '';
            $total_price = 0;
			
            //Loop Through Session Array
            foreach($paypal_product['items'] as $key => $item){
                $this->paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($item['itm_qty']);
                $this->paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item['itm_price']);
		$this->paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($item['itm_name']);
		$this->paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item['itm_code']);
			
		//Get Subtotal
		$subtotal = ($item['itm_price']*$item['itm_qty']);
			
        	//Get Total
		$total_price = ($total_price + $subtotal);
            }
			
            $padata = 	'&TOKEN='.urlencode($token).
                        '&PAYERID='.urlencode($payer_id).
			'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
			$this->paypal_data.
			'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($total_price).
			'&PAYMENTREQUEST_0_TAXAMT='.urlencode($paypal_product['assets']['tax_total']).
			'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($paypal_product['assets']['shipping_cost']).
			'&PAYMENTREQUEST_0_AMT='.urlencode($paypal_product['assets']['grand_total']).
			'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);
			
// STEP 1   //(EXECUTING EXPRESS CHECKOUT)
			//Execute "DoExpressCheckoutPayment"
			$httpParsedResponseAr = $this->paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $this->config->item('paypal_api_username'), $this->config->item('paypal_api_password'), $this->config->item('paypal_api_signature'), $this->config->item('paypal_mode'));
			
			//Check if everything went ok..
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
                            $data['trans_id'] = urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
					
                            //Load View
                            $data['main_content'] = 'thankyou';
                            $this->load->view('layouts/main', $data);
                            
                            /*
                             * On SUCCESSFULL checkout from "ExpressCheckout" Insert the order details to DB
                             */
                            // Add order Data
                            //$this->product_model->add_order($order_data);    
                            
                            /*
                             * $token => is the Transaction ID
                             */
                            $padata = 	'&TOKEN='.urlencode($token);
                            $httpParsedResponseAr = $this->paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $this->config->item('paypal_api_username'), $this->config->item('paypal_api_password'), $this->config->item('paypal_api_signature'), $this->config->item('paypal_mode'));
			} else {
                            die($httpParsedResponseAr["L_LONGMESSAGE0"]);
                            echo '<pre>';
                            print_r($httpParsedResponseAr);
                            echo '</pre>';
			}
		}
        
    }
    
}






