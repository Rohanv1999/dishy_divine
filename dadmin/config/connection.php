 <?php
  $conn = mysqli_connect('localhost','root','', 'dishi_new');

  date_default_timezone_set('Asia/Kolkata');
  if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
  }
  //define('BASE_URL', 'https://micodetest.com/dishy-divine/');

  ?>