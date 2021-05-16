<?php
    $config = include('config.php');

    $mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    if ($mysqli -> connect_errno)
    {
        echo "<script>console.log(\"Failed to connect to MySQL : { $mysqli -> connect_error }\")</script>";
        exit();
    }

    $sql = 
    "
        CREATE TABLE IF NOT EXISTS History (
            num INT NOT NULL AUTO_INCREMENT,
            name char(8) NOT NULL,
            id CHAR(32) NOT NULL,
            status TINYINT(1) NOT NULL,
            date TIMESTAMP DEFAULT NOW() NOT NULL,
            PRIMARY KEY(num)
        );
    ";
    $mysqli -> query($sql);
    
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>바로우산</title>
</head>
<body>
    
    <form action="input.php" method="POST">
        <input type="text" name="name">
        <input type="text" name="id">
        <input type="text" name="status">
        <input type="submit">
    </form>

    <?php
    
    $sql = 
    '
        SELECT * FROM History;
    ';
    $result = $mysqli -> query($sql);

    while($row = $result -> fetch_assoc())
    {
        echo $row['num'] . " " . $row['name'] . " " . $row['id'] . " " . $row['status'] . " " . $row['date'] . "<br>";
    }
    $result -> free();

    ?>

    
</body>
</html>