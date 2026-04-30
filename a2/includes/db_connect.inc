<?php
$host = (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'rmit') !== false)
    ? 'talsprddb02.int.its.rmit.edu.au'
    : 'localhost';

$db_user = (strpos($host, 'rmit') !== false) ? 's4092023' : 'root';
$db_pass = (strpos($host, 'rmit') !== false) ? 's4092023' : '';
$db_name = (strpos($host, 'rmit') !== false) ? 's4092023' : 'petconnect';

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
