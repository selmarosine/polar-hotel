const checkOutBtns = document.querySelectorAll("#btn_check_out");
const checkInBtns = document.querySelectorAll("#btn_check_in");
let checkInIndex = null;
let checkOutIndex = null;

const activityChecks = document.querySelectorAll(".activity-check");
const totalPrice = document.querySelector("#total-price");
const discountSum = document.querySelector("#discount-sum");

const baseRoomPrice = parseInt(totalPrice.textContent.split("$")[1]);
let priceTracker = baseRoomPrice; // Keep track of price with out discount
let activityTotal = 0;

const setNewPrice = (price) => {
  totalPrice.textContent = `$${price}`;
};

const discountCheck = (price) => {
  // Offers is set in room.php
  const totalDiscount = offers.reduce((acc, offer) => {
    if (offer.requirement === "days") {
      const days = checkOutIndex - checkInIndex;

      if (days > offer.requirement_amount) {
        return acc + offer.discount;
      }
    } else if (offer.requirement === "price") {
      if (price > offer.requirement_amount) {
        return acc + offer.discount;
      }
    }

    return acc;
  }, 0);

  const discount = Math.floor((totalDiscount / 100) * price);
  discountSum.textContent = discount > 0 ? `- ${discount}` : "";

  setNewPrice(price - discount);
};

// Remove class from previously selected date and add it to to new date
const toggleDate = (date, prevDate) => {
  if (prevDate) {
    prevDate.classList.remove("date-selected");
  }
  date.classList.add("date-selected");
};

const priceChange = () => {
  // Check in and out must be selected
  if (checkOutIndex === null || checkInIndex === null) return;

  const daysBooked = checkOutIndex - checkInIndex;
  priceTracker = baseRoomPrice * daysBooked + activityTotal;

  if (offers.length > 0) {
    discountCheck(priceTracker);
  } else {
    setNewPrice(priceTracker);
  }
};

checkOutBtns.forEach((checkOut, index) => {
  const radioBtn = checkOut.querySelector(".radio");

  radioBtn.addEventListener("click", () => {
    if (checkOut.classList.contains("offset-month")) return; // prevent date not in current month to be clicked
    checkOutIndex = index + 1;

    // Find previous selected date
    const prevDate = [...checkOutBtns].find((check) =>
      check.classList.contains("date-selected")
    );

    toggleDate(checkOut, prevDate);
    priceChange();

    // If a user selects checkOut 31 and there is a booked date 24 this will find the booked date and disable all the dates before the booked date on the check in calender
    // To prevent a user booking date over a booked date
    let afterSelectedDate = [...checkInBtns].reverse();
    let originalIndex = -1;
    let bookedDateIndex = afterSelectedDate.findIndex((date, findIndex) => {
      const dateA = parseInt(date.textContent);
      const nextIndex =
        findIndex + 1 <= afterSelectedDate.length - 1
          ? findIndex + 1
          : findIndex;
      const dateB = parseInt(afterSelectedDate[nextIndex].textContent);
      const unReversedIndex = afterSelectedDate.length - 1 - findIndex;

      if (dateA - dateB > 1 && index > unReversedIndex) {
        originalIndex = unReversedIndex;
        return true;
      }

      return false;
    });

    bookedDateIndex = originalIndex;

    // Disable check in dates after selected check out date
    checkInBtns.forEach((checkIn, checkIdx) => {
      if (index <= checkIdx || checkIdx < bookedDateIndex) {
        checkIn.classList.replace("current-month", "offset-month");
        return;
      }
      checkIn.classList.replace("offset-month", "current-month");
    });
  });
});

checkInBtns.forEach((checkIn, index) => {
  const radioBtn = checkIn.querySelector(".radio");

  radioBtn.addEventListener("click", () => {
    if (checkIn.classList.contains("offset-month")) return;
    checkInIndex = index;

    const prevDate = [...checkInBtns].find((check) =>
      check.classList.contains("date-selected")
    );

    toggleDate(checkIn, prevDate);
    priceChange();

    // If a user selects checkIn 5 and there is a booked date 11 this will find the booked date and disable all the dates after the booked date on the check out calender
    // To prevent a user booking date over a booked date
    let afterSelectedDate = [...checkOutBtns];
    let bookedDateIndex = afterSelectedDate.findIndex((date, findIndex) => {
      // Find a gap > 1 day to find out if there is booked days
      const dateA = parseInt(date.textContent);
      const nextIndex =
        findIndex + 1 <= afterSelectedDate.length - 1
          ? findIndex + 1
          : findIndex;
      const dateB = parseInt(afterSelectedDate[nextIndex].textContent);

      if (dateB - dateA > 1 && index < findIndex) {
        return true;
      }
    });

    if (bookedDateIndex < 0) {
      bookedDateIndex = 999;
    }

    // Disable check out dates before selected check in date
    checkOutBtns.forEach((checkOut, checkIdx) => {
      if (checkIdx <= index || checkIdx > bookedDateIndex) {
        checkOut.classList.replace("current-month", "offset-month");
        return;
      }
      checkOut.classList.replace("offset-month", "current-month");
    });
  });
});

activityChecks.forEach((activityCheck) => {
  activityCheck.addEventListener("click", () => {
    const price = parseInt(activityCheck.getAttribute("data-price"));

    // Save activity prices on global scope for check in/out price.
    activityTotal = activityCheck.checked
      ? activityTotal + price
      : activityTotal - price;

    priceTracker = activityCheck.checked
      ? priceTracker + price
      : priceTracker - price;

    if (offers.length > 0) {
      discountCheck(priceTracker);
    } else {
      setNewPrice(priceTracker);
    }
  });
});
