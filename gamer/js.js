//JavaScript

//login
const Lbtn = document.querySelector("#loginBtn");
Lbtn.disabled = true;
const userName = document.querySelector("#username");
const passwordInput = document.querySelector("#password");

function submitForm(event) {
  if(userName.value !== ""&&passwordInput.value !== ""){
    Lbtn.disabled = false;
  }else {
    Lbtn.disabled = true;
  }
}

userName.addEventListener("change", submitForm);
passwordInput.addEventListener("change", submitForm);



//register
const Rbtn = document.querySelector("#registerBtn");
Rbtn.disabled = true;
const confirm = document.querySelector("#confirm");
const Pinfo = document.querySelector("#info");

function submitRegisterForm(event) {
  if(userName.value !== ""&&passwordInput.value !== ""&&confirm.value !== ""){
    Rbtn.disabled = false;
  }else {
    Rbtn.disabled = true;
  }

  if(passwordInput.value !== confirm.value){
    confirm.setAttribute("border-color","red");
    Pinfo.innerHTML = "Both Password and Confirm Password need to be equal.";
    Rbtn.disabled = true;
  }else{
    confirm.setAttribute("border-color","red");
    Pinfo.innerHTML = "";
    Rbtn.disabled = false;
  }
}

userName.addEventListener("change", submitRegisterForm);
passwordInput.addEventListener("change", submitRegisterForm);
confirm.addEventListener("change", submitRegisterForm);

Pinfo.innerHTML = confirm.getAttribute("border-color");

