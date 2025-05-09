<?php

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'sdb-o.hosting.stackcp.net');
define('DB_USERNAME', 'esteban');
define('DB_PASSWORD', 'Gitzd201');
define('DB_NAME', 'wines-crud-app-313937c2fc');

/* Attempt to connect to MySQL database */

// Connect to MySQL and database (db)
$db_connect = mysqli_connect('sdb-o.hosting.stackcp.net', 'esteban', 'Gitzd201', 'wines-crud-app-313937c2fc');


if (!$db_connect) {
    echo "<h1>Unable to connect</h1>";
    die("Connection failed: " . mysqli_connect_error());
 
    exit;
}
?>