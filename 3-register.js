function check () {
  let pass = document.getElementsByName("pass")[0].value,
      cpass = document.getElementsByName("cpass")[0].value;
  if (pass != cpass) {
    alert("Passwords do not match");
    return false;
  } else { return true; }
}