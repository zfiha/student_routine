```php
<?php
$data = json_decode(file_get_contents("data/courses.json"), true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses - Smart Campus</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .course-header h1 {
            margin: 0;
            color: #1f2937;
        }

        .course-count {
            background: #eef2ff;
            color: #4f46e5;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 22px;
        }

        .course-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid #eee;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
        }

        .course-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.12);
        }

        .course-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: #4f46e5;
        }

        .course-code {
            display: inline-block;
            background: #eef2ff;
            color: #4f46e5;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .course-name {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 18px;
            min-height: 48px;
        }

        .course-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .credit-label {
            color: #6b7280;
            font-size: 14px;
        }

        .credit-value {
            background: #f3f4f6;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: bold;
            color: #374151;
        }
    </style>
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

    <div class="course-header">
        <h1>📚 My Courses</h1>

        <div class="course-count">
            <?= count($data) ?> Courses
        </div>
    </div>

    <div class="course-grid">

        <?php foreach ($data as $course): ?>

            <div class="course-card">

                <div class="course-code">
                    <?= htmlspecialchars($course['code'] ?? '') ?>
                </div>

                <div class="course-name">
                    <?= htmlspecialchars($course['name'] ?? '') ?>
                </div>

                <div class="course-info">
                    <span class="credit-label">Course Credit</span>

                    <span class="credit-value">
                        <?= htmlspecialchars($course['credit'] ?? '') ?>
                    </span>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>
```
