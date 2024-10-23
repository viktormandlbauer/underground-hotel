function load_profile() {
    fetch('/profile/load', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('username').textContent = data.username;
            document.getElementById('pronouns').value = data.pronouns;
            document.getElementById('givenname').value = data.givenname;
            document.getElementById('surname').value = data.surname;
            document.getElementById('email').value = data.email;
            document.getElementById('phone').value = data.phone;
        })
        .catch(error => {
            console.error('Error loading profile information:', error);
        });
}


function edit_profile(params) {

    fetch('/profile/edit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function default_picture() {
    var imageElement = document.getElementById('profile_picture')
    imageElement.src = '/public/images/default-avatar.svg'
    // Prevents infinite loop
    imageElement.removeAttribute("onerror");
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('changePasswordForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const params = Object.fromEntries(formData.entries());

        edit_profile(params);
    });

    load_profile();
});