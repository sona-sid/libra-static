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


