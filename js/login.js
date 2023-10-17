function submitData() {
    $(document).ready(function () {
        var data = {
            name: $("#name").val(),
            username: $("#username").val(),
            password: $("#password").val(),
            action: $("#action").val(),
        };

        $.ajax({
            url: './php/login.php',
            type: 'post',
            data: data,
            success: function (response) {
                if (response.login == true) {
                    $("#message").html(response.message);
                    $("#error").html("");
                    localStorage.setItem('id', response.id);
                    // alert(localStorage.getItem('id'));
                    // console.log(localStorage.getItem('id'));
                    window.location.reload();
                }
                else {
                    $("#error").html(response.message);
                }
            }
        });
    });
}
