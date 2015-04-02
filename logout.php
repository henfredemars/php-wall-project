<?php include("header.php"); ?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>You are now Logged Out</h1>
                        <?php
				unset($_SESSION["username"]);
				header("refresh: 3; index.php");
                        ?>
                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->

<?php include("close_header.html"); ?>
