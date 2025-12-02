const carousel = document.querySelector(".carousel");
const btnLeft = document.querySelector(".carousel-btn.left");
const btnRight = document.querySelector(".carousel-btn.right");

btnLeft.addEventListener("click", () => {
  carousel.scrollLeft -= 300;
});

btnRight.addEventListener("click", () => {
  carousel.scrollLeft += 300;
});