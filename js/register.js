function registerData() {
    $(document).ready(function () {
        var data = {
            name: $("#name").val(),
            username: $("#username").val(),
            password: $("#password").val(),
            action: $("#action").val(),
        };

        $.ajax({
            url: './php/register.php',
            type: 'post',
            data: data,
            success: function (response) {
                if (response.register == true) {
                    $("#error").html("");
                    sessionStorage.setItem("register-message", response.message);
                    console.log(response.message);
                    window.location.href = 'index.html';
                }
                else {
                    $("#error").html(response.message);
                }
            }
        });
    });
}
