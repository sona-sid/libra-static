
//contact us form validation
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm");

  form.addEventListener("submit", function (e) {
    e.preventDefault(); 
    let isValid = true;

    // Clear old errors
    document.querySelectorAll(".error").forEach(el => el.textContent = "");
    document.querySelectorAll("input, textarea").forEach(el => el.classList.remove("invalid"));

    // Validation rules
    const fields = [
      { id: "firstName", label: "First name", regex: /^[A-Za-z]+$/, error: "Only letters allowed" },
      { id: "lastName", label: "Last name", regex: /^[A-Za-z]+$/, error: "Only letters allowed" },
      { id: "email", label: "Email", regex: /^[^ ]+@[^ ]+\.[a-z]{2,3}$/, error: "Invalid email format" },
      { id: "phone", label: "Phone number", regex: /^[0-9+\-\s]{7,15}$/, error: "Invalid phone number" },
      { id: "message", label: "Message", regex: /^.{5,}$/, error: "Message must be at least 5 characters" }
    ];

    // Check for empty + regex
    fields.forEach(field => {
      const input = document.getElementById(field.id);
      const value = input.value.trim();

      if (value === "") {
        showError(field.id, `${field.label} is required`);
        input.classList.add("invalid");
        isValid = false;
      } else if (!field.regex.test(value)) {
        showError(field.id, field.error);
        input.classList.add("invalid");
        isValid = false;
      }
    });

    // Check subject (radio buttons)
    const subject = document.querySelector("input[name='subject']:checked");
    if (!subject) {
      document.querySelector(".subject .error").textContent = "Please select a subject";
      isValid = false;
    }

    if (isValid) {
      alert("Form submitted successfully!");
      form.reset();
    }
  });

  // Show error message
  function showError(id, message) {
    document.querySelector(`#${id} + .error`).textContent = message;
  }
});


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

hamburger.addEventListener("click", () => {
  navLinks.classList.toggle("active");
  hamburger.classList.toggle("open");
});
