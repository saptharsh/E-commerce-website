<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Add product
</button>
<br/>
<br/>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Data</h4>

            </div>
            <form role="form" enctype="multipart/form-data" action="admin/insertGame">
            <div class="modal-body">

                <!--<form role="form" enctype="multipart/form-data">-->
                    <div class="form-group">
                        <label for="gd">Category ID</label>
                        <input type="text" class="form-control" id="catID">
                    </div>
                    <div class="form-group">
                        <label for="pn">Title</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="form-group">
                        <label for="al">Description</label>
                        <textarea class="form-control" rows="5" id="desc"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="al">Image file Name.Type</label>
                        <input type="text" class="form-control" id="img">
                    </div>
                    <div class="form-group">
                        <label>Upload Image</label> 
                        <input type="file" name="gameImage" id="imagefile">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label for="al">Price</label>
                        <input type="text" class="form-control" id="price">
                    </div>
                <!--</form>-->

            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="save" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div><!-- Model End -->

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Category ID</th>
            <th>GameTitle</th>
            <th>Description</th>
            <th>Image</th>
            <th>Price</th>
            <th>Edit/Delete</th>
        </tr>
    </thead>

    <?php foreach ($allProducts as $product) : ?>

        <tbody>
            <tr>
                <td><?php echo $product->productid; ?></td>
                <td><?php echo $product->category_id; ?></td>
                <td><?php echo $product->title; ?></td>
                <td><?php echo $product->description; ?></td>
                <td><?php echo $product->image; ?>
                    <br/>
                    <br/>
                    <div class="form-group">
                        <label>Upload Image</label> 
                        <input type="file" name="gameImage">
                        <p class="help-block"></p>
                    </div>
                </td>
                <td><?php echo $product->price; ?></td>
                <td>
                    <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal<?php echo $product->productid; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                    <a class="btn btn-danger btn-sm"  onclick="deletedata('<?php echo $product->productid; ?>')" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal<?php echo $product->productid; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $product->productid; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel<?php echo $product->productid; ?>">Edit Items</h4>
                                </div>
                                <div class="modal-body">

                                    <form>
                                        <div class="form-group">
                                            <label for="gd">Category ID</label>
                                            <input type="text" class="form-control" id="catID<?php echo $product->productid; ?>" value="<?php echo $product->category_id; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="pn">Title</label>
                                            <input type="text" class="form-control" id="title<?php echo $product->productid; ?>" value="<?php echo $product->title; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="al">Description</label>
                                            <textarea class="form-control" rows="5" id="desc<?php echo $product->productid; ?>"><?php echo $product->description; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="al">Image</label>
                                            <input type="text" class="form-control" id="img<?php echo $product->productid; ?>" value="<?php echo $product->image; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="al">Price</label>
                                            <input type="text" class="form-control" id="price<?php echo $product->productid; ?>" value="<?php echo $product->price; ?>">
                                        </div>

                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
                                    <button type="button" onclick="updatedata('<?php echo $product->productid; ?>')" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </td>
            </tr>    
        </tbody>

    <?php endforeach; ?>
</table>

<script>
    $('#save').click(function () {

        var categoryID = $('#catID').val();
        var title = $('#title').val();
        var desc = $('#desc').val();
        var image = $('#img').val();
        var price = $('#price').val();
        var imageFile = $('#imagefile').val();
        var imageSize = $('#imagefile')[0].files[0].size;
        var imageType = $('#imagefile')[0].files[0].type;
        var imageName = $('#imagefile')[0].files[0].name;

        var datas = "catID=" + categoryID + "&title=" + title + "&desc=" + desc + "&image=" + image + "&price=" + price +
                    "&gameImage=" + imageFile + "&imgSize=" + imageSize + "&imgType=" + imageType + "&imgName=" + imageName;

        console.log(datas);            
        $.ajax({
            type: "POST",
            url: "<?php base_url(); ?>admin/insertGame",
            data: datas,
            success: function (data) {
                // Checking AJAX posts
                alert(data);

                //window.location.reload();
            }
        });
    });

    function updatedata(str) {

        var productid = str;
        var product_data = {
            categoryID: $('#catID' + str).val(),
            title: $('#title' + str).val(),
            desc: $('#desc' + str).val(),
            image: $('#img' + str).val(),
            price: $('#price' + str).val()
        };

        console.log(product_data);
        $.ajax({
            type: "POST",
            cache: false,
            url: "<?php base_url(); ?>admin/update/" + productid,
            data: product_data,
            beforeSend: function () {

            },
            success: function (data) {
                // Checking the FORM elements
                // alert(data);
                // $("#edit-products").html(data);

                window.location.reload();
            }
        });
    }
    function deletedata(str) {

        var id = str;

        if (confirm('Are you sure you want to delete this?')) {

            $.ajax({
                type: "POST",
                url: "<?php base_url(); ?>admin/delete/" + id,
                success: function (data) {
                    // Checking the FORM elements
                    // alert(data);
                    // $("#edit-products").html(data);

                    window.location.reload();
                }
            });
        }
    }
</script>
