const hamMenuBtn = document.querySelector("#ham-menu-btn");
const aSide = document.querySelector("#a-side");
const aSideNav = document.querySelector("#a-side-nav");

const checkOutBtns = document.querySelectorAll("#btn_checkout");
const checkInBtns = document.querySelectorAll("#btn_checkin");

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

hamMenuBtn.addEventListener("click", toggleAside);

window.addEventListener("resize", () => {
  if (
    window.innerWidth >= 600 &&
    aSideNav.classList.contains("show-mobile-nav")
  ) {
    toggleAside();
  }
});

checkOutBtns.forEach((checkOutBtn) => {
  const radioBtn = checkOutBtn.querySelector("#radio");
  radioBtn.addEventListener("click", () => {
    const prevSelected = [...checkOutBtns].find((check) =>
      check.classList.contains("date-selected")
    );
    toggleDate(checkOutBtn, prevSelected);
  });
});

checkInBtns.forEach((checkInBtn, index) => {
  const radioBtn = checkInBtn.querySelector("#radio");
  radioBtn.addEventListener("click", () => {
    const prevSelected = [...checkInBtns].find((check) =>
      check.classList.contains("date-selected")
    );
    toggleDate(checkInBtn, prevSelected);
    checkOutBtns.forEach((checkOut, checkIdx) => {
      if (checkIdx <= index) {
        checkOut.setAttribute("disabled", true);
        checkOut.classList.replace("current-month", "offset-month");
      } else {
        checkOut.setAttribute("disabled", false);
        checkOut.classList.replace("offset-month", "current-month");
      }
    });
  });
});
