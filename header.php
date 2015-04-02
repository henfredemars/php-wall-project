<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="A simple PHP wall" content="">
    <meta name="henfredemars" content="Anonymous comment board, class project">

    <title>PHP Wall Application</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="index.php">
                        PHP Wall
                    </a>
                </li>
		<li>
		    <a href="search.php">Search</a>
		</li>
		<li>
		    <a href="login.php">Login</a>
		</li>
		<li>
		    <a href="register.php">Register</a>
		</li>
		<?php
		include_once("util.php");
		session_start();
		if (isset($_SESSION["username"])) {
		  $db = connect();
		  $db = $db->logins;
		  $username = $_SESSION["username"];
		  $cursor = $db->find(array("username"=>$username,"type"=>"Admin"));
		  if ($cursor->count() > 0) {
		    echo "<li><a href=\"post_blog.php\">New Blog Post</a></li>";
		  }
		}
		?>
		<li>
		    <a href="blog.php">Blog</a>
		</li>
                <li>
                    <a href="about.php">About</a>
                </li>
		<li>
		    <a href="stats.php">Server Stats</a>
		</li>
                <li>
                    <a href="contact.php">Contact</a>
                </li>
		<li>
		    <a href="cans.php">Cans</a>
		</li>
            </ul>
        </div>

        <!-- /#sidebar-wrapper -->

