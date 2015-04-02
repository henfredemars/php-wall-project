<?php

include_once("util.php");
inc_pages_served();

echo "<p>This is a new PHP web application in the making!</p>";

echo "<h3>The Wall</h3>";
echo "<p>The purpose of this application is to provide an interactive wall for anonymous users. ".
	"The project is aimed at teaching myself the basics of PHP and database interaction. </p>";

echo "<h3>The Server</h3>";
echo "<p>We are running PHP with a mysterious database in the backend. This application should be secure with basic input sanitation, type checking, and no uninitialized variables. This server is hosted on a Digital Ocean 512MB/20GB plan from the GitHub Student Pack that was generously provided to me. I wrote this application because I hated PHP, but I wanted to learn how it can be a useful tool. I feel that I have succeeded in this mission.</p>";
echo "<p>As of April 1, 2015, the server moved to a Raspberry Pi Model B running in my apartment complex. The database is now hosted on MongoLab (MongoDB doesn't build on ARM yet) using a shared database instance with a 500MB development storage plan.</p>";

echo "<h3>The 'You'</h3>";
echo "<p>You must not post anything abusive or illegal in any context. Please.</p>";
echo "<p>If this happens, I may take my little project offline.</p>";

?>
