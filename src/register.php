<?php
    $config = include('config.php');

    $mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    if ($mysqli -> connect_errno)
    {
        echo "<script>console.log(\"Failed to connect to MySQL : { $mysqli -> connect_error }\")</script>";
        exit();
    }

    $card_id = $_POST['card_id'];
    $grade = $_POST['grade'];
    $class = $_POST['class'];
    $number = $_POST['number'];
    $name = $_POST['name'];

    $sql = "INSERT INTO Student (card_id, grade, class, number, name) VALUES('$card_id', '$grade', '$class', '$number', '$name')";
    
    if($mysqli -> query($sql) === TRUE)
    {
        echo "added";
    }
    else
    {
        echo "failed";
    }

    $mysqli -> close();
?>
