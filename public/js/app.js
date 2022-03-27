// const passwordField = document.querySelector(
//   '.form .field input[type="password"]'
// );
// const toggleBtn = document.querySelector(".form .field i");
const search = document.querySelector(".users .search input");
const searchBtn = document.querySelector(".users .search button");
const usersList = document.querySelector('.users-list')


searchBtn.addEventListener("click", function() {
    search.classList.toggle("active");
    search.focus();
    searchBtn.classList.toggle("active");
});

// const errorText = document.querySelector(".error-txt");

// // // Search users



// // show the password hidden
// toggleBtn.addEventListener("click", () => {
//   if (passwordField.type == "password") {
//     passwordField.type = "text";
//     toggleBtn.classList.add("active");
//   } else {
//     passwordField.type = "password";
//     toggleBtn.classList.remove("active");
//   }
// });

// // // register user


// //login

