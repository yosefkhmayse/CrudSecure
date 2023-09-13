<?php
session_start();
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login.php");
    exit;
}
include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = addslashes($_POST["id"]);
    $name = addslashes($_POST["name"]);
    $mailbox_number = addslashes($_POST["mailbox_number"]);
    $phone_number = addslashes($_POST["phone_number"]);
    $sql = "UPDATE lecturers_data SET name = '$name', mailbox_number = '$mailbox_number', phone_number = '$phone_number' WHERE id = $id";
    if ($mysql->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating record: " . $mysql->error;
    }
}
$id = addslashes($_GET["id"]);
$sql = "SELECT id, name, mailbox_number, phone_number FROM lecturers_data WHERE id = $id";
$result = $mysql->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "מרצה לא נמצא";
    exit;
}
$mysql->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>עריכת מרצה</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Change the font family */
            background-color: #818181; /* Change the background color */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        h2 {
            color: #000000; /* Change the header color */
            font-size: 35px;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        form {
            margin: 20px;
            padding: 20px;
            background-color: #9a9a9a; /* Change the form background color */
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 5px #888888;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 25%;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 20px;
        }

        input[type="submit"] {
            background-color: #42a600; /* Change the button background color */
            color: #000000; /* Change the button text color */
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }
        label{
            font-size: 20px;
            font-weight: bold;
            margin: 10px auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
    </style>
</head>
<body>
<h2>עריכת מרץ</h2>
<!--xss secure-->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
    <label>עריכת שם<input type="text" name="name"  placeholder="&#128522;"  value="<?php echo $row["name"]; ?>" required> </label> <br>
    <label>עריכת תיבת דואר <input type="number" name="mailbox_number" placeholder="&#128231;" value="<?php echo $row["mailbox_number"]; ?>" required></label> <br>
    <label>עריכת מספר טלפון <input type="text" name="phone_number" placeholder="&#128222;" value="<?php echo $row["phone_number"]; ?>"></label> <br><br><br>
    <input type="submit" value="&#9998; ערוך מרצה     ">
</form>
</body>
</html>
