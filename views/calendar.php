<?php

$selectedMonth = intval(date("m", mktime(0, 0, 0, 1, 1, 2024)));
$selectedYear = 2024;
$month = getMonth($selectedMonth, $selectedYear); // Create calender array

$identifier = $calendarIdentifier ?? ''; // If the calender is for check in or out.
?>
<div class="calendar-grid">
    <?php foreach ($month as $date) : ?>
        <div id="<?= $selectedMonth === $date["month"] ? 'btn' . $identifier : '' ?>" class="calendar-cell <?= $selectedMonth !== $date["month"] ? 'offset-month' : 'current-month contain-radio'; ?>">
            <?= $date["dayDate"] ?>
            <?php if ($selectedMonth === $date["month"]) : ?>
                <input required class="date-radio radio" type="radio" name="date<?= $identifier ?>" value="<?= $date["date"] ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>