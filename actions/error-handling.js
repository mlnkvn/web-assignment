function checkText(a) {
    return a != "" && a != null
}

function checkField(fieldName) {
    var a = document.getElementById(fieldName).value;
    var errorName = ["error", fieldName].join('-')
    if (!checkText(document.getElementById(fieldName).value)) {
        document.getElementById(errorName).style.visibility = "visible";
        event.preventDefault();
    } else {
        document.getElementById(errorName).style.visibility = "hidden";
    }
}

function checkPwd(pwd1, pwd2, pwd3) {
    var a = document.getElementById(pwd1).value;
    var errorName = ["error", pwd1].join('-')
    if (!checkText(document.getElementById(pwd1).value) && (checkText(document.getElementById(pwd2).value) || checkText(document.getElementById(pwd3).value))) {
        document.getElementById(errorName).style.visibility = "visible";
        event.preventDefault();
    } else {
        document.getElementById(errorName).style.visibility = "hidden";
    }
}

function checkForm() {
    var fieldArray = ["userFullName", "userLogin", "userEmail", "inputAddress"];
    var pwdArray = ["oldPwd", "newPwd","newPwdRepeat"];
    for (let i = 0; i < fieldArray.length; i++) {
        checkField(fieldArray[i]);
    }
    for (let i = 0; i < pwdArray.length; i++) {
        checkPwd(pwdArray[i], pwdArray[(i + 1) % 3], pwdArray[(i + 2) % 3]);
    }
    return true;
}

