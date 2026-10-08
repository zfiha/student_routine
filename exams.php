<?php
$data = json_decode(file_get_contents("data/exams.json"), true);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Exams</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav>
    <h2>Smart Campus</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="routine.php">Routine</a>
    <a href="courses.php">Courses</a>
    <a href="teachers.php">Teachers</a>
    <a href="notices.php">Notices</a>
    <a href="exams.php">Exams</a>
    <a href="assignments.php">Assignments</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">

    <h1>Exam Routine</h1>

    <table>

        <tr>
            <th>Course</th>
            <th>Date</th>
            <th>Time</th>
            <th>Room</th>
        </tr>

        <?php foreach ($data as $exam): ?>

        <tr>
            <td><?= htmlspecialchars($exam['course'] ?? '') ?></td>
            <td><?= htmlspecialchars($exam['date'] ?? '') ?></td>
            <td><?= htmlspecialchars($exam['time'] ?? '') ?></td>
            <td><?= htmlspecialchars($exam['room'] ?? '') ?></td>
        </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>