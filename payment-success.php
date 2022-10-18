<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ICS | Payment</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <!-- Custom Css -->
    <link rel="stylesheet" href="assets/css/custom.min.css" />

</head>

<body style="background: #EBF0F5;text-align: center;padding: 40px 0;">
    <div class="card2" id="print_data">
        <div class="icon_div">
            <i class="checkmark">✓</i>
        </div>
        <h1 class="pay">Payment Successfull</h1>
        <table class="pay_table">
            <tr>
                <td class="pay_td">Payment Type</td>
                <td class="pay_td">Net Banking</td>
            </tr>
            <tr>
                <td class="pay_td">Bank</td>
                <td class="pay_td">HDFC</td>
            </tr>
            <tr>
                <td class="pay_td">Mobile</td>
                <td class="pay_td">12354698</td>
            </tr>
            <tr>
                <td class="pay_td">Email</td>
                <td class="pay_td">zaidiftikhar63@gmail.com</td>
            </tr>
            <tr>
                <th class="pay_td">Amount Paid</th>
                <th class="pay_td">500.00</th>
            </tr>
            <tr>
                <td class="pay_td">Transaction ID</td>
                <td class="pay_td">1234564878729</td>
            </tr>
        </table>
        <br>
        <br>
        <div class="buttonss">
        <button type="button" id="print" onclick="printContent('print_data');" class="btn2 bg_gradient btn_style1">Print</button>
        <button type="button" class="btn2 bg_gradient btn_style1">Close</button>
        </div>
    </div>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script>
function printContent(el){
var restorepage = $('body').html();
var printcontent = $('#' + el).clone();
$('body').empty().html(printcontent);
window.print();
$('body').html(restorepage);
}
</script>