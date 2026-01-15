// Brinth Register JS (Final Cleaned & Fixed)
let usernameValid = false;
let emailValid = false;
let passwordValid = false;

function updateRegisterButtonState() {
    const registerBtn = document.getElementById("register-btn");
    if (registerBtn)
        registerBtn.disabled = !(usernameValid && emailValid && passwordValid);
}

function isStrongPassword(password) {
    // At least 8 chars, 1 upper, 1 lower, 1 digit, 1 special char
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    return regex.test(password);
}

document.addEventListener("DOMContentLoaded", () => {
    const usernameInput = document.getElementById("reg-username");
    const usernameStatus = document.getElementById("reg-username-status");
    const emailInput = document.getElementById("reg-email");
    const emailStatus = document.getElementById("reg-email-status");
    const passwordInput = document.getElementById("reg-password");
    const passwordStatus = document.getElementById("reg-password-status");
    const dobInput = document.getElementById("reg-dob");

    // Username live check
    usernameInput.addEventListener("input", () => {
        const username = usernameInput.value.trim();
        usernameValid = false;
        updateRegisterButtonState();

        if (username.length < 3) {
            usernameStatus.textContent = "I think you should try more than that.";
            usernameStatus.style.color = "#db6109";
            return;
        }

        usernameStatus.textContent = "Checking…";
        usernameStatus.style.color = "black";

        fetch(`check_username.php?username=${encodeURIComponent(username)}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.available) {
                    usernameStatus.textContent = data.message;
                    usernameStatus.style.color = "green";
                    usernameValid = true;
                } else {
                    usernameStatus.textContent = data.message;
                    usernameStatus.style.color = "red";
                }
                updateRegisterButtonState();
            })
            .catch(() => {
                usernameStatus.textContent = "Error checking username.";
                usernameStatus.style.color = "red";
                updateRegisterButtonState();
            });
    });

    // Email live check
    emailInput.addEventListener("input", () => {
        const email = emailInput.value.trim();
        emailValid = false;
        updateRegisterButtonState();

        const emailRegex = /^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;
        const badWords = ['boobs', 'dick', 'ass', 'blowjob', 'porn', '69', 'xxx', 'fuck', 'check', 'test', 'spam'];
        const emailLower = email.toLowerCase();

        if (!emailRegex.test(email)) {
            emailStatus.textContent = "That's not a valid email.";
            emailStatus.style.color = "red";
            return;
        }

        if (
            email.includes('xn--') ||
            badWords.some(word => emailLower.includes(word)) ||
            emailLower.match(/@[a-z]{4,10}[0-9]{3,}/) ||
            emailLower.length < 10
        ) {
            emailStatus.textContent = "This email looks fake or inappropriate.";
            emailStatus.style.color = "red";
            return;
        }

        emailStatus.textContent = "Checking…";
        emailStatus.style.color = "black";

        fetch(`check_email.php?email=${encodeURIComponent(email)}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.available) {
                    emailStatus.textContent = data.message;
                    emailStatus.style.color = "green";
                    emailValid = true;
                } else {
                    emailStatus.textContent = data.message;
                    emailStatus.style.color = "red";
                }
                updateRegisterButtonState();
            })
            .catch(() => {
                emailStatus.textContent = "Error checking email";
                emailStatus.style.color = "red";
                updateRegisterButtonState();
            });
    });

    // Password strength check
    passwordInput.addEventListener("input", () => {
        const password = passwordInput.value;
        passwordValid = false;
        updateRegisterButtonState();

        if (!isStrongPassword(password)) {
            passwordStatus.innerHTML =
                "Password must be and include:<br> At least 8 characters<br>Uppercase<br>Lowercase<br>Number<br>Special character.";
            passwordStatus.style.color = "#db6109";
        } else {
            passwordStatus.textContent = "I like this one";
            passwordStatus.style.color = "green";
            passwordValid = true;
        }

        updateRegisterButtonState();
    });

    // Block future date of birth
    dobInput.addEventListener("input", () => {
        const today = new Date().toISOString().split('T')[0];
        if (dobInput.value > today) {
            dobInput.setCustomValidity("You can't be born in the future.");
            dobInput.reportValidity();
        } else {
            dobInput.setCustomValidity("");
        }
    });

    updateRegisterButtonState();
});
