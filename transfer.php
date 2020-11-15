<?php
  require_once "pdo.php";
  session_start();

  if(isset($_POST['from']) && isset($_POST['to']) && isset($_POST['amt'])){
    if (strlen($_POST['from']) < 1 || strlen($_POST['to']) < 1 || !is_numeric($_POST['amt']))
    {
        $_SESSION['error'] = "All fields are required and Amount must be a number";
        header("Location:transfer.php");
        return;
    }
    else{
      $_SESSION['from']=htmlentities($_POST['from']);
      $_SESSION['to'] = htmlentities($_POST['to']);
      $_SESSION['amt'] = htmlentities($_POST['amt']);
      header("Location:transfer.php");
      return;
    }
  }

  if (isset($_SESSION['from'])&& isset($_SESSION['to'])&& isset($_SESSION['amt'])) {
    $from_mail = $_SESSION['from'];
    $to_mail = $_SESSION['to'];
    $sender=[];
    $reciever=[];
    $senderstmt = $pdo->query("SELECT * FROM customer WHERE email='$from_mail'");
    $recieverstmt = $pdo->query("SELECT * FROM customer WHERE email='$to_mail'");
    while ( $row = $senderstmt->fetch(PDO::FETCH_OBJ) )
    {
        $sender[] = $row;
    }
    while ( $row = $recieverstmt->fetch(PDO::FETCH_OBJ) )
    {
        $reciever[] = $row;
    }

    foreach($sender as $sender_data):
      $sender_amt= $sender_data->balance;
      $scust_id = $sender_data->cust_id;
      $sender_name = $sender_data->name;
    endforeach;
    foreach($reciever as $reciever_data):
      $reciever_amt = $reciever_data->balance;
      $rcust_id = $reciever_data->cust_id;
      $reciever_name = $reciever_data->name;
    endforeach;

    if($sender_amt<=0 || $sender_amt < $_SESSION['amt']){
      $_SESSION['error'] = "Insufficient Balance";
      unset($_SESSION['from']);
      unset($_SESSION['to']);
      unset($_SESSION['amt']);
      header("Location:transfer.php");
      return;
    }
    else{
      $stmt=$pdo->prepare("
      INSERT INTO transaction(sent_from,recieved_by,amount)
       VALUES(:sent,:recieved,:amount)
       ");

       $stmt->execute([
         ':sent' => "$sender_name",
         ':recieved' => $reciever_name,
         ':amount' => $_SESSION['amt'],
       ]);

    $sender_amt = $sender_amt- $_SESSION['amt'];
    $reciever_amt += $_SESSION['amt'];

    $stmt_1 = $pdo->prepare("
    UPDATE customer SET balance = :sbalance WHERE email=:semail
    ");
    $stmt_1->execute([
      ':sbalance' => $sender_amt,
      ':semail' => $_SESSION['from'],
    ]);
    $stmt_2 = $pdo->prepare("
    UPDATE customer SET balance=:rbalance WHERE email=:remail
    ");
    $stmt_2->execute([
      ':rbalance' =>  $reciever_amt,
      ':remail' => $_SESSION['to'],
    ]);

    $_SESSION['success'] = "Amount Transfered Successfully";
    unset($_SESSION['from']);
    unset($_SESSION['to']);
    unset($_SESSION['amt']);
   }
  }

  ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tranfer page</title>
    <link rel="icon" href="images/house_bank.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Metal+Mania&family=Roboto:ital@1&display=swap" rel="stylesheet">
  </head>
  <body id="transfer_body">
    <div id="trans">
      <h3>TRANSFER AMOUNT</h3>
      <?php
        if(isset($_SESSION['error'])){
          echo '<p style="color:red;font-size:32px;">'.$_SESSION['error']."</p>\n";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo '<p style="color:green;font-size:32px">'.$_SESSION['success']."</p>\n";
          unset($_SESSION['success']);
        }
       ?>
     <form method="post">
      <img src="images/bank.jpeg" alt="Loading..." id="transfer_img" align="center"><br>
      <label for="from_inp">From: <input type="text" id="from_inp"  class="inp_fields" name="from"></label><br>
      <label for="to_inp">To:<input type="text" id="to_inp"  class="inp_fields" name="to"></label><br>
      <label for="amt">Amount: <input type="text" id="amt" class="inp_fields" name="amt"></label> <br>
      <br>
      <button type="submit" class="work_button" >TRANSFER</button>
      <a href="home.php"><button type="button" class="cancel_button" onclick="cancel()">
        Cancel</button></a>
      </form>
    </div>
  </body>
  <!-- <script type="text/javascript" src="script.js">
  </script> -->
</html>
