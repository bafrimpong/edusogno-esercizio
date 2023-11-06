// input elements
const firstNameInput = document.getElementById("first_name");
const lastNameInput = document.getElementById("last_name");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");

/**
 * Hides the error message alert box if visible and shows it if hidden by toggling between the
 * element's style property
 */
const toggleErrorView = () => {
    const feedbackContainer = document.getElementsByClassName('feedback');
    feedbackContainer[0].style.display = "none";
}

/**
 * Hides the password input value if it is visible and shows if hidden by switching between
 * the element's type attribute
 */
const togglePasswordView = () => {

    if (passwordInput.type === "password"){
        passwordInput.setAttribute("type", "text");
    } else {
        passwordInput.setAttribute("type", "password");
    }
}

// validate input fields
/**
 * Validates the registration form before its submission
 * @param event
 */
const validateUserRegistration = (event) => {
    event.preventDefault;

    // get the form element
    const form = document.getElementById('registration-form');

    if (firstNameInput.value.trim() === "") {
        alert("First name is required");
        return;
    }
    if (lastNameInput.value.trim() === "") {
        alert("Last name is required");
        return;
    }
    if (emailInput.value.trim() === ""){
        alert("E-mail address is required");
        return;
    }
    if (passwordInput.value.trim() === "") {
        alert("Password is required");
        return;
    }

    // submit the form
    form.submit();
}

/**
 * Validates if user email and passwords are entered before form submission
 */
const validateUserLogin = (event) => {
    event.preventDefault;

    const loginForm = document.getElementById("login-form");

    if (emailInput.value.trim() === ""){
        alert("E-mail address is required");
        return;
    }
    if (passwordInput.value.trim() === ""){
        alert("Password is required");
        return;
    }

    // submit the form when validation is passed
    loginForm.submit();
}

function validatePasswordChange(event) {
    event.preventDefault;
    const confirmPassword = document.getElementById('confirm_password');
    const form = document.getElementById("password-edit-form");

    if (passwordInput.value.trim() === ""){
        alert("Enter your new password");
        return;
    }

    if (confirmPassword.value.trim() === ""){
        alert("Confirm your new password");
        return;
    }

    if (passwordInput.value.trim() !== confirmPassword.value.trim()){
        alert("Your new password do not match");
        return;
    }

    // submit the form when validation is passed
    form.submit();
}

// validate event add
const eventName = document.getElementById("event_name");
const eventDate = document.getElementById("event_date");
const eventAttendees = document.getElementById("event_attendees");
const eventDescription = document.getElementById("event_description");
const eventForm = document.getElementById("event-form");

function validateCreateEvent(event) {
    event.preventDefault;

    if (eventName.value.trim() === ""){
        alert("Event name is required");
        return;
    }

    if (eventDate.value.trim() === "") {
        alert("Event date is required");
        return;
    }

    if (eventAttendees.value.trim() === ""){
        alert("Select at least one attendee for the event");
        return;
    }

    if (eventDescription.value.trim() === ""){
        alert("Event description is required");
        return;
    }

    // submit the form if validation is passed
    eventForm.submit();
}
