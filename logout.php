<?php include("header.html"); ?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>You are now Logged Out</h1>
                        <?php
                                session_start();
				unset($_SESSION["username"]);
				echo "<META HTTP-EQUIV=Refresh CONTENT=\"3\"; URL=\"index.php/\">";
                        ?>
                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->

<?php include("close_header.html"); ?>
