<?php

require_once "db.php";

$selectedDay = $_GET['day'] ?? 'All';

?>

<!DOCTYPE html>
<html>

<head>

    <title>Class Routine</title>

    <link rel="stylesheet" href="style.css">

    <style>

        body {
            background: #f5f7ff;
        }

        .day-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px 0;
        }

        .day-buttons a {
            display: inline-block;
            text-decoration: none;
            background: #4056a1;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
        }

        .day-buttons a:hover {
            background: #b95788;
        }

        .day-buttons a.active {
            background: #b95788;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-radius: 10px;
            overflow: hidden;
        }

        table th {
            background: #4056a1;
            color: white;
            padding: 12px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        table tr:hover {
            background: #f8f3f8;
        }

    </style>

</head>


<body>


<!-- Navigation -->

<nav>

    <h2>Student Routine</h2>

    <div>

        <a href="dashboard.php">Dashboard</a>

        <a href="routine.php">Routine</a>

        <a href="courses.php">Courses</a>

        <a href="teachers.php">Teachers</a>

        <a href="assignments.php">Assignments</a>

        <a href="exams.php">Exams</a>

        <a href="notices.php">Notices</a>

        <a href="profile.php">Profile</a>

        <a href="logout.php">Logout</a>

    </div>

</nav>


<div class="container">

    <h1>Class Routine</h1>

    <p>View your weekly class routine</p>


    <!-- Day Buttons -->

    <div class="day-buttons">

        <a
            href="routine.php?day=All"
            class="<?php echo ($selectedDay == 'All') ? 'active' : ''; ?>"
        >
            All
        </a>

        <a
            href="routine.php?day=Saturday"
            class="<?php echo ($selectedDay == 'Saturday') ? 'active' : ''; ?>"
        >
            Saturday
        </a>

        <a
            href="routine.php?day=Sunday"
            class="<?php echo ($selectedDay == 'Sunday') ? 'active' : ''; ?>"
        >
            Sunday
        </a>

        <a
            href="routine.php?day=Monday"
            class="<?php echo ($selectedDay == 'Monday') ? 'active' : ''; ?>"
        >
            Monday
        </a>

        <a
            href="routine.php?day=Tuesday"
            class="<?php echo ($selectedDay == 'Tuesday') ? 'active' : ''; ?>"
        >
            Tuesday
        </a>

        <a
            href="routine.php?day=Wednesday"
            class="<?php echo ($selectedDay == 'Wednesday') ? 'active' : ''; ?>"
        >
            Wednesday
        </a>

        <a
            href="routine.php?day=Thursday"
            class="<?php echo ($selectedDay == 'Thursday') ? 'active' : ''; ?>"
        >
            Thursday
        </a>

    </div>


    <?php

    if ($selectedDay == "All") {

        $stmt = $conn->prepare(
            "SELECT id, day, time, subject, teacher, room
             FROM routines
             ORDER BY id ASC"
        );

    } else {

        $stmt = $conn->prepare(
            "SELECT id, day, time, subject, teacher, room
             FROM routines
             WHERE LOWER(TRIM(day)) = LOWER(TRIM(?))
             ORDER BY id ASC"
        );

        $stmt->bind_param("s", $selectedDay);

    }

    $stmt->execute();

    $result = $stmt->get_result();

    ?>


    <!-- Heading -->

    <h2>

        <?php

        if ($selectedDay == "All") {

            echo "All Class Routine";

        } else {

            echo htmlspecialchars($selectedDay) . " Class Routine";

        }

        ?>

    </h2>


    <!-- Routine Table -->

    <table>

        <tr>

            <th>Day</th>

            <th>Time</th>

            <th>Subject</th>

            <th>Teacher</th>

            <th>Room</th>

        </tr>


        <?php

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

        ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($row['day']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['time']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['subject']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['teacher']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['room']); ?>
                    </td>

                </tr>

        <?php

            }

        } else {

        ?>

            <tr>

                <td colspan="5">

                    No routine available for
                    <?php echo htmlspecialchars($selectedDay); ?>.

                </td>

            </tr>

        <?php

        }

        ?>

    </table>


</div>


</body>

</html>