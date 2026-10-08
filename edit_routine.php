<?php

session_start();

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != "admin"
) {

    header("Location: login.php");
    exit();
}

$file = "data/routine.json";

$routine = json_decode(
    file_get_contents($file),
    true
);

$id = $_GET['id'];

$current = null;

foreach ($routine as $item) {

    if ($item['id'] == $id) {
        $current = $item;
    }
}

if (isset($_POST['update'])) {

    foreach ($routine as &$item) {

        if ($item['id'] == $id) {

            $item['day'] = $_POST['day'];

            $item['time'] = $_POST['time'];

            $item['course'] = $_POST['course'];

            $item['teacher'] = $_POST['teacher'];

            $item['room'] = $_POST['room'];
        }
    }

    file_put_contents(
        $file,
        json_encode($routine, JSON_PRETTY_PRINT)
    );

    header("Location: admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Routine</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-box">

    <h2>Edit Routine</h2>

    <form method="POST">

        <label>Day</label>

        <select name="day">

            <option
                value="Sunday"
                <?php if ($current['day']=="Sunday") echo "selected"; ?>
            >
                Sunday
            </option>

            <option
                value="Monday"
                <?php if ($current['day']=="Monday") echo "selected"; ?>
            >
                Monday
            </option>

            <option
                value="Tuesday"
                <?php if ($current['day']=="Tuesday") echo "selected"; ?>
            >
                Tuesday
            </option>

            <option
                value="Wednesday"
                <?php if ($current['day']=="Wednesday") echo "selected"; ?>
            >
                Wednesday
            </option>

            <option
                value="Thursday"
                <?php if ($current['day']=="Thursday") echo "selected"; ?>
            >
                Thursday
            </option>

        </select>

        <label>Time</label>

        <input
            type="text"
            name="time"
            value="<?php echo $current['time']; ?>"
            required
        >

        <label>Course</label>

        <input
            type="text"
            name="course"
            value="<?php echo $current['course']; ?>"
            required
        >

        <label>Teacher</label>

        <input
            type="text"
            name="teacher"
            value="<?php echo $current['teacher']; ?>"
            required
        >

        <label>Room</label>

        <input
            type="text"
            name="room"
            value="<?php echo $current['room']; ?>"
            required
        >

        <button name="update">
            Update Routine
        </button>

    </form>

</div>

</body>
</html>