<?php

session_start();

require 'dbconnection.php';

// URL girerek gitmeyi engelleme

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php');
    exit();
}
if ($_SESSION['usertype']) {
    header('Location: ../index.php');
    exit();
}

// kitap sayısını çeken kod
$result = mysqli_query($connection, "SELECT COUNT(*) FROM movie;");
$row = mysqli_fetch_array($result);
$moviecount = $row[0];


// duyuruları çeken kod
$sql = "SELECT * FROM announcement ORDER BY date DESC ";
$result = mysqli_query($connection, $sql);

?>


<!DOCTYPE html>
<html>

<head>

    <title>User Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 240px;
            background-color: #0a8cff;
            padding-top: 20px;
            outline: none;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            margin-bottom: 10px;
        }

        .menu li a {
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .menu li a i {
            margin-right: 10px;
        }

        .menu li a:hover {
            background-color: #495057;
        }

        .main-content {
            margin-left: 240px;
            padding: 30px;
        }

        .header {
            margin-bottom: 30px;
            color: #495057;
        }

        .info {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color: #343a40;
        }

        .announcement {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-left: 4px solid #007bff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .announcement .title {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .announcement .content {
            margin-bottom: 10px;
        }

        .announcement .date {
            color: #6c757d;
            font-size: 12px;
        }
        
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="logo">
            <img src="../resimler/logo.png" width="100" alt="Logo">
        </div>
        <ul class="menu">
            <li class="active"><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="./useroperations/passwordchange.php"><i class="fas fa-key"></i> Password Operations</a></li>
            <li><a href="./movieoperations/viewmovie.php"><i class="fas fa-video"></i> View Movies</a></li>
            <li><a href="./movieoperations/searchmovie.php"><i class="fas fa-film"></i> Search Movies</a></li>
            <li><a href="../mesaj/index.php"><i class="fas fa-envelope"></i>Messages</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>User Panel</h1>
        </div>
        <div class="info">
            <p>
            <h3>You can make your operations using this page.</h3>
            </p>
        </div>
        <section>
            <br>
            <br>
            <div class="info">
                <div class="container">
                    <h2><u><strong>Recent Announcements</strong></u></h2>
                    <br>
                    <br>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="announcement">';
                            echo '<div class="title">' . $row["title"] . '</div>';
                            echo '<div class="content">' . $row["content"] . '</div>';
                            echo '<div class="date">' . $row['date'] . '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No results</p>";
                    }
                    ?>
                </div>
            </div>
            <br>
            <br>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>

</html>
