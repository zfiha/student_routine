<?php

session_start();

require_once "db.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM routines");
$totalData = $totalQuery->fetch_assoc();
$totalClasses = $totalData['total'];

$today = date("l");

$stmt = $conn->prepare(
    "SELECT * FROM routines
     WHERE TRIM(day) = ?
     ORDER BY id ASC"
);

$stmt->bind_param("s", $today);
$stmt->execute();

$todayResult = $stmt->get_result();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Student Dashboard</title>

    <link rel="stylesheet" href="style.css">

    <style>

        body {
            background: #f5f7ff;
        }

        /* Welcome Section */

        .dashboard-header {
            background: linear-gradient(135deg, #4056a1, #b95788);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(61, 73, 130, 0.15);
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 30px;
        }

        .owner-name {
            margin: 5px 0 0 0;
            padding: 0;
            font-size: 13px;
            font-weight: 600;
            opacity: 0.9;
        }

        .welcome-text {
            margin-top: 8px;
            margin-bottom: 0;
            font-size: 15px;
        }


        /* Date and Time */

        .date-time-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .date-time-box p {
            margin: 5px;
            color: #666;
        }

        .date-time-box h2 {
            color: #4056a1;
            margin: 8px 0 15px;
        }


        /* Dashboard Cards */

        .dashboard-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .dashboard-card {
            flex: 1;
            min-width: 180px;
            background: linear-gradient(135deg, #4056a1, #b95788);
            color: white;
            padding: 22px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(61, 73, 130, 0.15);
        }

        .dashboard-card p {
            margin: 0;
            font-size: 15px;
        }

        .dashboard-card h2 {
            margin: 10px 0 0;
            font-size: 28px;
        }


        /* Quick Access */

        .quick-links {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .quick-links h2 {
            color: #4056a1;
            margin-top: 0;
        }

        .quick-links a {
            display: inline-block;
            text-decoration: none;
            background: #4056a1;
            color: white;
            padding: 10px 16px;
            margin: 5px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .quick-links a:hover {
            background: #b95788;
        }


        /* Today's Routine */

        .today-title {
            color: #4056a1;
            margin-bottom: 15px;
        }


        /* Table */

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


    <!-- Welcome -->

    <div class="dashboard-header">

        <h1>
            Welcome !
        </h1>

        <p class="owner-name">
            Developed by Zannatul Fiha
        </p>

        <p class="welcome-text">
            Here is your academic dashboard.
        </p>

    </div>


    <!-- Date and Time -->

    <div class="date-time-box">

        <p>Today's Date</p>

        <h2 id="currentDate"></h2>

        <p>Current Time</p>

        <h2 id="liveTime"></h2>

    </div>


    <!-- Dashboard Cards -->

    <div class="dashboard-cards">


        <div class="dashboard-card">

            <p>Total Classes</p>

            <h2>
                <?php echo $totalClasses; ?>
            </h2>

        </div>


        <div class="dashboard-card">

            <p>Today</p>

            <h2>
                <?php echo htmlspecialchars($today); ?>
            </h2>

        </div>


        <div class="dashboard-card">

            <p>Today's Classes</p>

            <h2>
                <?php echo $todayResult->num_rows; ?>
            </h2>

        </div>


    </div>


    <!-- Quick Access -->

    <div class="quick-links">

        <h2>Quick Access</h2>

        <a href="routine.php">
            View Full Routine
        </a>

        <a href="assignments.php">
            Assignments
        </a>

        <a href="exams.php">
            Exams
        </a>

        <a href="notices.php">
            Notices
        </a>

    </div>


    <!-- Today's Routine -->

    <h2 class="today-title">

        Today's Routine -
        <?php echo htmlspecialchars($today); ?>

    </h2>


    <table>

        <tr>

            <th>Time</th>

            <th>Subject</th>

            <th>Teacher</th>

            <th>Room</th>

        </tr>


        <?php if ($todayResult->num_rows > 0) { ?>


            <?php while ($row = $todayResult->fetch_assoc()) { ?>

                <tr>

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

            <?php } ?>


        <?php } else { ?>

            <tr>

                <td colspan="4">
                    No classes scheduled for today.
                </td>

            </tr>

        <?php } ?>


    </table>


</div>


<!-- Live Date and Time -->

<script>

function updateDateTime() {

    const now = new Date();

    const dateOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };

    const date = now.toLocaleDateString(
        'en-US',
        dateOptions
    );

    const time = now.toLocaleTimeString(
        'en-US',
        {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        }
    );

    document.getElementById('currentDate').textContent = date;

    document.getElementById('liveTime').textContent = time;

}

updateDateTime();

setInterval(updateDateTime, 1000);

</script>


</body>

</html>