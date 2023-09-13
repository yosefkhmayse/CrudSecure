<?php
session_start();
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login.php");
    exit;
}
//csrf secure
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = uniqid("",true);
}

include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF Token Validation Failed");
    }
    //sql injection addslashes secure
    $name = addslashes($_POST["name"]);
    $mailbox_number = addslashes($_POST["mailbox_number"]);
    $phone_number = addslashes($_POST["phone_number"]);

    $sql = "INSERT INTO lecturers_data (name, mailbox_number, phone_number)
            VALUES ('$name', '$mailbox_number', '$phone_number')";
    if ($mysql->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $mysql->error;
    }
}
$mysql->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>הוספת מרצה חדש</title>
</head>
<body>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #818181;
    }
    h2 {
        color: #000000;
        font-size: 35px;
        font-weight: bold;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    input {
        font-size: 20px;
        font-weight: bold;
        color: #150000; /* Change the link color */
        border: 2px solid;
        padding: 10px;
        border-radius: 8px;
        margin: 10px auto;
        display: inline-block;
        width: 20%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    label {
        font-size: 20px;
        font-weight: bold;
        margin: 10px auto;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
</style>
<h2>הוספת מרצה חדש</h2>
<!--xss secure-->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <label>שם מרצה<input type="text" name="name" placeholder="&#128522;Name......" required><br></label>
    <label> מספר תיבת דואר<input type="number" name="mailbox_number" placeholder="&#128231;mailbox number......" required><br></label>
    <label>מספר טלפון<input type="text" name="phone_number"  placeholder="&#128222;phone number......" required ><br></label><br><br>
    <input type="submit" value=" ➕ הוסף מרצה">
</form>
</body>
</html>
