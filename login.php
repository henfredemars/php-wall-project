<?php include("header.html"); ?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>User Login</h1>
                        <?php
                                include('do_login.php');
				echo "<p>Note: Logins don't do anything yet.</p>";
                        ?>
                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
            </div>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->

<?php include("close_header.html"); ?>
