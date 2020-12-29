<html>
<head>
    <title>Show Payment Page</title>
</head>
<body>
<center>
    <h1>Please do not refresh this page...</h1>
</center>
<form method="post" action="https://securegw-stage.paytm.in/theia/api/v1/showPaymentPage?mid={{$mid}}&orderId={{$order_id}}" name="paytm">
    <table border="1">
        <tbody>
        <input type="hidden" name="mid" value="{{$mid}}">
        <input type="hidden" name="orderId" value="{{$order_id}}">
        <input type="hidden" name="txnToken" value="{{$response->body->txnToken}}">
        </tbody>
    </table>
    <script type="text/javascript"> document.paytm.submit(); </script>
</form>
</body>
</html>
