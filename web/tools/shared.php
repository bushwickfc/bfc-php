<?php
if (!getenv("POS_USERNAME")) {
  include "./credentials.php";
}
$username = getenv("POS_USERNAME");
$password = getenv("POS_PASSWORD");
$hostname = getenv("POS_HOSTNAME"); 
$database = getenv("POS_DATABASE");
$owners_username = getenv("OWNERS_USERNAME");
$owners_password = getenv("OWNERS_PASSWORD");
$owners_hostname = getenv("OWNERS_HOSTNAME");
$owners_database = getenv("OWNERS_DATABASE");
?>
