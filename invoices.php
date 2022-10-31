<?php

require_once('common.php');
if (isset($_SESSION['userInfo'])) {
  $userInfo = $_SESSION['userInfo'];
  if ($userInfo->privileges == 'Admin') {
    $unpaidInvoices = $database->getUnpaidInvoices($userInfo);
    $paidInvoices = $database->getPaidInvoices($userInfo);
    $overdueInvoices = $database->getOverdueInvoices($userInfo);
    $underdueInvoices = $database->getUnderdueInvoices($userInfo);
  }
  else{
    echo "You must be an admin to view this page.";
  }
}
?>

<!DOCTYPE HTML>
<HTML lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width = device-width, initial-scale = 1.0, user-scalable = 1;">
  <link rel="stylesheet" type="text/css" href="css/bestPet.css">
  <link rel="stylesheet" type="text/css" href="css/sideBar.css">
  <title>Pet Best, LLC</title>
</head>

<body>
  <?php require_once("menu.php") ?>
  <?php require_once("sideBar.php") ?>

  <div class="main">
    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">

      <?php if (isset($userInfo)) : ?>
        <div id="flex-card">
          <div class="card">
            <h1>Pet Best LLC</h1>
            <?php if (isset($paidInvoices)) : ?>
              <h2>Paid Invoices</h2>
              <table id="free">
                <tr>
                  <th>Invoice ID</th>
                  <th>Order ID</th>
                  <th>Customer ID</th>
                  <th>Invoice Date</th>
                  <th>Invoice Total</th>
                  <th>Payment Total</th>
                  <th>Invoice Due Date</th>
                  <th>Payment Date</th>
                </tr>

                <?php foreach ($paidInvoices as $value) : ?>
                  <tr>
                    <td><?php echo $value->invoiceID; ?></td>
                    <td><?php echo $value->orderID; ?></td>
                    <td><?php echo $value->customerID; ?></td>
                    <td><?php echo $value->invoiceDate; ?></td>
                    <td><?php echo $value->invoiceTotal; ?></td>
                    <td><?php echo $value->paymentTotal; ?></td>
                    <td><?php echo $value->invoiceDueDate; ?></td>
                    <td><?php echo $value->paymentDate; ?></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            <?php endif; ?>


            <?php if (!empty($unpaidInvoices)) : ?>
              <h2>Unpaid Invoices</h2>
              <table id="free">
                <tr>
                  <th>Invoice ID</th>
                  <th>Order ID</th>
                  <th>Customer ID</th>
                  <th>Invoice Date</th>
                  <th>Invoice Total</th>
                  <th>Payment Total</th>
                  <th>Invoice Due Date</th>
                  <th>Payment Date</th>
                </tr>

                <?php foreach ($unpaidInvoices as $value) : ?>
                  <tr>
                    <td><?php echo $value->invoiceID; ?></td>
                    <td><?php echo $value->orderID; ?></td>
                    <td><?php echo $value->customerID; ?></td>
                    <td><?php echo $value->invoiceDate; ?></td>
                    <td><?php echo $value->invoiceTotal; ?></td>
                    <td><?php echo $value->paymentTotal; ?></td>
                    <td><?php echo $value->invoiceDueDate; ?></td>
                    <td><?php echo $value->paymentDate; ?></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            <?php endif; ?>

            <?php if (!empty($overdueInvoices)) : ?>
              <h2>Overdue Invoices</h2>
              <table id="free">
                <tr>
                  <th>Invoice ID</th>
                  <th>Order ID</th>
                  <th>Customer ID</th>
                  <th>Invoice Date</th>
                  <th>Invoice Total</th>
                  <th>Payment Total</th>
                  <th>Invoice Due Date</th>
                  <th>Payment Date</th>
                </tr>

                <?php foreach ($overdueInvoices as $value) : ?>
                  <tr>
                    <td><?php echo $value->invoiceID; ?></td>
                    <td><?php echo $value->orderID; ?></td>
                    <td><?php echo $value->customerID; ?></td>
                    <td><?php echo $value->invoiceDate; ?></td>
                    <td><?php echo $value->invoiceTotal; ?></td>
                    <td><?php echo $value->paymentTotal; ?></td>
                    <td><?php echo $value->invoiceDueDate; ?></td>
                    <td><?php echo $value->paymentDate; ?></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            <?php endif; ?>
          </div>
        </div>

            <?php if (!empty($underdueInvoices)) : ?>
              <h2>Underdue Invoices</h2>
              <table id="free">
                <tr>
                  <th>Invoice ID</th>
                  <th>Order ID</th>
                  <th>Customer ID</th>
                  <th>Invoice Date</th>
                  <th>Invoice Total</th>
                  <th>Payment Total</th>
                  <th>Invoice Due Date</th>
                  <th>Payment Date</th>
                </tr>

                <?php foreach ($underdueInvoices as $value) : ?>
                  <tr>
                    <td><?php echo $value->invoiceID; ?></td>
                    <td><?php echo $value->orderID; ?></td>
                    <td><?php echo $value->customerID; ?></td>
                    <td><?php echo $value->invoiceDate; ?></td>
                    <td><?php echo $value->invoiceTotal; ?></td>
                    <td><?php echo $value->paymentTotal; ?></td>
                    <td><?php echo $value->invoiceDueDate; ?></td>
                    <td><?php echo $value->paymentDate; ?></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
</body>

</HTML>
