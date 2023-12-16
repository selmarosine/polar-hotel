const checkOutBtns = document.querySelectorAll("#btn_check_out");
const checkInBtns = document.querySelectorAll("#btn_check_in");
let checkInIndex = null;
let checkOutIndex = null;

const activityChecks = document.querySelectorAll(".activity-check");
const totalPrice = document.querySelector("#total-price");
const totalCost = document.querySelector("#total-cost");
const discountSum = document.querySelector("#discount-sum");

const baseRoomPrice = parseInt(totalPrice.textContent.split("$")[1]);
let priceTracker = baseRoomPrice; // Keep track of price with out discount
let activityTotal = 0;

const setNewPrice = (price) => {
  totalCost.value = price; // update the hidden input for php
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

const toggleDate = (date, prevDate) => {
  if (prevDate) {
    prevDate.classList.remove("date-selected");
  }
  date.classList.add("date-selected");
};

const priceChange = () => {
  if (checkOutIndex === null || checkInIndex === null) return;

  const daysBooked = checkOutIndex - checkInIndex;
  const newPrice = baseRoomPrice * daysBooked + activityTotal;
  priceTracker = newPrice;

  if (offers.length > 0) {
    discountCheck(newPrice);
  } else {
    setNewPrice(newPrice);
  }
};

checkOutBtns.forEach((checkOut, index) => {
  const radioBtn = checkOut.querySelector(".radio");

  radioBtn.addEventListener("click", () => {
    if (checkOut.classList.contains("offset-month")) return;
    checkOutIndex = index + 1;

    const prevDate = [...checkOutBtns].find((check) =>
      check.classList.contains("date-selected")
    );

    toggleDate(checkOut, prevDate);
    priceChange();

    let afterSelectedDate = [...checkInBtns].reverse();
    let originalIndex = -1;
    let bookedDateIndex = afterSelectedDate.findIndex((date, findIndex) => {
      // Find a gap > 1 day to find out if there is booked days
      const dateA = parseInt(date.textContent);
      const nextIndex =
        findIndex + 1 <= afterSelectedDate.length - 1
          ? findIndex + 1
          : findIndex;
      const dateB = parseInt(afterSelectedDate[nextIndex].textContent);
      const unReversedIndex = afterSelectedDate.length - 1 - findIndex;

      if (dateA - dateB > 1 && index > unReversedIndex) {
        console.log({ index, unReversedIndex });
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

    const newPrice = activityCheck.checked
      ? priceTracker + price
      : priceTracker - price;

    priceTracker = newPrice;

    discountCheck(newPrice);
  });
});
