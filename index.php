<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/@mdi/light-font@0.2.63/css/materialdesignicons-light.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    $currentDate = time();
    $currentday = date('d', strtotime($currentDate));
    $currentmonth = date('m', strtotime($currentDate));
    $currentyear = date('y', strtotime($currentDate));

    if (isset($_GET['month'])) {
        $currentmonth = $_GET['month'];
        $currentDate = strtotime($currentyear . '-' . $currentmonth . '-' . $currentday);
    }

    if (isset($_GET['year'])) {
        $currentyear = $_GET['year'];
        $currentDate = strtotime($currentyear . '-' . $currentmonth . '-' . $currentday);
    }


    // Get the month and year from GET parameters, or use current month and year
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');

    $previousDate = strtotime("-1 months", $currentDate);
    $nextDate = strtotime("+1 months", $currentDate);

    ?>
    <div class="calendar">
        <div class="header">
            <a class="prevBtn" href="?month=<?php echo date('m', $previousDate); ?>&year=<?php echo date('Y', $previousDate); ?>">
                <span class="mdil mdil-chevron-left"></span>
            </a>

            <!-- Display current month and year -->
            <span class="month-year"><?php echo date('F Y', $currentDate) ?></span>


            <a class="nextBtn" href="?month=<?php echo date('m', $nextDate); ?>&year=<?php echo date('Y', $nextDate); ?>">
                <span class="mdil mdil-chevron-right"></span>
            </a>
        </div>
        <div class="weekdays">
            <!-- Display names of days of the week -->
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>
        <div class="days">
            <?php
            // Calculate the first and last day of the displayed month
            $firstDayOfMonth = strtotime('first day of ' . $year . '-' . $month);
            $lastDayOfMonth = strtotime('last day of ' . $year . '-' . $month);
            // Calculate the day of the week for the first day of the month
            $firstDayOfWeek = date('w', $firstDayOfMonth);
            $lastDay = date('d', $lastDayOfMonth);

            // Display days from previous month if necessary to fill the first week
            for ($i = 0; $i < $firstDayOfWeek; $i++) {
                echo '<div class="day other-month">' . date('d', strtotime('-' . ($firstDayOfWeek - $i) . ' day', $firstDayOfMonth)) . '</div>';
            }

            // Display days of the current month
            for ($i = 1; $i <= $lastDay; $i++) {
                echo '<div class="day' . (($i == date('d') && $month == date('m') && $year == date('Y')) ? ' today' : '') . '">' . $i . '</div>';
            }

            // Display days from next month if necessary to fill the last week
            $lastDayOfWeek = date('w', $lastDayOfMonth);
            for ($i = 1; $i < 7 - $lastDayOfWeek; $i++) {
                echo '<div class="day other-month">' . date('d', strtotime('+' . $i . ' day', $lastDayOfMonth)) . '</div>';
            }
            ?>
        </div>
    </div>
    <div class="navigation-container">
        <div class="controls">
            <div class="navigation-header">
                <h2>Kalender</h2>
            </div>
            <!-- Dropdowns to select month and year -->
            <form method="GET">


                <div class="dropdown month-dropdown">
                    <label for="months">Monat: </label>
                    <select id="months" name="month" onchange="this.form.submit()">
                        <?php
                        // Generate options for selecting a month
                        for ($i = 1; $i <= 12; $i++) {
                            echo '<option value="' . $i . '"' . ($month == $i ? ' selected' : '') . '>' . date('F', mktime(0, 0, 0, $i, 1)) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="dropdown year-dropdown">
                    <label for="years">Jahr: </label>
                    <select id="years" name="year" onchange="this.form.submit()">
                        <?php
                        // Generate options for selecting a year
                        for ($i = date('Y') - 5; $i <= date('Y') + 5; $i++) {
                            echo '<option value="' . $i . '"' . ($year == $i ? ' selected' : '') . '>' . $i . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </form>
            <!-- Navigation links for today, previous month, and next month -->
            <div class="btn-container">
                <a class="todayBtn" href="?month=<?php echo date('m'); ?>&year=<?php echo date('Y'); ?>">Today</a>
                <a class="prevBtn" href="?month=<?php echo date('m', $previousDate); ?>&year=<?php echo date('Y', $previousDate); ?>">
                    <span class="mdil mdil-chevron-left"></span>
                </a>
                <a class="nextBtn" href="?month=<?php echo date('m', $nextDate); ?>&year=<?php echo date('Y', $nextDate); ?>">
                    <span class="mdil mdil-chevron-right"></span>
                </a>
                <?php

                ?>
            </div>
        </div>
    </div>
</body>

</html>