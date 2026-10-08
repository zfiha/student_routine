<?php

session_start();

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != "student"
) {

    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Profile</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<nav>

    <h2>Student Routine</h2>

    <div>

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="routine.php">
            Routine
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

</nav>

<div class="profile">

    <h1>My Profile</h1>

    <div class="profile-card">

        <h2>
            <?php echo $_SESSION['name']; ?>
        </h2>

        <p>
            <b>Email:</b>
            <?php echo $_SESSION['email']; ?>
        </p>

        <p>
            <b>Role:</b> Student
        </p>

    </div>

</div>

</body>
</html>