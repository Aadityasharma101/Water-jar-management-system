<?php
// Get the query parameters from the URL
$transaction_id = $_GET['transaction_id'] ?? 'N/A';
$pidx = $_GET['pidx'] ?? 'N/A';
$tidx = $_GET['tidx'] ?? 'N/A';
$amount = $_GET['amount'] ?? 'N/A';
$total_amount = $_GET['total_amount'] ?? 'N/A';
$mobile = $_GET['mobile'] ?? 'N/A';
$status = $_GET['status'] ?? 'N/A';
$purchase_order_id = $_GET['purchase_order_id'] ?? 'N/A';
$purchase_order_name = $_GET['purchase_order_name'] ?? 'N/A';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .receipt-container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #28a745;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background: #28a745;
            color: white;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .failed {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <h2>Payment Receipt</h2>
    <p>Status: <span class="<?php echo $status == 'Completed' ? 'success' : 'failed'; ?>"><?php echo $status; ?></span></p>
    
    <table>
        <tr>
            <th>Field</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Transaction ID</td>
            <td><?php echo htmlspecialchars($transaction_id); ?></td>
        </tr>
        <tr>
            <td>Payment Index (pidx)</td>
            <td><?php echo htmlspecialchars($pidx); ?></td>
        </tr>
        <tr>
            <td>Transaction Index (tidx)</td>
            <td><?php echo htmlspecialchars($tidx); ?></td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>Rs. <?php echo number_format($amount, 2); ?></td>
        </tr>
        <tr>
            <td>Total Amount</td>
            <td>Rs. <?php echo number_format($total_amount, 2); ?></td>
        </tr>
        <tr>
            <td>Mobile</td>
            <td><?php echo htmlspecialchars($mobile); ?></td>
        </tr>
        <tr>
            <td>Purchase Order ID</td>
            <td><?php echo htmlspecialchars($purchase_order_id); ?></td>
        </tr>
        <tr>
            <td>Purchase Order Name</td>
            <td><?php echo htmlspecialchars($purchase_order_name); ?></td>
        </tr>
    </table>

    <p><strong>Thank you for your payment!</strong></p>
</div>

</body>
</html>
