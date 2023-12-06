const hamMenuBtn = document.querySelector('#ham-menu-btn');
const aSide = document.querySelector('#a-side');
const aSideNav = document.querySelector('#a-side-nav');

const toggleAside = () => {
  const [firstLine, secondLine, thirdLine] = hamMenuBtn.children;

  firstLine.classList.toggle('ham-line-top');
  secondLine.style.width = firstLine.classList.contains('ham-line-top')
    ? 0
    : '30px';
  thirdLine.classList.toggle('ham-line-bottom');

  if (aSideNav.classList.contains('show-mobile-nav')) {
    // Close aside
    aSideNav.classList.remove('show-mobile-nav');
    setTimeout(() => {
      aSide.style.display = 'static';
    }, 300);
  } else {
    // Open aside
    aSide.style.display = 'hidden';
    setTimeout(() => {
      aSideNav.classList.add('show-mobile-nav');
    }, 10);
  }
};

hamMenuBtn.addEventListener('click', toggleAside);

window.addEventListener('resize', () => {
  if (
    window.innerWidth >= 600 &&
    aSideNav.classList.contains('show-mobile-nav')
  ) {
    toggleAside();
  }
});
