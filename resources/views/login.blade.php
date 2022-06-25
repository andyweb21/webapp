<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Aplikasi Web</title>
    <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body class="bg-light">

<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-5 offset-md-3">
            <div class="card rounded shadow">
                <div class="card-body">
                    <h4 class="text-center">LOGIN</h4>
                    <hr>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Your Email">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Your Password">
                    </div>

                    <button class="btn btn-login btn-block btn-primary">LOGIN</button>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {

        $(".btn-login").click( function() {
            var el = $(this);
            var email = $("#email").val();
            var password = $("#password").val();
            var token = $("meta[name='csrf-token']").attr("content");

            if(email.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Alamat Email Wajib Diisi !'
                });

            } else if(password.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Password Wajib Diisi !'
                });

            } else {
                el.html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>').attr('disabled', true);
                $.ajax({

                    url: "{{ route('login.check_login') }}",
                    type: "POST",
                    dataType: "JSON",
                    cache: false,
                    data: {
                        "email": email,
                        "password": password,
                        "_token": token
                    },

                    success:function(response){

                        if (response.success) {

                            Swal.fire({
                                type: 'success',
                                title: 'Login Berhasil!',
                                text: 'Anda akan di arahkan dalam 2 Detik',
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                                .then (function() {
                                    window.location.href = "{{ route('user') }}";
                                });

                        } else {

                            // console.log(response.success);

                            Swal.fire({
                                type: 'error',
                                title: 'Login Gagal!',
                                text: 'silahkan coba lagi!'
                            });

                        }
                        el.html('LOGIN').attr('disabled', false);
                        // console.log(response);

                    },

                    error:function(response){

                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: 'server error!'
                        });

                        // console.log(response);
                        el.html('LOGIN').attr('disabled', false);
                    }

                });

            }

        });

    });
</script>

</body>
</html>