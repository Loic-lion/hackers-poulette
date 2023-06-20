function validateForm() {
    var name = document.getElementsByName('name')[0].value;
    var firstname = document.getElementsByName('firstname')[0].value;
    var email = document.getElementsByName('email')[0].value;
    var description = document.getElementsByName('description')[0].value;
    var valid = true;

    document.getElementById('name-error').textContent = '';
    document.getElementById('firstname-error').textContent = '';
    document.getElementById('email-error').textContent = '';
    document.getElementById('description-error').textContent = '';

    if (name.length < 2 || name.length > 255) {
        document.getElementById('name-error').textContent = 'Name must be between 2 and 255 characters';
        valid = false;
    }

    if (firstname.length < 2 || firstname.length > 255) {
        document.getElementById('firstname-error').textContent = 'First Name must be between 2 and 255 characters';
        valid = false;
    }

    if (!validateEmail(email)) {
        document.getElementById('email-error').textContent = 'Invalid email address';
        valid = false;
    }

    if (description.length < 2 || description.length > 1000) {
        document.getElementById('description-error').textContent = 'Description must be between 2 and 1000 characters';
        valid = false;
    }

    return valid;
}

function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}