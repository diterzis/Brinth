<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../loggedin/protected_page.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report An Issue - Brinth</title>
    <link rel="stylesheet" href="../brinth_styles/index/Brinth_Support.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_navbar.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_forgot.css" />
    <link rel="icon" href="../brinth_icons/brinth_logo.png">
    <style>
        .guest-report-box select {
            background: #2b1a12;
            color: #f5e4d0;
            border: 1px solid #7d5c45;
            padding: 12px;
            border-radius: 12px;
            font-size: 1em;
            appearance: none;
        }

        .confirmation-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(10, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffe;
            font-size: 2em;
            font-family: 'Cinzel Decorative', serif;
            z-index: 9999;
            text-align: center;
            padding: 30px;
        }
    </style>
</head>

<body>
    <?php include 'brinth_header.php'; ?>

    <main class="support-container">
        <h1 class="support-title">Report An Issue</h1>
        <p class="support-intro">Not a registered adventurer? You can still help us protect Brinth.</p>

        <form id="guestReportForm" class="report-form guest-report-box">
            <input type="text" name="username" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>

            <select name="category" required>
                <option value="" disabled selected>Choose a category</option>
                <optgroup label="Account Issues">
                    <option value="Forgot my Password">Forgot my Password</option>
                    <option value="Didn't receive verification email">I didn’t receive my verification email</option>
                    <option value="Change account details">I want to change my account details</option>
                </optgroup>
                <optgroup label="In-Game Bugs">
                    <option value="Game won't unlock">A game won’t unlock</option>
                    <option value="Incorrect XP">My XP is incorrect</option>
                    <option value="Wrong Role">Something’s wrong with my role</option>
                    <option value="Game Bug">Game bug (Please mention the Game Code)</option>
                    <option value="Other">Other</option>
                </optgroup>
            </select>

            <textarea name="message" placeholder="Describe the issue..." required></textarea>
            <button type="submit">Send Report</button>
        </form>
    </main>

    <?php include 'brinth_footer.php'; ?>

<script>
    document.getElementById("guestReportForm").addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const plainData = Object.fromEntries(formData.entries());

        try {
            const response = await fetch("submit_guest_report.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(plainData)
            });

            const result = await response.json();

            if (response.ok && result.status === "success") {
                const overlay = document.createElement("div");
                overlay.className = "confirmation-overlay";
                overlay.textContent = "Your message was sent. Thank you for keeping Brinth Safe!";
                overlay.addEventListener("click", () => overlay.remove());
                document.body.appendChild(overlay);
                document.getElementById("guestReportForm").reset();
            } else {
                alert("Something went wrong. Please try again later.");
            }

        } catch (err) {
            alert("Failed to send report. Please check your connection.");
            console.error(err);
        }
    });
</script>

    <script src="Brinth_Index_Script.js" defer></script>
</body>

</html>