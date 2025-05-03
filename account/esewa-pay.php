<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_amount = 0;
    foreach ($_POST as $key => $value) {
        if (is_numeric($key) && $value > 0) {
            // Query the item price
            include 'includes/connect.php';
            $result = mysqli_query($con, "SELECT * FROM items WHERE id = $key");
            if ($item = mysqli_fetch_assoc($result)) {
                $total_amount += $item['price'] * intval($value);
            }
        }
    }

    // Prepare eSewa payment parameters
    $merchant_code = "YOUR_MERCHANT_CODE";
    $return_url = "http://yourdomain.com/payment-success.php";
    $cancel_url = "http://yourdomain.com/payment-failed.php";
    $pid = uniqid("ORDER_");

    echo '
    <form id="esewaForm" action="https://uat.esewa.com.np/epay/main" method="POST">
        <input value="'. $total_amount .'" name="tAmt" type="hidden">
        <input value="'. $total_amount .'" name="amt" type="hidden">
        <input value="0" name="txAmt" type="hidden">
        <input value="0" name="psc" type="hidden">
        <input value="0" name="pdc" type="hidden">
        <input value="'. $merchant_code .'" name="scd" type="hidden">
        <input value="'. $pid .'" name="pid" type="hidden">
        <input value="'. $return_url .'" type="hidden" name="su">
        <input value="'. $cancel_url .'" type="hidden" name="fu">
    </form>
    <script>document.getElementById("esewaForm").submit();</script>';
}
?>
