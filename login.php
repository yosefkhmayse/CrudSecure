<?php
session_start();
$max_attempts = 3;
$block_duration = 15;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //הגנת כוח גס
    if (isset($_SESSION['block_start_time']) && time() - $_SESSION['block_start_time'] < $block_duration) {
        $remaining_time = $block_duration - (time() - $_SESSION['block_start_time']);
        $error_message = "Too many login attempts. Please try again in " . $remaining_time . " seconds.";
    } else {
        $password = $_POST["password"];
        $correct_password = "AAA";
        if ($password === $correct_password) {
            unset($_SESSION['login_attempts']);
            unset($_SESSION['block_start_time']);
            $_SESSION["authenticated"] = true;
            header("Location: index.php");
            exit;
        } else {
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 1;
            } else {
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= $max_attempts) {
                    $_SESSION['block_start_time'] = time();
                    $error_message = "Too many login attempts. Please try again in $block_duration seconds.";
                }
            }
            $error_message = "סיסמה שגויה";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>התחברות</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Change the font family */
            background-color: #818181; /* Change the background color */
        }

        h2 {
            color: #000000; /* Change the header color */
            font-size: 30px;
            font-weight: bold;
        }

        footer {
            margin: 50px;
        }

        h1 {
            color: #000000; /* Change the header color */
            font-size: 30px;
            font-weight: bold;
        }

        form {
            margin: 100px 22%;
            padding: 30px;
            background-color: #ababab; /* Change the form background color */
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            font-size: 16px;
            color: #070000; /* Change the label color */
            font-weight: bold;
        }

        input[type="password"] {
            width: 20%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #ff0000; /* Change the button background color */
            color: #000000; /* Change the button text color */
            padding: 8px 16px;
            border: none;
            border-radius: 3px;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #0a9400; /* Change the button background color on hover */
        }

        p.error-message {
            color: #bb0000; /* Change the error message color */
            font-size: 30px;
            font-weight: bold;
            text-shadow: 1px 2px #150000;
        }
    </style>
</head>
<body>
<center>
    <h2>התחברות למערכת המרצים</h2>
    <footer>
        <h1>Welcome....👋</h1></footer>
    <!--xss secure-->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="password">Password :
            <input type="password" name="password" placeholder="&#128274; password....." required></label>
        <br>
        <input type="submit" value=" &#10004; התחבר   ">

    </form>
    <?php
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>
</center>
</body>
</html>
