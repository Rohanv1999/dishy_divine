<?php

/* =====[ SMTP Vendor Include  ]===== */
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
require_once __DIR__ . '/../../SMTP_Vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../SMTP_Vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../SMTP_Vendor/phpmailer/src/SMTP.php';

if ( !function_exists( "prx" ) ) {
    function prx( $x, $exit = 0 )
    {
        echo '<h1 style="top:0;position:fixed;color:white;background:red;text-align:center;width:30%;right:0;">PAGE UNDER CONSTRACTION</h1>';
        echo $res = "<pre>";
        if ( is_array( $x ) || is_object( $x ) ) {
            print_r( $x );
        } else {
            var_dump( $x );
        }
        echo "</pre>";
        if ( $exit == 0 ) {die();}
    }
}

if ( !function_exists( "pr" ) ) {
    function pr( $x, $exit = 0 )
    {
        echo '<h1 style="top:0;position:fixed;color:white;background:red;text-align:center;width:30%;right:0;">PAGE UNDER CONSTRACTION</h1>';
        echo $res = "<pre>";
        if ( is_array( $x ) || is_object( $x ) ) {
            print_r( $x );
        } else {
            var_dump( $x );
        }
        echo "</pre>";
    }
}

function sendEmail($recipient, $subject, $body, $attachment = null) {

    // Create a new PHPMailer instance with exceptions enabled
    $mail = new PHPMailer(true);

    try {
        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPDebug = 0;
        $mail->Username = 'saurabhsrbjha@gmail.com'; // Replace with your Gmail address
        $mail->Password = 'butdbnuqdgfaagtr'; // Replace with your Gmail password

        // Set email parameters
        $mail->setFrom('saurabhsrbjha@gmail.com', 'Dishy Divine'); // Replace with your name and email address
        $mail->addAddress($recipient);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);

        // Attach a file, if provided
        if ($attachment) {
            $mail->addAttachment($attachment);
        }

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
        // return false;
    }

}
/*
    var_dump( sendEmail('phpfact@gmail.com', 'testing by sachin', 'hello world') );
*/

function _insert($table, $data)
{
    global $con;

    // Build the SQL query string
    $fields = implode(',', array_keys($data));
    $values = "'" . implode("','", array_values($data)) . "'";
    $sql = "INSERT INTO $table ($fields) VALUES ($values)";

    // Execute the query
    mysqli_query($con, $sql);

    // Get the inserted ID
    $inserted_id = mysqli_insert_id($con);

    return $inserted_id;
}

/*
    _insert('users', ['fname'=>'abc', 'lname'=>'xyz']);
*/


if ( !function_exists( "_get" ) ) {
    function _get( $table )
    {
        global $con;
        $result = mysqli_query($con, "SELECT * FROM $table");
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}


if ( !function_exists( "_getWhere" ) ) {
    function _getWhere( $table, $whereCondition, $multipleRow = 'no' )
    {
        global $con;
        $whereClause = '';
        foreach ($whereCondition as $key => $value) {
            $whereClause .= $key . "='" . $value . "' AND ";
        }
        $whereClause = rtrim($whereClause, ' AND ');
        $result = mysqli_query($con, "SELECT * FROM $table WHERE $whereClause");

        if ( $multipleRow == 'no' ) {
            return mysqli_fetch_assoc($result);
        } else {
            $rows = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            return $rows;
        }
    }
}
/*
    _getWhere('vt_roles', ['id' => 1]); // Single Data
    _getWhere('vt_roles', ['plan' => 2], 'yes'); // Multiple Data
	_getWhere('vt_roles', ['plan' => 2, 'id != ' => 123], 'yes'); // Multiple Data
*/



if ( !function_exists( "_getLatestRecord" ) ) {
    function _getLatestRecord( $table, $whereCondition = [] )
    {
        global $con;
        $whereClause = '';
        if ( !empty( $whereCondition ) ) {
            foreach ($whereCondition as $key => $value) {
                $whereClause .= $key . "='" . $value . "' AND ";
            }
            $whereClause = rtrim($whereClause, ' AND ');
        }
        $result = mysqli_query($con, "SELECT * FROM $table" . ( !empty( $whereClause ) ? " WHERE $whereClause" : "" ) . " ORDER BY id DESC LIMIT 1");
        return mysqli_fetch_assoc($result);
    }
}
/*
    _getLatestRecord('users');
    _getLatestRecord('users', ['username' => 'john', 'email' => 'john@example.com']);
*/


if ( !function_exists( "_getWhereCommaSeprated" ) ) {
    function _getWhereCommaSeprated( $table, $ids, $columnName='id' )
    {
        global $con;
        $result = mysqli_query($con, "SELECT * FROM $table WHERE $columnName IN ($ids)");
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

if ( !function_exists( "_getWhereIn" ) ) {
    function _getWhereIn( $table, $whereCondition, $columnName='id' )
    {
        global $con;
        $whereIn = '';
        foreach ($whereCondition as $key => $value) {
            $whereIn .= "'" . $value . "',";
        }
        $whereIn = rtrim($whereIn, ',');
        $result = mysqli_query($con, "SELECT * FROM $table WHERE $columnName IN ($whereIn)");
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

if ( !function_exists( "_getWhereNotIn" ) ) {
    function _getWhereNotIn( $table, $whereCondition, $columnName='id' )
    {
        global $con;
        $whereIn = '';
        foreach ($whereCondition as $key => $value) {
            $whereIn .= "'" . $value . "',";
        }
        $whereIn = rtrim($whereIn, ',');
        $result = mysqli_query($con, "SELECT * FROM $table WHERE $columnName NOT IN ($whereIn)");
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}




