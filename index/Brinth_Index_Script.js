function handleForgotFormSubmit(e) {
    e.preventDefault();
    const email = e.target.recovery_email.value;

    fetch("brinth_forgot.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
            recovery_email: email,
        }),
    })
        .then((res) => res.json())
        .then((data) => {
            const box = document.querySelector(".forgot-box");
            if (data.status === "not_found") {
                box.innerHTML = `
              <p>There isn't a user with such mail.</p>
              <button onclick="resetForgotForm()">Try Again</button>
            `;
            } else if (data.status === "not_verified") {
                box.innerHTML = `
              <p>Unfortunately, your email has not been verified and access cannot be restored.</p>
              <button onclick="closeForgotForm()">Close</button>
            `;
            } else if (data.status === "sent") {
                box.innerHTML = `
              <p>Thank you<br>Check your email to receive your new password.</p>
              <button onclick="closeForgotForm()">Close</button>
            `;
            } else {
                box.innerHTML = `
              <p>Something went wrong. Please try again later.</p>
              <button onclick="closeForgotForm()">Close</button>
            `;
            }
        })
        .catch((err) => {
            console.error("AJAX error:", err);
        });
}

function resetForgotForm() {
    document.querySelector(".forgot-box").innerHTML = `
      <form id="forgot-form">
        <h3>Recover Password</h3>
        <input type="email" name="recovery_email" placeholder="Enter your email" required />
        <button type="submit">Send Reset Link</button>
        <button type="button" onclick="closeForgotForm()">Cancel</button>
      </form>
    `;
    document
        .getElementById("forgot-form")
        .addEventListener("submit", handleForgotFormSubmit);
}

function openForgotForm() {
    document.getElementById("forgot-modal").style.display = "flex";
}
function closeForgotForm() {
    document.getElementById("forgot-modal").style.display = "none";
}

document.addEventListener("DOMContentLoaded", () => {
    const forgotForm = document.getElementById("forgot-form");
    if (forgotForm) {
        forgotForm.addEventListener("submit", handleForgotFormSubmit);
    }
});


document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    if (params.get("login_error") === "1") {
        const popup = document.getElementById("login-error-popup");
        popup.style.display = "flex";

        // Hide popup if user clicks outside the box
        popup.addEventListener("click", (e) => {
            if (!e.target.closest(".login-error-box")) {
                popup.style.display = "none";
                // Optional: clean URL
                const url = new URL(window.location);
                url.searchParams.delete("login_error");
                window.history.replaceState({}, "", url);
            }
        });
    }
});

function toggleMobileMenu() {
    const menu = document.getElementById("mobileMenu");
    menu.classList.toggle("open");
}

function toggleDropdown(el) {
    el.parentElement.classList.toggle("open");
}