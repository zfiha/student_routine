<?php

$file = __DIR__ . "/data/notices.json";

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
    $data = array_filter($data, function ($notice) use ($search) {

        $title = $notice['title'] ?? '';
        $description = $notice['description'] ?? '';

        return stripos($title, $search) !== false ||
               stripos($description, $search) !== false;
    });
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Notice Board | Student Routine</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #f4f7fb;
    color: #1f2937;
}

.notice-container {
    max-width: 1150px;
    margin: 35px auto;
    padding: 0 20px;
}

/* HEADER */

.notice-header {
    background: linear-gradient(135deg, #1e3a8a, #4f46e5);
    border-radius: 22px;
    padding: 35px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    box-shadow: 0 12px 30px rgba(37, 99, 235, 0.18);
}

.notice-header h1 {
    font-size: 32px;
    margin-bottom: 8px;
}

.notice-header p {
    font-size: 14px;
    opacity: 0.9;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.18);
    border-radius: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 34px;
}

/* SEARCH */

.search-box {
    background: white;
    padding: 18px;
    border-radius: 16px;
    margin-bottom: 25px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 5px 18px rgba(0,0,0,0.04);
}

.search-form {
    display: flex;
    gap: 10px;
}

.search-form input {
    flex: 1;
    padding: 14px 17px;
    border: 1px solid #d9dee8;
    border-radius: 11px;
    outline: none;
    font-size: 14px;
}

.search-form input:focus {
    border-color: #4f46e5;
}

.search-form button {
    padding: 14px 25px;
    border: none;
    border-radius: 11px;
    background: #4f46e5;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.search-form button:hover {
    background: #3730a3;
}

/* NOTICE LIST */

.notice-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

/* CARD */

.notice-card {
    background: white;
    border-radius: 20px;
    padding: 22px;
    border: 1px solid #e5e7eb;
    display: flex;
    gap: 18px;
    position: relative;
    overflow: hidden;
    transition: 0.3s ease;
}

.notice-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background: #4f46e5;
}

.notice-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.09);
    border-color: #c7d2fe;
}

/* DATE */

.notice-date {
    min-width: 75px;
    height: 82px;
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #3730a3;
}

.notice-date .day {
    font-size: 28px;
    font-weight: bold;
}

.notice-date .month {
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
}

/* CONTENT */

.notice-content {
    flex: 1;
}

.notice-title {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 9px;
}

.notice-title h2 {
    font-size: 18px;
    color: #111827;
    line-height: 1.3;
}

.new-badge {
    background: #dcfce7;
    color: #15803d;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 9px;
    font-weight: bold;
}

.notice-description {
    font-size: 13px;
    color: #6b7280;
    line-height: 1.65;
}

.notice-footer {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 14px;
}

.notice-category {
    background: #f1f5f9;
    color: #475569;
    padding: 5px 9px;
    border-radius: 7px;
    font-size: 10px;
    font-weight: bold;
}

.notice-published {
    font-size: 11px;
    color: #9ca3af;
}

/* ICON */

.notice-arrow {
    position: absolute;
    right: 18px;
    bottom: 18px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #f1f5ff;
    color: #4f46e5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

/* EMPTY */

.empty-box {
    background: white;
    border-radius: 18px;
    padding: 55px;
    text-align: center;
    grid-column: 1 / -1;
    border: 1px solid #e5e7eb;
}

.empty-box div {
    font-size: 42px;
    margin-bottom: 12px;
}

.empty-box h2 {
    color: #374151;
    margin-bottom: 7px;
}

.empty-box p {
    color: #9ca3af;
    font-size: 14px;
}

/* RESPONSIVE */

@media (max-width: 850px) {

    .notice-list {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .notice-header {
        padding: 25px;
    }

    .notice-header h1 {
        font-size: 25px;
    }

    .header-icon {
        width: 55px;
        height: 55px;
        font-size: 27px;
    }

    .search-form {
        flex-direction: column;
    }

    .search-form button {
        width: 100%;
    }

    .notice-card {
        padding: 18px;
    }

}

@media (max-width: 450px) {

    .notice-card {
        flex-direction: column;
    }

    .notice-date {
        width: 75px;
    }

}

</style>

</head>

<body>

<?php

if (file_exists(__DIR__ . '/header.php')) {
    include __DIR__ . '/header.php';
}

?>

<div class="notice-container">

    <!-- HEADER -->

    <div class="notice-header">

        <div>

            <h1>📢 Notice Board</h1>

            <p>
                Stay updated with the latest academic announcements,
                examinations and departmental information.
            </p>

        </div>

        <div class="header-icon">
            🔔
        </div>

    </div>


    <!-- SEARCH -->

    <div class="search-box">

        <form method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="🔍 Search notice by title or description..."
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button type="submit">
                Search
            </button>

        </form>

    </div>


    <!-- NOTICE -->

    <div class="notice-list">

        <?php if (!empty($data)): ?>

            <?php foreach ($data as $notice): ?>

                <?php

                $title = $notice['title'] ?? 'Untitled Notice';
                $description = $notice['description'] ?? '';
                $noticeDate = $notice['date'] ?? '';

                $timestamp = strtotime($noticeDate);

                if ($timestamp !== false) {

                    $day = date('d', $timestamp);
                    $month = date('M', $timestamp);
                    $formattedDate = date('d M Y', $timestamp);

                } else {

                    $day = '--';
                    $month = '---';
                    $formattedDate = 'Date unavailable';

                }

                ?>

                <div class="notice-card">

                    <!-- DATE -->

                    <div class="notice-date">

                        <span class="day">
                            <?php echo htmlspecialchars($day); ?>
                        </span>

                        <span class="month">
                            <?php echo htmlspecialchars($month); ?>
                        </span>

                    </div>


                    <!-- CONTENT -->

                    <div class="notice-content">

                        <div class="notice-title">

                            <h2>
                                <?php echo htmlspecialchars($title); ?>
                            </h2>

                            <span class="new-badge">
                                NEW
                            </span>

                        </div>


                        <p class="notice-description">

                            <?php echo htmlspecialchars($description); ?>

                        </p>


                        <div class="notice-footer">

                            <span class="notice-category">
                                📌 Academic
                            </span>

                            <span class="notice-published">
                                Published:
                                <?php echo htmlspecialchars($formattedDate); ?>
                            </span>

                        </div>

                    </div>


                    <div class="notice-arrow">
                        →
                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-box">

                <div>
                    📭
                </div>

                <h2>
                    No Notices Found
                </h2>

                <p>
                    Try searching with another keyword.
                </p>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>

</html>