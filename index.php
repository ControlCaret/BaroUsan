<?php
    date_default_timezone_set('Asia/Seoul');
    //error_reporting(E_ERROR | E_PARSE);
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
    <title>????????????</title>

    <link href="css/style.css" rel="stylesheet"></link>

    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css"
    rel="stylesheet"
    />
</head>
<body>
    <header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container-fluid">
        <div class="collapse navbar-collapse text" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item active">
                <a class="nav-link text-white fs-4" aria-current="page" href="#">????????????</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>
    <br>
    <!-- Navbar -->
    </header>


    <div class="container">

        <div id="qr-reader" style="width:500px"></div>

        <form class="form-outline" action="register.php" method="POST">
            <label>????????? ??????</label>  
            <input type="text" name="card_id" id="card_id" required>
            <label>??????</label>
            <input type="text" class="col-md-1" name="grade" required>
            <label>???</label>
            <input type="text" class="col-md-1" name="class" required>
            <label>??????</label>
            <input type="text" class="col-md-1" name="number" required>
            <label>??????</label>
            <input type="text" name="name" required>
            <input type="submit" class="btn btn-success" value="????????? ??????">
        </form>

        <form action="input.php" method="POST">
            <label>????????? ??????</label>
            <input type="text" name="card_id" id="card_id" required>
            <label>?????? ??????</label>
            <input type="text" name="umbrella_id" required>
            <input type="submit" class="btn btn-success" value="?????? ??????">
        </form>


        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">??????</th>
                    <th scope="col">?????????</th>
                    <th scope="col">?????? ??????</th>
                    <th scope="col">?????? ??????</th>
                    <th scope="col">?????? ??????</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sql = 'SELECT * FROM History ORDER BY NUM DESC;';
                $result = $mysqli -> query($sql);

                while($row = $result -> fetch_assoc())
                {
                    echo "
                        <tr>
                            <td scope=\"row\">$row[num]</td>
                            <td>$row[name]</td>
                            <td>$row[card_id]</td>
                            <td>$row[umbrella_id]</td>
                            <td>$row[borrow_date]</td>
                            <td>$row[return_date]
                        ";
                        if($row['status'] == 0)
                        {
                            echo "
                                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-mdb-toggle=\"modal\" data-mdb-target=\"#returnModal\" id=\"$row[num]\" onclick=\"returnNum(this.id)\">??????</button>
                                    </td>
                                ";
                        }
                        else
                        {
                            echo "</td>";
                        }
                    echo "
                        </tr>
                    ";
                    
                }
                $result -> free();
                ?>
            </tbody>
        </table>

        <!-- 
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

        -->
    </div>

    <!-- returnModal -->
    <div
    class="modal fade"
    id="returnModal"
    tabindex="-1"
    aria-labelledby=""
    aria-hidden="true"
    >
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="">?????? ????????????</h5>
        </div>
        <div class="modal-body">
            ????????? ????????????????????????? ??????????????? ????????? ????????? ????????? ?????????.<br>
        </div>
        <div class="modal-footer">
            <form action="return.php" method="POST">
                <input type="hidden" name="returnNum" id="returnNum" value="NULL">
                <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">?????????</button>
                <button type="submit" class="btn btn-success">????????????</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <!-- MDB -->
    <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"
    ></script>

</body>
<script src="./js/html5-qrcode.min.js"></script>
<script src="./js/script.js"></script>
</html>
