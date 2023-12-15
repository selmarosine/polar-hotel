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

const toggleDate = (date, prevSelected) => {
  if (prevSelected) {
    prevSelected.classList.remove("date-selected");
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

checkOutBtns.forEach((checkOutBtn, index) => {
  const radioBtn = checkOutBtn.querySelector(".radio");
  radioBtn.addEventListener("click", () => {
    if (checkOutBtn.classList.contains("offset-month")) return;
    const prevSelected = [...checkOutBtns].find((check) =>
      check.classList.contains("date-selected")
    );
    toggleDate(checkOutBtn, prevSelected);
    checkOutIndex = index + 1;

    priceChange();

    checkInBtns.forEach((checkIn, checkIdx) => {
      if (checkIdx >= index) {
        checkIn.classList.replace("current-month", "offset-month");
      } else {
        checkIn.classList.replace("offset-month", "current-month");
      }
    });
  });
});

checkInBtns.forEach((checkInBtn, index) => {
  const radioBtn = checkInBtn.querySelector(".radio");
  radioBtn.addEventListener("click", () => {
    if (checkInBtn.classList.contains("offset-month")) return;
    const prevSelected = [...checkInBtns].find((check) =>
      check.classList.contains("date-selected")
    );

    toggleDate(checkInBtn, prevSelected);
    checkInIndex = index;

    priceChange();

    checkOutBtns.forEach((checkOut, checkIdx) => {
      if (checkIdx <= index) {
        checkOut.classList.replace("current-month", "offset-month");
      } else {
        checkOut.classList.replace("offset-month", "current-month");
      }
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
