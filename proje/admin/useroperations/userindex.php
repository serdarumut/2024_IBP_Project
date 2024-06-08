<?php
// her seyin ana sayfası burası 

session_start();

require 'dbconnection.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Details</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa; /* Arka plan rengini açık gri yaptım */
            color: #343a40; /* Yazı rengini koyu gri yaptım */
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 240px;
            background-color: #343a40; /* Sidebar rengini koyu gri yaptım */
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
            color: #fff; /* Menü yazı rengini beyaz yaptım */
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .menu li a i {
            margin-right: 10px;
        }

        .menu li a:hover {
            background-color: #495057; /* Menüde hover rengini koyu gri yaptım */
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .card {
            background-color: #ffffff; /* Kart rengini beyaz yaptım */
            border-color: #ced4da; /* Kart sınır rengini açık gri yaptım */
            color: #343a40; /* Kart yazı rengini koyu gri yaptım */
        }

        .card-header {
            background-color: #f8f9fa; /* Kart başlık rengini açık gri yaptım */
            border-color: #ced4da; /* Kart başlık sınır rengini açık gri yaptım */
            color: #343a40; /* Kart başlık yazı rengini koyu gri yaptım */
        }

        .table {
            color: #343a40; /* Tablo yazı rengini koyu gri yaptım */
        }

        .btn-primary {
            background-color: #007bff; /* Birincil buton rengini mavi yaptım */
            border-color: #007bff; /* Birincil buton sınır rengini mavi yaptım */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Birincil buton hover rengini koyu mavi yaptım */
            border-color: #0056b3; /* Birincil buton hover sınır rengini koyu mavi yaptım */
        }

        .btn-info {
            background-color: #17a2b8; /* Bilgi buton rengini maviye çalan yeşil yaptım */
            border-color: #17a2b8; /* Bilgi buton sınır rengini maviye çalan yeşil yaptım */
        }

        .btn-info:hover {
            background-color: #138496; /* Bilgi buton hover rengini koyu maviye çalan yeşil yaptım */
            border-color: #138496; /* Bilgi buton hover sınır rengini koyu maviye çalan yeşil yaptım */
        }

        .btn-success {
            background-color: #28a745; /* Başarı buton rengini yeşil yaptım */
            border-color: #28a745; /* Başarı buton sınır rengini yeşil yaptım */
        }

        .btn-success:hover {
            background-color: #1e7e34; /* Başarı buton hover rengini koyu yeşil yaptım */
            border-color: #1e7e34; /* Başarı buton hover sınır rengini koyu yeşil yaptım */
        }

        .btn-danger {
            background-color: #dc3545; /* Tehlike buton rengini kırmızı yaptım */
            border-color: #dc3545; /* Tehlike buton sınır rengini kırmızı yaptım */
        }

        .btn-danger:hover {
            background-color: #bd2130; /* Tehlike buton hover rengini koyu kırmızı yaptım */
            border-color: #bd2130; /* Tehlike buton hover sınır rengini koyu kırmızı yaptım */
        }

        @media (max-width: 767px) {
            body {
                padding: 10px;
            }

            .sidebar {
                width: 100%;
                position: static;
                height: auto;
                padding-top: 0;
                margin-bottom: 20px;
            }

            .logo {
                margin-bottom: 20px;
            }

            .menu li {
                margin-bottom: 5px;
            }

            .menu li a {
                padding: 8px;
            }

            form {
                max-width: 100%;
                padding: 10px;
                margin-top: 20px;
            }

            input[type=submit],
            .button {
                width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
<div class="sidebar">
    <div class="logo">
        <img src="../../resimler/logo.png" width="100" alt="Logo">
    </div>
    <ul class="menu">
        <li class="active"><a href="../admindashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="../useroperations/userindex.php"><i class="fas fa-users"></i> User Operations</a></li>
        <li><a href="../movieoperations/movieindex.php"><i class="fas fa-video"></i> Movie Operations</a></li>
        <li><a href="../announcement.php"><i class="fas fa-bullhorn"></i> Announcement</a></li>
        <li><a href="../../mesaj/index.php"><i class="fas fa-envelope"></i>Messages</a></li>
        <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="content">
    <div class="container mt-4">
        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-between align-items-center">User Details
                            <a href="adduser.php" class="btn btn-primary ">Add User</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>User Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Fetch records from the database
                                $query = "SELECT * FROM user";
                                $query_run = mysqli_query($connection, $query);

                                // Display data in a table
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $userData) {
                                        ?>
                                        <tr>
                                            <td><?= $userData['id']; ?></td>
                                            <td><?= $userData['email']; ?></td>
                                            <td><?= $userData['password']; ?></td>
                                            <td><?= $userData['usertype']; ?></td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <a href="userview.php?id=<?= $userData['id']; ?>"
                                                       class="btn btn-info btn-sm">View</a>
                                                    <a href="useredit.php?id=<?= $userData['id']; ?>"
                                                       class="btn btn-success btn-sm">Edit</a>
                                                    <form action="usercode.php" method="POST"
                                                          class="d-inline">
                                                        <button type="submit" name="delete_user"
                                                                value="<?= $userData['id']; ?>"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<h4>No Record Found</h4>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>

</body>

</html>
