<?php
require('../config.php');

$data = array();

// session_start();


if($_POST['userEmail']){

    $tableName= "newsletter";
    $recordArr = array(
        "email" => $_POST['userEmail']
    );

    if($wishList->save($tableName,$recordArr)){
        $data['status'] = true;
        $data['result'] = 'Successfully!';

    }else{
        $data['status'] = true;
        $data['result'] = 'Error Occur! Please try again';

    }
}

echo json_encode($data);

?>