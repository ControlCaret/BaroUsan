<?php
    date_default_timezone_set('Asia/Seoul');
    $config = include('config.php');

    $mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    if ($mysqli -> connect_errno)
    {
        echo "<script>console.log(\"Failed to connect to MySQL : { $mysqli -> connect_error }\")</script>";
        exit();
    }

    $returnNum = $_POST['returnNum'];
    $date = date("Y-m-d H:i:s");

    $sql = "UPDATE History SET status = 1, return_date = '$date' WHERE num = $returnNum;";
    
    if($mysqli -> query($sql) === TRUE)
    {
        //echo "success";
        echo "<script>window.location.href=\"./\";</script>"; 
    }
    else
    {
        echo "<script>alert(\"오류\");</script>";
        echo "<script>window.location.href=\"./\";</script>"; 
    }

    $mysqli -> close();
?>
