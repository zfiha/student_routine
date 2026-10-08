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

$sql = "SELECT * FROM routines ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<nav>

    <h2>Admin Panel</h2>

    <div>

        <a href="admin.php">Dashboard</a>

        <a href="add_routine.php">Add Routine</a>

        <a href="logout.php">Logout</a>

    </div>

</nav>

<div class="container">

    <h1>Admin Dashboard</h1>

    <p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>

    <a href="add_routine.php" class="btn">
        + Add New Routine
    </a>

    <h2>Manage Routine</h2>

    <table>

        <tr>

            <th>ID</th>
            <th>Day</th>
            <th>Time</th>
            <th>Subject</th>
            <th>Teacher</th>
            <th>Room</th>
            <th>Action</th>

        </tr>

        <?php while ($item = $result->fetch_assoc()) { ?>

        <tr>

            <td>
                <?php echo $item['id']; ?>
            </td>

            <td>
                <?php echo htmlspecialchars($item['day']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($item['time']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($item['subject']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($item['teacher']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($item['room']); ?>
            </td>

            <td>

                <a href="edit_routine.php?id=<?php echo $item['id']; ?>">
                    Edit
                </a>

                |

                <a
                    href="delete_routine.php?id=<?php echo $item['id']; ?>"
                    onclick="return confirm('Delete this routine?')"
                >
                    Delete
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>

</html>