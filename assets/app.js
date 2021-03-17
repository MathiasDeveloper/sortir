/*
  Include all dependencies
 */
import "./boot/bootstrap.js";

// Profile dropdown
let profileDropdownButton = document.getElementById("profileDropdownButton");
let profileDropdownMenu = document.getElementById("profileDropdownMenu");
let profileDropdown = document.getElementById("profileDropdown");

profileDropdownButton.addEventListener("click", profileDropdownToggle);
function profileDropdownToggle() {
  profileDropdownMenu.classList.toggle("hidden");
}

document.addEventListener("click", function (event) {
  var isClickInside = profileDropdown.contains(event.target);

  if (!isClickInside) {
    profileDropdownMenu.classList.add("hidden");
  }
});

// Mobile menu
let mobileMenu = document.getElementById("mobile-menu");
let mobileMenuButton = document.getElementById("mobile-menu-button");

mobileMenuButton.addEventListener("click", mobileMenuToggle);
function mobileMenuToggle() {
  mobileMenu.classList.toggle("hidden");
}
