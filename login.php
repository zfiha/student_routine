<?php
session_start();

require_once "db.php";

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT id, name, email, password, role FROM users WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }

            exit();

        } else {
            $error = "Wrong email or password!";
        }

    } else {
        $error = "Wrong email or password!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login | Student Routine</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav>

    <h2>Student Routine</h2>

    <div>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
    </div>

</nav>

<div class="form-box">

    <h2>Login</h2>

    <?php
    if ($error != "") {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <form method="POST">

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

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <p>
        New student?
        <a href="register.php">Register</a>
    </p>

</div>

</body>
</html>