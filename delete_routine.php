<?php

session_start();

require_once "db.php";

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != "admin"
) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare(
    "DELETE FROM routines WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$stmt->close();

header("Location: admin.php");
exit();

?>