<?php

$selectedMonth = intval(date("m", mktime(0, 0, 0, 1, 1, 2024)));
$selectedYear = 2024;
$month = getMonth($selectedMonth, $selectedYear); // Create calender array

$identifier = $calendarIdentifier ?? ''; // If the calender is for check in or out.

?>
<div class="calendar-grid">
    <?php foreach ($month as $date) :
        $dateIsBooked = isDateBooked(strtotime($date["date"]), $bookedCheckIn, $bookedCheckOut);
    ?>
        <div id="<?= ($selectedMonth === $date["month"] && !$dateIsBooked) ? 'btn_' . $identifier : '' ?>" class="calendar-cell
        <?= $selectedMonth !== $date["month"] ? 'offset-month' : (!$dateIsBooked ? 'current-month contain-radio' : ""); ?>
        <?= $dateIsBooked ? "date-is-booked" : ""; ?>" title="<?= $dateIsBooked ? $date["date"] . " is already booked" : "Please select a date"; ?>">
            <?= $date["dayDate"] ?>
            <?php if ($selectedMonth === $date["month"] && !$dateIsBooked) : ?>
                <input required class="date-radio radio" type="radio" name="date<?= $identifier ?>" value="<?= $date["date"] ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
