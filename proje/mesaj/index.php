<?php

session_start();

if (isset($_GET['logout'])) {

    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>" . $_SESSION['name'] . "</b> has left the chat session.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);

    session_destroy();

    header("Location: index.php"); //Redirect the user

}

if (isset($_POST['enter'])) {

    if ($_POST['name'] != "") {

        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    } else {

        echo '<span class="error">Please type in a name</span>';
    }
}

function loginForm()
{

    echo
    '<div id="loginform">
            <p>Please enter your name to continue!</p>
            <form action="index.php" method="post">
                <label for="name">Name &mdash;</label>
                <input type="text" name="name" id="name" />
                <input type="submit" name="enter" id="enter" value="Enter" />
            </form>
        </div>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Chat!!</title>
    <meta name="description" content="Chat!!" />
    <link rel="stylesheet" href="style.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 20px auto;
            font-family: "Lato", sans-serif;
            font-weight: 300;
            background-color: #f8f9fa;
            color: #343a40;
        }

        form {
            padding: 15px 25px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        form label {
            font-size: 1.5rem;
            font-weight: bold;
        }

        input {
            font-family: "Lato", sans-serif;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        #wrapper,
        #loginform {
            margin: 0 auto;
            padding-bottom: 25px;
            background: #ffffff;
            width: 600px;
            max-width: 100%;
            border: 2px solid #e6e6e6;
            border-radius: 4px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        #loginform {
            padding-top: 18px;
            text-align: center;
        }

        #loginform p {
            padding: 15px 25px;
            font-size: 1.4rem;
            font-weight: bold;
            color: #343a40;
        }

        #chatbox {
            text-align: left;
            margin: 0 auto;
            margin-bottom: 25px;
            padding: 10px;
            background: #f8f9fa;
            height: 300px;
            width: 530px;
            border: 1px solid #ddd;
            overflow: auto;
            border-radius: 4px;
            border-bottom: 4px solid #ddd;
        }

        #usermsg {
            flex: 1;
            border-radius: 4px;
            border: 1px solid #ced4da;
            background-color: #ffffff;
            color: #343a40;
            padding: 10px;
            outline: none;
        }

        #name {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 2px 8px;
            background-color: #ffffff;
            color: #343a40;
        }

        #submitmsg,
        #enter {
            background: #007bff;
            border: 2px solid #0056b3;
            color: white;
            padding: 4px 10px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }

        .error {
            color: #dc3545;
        }

        #menu {
            padding: 15px 25px;
            display: flex;
        }

        #menu p.welcome {
            flex: 1;
            color: #343a40;
            font-size: 20px;
            font-weight: bold;
        }

        a#exit {
            color: white;
            background: #dc3545;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }

        .msgln {
            margin: 0 0 5px 0;
        }

        .msgln span.left-info {
            color: #ff5722;
        }

        .msgln span.chat-time {
            color: #6c757d;
            font-size: 60%;
            vertical-align: super;
        }

        .msgln b.user-name,
        .msgln b.user-name-left {
            font-weight: bold;
            background: #007bff;
            color: white;
            padding: 2px 4px;
            font-size: 90%;
            border-radius: 4px;
            margin: 0 5px 0 0;
        }

        .msgln b.user-name-left {
            background: #ff5722;
        }
    </style>
</head>

<body>
<?php
if (!isset($_SESSION['name'])) {
    loginForm();
} else {
    ?>
    <div id="wrapper">
        <div id="menu">
            <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
        </div>
        <div id="chatbox">
            <?php
            if (file_exists("log.html") && filesize("log.html") > 0) {
                $contents = file_get_contents("log.html");
                echo $contents;
            }
            ?>
        </div>
        <form name="message" action="">
            <input name="usermsg" type="text" id="usermsg" placeholder="Type your message here..." />
            <button name="submitmsg" type="submit" id="submitmsg">Send</button>
        </form>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#submitmsg").click(function() {
                var clientmsg = $("#usermsg").val();
                $.post("post.php", {
                    text: clientmsg
                });
                $("#usermsg").val("");
                return false;
            });

            function loadLog() {
                var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; 
                $.ajax({
                    url: "log.html",
                    cache: false,
                    success: function(html) {
                        $("#chatbox").html(html);
                        var newscrollHeight = $("#chatbox")[0].scrollHeight - 20;
                        if (newscrollHeight > oldscrollHeight) {
                            $("#chatbox").animate({
                                scrollTop: newscrollHeight
                            }, 'normal');
                        }
                    }
                });
            }

            setInterval(loadLog, 2500);

            $("#exit").click(function() {
                var exit = confirm("Are you sure you want to end the session?");
                if (exit == true) {
                    window.location = "../index.php";
                }
            });
        });
    </script>
    <?php
}
?>
</body>

</html>
