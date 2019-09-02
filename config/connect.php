<?php
//db connection
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_DSN', 'mysql:host=localhost;dbname=event_management');

$dbh = new PDO(DB_DSN, DB_USER, DB_PASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


