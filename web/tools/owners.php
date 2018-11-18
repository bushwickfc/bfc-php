<?php
include "./shared.php";
include "./aux_funcs.php";
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
    <title>Status - Bushwick Food Coop</title>
    <link href="owners.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="https://www.bushwickfoodcoop.org/favicon.ico">
  </head>
  <body>
    <main>
      <left>
        <div class="header">
          <div class="logoimage">
            <a href="http://bushwickfoodcoop.org">
              <img src="//static1.squarespace.com/static/5a54f5ccd74cff1c818ca40e/t/5a5fbea28165f51098cc9953/1516513105858/?format=100w">
            </a>
            <h1>Status lookup</h1>
          </div>
          <form id="main_form" action="owners.php" method="get">
            <input type="text" name="name" placeholder="Enter email address..." value="<?php if(isset($_GET["name"])) print $_GET["name"] ?>"></br>
            <div class="submit_container">
              <input type="submit" name="submit" value="Search">
            </div>
          </form>
        </div>
        <span>Hours Balance:</span>
        <p class="description">
          Current number of hours banked (may be positive or negative). 0 means that owner is up to date and owes only current month hours.
        </p>
        <span>Equity Delinquent:</span> 
        <p class="description">
          Amount of equity owner has missed from previous month payment installments. Amount does not include an installment from the current month if owner is still on the payment plan.
        </p>
        <span>Status Code:</span>
        <ul class="description">
          <li>1 = Active</li>
          <li>2 = Suspended for owed hours and/or equity</li>
          <li>3 = Suspended until Payment Plan Agreement submitted</li>
        </ul>
        <span>Ownership Category/Work Exemption Code:</span>
        <ul class="description">
          <li>S = Senior</li>
          <li>PG = Parent/Guardian</li>
          <li>DI = Disability/Injury</li>
          <li>P = Pregnancy</li>
          <li>FL = Family Leave</li>
          <li>H = Hold</li>
        </ul>
        <span>For example:</span></br>
        <code>Jane Cooper // 10 // 2 // H // -25</code>
        <p class="description">
          Owner Jane Cooper is suspended, has 10 hours banked, is on hold, and is behind 25 dollars in their equity payments.
        </p>
      </left>
      <right>
        <span class="status_head">Owner status</span>
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
        <span>Owner Status Key</span>
        <p>
          Name // Status // Hours Balance // Ownership Category/Work Exemption (if applicable) // Equity Delinquent (if applicable)
        </p>
      </right>
    </main>
  </body>
</html>
