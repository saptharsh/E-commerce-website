<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gaming Lounge</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>

    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>">Gaming Lounge</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <?php if ($this->session->userdata('role') == "admin") : ?>
                            <li><a href="<?php echo base_url(); ?>admin">Admin</a></li>
                        <?php endif; ?>
                        <?php if (!$this->session->userdata('logged_in')) : ?>
                            <li><a href="<?php echo base_url(); ?>users/register">Create Account</a></li>
                        <?php endif; ?>
                    </ul>
                    <?php if (!$this->session->userdata('logged_in')) : ?>
                        <form method="POST" action="<?php base_url(); ?>users/login" class="navbar-form navbar-right">
                            <div class="form-group">
                                <input name="username" type="text" class="form-control" placeholder="Enter Username..">
                                <input name="password" type="password" class="form-control" placeholder="Enter Password..">
                            </div>
                            <button name="submit" type="submit" class="btn btn-default">Login</button>
                        </form>
                    <?php else : ?>
                        <form class="navbar-form navbar-right" method="POST" action="<?php echo base_url(); ?>users/logout">
                            <button name="submit" type="submit" class="btn btn-default">Logout</button>
                        </form>
                    <?php endif; ?>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">

            <div class="row">
                
                <?php if($this->session->userdata('logged_in')) : ?>
                    <!-- Web design when user is logged in -->
                    <?php if($this->session->userdata('role') == "user") : ?>            

                    <div class="col-md-4">
                        <div class="cart-block">
                            <!-- Side Bar -->
                            <?php $this->load->view('layouts/includes/sidebar'); ?>

                        </div><!-- End of col-md-4-->

                        <div class="col-md-8">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-green">
                                    <h3 class="panel-title">Latest Releases</h3>
                                </div>
                                <div class="panel-body">
                    <?php else : ?>
                        <!-- Web design when admin is logged in -->
                        <?php if($this->session->userdata('role') == "admin") : ?>            
                                    
                                <div class="col-md-12">
                                    
                                    <!-- Side Bar -->
                                    <?php $this->load->view('layouts/includes/admin_sidebar'); ?>
                                </div>    
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading panel-heading-green">
                                            <h3 class="panel-title">Admin Section</h3>
                                        </div>
                                        <div class="panel-body" id="edit-products">
                        <?php endif; ?>                            
                    <?php endif; ?>                            
                                           
                <?php else : ?>
                    <!-- Web design when user is not logged in -->                        
                    <div class="col-md-4">
                        <div class="cart-block">
                            <!-- Side Bar -->
                            <?php $this->load->view('layouts/includes/sidebar'); ?>

                        </div><!-- End of col-md-4-->

                        <div class="col-md-8">
                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-green">
                                    <h3 class="panel-title">Latest Releases</h3>
                                </div>
                                <div class="panel-body">
                    
                <?php endif; ?>                            