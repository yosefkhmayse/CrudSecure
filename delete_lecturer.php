<?php
session_start();
if (!isset($_SESSION["authenticated"]) || !$_SESSION["authenticated"]) {
    header("Location: login.php");
    exit;
}
include "mysql_conn.php";
$mysql_obj = new mysql_conn();
$mysql = $mysql_obj->GetConn();
$id = $_GET["id"];
$sql = "DELETE FROM lecturers_data WHERE id = $id";
if ($mysql->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting record: " . $mysql->error;
}
$mysql->close();
?>
