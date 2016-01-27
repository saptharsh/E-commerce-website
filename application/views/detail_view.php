<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo $greet;
?>
<?php //echo $products[0]->productid; ?>

<div class="row details">
    <div class="col-md-4">
        <img src="<?php echo base_url(); ?>assets/images/products/<?php echo $product->image; ?>" />
    </div>
    <div class="col-md-8">
        <h3><?php echo $product->title; ?></h3>
        <div class="details-price">
            <?php echo $product->price; ?>
        </div>
        <div class="details-description">
            <p><?php echo $product->description; ?></p>
        </div>

        <div class="details-buy">
            <form method="POST" action="<?php echo base_url(); ?>cart/add/<?php echo $product->productid; ?>">
                <label>QTY: </label><input class="qty" type="text" name="qty" value="1"/>
                <input type="hidden" name="item_number" value="<?php echo $product->productid; ?>"/>
                <input type="hidden" name="price" value="<?php echo $product->price; ?>"/>
                <input type="hidden" name="title" value="<?php echo $product->title; ?>"/>
                
                <button class="btn btn-primary" type="submit">Add To Cart</button>
            </form>
        </div>
    </div>
</div>










