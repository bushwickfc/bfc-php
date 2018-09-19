<?php
include "shared.php";
include "aux_funcs.php";
ini_set('display_errors',1); 
error_reporting(E_ALL);

global $con;
$con = connect($hostname, $username, $password, $database);

function search_for() {
  global $con;
  if (isset($_GET["name"]) && $_GET["name"] != "") {
    $q = "SELECT name, searchkey FROM CUSTOMERS WHERE name LIKE '". $_GET["name"] ."%'";
  } else if (isset($_GET["searchkey"]) && $_GET["searchkey"] != "") {
    $searchkey = explode(",", str_replace(" ", "", $_GET["searchkey"]));
    $searchkey = join($searchkey, "','");
    $q = "SELECT name, searchkey FROM CUSTOMERS WHERE searchkey IN ( '". $searchkey ."')";
  } else {
    trigger_error("Please supply an ID or Name to search for", E_USER_ERROR);
  }
  return send_query($con, $q);
}

function print_results() {
  $res = search_for();
  while ($row = mysqli_fetch_array($res)) {
    printf("<tr><td>%s</td><td>%s</td</tr>\n", $row[0], $row[1]);  
  }
  mysqli_free_result($res);
}

?>

<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <title>Bushwick Food Coop: membership name and id</title>
  </head>
  <body>
    <p>
    <form id="main_form" action="members.php" method="get">
      Name: <input type="text" name="name" value="<?php if(isset($_GET["name"])) print $_GET["name"] ?>"><br>
      Id:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="searchkey" value="<?php if(isset($_GET["searchkey"])) print $_GET["searchkey"] ?>"><br>
      <input type="submit" name="submit" value="Search">
    </form>
    </p>
    
    <?php if (isset($_GET["submit"])) {?>
    <p>
    <table border=1>
      <tr>
        <th>Name</th>
        <th>Id</th>
      </tr>
      
      <?php print_results(); ?>
    <?php }?>
  </body>
</html>
