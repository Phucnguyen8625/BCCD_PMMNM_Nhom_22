document.addEventListener('DOMContentLoaded', function () {
    const passwordFields = document.querySelectorAll('input[type="password"]');

    passwordFields.forEach(function (field) {
        field.setAttribute('autocomplete', 'current-password');
    });
});
