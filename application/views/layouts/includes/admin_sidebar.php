
<div class="panel panel-default panel-list">
    <div class="panel-heading panel-heading-dark">
        <h3 class="panel-title">
            Categories
        </h3>
    </div>
    <!-- List group -->
    <ul class="list-group">
        <?php foreach (get_categories_h() as $category) : ?> 
            <li class="list-group-item"><a href="<?php echo base_url(); ?>products/category/<?php echo $category->categoryid; ?>"><?php echo $category->name; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="panel panel-default panel-list">
    <div class="panel-heading">
        <h3 class="panel-title">
            Most Popular
        </h3>
    </div>
    <!-- List group -->
    <ul class="list-group">
        <?php foreach (get_popular_h() as $popular) : ?>
            <li class="list-group-item"><a href="<?php echo base_url(); ?>products/details/<?php echo $popular->productid; ?>"><?php echo $popular->title; ?></a></li>
            <?php endforeach; ?>

    </ul>
</div>



