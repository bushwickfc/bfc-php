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
    $q = "SELECT name, searchkey FROM CUSTOMERS WHERE REPLACE(searchkey,'.','') = REPLACE('". $_GET["name"] ."','.','')";
  } else {
    trigger_error("Please supply an Email to search for", E_USER_ERROR);
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
  <title>Bushwick Food Coop: Status</title>
  </head>
  <body>
    <p>Status lookup</p>
    <p>
    <form id="main_form" action="owners.php" method="get">
      Email: <input type="text" name="name" value="<?php if(isset($_GET["name"])) print $_GET["name"] ?>"><br>
      <input type="submit" name="submit" value="Search">
    </form>
    </p>
    
    <?php if (isset($_GET["submit"])) {?>
    <p>
    <table border=1>
      <tr>
        <th>Name / Status</th>
        <th>Email</th>
      </tr>
      
      <?php print_results(); ?>
    <?php }?>
    </table>
    </p>
    <h4>Owner Status Key</h4>
    <p>Name // Status // Hours Balance // Ownership Category/Work Exemption (if applicable) // Equity Delinquent (if applicable) </p>
<h5>Hours Balance:</h5>
<p>Current number of hours banked (may be positive or negative). 0 means that owner is up to date and owes only current month hours.</p>

<h5>Equity Delinquent:</h5> 
<p>Amount of equity owner has missed from previous month payment installments. Amount does not include an installment from the current month if owner is still on the payment plan.</p>

    <h5>Status Code:</h5>
    <ul><li>1 = Active</li>
    <li>2 = Suspended for owed hours and/or equity</li>
    <li>3 = Suspended until Payment Plan Agreement submitted</li></ul>

    <h5>Ownership Category/Work Exemption Code:</h5>
<ul><li>S = Senior</li>
<li>PG = Parent/Guardian</li>
<li>DI = Disability/Injury</li>
<li>P = Pregnancy</li>
<li>FL = Family Leave</li>
<li>H = Hold</li></ul>
As an example, consider the following:
<code> Jane Cooper // 10 // 2 // H // -25 </code>
</br> Owner Jane Cooper is suspended, has 10 hours banked, is on hold, and is behind 25 dollars in their equity payments.
  </body>
</html>