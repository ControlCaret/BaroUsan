<?php
    $config = include('config.php');

    $mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    if ($mysqli -> connect_errno)
    {
        echo "<script>console.error(\"Failed to connect to MySQL : { $mysqli -> connect_error }\")</script>";
        exit();
    }

    # Create Student table if not exists
    $sql = "SHOW TABLES LIKE 'Student';";
    $result = $mysqli -> query($sql);
    if($result -> num_rows == 0)
    {
        echo "<script>console.warn('\'Student\' Table Not Exists')</script>";
        $sql = 
        '
            CREATE TABLE Student (
                num INT NOT NULL AUTO_INCREMENT,
                card_id CHAR(32) NOT NULL,
                name char(8) NOT NULL,
                grade INT NOT NULL,
                class INT NOT NULL,
                number INT NOT NULL,
                PRIMARY KEY(num, card_id)
            );
        ';
        $result = $mysqli -> query($sql);
        if($result === TRUE)
            echo "<script>console.info('\'Student\' Table Created')</script>";
        else
            echo "<script>console.error('\'Student\' Table Not Created')</script>";
    }
    else
        echo "<script>console.log('\'Student\' Table Exists')</script>";



    # Create History table if not exists
    $sql = "SHOW TABLES LIKE 'History';";
    $result = $mysqli -> query($sql);
    if($result -> num_rows == 0)
    {
        echo "<script>console.warn('\'History\' Table Not Exists')</script>";
        $sql = 
        '
            CREATE TABLE History (
                num INT NOT NULL AUTO_INCREMENT,
                name char(8) NOT NULL,
                card_id CHAR(32) NOT NULL,
                umbrella_id CHAR(32) NOT NULL,
                status TINYINT(1) DEFAULT 0 NOT NULL,
                borrow_date TIMESTAMP DEFAULT NOW() NOT NULL,
                return_date TIMESTAMP,
                PRIMARY KEY(num)
            );
        ';
        $result = $mysqli -> query($sql);
        if($result === TRUE)
            echo "<script>console.info('\'History\' Table Created')</script>";
        else
            echo "<script>console.error('\'History\' Table Not Created')</script>";
    }
    else
        echo "<script>console.log('\'History\' Table Exists')</script>";
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>바로우산</title>
</head>
<body>
    <!-- <div id="qr-reader" style="width:500px"></div> -->

    <form action="register.php" method="POST">
        <label>card_id</label>
        <input type="text" name="card_id" required>
        <label>grade</label>
        <input type="text" name="grade" required>
        <label>class</label>
        <input type="text" name="class" required>
        <label>number</label>
        <input type="text" name="number" required>
        <label>name</label>
        <input type="text" name="name" required>
        <input type="submit">
    </form>

    <form action="input.php" method="POST">
        <label>card_id</label>
        <input type="text" name="card_id" required>
        <label>unbrella_id</label>
        <input type="text" name="umbrella_id" required>
        <input type="submit">
    </form>


    <table>
        <tr>
            <th>num</th>
            <th>name</th>
            <th>card_id</th>
            <th>unbrella_id</th>
            <th>borrow_date</th>
            <th>return_date</th>
            <th>status</th>
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
                    <td>$row[card_id]</td>
                    <td>$row[umbrella_id]</td>
                    <td>$row[borrow_date]</td>
                    <td>$row[return_date]</td>
                    <td>$row[status]</td>
                </tr>
            ";
        }
        $result -> free();
        ?>
    </table>


    <table>
        <tr>
            <th>num</th>
            <th>card_id</th>
            <th>name</th>
            <th>grade</th>
            <th>class</th>
            <th>number</th>
        </tr>
        <?php
        $sql = 'SELECT * FROM Student;';
        $result = $mysqli -> query($sql);

        while($row = $result -> fetch_assoc())
        {
            echo "
                <tr>
                    <td>$row[num]</td>
                    <td>$row[card_id]</td>
                    <td>$row[name]</td>
                    <td>$row[grade]</td>
                    <td>$row[class]</td>
                    <td>$row[number]</td>
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
