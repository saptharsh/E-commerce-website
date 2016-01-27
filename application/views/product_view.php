<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo $greet;
?>
<!-- Admin Section design -->
<?php if($this->session->userdata('role') == "admin") : ?>
    <div class="col-md-10 pull-right">
<?php endif; ?>
        
<?php //echo $products[0]->productid; ?>

<?php if($this->session->flashdata('registered')) : ?>
	<div class="alert alert-success">
		<?php echo $this->session->flashdata('registered'); ?>
	</div>
<?php endif; ?>

<?php if($this->session->flashdata('pass_login')) : ?>
	<div class="alert alert-success">
		<?php echo $this->session->flashdata('pass_login'); ?>
	</div>
<?php endif; ?>

<?php if($this->session->flashdata('fail_login')) : ?>
	<div class="alert alert-danger">
		<?php echo $this->session->flashdata('fail_login'); ?>
	</div>
<?php endif; ?>

<?php foreach ($products as $product) : ?>

    <div class="col-md-4 game">
        <div class="game-price"><?php echo $product->price; ?></div>
        <a href="<?php base_url(); ?>products/details/<?php echo $product->productid; ?>">
            <img src="<?php echo base_url(); ?>assets/images/products/<?php echo $product->image; ?>" />
        </a>
        <div class="game-title">
            <?php echo $product->title; ?>
        </div>
        <div class="game-add">
            <form method="POST" action="<?php echo base_url(); ?>cart/add">
                <label>QTY: </label><input class="qty" type="text" name="qty" value="1"/>
                <input type="hidden" name="item_number" value="<?php echo $product->productid; ?>"/>
                <input type="hidden" name="price" value="<?php echo $product->price; ?>"/>
                <input type="hidden" name="title" value="<?php echo $product->title; ?>"/>
                
                <button class="btn btn-primary" type="submit">Add To Cart</button>
            </form>
        </div>
    </div>

    
<?php endforeach; ?>
<?php if($this->session->userdata('role') == "admin") : ?>    
    </div>
<?php endif; ?>