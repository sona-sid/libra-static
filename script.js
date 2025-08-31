
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
  const techSection = document.querySelector(".tech-section");
  if (!techSection) return;

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          techSection.classList.add("animate-in");
          io.unobserve(techSection);
        }
      });
    },
    { threshold: 0.25 } // trigger when ~25% of the section is visible
  );

  io.observe(techSection);
});


//contact us form validation
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm");
  const successMessage = document.getElementById("successMessage");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    let isValid = true;

    // Clear old errors
    document.querySelectorAll(".error").forEach((el) => {
      el.textContent = "";
      el.classList.remove("show"); // hide errors
    });

    document
      .querySelectorAll("input, textarea")
      .forEach((el) => el.classList.remove("invalid"));

    // Validation rules
    const fields = [
      {
        id: "firstName",
        label: "First name",
        regex: /^[A-Za-z]{2,}$/,
        error: "Only letters allowed (min 2)",
      },
      {
        id: "lastName",
        label: "Last name",
        regex: /^[A-Za-z]{2,}$/,
        error: "Only letters allowed (min 2)",
      },
      {
        id: "email",
        label: "Email",
        regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/,
        error: "Invalid email format",
      },
      {
        id: "phone",
        label: "Phone number",
        regex: /^\+?[0-9]{7,15}$/,
        error: "Phone must be digits only (7-15 digits)",
      },
      {
        id: "message",
        label: "Message",
        regex: /^.{5,}$/,
        error: "Message must be at least 5 characters",
      },
    ];

    // Check each field
    fields.forEach((field) => {
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
      const subjectError = document.querySelector(".subject .error");
      subjectError.textContent = "Please select a subject";
      subjectError.classList.add("show");
      isValid = false;
    }

    if (isValid) {
      form.reset();

      // Show success message
      successMessage.style.display = "block";
      successMessage.style.opacity = "1";

      // Hide after 20s (fade out)
      setTimeout(() => {
        successMessage.style.opacity = "0";
        setTimeout(() => {
          successMessage.style.display = "none";
        }, 1000);
      }, 20000);
    }
  });

  // Show error message
  function showError(id, message) {
    const input = document.getElementById(id);
    const errorEl = input.nextElementSibling; // assumes <span class="error"></span> follows input
    if (errorEl) {
      errorEl.textContent = message;
      errorEl.classList.add("show"); // display:block
    }
  }
});

//quote form validation
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("quoteForm");
  const successMessage = document.getElementById("successMessage");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    let isValid = true;

    // Clear old errors
    document.querySelectorAll(".error").forEach((el) => {
      el.textContent = "";
      el.classList.remove("show");
    });
    document
      .querySelectorAll("input, textarea, select")
      .forEach((el) => el.classList.remove("invalid"));

    // Validation rules
    const fields = [
      {
        id: "fullname",
        label: "Full Name",
        regex: /^[A-Za-z\s]{2,}$/,
        error: "Enter a valid name (letters only, min 2 chars)",
      },
      {
        id: "email",
        label: "Email",
        regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/,
        error: "Invalid email format",
      },
      {
        id: "phone",
        label: "Phone Number",
        regex: /^\+?[0-9]{7,15}$/,
        error: "Phone must be digits only (7–15 digits)",
      },
      {
        id: "service",
        label: "Service",
        regex: /^(?!\s*$).+/, // not empty
        error: "Please select a service",
      },
      {
        id: "quantity",
        label: "Quantity",
        regex: /^[1-9][0-9]*$/,
        error: "Enter a valid quantity (greater than 0)",
      },
      {
        id: "material",
        label: "Material",
        regex: /^(?!\s*$).+/, // not empty
        error: "Please select a material",
      },
      {
        id: "size",
        label: "Size",
        regex: /^.{2,}$/, // at least 2 characters
        error: "Size is required (e.g. A4, A5, Custom)",
      },
    ];

    // Validate normal fields
    fields.forEach((field) => {
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

    // Validate file upload
    const fileInput = document.getElementById("file");
    if (!fileInput.files.length) {
      showError("file", "File upload is required");
      fileInput.classList.add("invalid");
      isValid = false;
    }

    if (isValid) {
      form.reset();

      // Show success message
      successMessage.style.display = "block";
      successMessage.style.opacity = "1";

      // Hide after 15s
      setTimeout(() => {
        successMessage.style.opacity = "0";
        setTimeout(() => {
          successMessage.style.display = "none";
        }, 1000); // wait for fade
      }, 15000);
    }
  });

  function showError(id, message) {
    const input = document.getElementById(id);
    const errorEl = input.parentElement.querySelector(".error");
    if (errorEl) {
      errorEl.textContent = message;
      errorEl.classList.add("show"); // make it visible
    }
  }
});

//fotter form
document
  .getElementById("subscribeForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    let isValid = true;

    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");

    // Name validation (only letters and spaces, min 2 chars)
    const nameRegex = /^[a-zA-Z\s]{2,}$/;
    if (!nameRegex.test(nameInput.value.trim())) {
      nameError.classList.add("show");
      isValid = false;
    } else {
      nameError.classList.remove("show");
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value.trim())) {
      emailError.classList.add("show");
      isValid = false;
    } else {
      emailError.classList.remove("show");
    }

    if (isValid) {
      alert("Form submitted successfully!");
      // here you can send data to backend
      this.reset();
    }
  });

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
