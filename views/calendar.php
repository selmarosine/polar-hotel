<?php

$selectedMonth = intval(date("m"));
$selectedYear = intval(date("Y"));
$month = getMonth($selectedMonth, $selectedYear);

// Looping 42 times to get 6 rows with 7 columns for calender view
?>
<div class="calendar-grid">
    <?php foreach ($month as $date) : ?>
        <div id="<?= $selectedMonth === $date["month"] ? 'calendar-btn' : '' ?>" class="calendar-cell <?= $selectedMonth !== $date["month"] ? 'offset-month' : 'current-month'; ?>">
            <?= $date["dayDate"] ?>
        </div>
    <?php endforeach; ?>
</div>