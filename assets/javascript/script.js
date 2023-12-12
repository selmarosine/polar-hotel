const hamMenuBtn = document.querySelector("#ham-menu-btn");
const aSide = document.querySelector("#a-side");
const aSideNav = document.querySelector("#a-side-nav");

const checkOutBtns = document.querySelectorAll("#btn-checkout");
const checkInBtns = document.querySelectorAll("#btn-checkin");
let checkInIndex = null;
let checkOutIndex = null;

const activityChecks = document.querySelectorAll("#activity-check");
let activityTotal = 0;
const totalPrice = document.querySelector("#total-price");
let baseRoomPrice = null;
if (totalPrice !== null) {
  baseRoomPrice = parseInt(totalPrice.textContent.split("$")[1]);
}

const toggleAside = () => {
  const [firstLine, secondLine, thirdLine] = hamMenuBtn.children;

  firstLine.classList.toggle("ham-line-top");
  secondLine.style.width = firstLine.classList.contains("ham-line-top")
    ? 0
    : "30px";
  thirdLine.classList.toggle("ham-line-bottom");

  if (aSideNav.classList.contains("show-mobile-nav")) {
    // Close aside
    aSideNav.classList.remove("show-mobile-nav");
    setTimeout(() => {
      aSide.style.display = "none";
    }, 300);
  } else {
    // Open aside
    aSide.style.display = "flex";
    setTimeout(() => {
      aSideNav.classList.add("show-mobile-nav");
    }, 10);
  }
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
  const newPrice = baseRoomPrice * daysBooked;

  totalPrice.textContent = `$${newPrice + activityTotal}`;
};

hamMenuBtn.addEventListener("click", toggleAside);

window.addEventListener("resize", () => {
  if (
    window.innerWidth >= 600 &&
    aSideNav.classList.contains("show-mobile-nav")
  ) {
    toggleAside();
  }
});

checkOutBtns.forEach((checkOutBtn, index) => {
  const radioBtn = checkOutBtn.querySelector("#radio");
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
  const radioBtn = checkInBtn.querySelector("#radio");
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
    const originalPrice = parseInt(totalPrice.textContent.split("$")[1]);

    activityTotal = activityCheck.checked
      ? activityTotal + price
      : activityTotal - price;

    totalPrice.textContent = `$${
      activityCheck.checked ? originalPrice + price : originalPrice - price
    }`;
  });
});
