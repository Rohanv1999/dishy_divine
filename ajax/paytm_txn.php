<?php
include('../config.php');

if (isset($_POST['action']) && $_POST['action'] == 'paytmpayment') {

    $ORDER_ID =  $_POST['order_id'];

    $TXN_AMOUNT = $_POST['TXN_AMOUNT'];?>

        <form method="post" action="../paytm-main/pgRedirect.php" name="f1">
            <input type="hidden" name="ORDER_ID" value="<?= $ORDER_ID ?>">
            <input type="hidden" name="TXN_AMOUNT" value="<?= $TXN_AMOUNT ?>">
             <input type="hidden" name="loginid" value="<?= $_SESSION['loginid'] ?>">
             <input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
             <input type="hidden" name="userLoginStatus" value="<?= $_SESSION['userLoginStatus'] ?>">
           <script type="text/javascript">
                document.f1.submit();
            </script> 
        </form>
<?php 
}
