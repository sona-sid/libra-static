//home swiper
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

// home banner animation
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

//section2 animation
document.addEventListener("DOMContentLoaded", () => {
  const section2 = document.querySelector(".section2");

  if (section2) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            section2.classList.add("animate-in");
            observer.unobserve(section2); // run only once
          }
        });
      },
      { threshold: 0.2 } // triggers when 20% of section is visible
    );

    observer.observe(section2);
  }
});

/* services animations */
document.addEventListener("DOMContentLoaded", () => {
  const servicesSection = document.querySelector(".services");

  if (servicesSection) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            servicesSection.classList.add("animate-in");
            observer.unobserve(servicesSection); // run only once
          }
        });
      },
      { threshold: 0.2 } // trigger when 20% is visible
    );

    observer.observe(servicesSection);
  }
});

/* tech banner animation */

document.addEventListener("DOMContentLoaded", () => {
  const brainImage = document.getElementById("brainImage");
  const techSection = document.getElementById("techSection");

  function handleScroll() {
    const sectionTop = techSection.getBoundingClientRect().top;
    const windowHeight = window.innerHeight;

    if (sectionTop < windowHeight - 100) {
      brainImage.classList.add("show");
      window.removeEventListener("scroll", handleScroll); 
    }
  }

  window.addEventListener("scroll", handleScroll);
});


