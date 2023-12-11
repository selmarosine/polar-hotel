<?php

$selectedMonth = intval(date("m", mktime(0, 0, 0, 1, 1, 2024)));
$selectedYear = intval(date("Y", mktime(0, 0, 0, 1, 1, 2024)));
$month = getMonth($selectedMonth, $selectedYear);

$identifier = $calendarIdentifier ?? '';

// Looping 42 times to get 6 rows with 7 columns for calender view
?>
<div class="calendar-grid">
    <?php foreach ($month as $date) : ?>
        <div id="<?= $selectedMonth === $date["month"] ? 'btn' . $identifier : '' ?>" class="calendar-cell <?= $selectedMonth !== $date["month"] ? 'offset-month' : 'current-month contain-radio'; ?>">
            <?= $date["dayDate"] ?>
            <?php if ($selectedMonth === $date["month"]) : ?>
                <input required id="radio" class="date-radio" type="radio" name="date<?= $identifier ?>" value="<?= $date["date"] ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>