<?php
require('../config.php');

$data = array();

// session_start();
$otp="";
// print_r($_POST);
// exit();
if($_POST['userInfo']){

    if((isset($_POST['otp']))&&!empty($_POST['otp'])){
       
        $otps=$_POST['otp'];

foreach($otps as $ot){
    $otp .= $ot; 
}

    }else{

    }

    $verifyOtp = $user->verifyOtp($_POST['userInfo'],$otp);

if($verifyOtp == 'success'){
    

    
}else{
    $data = $verifyOtp;
}

    // print_r($data);
// exit();
}

$data['redirect']= 0;
if(isset($_POST['url'])){
    $data['redirect']= 1;
    $data['url']=$_POST['url'];
    }else{
    $data['redirect']= 0;

    }
echo json_encode($data);

?>