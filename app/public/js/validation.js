(() => {
    'use strict'

    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            const password = document.getElementById('password').value
            const passwordConfirm = document.getElementById('password_confirm').value
            const passwordConfirmField = document.getElementById('password_confirm')

            if (password !== passwordConfirm) {
                passwordConfirmField.setCustomValidity('Passwörter stimmen nicht überein.')
            } else {
                passwordConfirmField.setCustomValidity('')
            }

            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
