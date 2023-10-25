<?php
session_start();

if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login.php");
    exit;
}

include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();
$sql = "SELECT id, name, mailbox_number, phone_number FROM lecturers_data";
$result = $mysql->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ניהול מרצים</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Change the font family */
            background-color: #818181; /* Change the background color */
        }
        h2 {
            color: #000000; /* Change the header color */
            font-size: 35px;
            font-weight: bold;
        }
        input[type="submit"] {
            background-color: #c51d1d; /* Change the button background color */
            color: #020000; /* Change the button text color */
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border: 2px solid;
            border-radius: 4px;
            cursor: pointer;
        }
        a {
            font-size: 20px;
            font-weight: bold;
            color: #150000; /* Change the link color */
            text-decoration: none;
            border: 2px solid;
            padding: 10px;
            border-radius: 8px;
            margin: 10px auto;
            display: inline-block;
            width: 30%;
        }
        .add_lect{
            width: 15%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #949494; /* Change the table background color */
        }
         td {
            border: 2px solid #000000;
            text-align: center;

            font-weight: bold;
            font-size: 20px;
        }

        th {
            background-color: #ffffff; /* Change the table header background color */
            color: #070000; /* Change the table header text color */
            border: 2px solid #000000;
            text-align: center;
            padding: 15px;
            font-weight: bold;
            font-size: 25px;
        }
        tr:nth-child(even) {
            background-color: #ababab; /* Change the even row background color */
        }

        tr:nth-child(odd) {
            background-color: #e8e8e8; /* Change the odd row background color */padding: 10px;

        }
    </style>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<center>

    <form method="POST" action="logout.php" >

        <input type="submit" value="&#x26D2;  התנתק  &#x26D2;">
    </form>
<h2>&#9997;  ניהול מרצים</h2>
<a class="add_lect" href="add_lecturer.php">   ➕ הוספת מרצה חדש     </a>
</center>
<table>
    <tr>
        <th>&#128522; שם   </th>
        <th> &#128231;מספר תיבת דואר   </th>
        <th>&#128222; מספר טלפון   </th>
        <th>  פעולות     &#9998;&#128465; </th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>"; //הגנת xss
            echo "<td>" . htmlspecialchars($row["mailbox_number"]) . "</td>"; //הגנת xss
            echo "<td>" . htmlspecialchars($row["phone_number"]) . "</td>"; //הגנת xss
            echo "<td><a href='edit_lecturer.php?id=" . $row["id"] . "'> &#9998; ערוך</a>    <a href='delete_lecturer.php?id=" . $row["id"] . " '>&#128465; מחק</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'> &#9785;....  אין מרצים להצגה  </td></tr>";
    }
    ?>
</table>
</body>
</html>

