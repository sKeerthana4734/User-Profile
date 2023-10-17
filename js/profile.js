function displayUserDetails() {
    let fields = {
        username: 'Username',
        firstname: 'First Name',
        lastname: 'Last Name',
        email: 'Email',
        age: 'Age',
        gender: 'Gender',
        phone: 'Phone',
        country: 'Country',
    };

    let userData = localStorage.getItem('user-data');
    let sessionData = JSON.parse(userData);
    let stored = 0;
    let count = 0;

    for (let sessionKey in fields) {
        let label = fields[sessionKey];
        let value = sessionData[sessionKey] || '';
        let leftColumn = document.getElementById('leftColumn');
        let rightColumn = document.getElementById('rightColumn');

        if (count % 2 === 0) {
            let labelElement = document.createElement("label");
            labelElement.setAttribute("for", sessionKey);
            labelElement.textContent = label + ":";
            leftColumn.appendChild(labelElement);

            let inputElement = document.createElement("input");
            inputElement.setAttribute("type", "text");
            inputElement.setAttribute("id", sessionKey);
            inputElement.setAttribute("name", sessionKey);
            if (value) {
                inputElement.setAttribute("value", value);
                inputElement.setAttribute("disabled", "disabled");
                stored++;
            }
            else {
                inputElement.setAttribute("value", value);
                inputElement.setAttribute("placeholder", "Please fill this field");
                inputElement.setAttribute("required", "required");
            }
            leftColumn.appendChild(inputElement);



        } else {
            let labelElement = document.createElement("label");
            labelElement.setAttribute("for", sessionKey);
            labelElement.textContent = label + ":";
            rightColumn.appendChild(labelElement);

            let inputElement = document.createElement("input");
            inputElement.setAttribute("type", "text");
            inputElement.setAttribute("id", sessionKey);
            inputElement.setAttribute("name", sessionKey);
            if (value) {
                inputElement.setAttribute("value", value);
                inputElement.setAttribute("disabled", "disabled");
                stored++;
            }
            else {
                inputElement.setAttribute("value", value);
                inputElement.setAttribute("placeholder", "Please fill this field");
                inputElement.setAttribute("required", "required");
            }
            rightColumn.appendChild(inputElement);
        }
        count++;
    }

    let errorElement = document.createElement('div');
    errorElement.setAttribute("id", "error");
    leftColumn.appendChild(errorElement);

    let messageElement = document.createElement('div');
    messageElement.setAttribute("id", "message");
    leftColumn.appendChild(messageElement);

    let welcomeMessage = document.getElementById('welcomeMessage');
    if (sessionData.username) {
        welcomeMessage.innerText = 'Welcome ' + sessionData.username;
    }

    let saveButton = document.createElement('button');
    if (stored !== 8) {
        saveButton.textContent = 'Save';
        saveButton.addEventListener('click', saveData);
    } else {
        saveButton.textContent = 'Saved';
        saveButton.classList.add('disable');
        saveButton.disabled = true;
    }
    rightColumn.appendChild(saveButton);
    let brk = document.createElement('br');
    rightColumn.appendChild(brk);

    if (localStorage.getItem('save-message') !== null) {
        console.log(localStorage.getItem('save-message'));
        document.getElementById('message').innerHTML =
            localStorage.getItem('save-message');
    }
}




document.addEventListener("DOMContentLoaded", function () {
    $.ajax({
        url: './php/profile.php',
        type: 'post',
        data: { action: 'load_profile' },
        success: function (response) {
            if (response) {
                const userData = JSON.stringify(response);
                localStorage.setItem("user-data", userData);
                displayUserDetails();
            }

        }
    });
});



function saveData() {
    var data = {
        username: $("#username").val(),
        firstname: $("#firstname").val(),
        lastname: $("#lastname").val(),
        email: $("#email").val(),
        age: $("#age").val(),
        gender: $("#gender").val(),
        phone: $("#phone").val(),
        country: $("#country").val(),
        action: $("#action").val(),
    };

    $.ajax({
        url: './php/profile.php',
        type: 'post',
        data: data,
        success: function (response) {
            if (response.save == true) {
                localStorage.setItem("save-message", response.message);
            }
            else {
                $("#error").html(response.message);
            }
        }
    });
}

document.getElementById("logout").addEventListener("click", function () {
    localStorage.clear();
    window.location.href = "index.html";
});
