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


    $sql = "INSERT INTO History (name, card_id, umbrella_id) VALUES('$name[0]', '$card_id', '$umbrella_id')";
    
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
