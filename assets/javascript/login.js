function bindEventListeners() {
  const signinButton = document.querySelector(".signin-btn");
  const formBackground = document.querySelector(".form-background");
  const formContainer = document.querySelector(".form-container");

  signinButton.addEventListener("click", function () {
      if (formBackground.style.display === "none" || formBackground.style.display === "") {
          formBackground.style.display = "flex";
      } else {
          formBackground.style.display = "none";
      }
  });

  formContainer.addEventListener("click", function (event) {
      event.stopPropagation(); 
  });

  document.addEventListener("click", function (event) {
    console.log("123");
      if (event.target !== formContainer && event.target !== signinButton) {
          formBackground.style.display = "none";
      }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  bindEventListeners();
});