<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <form id="loginForm">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('login') }}",
                    method: "POST",
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // alert(response.message);
                            window.location.href = "{{ url('layout') }}"; // Redirect ke halaman layout
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan');
                    }
                });
            });
        });
    </script>

</body>

</html>