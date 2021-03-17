/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.css";
import "./styles/extras.css";

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from "jquery";
// import datatable from "datatables";

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
