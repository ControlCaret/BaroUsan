<?php
    $config = include('config.php');

    $mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    if ($mysqli -> connect_errno)
    {
        echo "<script>console.error(\"Failed to connect to MySQL : { $mysqli -> connect_error }\")</script>";
        exit();
    }

    # Create Table If not Exists
    $sql = "SHOW TABLES LIKE 'History';";
    $result = $mysqli -> query($sql);
    if($result -> num_rows == 0)
    {
        echo "<script>console.warn('Table Not Exists')</script>";
        $sql = 
        '
            CREATE TABLE History (
                num INT NOT NULL AUTO_INCREMENT,
                name char(8) NOT NULL,
                id CHAR(32) NOT NULL,
                status TINYINT(1) NOT NULL,
                date TIMESTAMP DEFAULT NOW() NOT NULL,
                PRIMARY KEY(num)
            );
        ';
        $result = $mysqli -> query($sql);
        if($result === TRUE)
            echo "<script>console.info('Table Created')</script>";
        else
            echo "<script>console.error('Table Not Created')</script>";
    }
    else
        echo "<script>console.log('Table Exists')</script>";
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>바로우산</title>
</head>
<body>
    <div id="qr-reader" style="width:500px"></div>
    <form action="input.php" method="POST">
        <input type="text" name="name">
        <input type="text" name="id">
        <input type="text" name="status">
        <input type="submit">
    </form>


    <table>
        <tr>
            <th>num</th>
            <th>name</th>
            <th>id</th>
            <th>status</th>
            <th>date</th>
        </tr>
        <?php
        
        $sql = 'SELECT * FROM History ORDER BY NUM DESC;';
        $result = $mysqli -> query($sql);

        while($row = $result -> fetch_assoc())
        {
            echo "
                <tr>
                    <td>$row[num]</td>
                    <td>$row[name]</td>
                    <td>$row[id]</td>
                    <td>$row[status]</td>
                    <td>$row[date]</td>
                </tr>
            ";
        }
        $result -> free();
        ?>
    </table>

</body>
<script src="./script/html5-qrcode.min.js"></script>
<script src="./script/script.js"></script>
</html>
