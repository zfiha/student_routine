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

$message = "";

if (isset($_POST['add'])) {

    $day = $_POST['day'];
    $time = $_POST['time'];
    $subject = $_POST['subject'];
    $teacher = $_POST['teacher'];
    $room = $_POST['room'];

    $stmt = $conn->prepare(
        "INSERT INTO routines (day, time, subject, teacher, room)
         VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssss",
        $day,
        $time,
        $subject,
        $teacher,
        $room
    );

    if ($stmt->execute()) {

        header("Location: admin.php");
        exit();

    } else {

        $message = "Failed to add routine!";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Routine</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<nav>

    <h2>Admin Panel</h2>

    <div>

        <a href="admin.php">Dashboard</a>

        <a href="logout.php">Logout</a>

    </div>

</nav>


<div class="form-box">

    <h2>Add Class Routine</h2>


    <?php if ($message != "") { ?>

        <p class="error">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>


    <form method="POST">

        <label>Day</label>

        <select name="day" required>

            <option value="">Select Day</option>

            <option value="Saturday">Saturday</option>

            <option value="Sunday">Sunday</option>

            <option value="Monday">Monday</option>

            <option value="Tuesday">Tuesday</option>

            <option value="Wednesday">Wednesday</option>

            <option value="Thursday">Thursday</option>

        </select>


        <label>Time</label>

        <input
            type="text"
            name="time"
            placeholder="9:00 AM - 10:00 AM"
            required
        >


        <label>Subject</label>

        <input
            type="text"
            name="subject"
            placeholder="Subject Name"
            required
        >


        <label>Teacher</label>

        <input
            type="text"
            name="teacher"
            placeholder="Teacher Name"
            required
        >


        <label>Room</label>

        <input
            type="text"
            name="room"
            placeholder="Room Number"
            required
        >


        <button type="submit" name="add">
            Add Routine
        </button>

    </form>


    <br>

    <a href="admin.php">
        Back to Admin
    </a>

</div>

</body>

</html>