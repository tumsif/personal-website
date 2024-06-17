const inputcv = document.getElementById("cv");
const labelcv = document.getElementById("cv-label");
const registerform = document.getElementById("register-course");

if (inputcv) {
  inputcv.addEventListener("change", (e) => {
    let previousLabel = labelcv.innerText;
    let fileName = "";
    fileName = e.target.value.split("\\").pop();

    if (fileName !== "") {
      labelcv.innerText = fileName;
    } else {
      labelcv.innerText = previousLabel;
    }
  });
}

/**showing register course form */
function showRegisterForm() {
  registerform.classList.toggle("overlay");
}

function hideRegisterForm() {
  registerform.classList.remove("overlay");
}
