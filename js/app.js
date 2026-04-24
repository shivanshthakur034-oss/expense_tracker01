document.addEventListener("DOMContentLoaded", function () {
  var wrapper = document.getElementById("wrapper");
  var menuToggle = document.getElementById("menu-toggle");

  if (wrapper && menuToggle) {
    menuToggle.addEventListener("click", function (event) {
      event.preventDefault();
      wrapper.classList.toggle("toggled");
    });
  }

  var closeDropdowns = function (currentToggle) {
    var toggles = document.querySelectorAll(".dropdown-toggle");

    toggles.forEach(function (toggle) {
      if (currentToggle && toggle === currentToggle) {
        return;
      }

      var menu = toggle.parentElement
        ? toggle.parentElement.querySelector(".dropdown-menu")
        : null;

      toggle.setAttribute("aria-expanded", "false");

      if (menu) {
        menu.classList.remove("show");
      }
    });
  };

  var dropdownToggles = document.querySelectorAll(".dropdown-toggle");
  dropdownToggles.forEach(function (toggle) {
    toggle.addEventListener("click", function (event) {
      var menu = toggle.parentElement
        ? toggle.parentElement.querySelector(".dropdown-menu")
        : null;

      if (!menu) {
        return;
      }

      event.preventDefault();

      var isOpen = menu.classList.contains("show");
      closeDropdowns(toggle);

      if (!isOpen) {
        menu.classList.add("show");
        toggle.setAttribute("aria-expanded", "true");
      }
    });
  });

  document.addEventListener("click", function (event) {
    if (!event.target.closest(".dropdown")) {
      closeDropdowns();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closeDropdowns();
    }
  });

  var avatar = document.querySelector(".avatar");
  var fileUploads = document.querySelectorAll(".file-upload");

  fileUploads.forEach(function (input) {
    input.addEventListener("change", function () {
      var file = input.files && input.files[0];

      if (!file || !avatar) {
        return;
      }

      var reader = new FileReader();
      reader.onload = function (loadEvent) {
        avatar.setAttribute("src", loadEvent.target.result);
      };
      reader.readAsDataURL(file);
    });
  });
});
