<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

$sql = "DELETE FROM posts WHERE id='$id' AND user_id='".$_SESSION['user_id']."'";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
