<?php
// Khalti API Endpoint
$url = "https://dev.khalti.com/api/v2/epayment/initiate/";

// Your Khalti Secret Key
$secretKey = "869eb9d04b0f4764bff1000408db395f";

// Request payload
$data = [
    "return_url" => "http://localhost/sample/Customer/recived.php",
    "website_url" => "http://example.com/",
    "amount" => 1000,
    "purchase_order_id" => "Order01",
    "purchase_order_name" => "Test",
    "customer_info" => [
        "name" => "Test Bahadur",
        "email" => "test@khalti.com",
        "phone" => "9800000001"
    ]
];

// cURL Request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Key $secretKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

// Convert JSON response to PHP array
$responseData = json_decode($response, true);

// Check if request was successful
if (isset($responseData["payment_url"])) {
    // Redirect user to the Khalti payment page
    header("Location: " . $responseData["payment_url"]);
    exit();
} else {
    // Handle error
    echo "Error initiating payment: " . $response;
}
?>
