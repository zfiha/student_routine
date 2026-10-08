```php
<?php
$data = json_decode(file_get_contents("data/teachers.json"), true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teachers - Smart Campus</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .teacher-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .teacher-header h1 {
            margin: 0;
            color: #1f2937;
        }

        .teacher-count {
            background: #eef2ff;
            color: #4f46e5;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .teacher-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 22px;
        }

        .teacher-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid #eee;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
        }

        .teacher-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.12);
        }

        .teacher-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: #4f46e5;
        }

        .teacher-icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-bottom: 15px;
        }

        .teacher-name {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .qualification {
            color: #4f46e5;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .teacher-info {
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .info-row {
            margin-bottom: 10px;
            color: #555;
            font-size: 14px;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
        }

        .email {
            color: #4f46e5;
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

    <div class="teacher-header">
        <h1>👨‍🏫 Our Teachers</h1>

        <div class="teacher-count">
            <?= count($data) ?> Teachers
        </div>
    </div>

    <div class="teacher-grid">

        <?php foreach ($data as $teacher): ?>

            <div class="teacher-card">

                <div class="teacher-icon">
                    👨‍🏫
                </div>

                <div class="teacher-name">
                    <?= htmlspecialchars($teacher['name'] ?? '') ?>
                </div>

                <div class="qualification">
                    <?= htmlspecialchars($teacher['qualification'] ?? 'Faculty Member') ?>
                </div>

                <div class="teacher-info">

                    <div class="info-row">
                        <span class="info-label">Department:</span>
                        <?= htmlspecialchars($teacher['department'] ?? '') ?>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="email">
                            <?= htmlspecialchars($teacher['email'] ?? '') ?>
                        </span>
                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>
```
