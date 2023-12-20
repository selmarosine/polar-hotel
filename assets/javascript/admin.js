const imageMain = document.querySelector("#image-main");
const imageSecondaryLeft = document.querySelector("#images-secondary-left");
const imageSecondaryRight = document.querySelector("#images-secondary-right");

const displayImage = (imageElement, file) => {
  const reader = new FileReader();

  reader.onload = () => {
    const url = reader.result;
    imageElement.style.backgroundImage = `url(${url})`;
  };

  reader.readAsDataURL(file);
};

imageMain.addEventListener("input", (ev) => {
  displayImage(ev.target.parentElement, ev.target.files[0]);
});

if (imageSecondaryLeft !== null) {
  imageSecondaryLeft.addEventListener("input", (ev) => {
    displayImage(ev.target.parentElement, ev.target.files[0]);
  });
}

if (imageSecondaryRight !== null) {
  imageSecondaryRight.addEventListener("input", (ev) => {
    displayImage(ev.target.parentElement, ev.target.files[0]);
  });
}
