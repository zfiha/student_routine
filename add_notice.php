<?php

session_start();

require_once "db.php";

/* Only admin can add notices */

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add_notice'])) {

    $title = trim($_POST['title']);
    $noticeMessage = trim($_POST['message']);
    $noticeDate = $_POST['notice_date'];

    if ($title == "" || $noticeMessage == "" || $noticeDate == "") {

        $message = "Please fill in all fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO notices (title, message, notice_date)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "sss",
            $title,
            $noticeMessage,
            $noticeDate
        );

        if ($stmt->execute()) {
            $message = "Notice added successfully!";
        } else {
            $message = "Failed to add notice!";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Notice | Student Routine</title>

    <link rel="stylesheet" href="style.css">

    <style>

        body {
            background: #f5f7ff;
        }

        .notice-box {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .notice-box h1 {
            color: #4056a1;
            margin-bottom: 25px;
        }

        .notice-box label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .notice-box input,
        .notice-box textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .notice-box textarea {
            height: 120px;
            resize: vertical;
        }

        .notice-box button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #4056a1;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .notice-box button:hover {
            background: #b95788;
        }

        .success {
            background: #e8f7ee;
            color: #217a45;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .error {
            background: #fdeaea;
            color: #b42323;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #4056a1;
            text-decoration: none;
        }

    </style>

</head>

<body>


<nav>

    <h2>Admin Panel</h2>

    <div>

        <a href="admin.php">Dashboard</a>

        <a href="add_notice.php">Add Notice</a>

        <a href="add_routine.php">Add Routine</a>

        <a href="logout.php">Logout</a>

    </div>

</nav>


<div class="notice-box">

    <h1>Add Notice</h1>


    <?php if ($message != "") { ?>

        <?php if (strpos($message, "successfully") !== false) { ?>

            <p class="success">
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php } else { ?>

            <p class="error">
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php } ?>

    <?php } ?>


    <form method="POST">

        <label>Notice Title</label>

        <input
            type="text"
            name="title"
            placeholder="Example: Class Cancelled"
            required
        >


        <label>Notice Message</label>

        <textarea
            name="message"
            placeholder="Example: Web Application Development class has been cancelled."
            required
        ></textarea>


        <label>Notice Date</label>

        <input
            type="date"
            name="notice_date"
            required
        >


        <button type="submit" name="add_notice">
            Add Notice
        </button>

    </form>


    <a href="admin.php" class="back-link">
        ← Back to Admin Dashboard
    </a>

</div>


</body>

</html>