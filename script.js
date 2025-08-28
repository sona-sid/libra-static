const swiper = new Swiper(".printing-slider .swiper", {
  slidesPerView: "auto",
  centeredSlides: true,
  spaceBetween: 24,
  loop: true,
  loopedSlides: 4,
  loopAdditionalSlides: 4,
  grabCursor: true,
  initialSlide: 1, // 👈 start at 2nd slide (0-based index)
  pagination: {
    el: ".printing-slider .swiper-pagination",
    clickable: true,
    type: "bullets",
    renderBullet: function (index, className) {
      if (index < 3) {
        return '<span class="' + className + '"></span>';
      }
      return "";
    },
  },
  on: {
    init: function () {
      // force update active bullet
      this.pagination.update();
    },
  },
});


const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");


document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM fully loaded and parsed");
  const logo = document.querySelector(".hero-logo img");
  const heroImg = document.querySelector(".hero-image-wrapper img");
  const heroText = document.querySelector(".hero-text");

  if (logo) {
    logo.classList.add("animate-logo");
  }
  if (heroImg) {
    setTimeout(() => {
      heroImg.classList.add("animate-hero-image");
    }, 300); // delay for smoothness
  }
  if (heroText) {
    setTimeout(() => {
      heroText.classList.add("animate-hero-text");
    }, 600); // delay so it comes after hero image
  }
});

hamburger.addEventListener("click", () => {
  navLinks.classList.toggle("active");
  hamburger.classList.toggle("open");
});

