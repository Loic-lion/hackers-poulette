function validateForm(event) {
  var name = document.getElementsByName("name")[0].value;
  var firstname = document.getElementsByName("firstname")[0].value;
  var email = document.getElementsByName("email")[0].value;
  var description = document.getElementsByName("description")[0].value;
  var valid = true;

  var errorElement = document.getElementById("error");
  errorElement.textContent = "";

  if (name.length < 2 || name.length > 255) {
    errorElement.textContent += "*Name must be between 2 and 255 characters";
    valid = false;
  }

  if (firstname.length < 2 || firstname.length > 255) {
    errorElement.textContent +=
      " *First Name must be between 2 and 255 characters";
    valid = false;
  }

  if (!validateEmail(email)) {
    errorElement.textContent += " *Invalid email address";
    valid = false;
  }

  if (description.length < 2 || description.length > 1000) {
    errorElement.textContent +=
      " *Description must be between 2 and 1000 characters";
    valid = false;
  }

  if (!valid) {
    event.preventDefault();
  }
}

function validateEmail(email) {
  var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

var form = document.querySelector("form");
form.addEventListener("submit", validateForm);
