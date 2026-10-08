<?php

$file = __DIR__ . "/data/assignments.json";

$data = [];

if (file_exists($file)) {
    $json = file_get_contents($file);
    $decoded = json_decode($json, true);

    if (is_array($decoded)) {
        $data = $decoded;
    }
}

$search = trim($_GET['search'] ?? '');

if ($search !== '') {
    $data = array_filter($data, function ($assignment) use ($search) {

        $course = $assignment['course'] ?? '';
        $title = $assignment['title'] ?? '';
        $type = $assignment['type'] ?? '';
        $description = $assignment['description'] ?? '';

        return stripos($course, $search) !== false ||
               stripos($title, $search) !== false ||
               stripos($type, $search) !== false ||
               stripos($description, $search) !== false;
    });
}

usort($data, function ($a, $b) {
    return strtotime($a['deadline'] ?? '') - strtotime($b['deadline'] ?? '');
});

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Assignments | Smart Campus</title>

    <link rel="stylesheet" href="style.css">

    <style>

        body {
            background: #f5f7fb;
        }

        .assignment-container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .assignment-header {
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
            color: white;
            border-radius: 22px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 12px 30px rgba(79, 70, 229, 0.18);
        }

        .assignment-header h1 {
            margin: 0 0 8px;
            font-size: 32px;
        }

        .assignment-header p {
            margin: 0;
            opacity: 0.9;
        }

        .search-box {
            background: white;
            padding: 18px;
            border-radius: 18px;
            margin-bottom: 25px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);
        }

        .search-box form {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            padding: 13px 16px;
            border: 1px solid #dbe1ea;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
        }

        .search-box input:focus {
            border-color: #4f46e5;
        }

        .search-box button {
            border: none;
            padding: 13px 22px;
            border-radius: 12px;
            background: #4f46e5;
            color: white;
            font-size: 15px;
            cursor: pointer;
        }

        .search-box button:hover {
            background: #3730a3;
        }

        .assignment-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .assignment-card {
            background: white;
            border-radius: 20px;
            padding: 23px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            transition: 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .assignment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.10);
        }

        .assignment-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: #7c3aed;
        }

        .assignment-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 16px;
        }

        .assignment-title h2 {
            margin: 0 0 6px;
            color: #1f2937;
            font-size: 20px;
        }

        .course-name {
            color: #6b7280;
            font-size: 14px;
        }

        .type-badge {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .assignment-badge {
            background: #ede9fe;
            color: #6d28d9;
        }

        .lab-badge {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .deadline-box {
            background: #f8fafc;
            border-radius: 14px;
            padding: 14px;
            margin: 18px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .date-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .deadline-label {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 3px;
        }

        .deadline-date {
            color: #1f2937;
            font-weight: 700;
            font-size: 15px;
        }

        .assignment-description {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        .empty-box {
            background: white;
            text-align: center;
            padding: 60px 20px;
            border-radius: 20px;
            color: #6b7280;
        }

        .empty-box .icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .empty-box h2 {
            color: #374151;
            margin-bottom: 8px;
        }

        @media (max-width: 800px) {

            .assignment-grid {
                grid-template-columns: 1fr;
            }

            .assignment-header h1 {
                font-size: 26px;
            }

        }

        @media (max-width: 550px) {

            .search-box form {
                flex-direction: column;
            }

            .assignment-top {
                flex-direction: column;
            }

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


<div class="assignment-container">

    <div class="assignment-header">

        <h1>📚 Assignments & Lab Reports</h1>

        <p>
            Keep track of your assignments, lab reports and upcoming deadlines.
        </p>

    </div>


    <div class="search-box">

        <form method="GET">

            <input
                type="text"
                name="search"
                placeholder="🔍 Search course, assignment or lab report..."
                value="<?= htmlspecialchars($search) ?>"
            >

            <button type="submit">
                Search
            </button>

        </form>

    </div>


    <?php if (!empty($data)): ?>

        <div class="assignment-grid">

            <?php foreach ($data as $assignment): ?>

                <?php

                $type = $assignment['type'] ?? 'Assignment';

                $deadline = $assignment['deadline'] ?? '';

                $timestamp = strtotime($deadline);

                if ($timestamp !== false) {
                    $formattedDeadline = date('d M Y', $timestamp);
                } else {
                    $formattedDeadline = 'Date unavailable';
                }

                $badgeClass =
                    strtolower($type) === 'lab report'
                    ? 'lab-badge'
                    : 'assignment-badge';

                ?>

                <div class="assignment-card">

                    <div class="assignment-top">

                        <div class="assignment-title">

                            <h2>
                                <?= htmlspecialchars($assignment['title'] ?? 'Untitled') ?>
                            </h2>

                            <span class="course-name">
                                📘 <?= htmlspecialchars($assignment['course'] ?? '') ?>
                            </span>

                        </div>


                        <span class="type-badge <?= $badgeClass ?>">

                            <?= htmlspecialchars($type) ?>

                        </span>

                    </div>


                    <div class="deadline-box">

                        <div class="date-icon">
                            📅
                        </div>

                        <div>

                            <span class="deadline-label">
                                Submission Deadline
                            </span>

                            <span class="deadline-date">
                                <?= htmlspecialchars($formattedDeadline) ?>
                            </span>

                        </div>

                    </div>


                    <div class="assignment-description">

                        <?= htmlspecialchars(
                            $assignment['description']
                            ?? 'No description available.'
                        ) ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty-box">

            <div class="icon">
                📭
            </div>

            <h2>No Assignments Found</h2>

            <p>
                Try searching with another keyword.
            </p>

        </div>

    <?php endif; ?>

</div>

</body>
</html>