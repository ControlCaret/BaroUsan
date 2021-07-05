<?php
    $config = include('config.php');

    $mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    if ($mysqli -> connect_errno)
    {
        echo "<script>console.log(\"Failed to connect to MySQL : { $mysqli -> connect_error }\")</script>";
        exit();
    }

    $card_id = $_POST['card_id'];
    $umbrella_id = $_POST['umbrella_id'];

    $sql = "SELECT name FROM Student WHERE card_id = '$card_id';";
    $result = $mysqli -> query($sql);
    $name = mysqli_fetch_row($result);

    if(!isset($name[0]))
    {
        echo "<script>alert(\"학생증이 등록되어 있지 않습니다.\");</script>";
        echo "<script>window.location.href=\"./\";</script>"; 
        exit();
    }

    $sql = "INSERT INTO History (name, card_id, umbrella_id) VALUES('$name[0]', '$card_id', '$umbrella_id')";
    
    if($mysqli -> query($sql) === TRUE)
    {
        //echo "added";
        echo "<script>window.location.href=\"./\";</script>"; 
    }
    else
    {
        echo "<script>alert(\"오류\");</script>";
        echo "<script>window.location.href=\"./\";</script>"; 
    }

    $mysqli -> close();
?>
