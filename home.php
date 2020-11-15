<?php
  require_once "pdo.php";
  session_start();

  $customers=[];
  $all_customers = $pdo->query("SELECT * FROM customer");

                while ( $row = $all_customers->fetch(PDO::FETCH_OBJ) )
                {
                    $customers[] = $row;
                }

    $transactions=[];
    $related_cust=[];
    $all_transactions = $pdo->query("SELECT * FROM transaction");
    // $all_related_cust = $pdo->query("SELECT name FROM customer");

    while($row = $all_transactions->fetch(PDO::FETCH_OBJ))
    {
      $transactions[] =$row;
    }



 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="icon" href="images/house_bank.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body id="home_body">
    <h1 id="home_heading">Welcome to Basic & Internet Banking</h1>
    <div class="pale_bg" id="top">
      <p id="p_head">Account Holder Name: <span id="span_name">R Nadhinya</span><br>
        Account Number: <span id="span_name">BNK010001</span>
      </p>
    </div>
    <div id="home_contain">
      <a href="transfer.php"><button type="button" name="button" class="home_button "id="btntrans" onclick="see_trans()">
        TRANSFER AMOUNT</button></a>
      <button type="button" name="button" class="home_button "id="btnamttran" onclick="show_cust()">
         VIEW ALL CUSTOMERS</button>
      <button type="button" name="button" class="home_button "id="btncust" onclick="see_amttrans()">
         VIEW TRANSACTION</button><br>
    </div>
    <div id="vwcust">
      <?php if (empty($customers)) : ?>
                                        <p>No rows found</p>
                                <?php else : ?>
                                        <table border="1" id="cust_table" cellspacing="2" cellpadding="2">
                                                <thead>
              <tr>
                <td colspan="5">List of Customers</td>
              </tr>
                                                        <tr>
                <th>SL.No</th>
                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Acc_No</th>
                <th>Balance</th>
                                                        </tr>
                                                </thead>
            <tbody>
              <?php foreach ($customers as $customer ): ?>
              <tr>
                <td><?php echo $customer->cust_id ?></td>
                <td><a href="view.php?cust_id=<?php echo $customer->cust_id;?>">
                  <?php echo $customer->name ?></a></td>
                <td><?php echo $customer->email ?></td>
                <td><?php echo $customer->acc_no ?></td>
                <td><?php echo $customer->balance ?></td>
              </tr>
              <?php endforeach; ?>
             </tbody>
          </table><br>
      <?php endif; ?>
      <button type="button" class="cancel_button" id="cust_cancel" onclick="cancel()">Cancel</button>
    </div>
    <div id="vwtransa">
      <div id="vwtransa_table">
      <?php if (empty($transactions)) : ?>
                                        <p>No rows found</p>
                                <?php else : ?>

                                        <table border="1" id="trans_table"
          cellspacing="2" cellpadding="2" align="center">
                                                <thead>
              <tr>
                <td colspan="5">List of Transactions</td>
              </tr>
                                                        <tr>
                <th>Trans Id</th>
                <th>Sent From</th>
                                                                <th>Recieved By</th>
                                                                <th>Amount</th>
                                                        </tr>
                                                </thead>
            <tbody>
              <?php foreach ($transactions as $transaction ):
                    // foreach ($related_cust as $custo):?>
              <tr>
                <td><?php echo $transaction->trans_id ?></td>
                <td><?php echo $transaction->sent_from ?></td>
                <td><?php echo $transaction->recieved_by ?></td>
                <td><?php echo $transaction->amount ?></td>
              </tr>
              <?php endforeach; ?>
              <!-- <?php //endforeach; ?> -->
             </tbody>
          </table><br>
      <?php endif; ?>
     </div>
      <button type="button" class="cancel_button" id="trans_cancel" onclick="cancel()">
        Cancel</button>
    </div>
    <a href="exit.php"><button type="button" name="button" class="home_button"
      id="btnhmext">EXIT</button></a>

    <script type="text/javascript" src="script.js">
    </script>

  </body>
</html>
