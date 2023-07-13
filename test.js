function bindEventListeners() {
    document.querySelector(".signin-btn").addEventListener("click", function() {
        const loginForm = document.querySelector(".form-background");
        if (loginForm.style.display === "none") {
          loginForm.style.display = "flex";
        } else {
          loginForm.style.display = "none";
        }
      });

    document.querySelector(".moreinfo-btn").addEventListener("click", function() {
    });
}

document.addEventListener("DOMContentLoaded", function() {
    bindEventListeners();
});

window.onclick = function(event) {
  const formContainer = document.querySelector('.form-container');
  if (!formContainer.contains(event.target)) {
    console.log("Clicked outside of .form-container");
  }
};