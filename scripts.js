var inputcv = document.getElementById("cv");
let labelcv = document.getElementById("cv-label");
let previousLabel = labelcv.innerText;

inputcv.addEventListener("change", (e) => {
  let fileName = "";
  fileName = e.target.value.split("\\").pop();

  if (fileName !== "") {
    labelcv.innerText = fileName;
  } else {
    labelcv.innerText = previousLabel;
  }
});
