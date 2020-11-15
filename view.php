<?php
require_once "pdo.php";
session_start();

if(!isset($_GET['cust_id'])){
  die("Customer Id Missing");
}

if (isset($_REQUEST['cust_id']))
{
    $customer_id = htmlentities($_REQUEST['cust_id']);

    $stmt = $pdo->prepare("
        SELECT * FROM customer
        WHERE cust_id = :cust_id
    ");

    $stmt->execute([
        ':cust_id' => $customer_id,
    ]);

    $customer = $stmt->fetch(PDO::FETCH_OBJ);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Page</title>
    <link rel="icon" href="images/house_bank.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body id="view_body">
    <h1>Customer Details</h1>
    <div id="cust_details">
      <p>Name: <?php echo $customer->name  ?></p>
      <p>Email: <?php echo $customer->email ?></p>
      <p>Account No: <?php echo $customer->acc_no ?></p>
      <p>Balance: <?php echo $customer->balance ?></p>

    <div>
      <p><a href="home.php"><button type="button" name="button" class="cancel_button" onclick="cancel_view()">
        BACK TO HOME</button> </a> </p>
    </div>
    </div>
  </body>
</html>
