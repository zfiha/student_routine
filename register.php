<?php
session_start();

require_once "db.php";

$message = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {

        $message = "Email already exists!";

    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, password, role)
             VALUES (?, ?, ?, 'student')"
        );

        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $message = "Registration successful! You can now login.";
        } else {
            $message = "Registration failed!";
        }

        $stmt->close();
    }

    $check->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav>
    <h2>Student Routine</h2>

    <div>
        <a href="index.php">Home</a>
        <a href="routine.php">Routine</a>
        <a href="login.php">Login</a>
    </div>
</nav>

<div class="form-box">

    <h2>Student Registration</h2>

    <?php
    if ($message != "") {
        echo "<p class='message'>$message</p>";
    }
    ?>

    <form method="POST">

        <label>Name</label>

        <input
            type="text"
            name="name"
            placeholder="Enter your name"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter password"
            required
        >

        <button type="submit" name="register">
            Register
        </button>

    </form>

    <p>
        Already registered?
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>