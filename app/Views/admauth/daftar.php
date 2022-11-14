<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSP | Daftar</title>
    <link rel="shortcut icon" href="<?= base_url() ?>/upload/logo.png" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">



    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>



</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="<?= base_url() ?>/index2.html"><b>RSP</b></a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Daftar Akun baru</p>

                <form action="<?= base_url() ?>/admauth/daftarsimpan" method="post" class="daftar">
                    <?= csrf_field() ?>

                    <div class="input-group mb-3">
                        <input type="text" name="usernama" id="usernama" class="form-control" autocomplete="off"
                            placeholder="Nama Lengkap">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <!-- validasi -->
                        <div class="invalid-feedback errorUserNama"></div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="userktp" id="userktp" class="form-control" autocomplete="off"
                            placeholder="Nomor KTP" onkeypress="return hanyaAngka(event)">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-address-card"></span>
                            </div>
                        </div>
                        <!-- validasi -->
                        <div class="invalid-feedback errorUserKtp"></div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="userid" id="userid" class="form-control" autocomplete="off"
                            placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <!-- validasi -->
                        <div class="invalid-feedback errorUserID"></div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="userpassworda" id="userpassworda" class="form-control"
                            autocomplete="off" placeholder="Sandi">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <!-- validasi -->
                        <div class="invalid-feedback errorUserPasswordA"></div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="userpasswordb" id="userpasswordb" class="form-control"
                            autocomplete="off" placeholder="Ulangi Sandi">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <!-- validasi -->
                        <div class="invalid-feedback errorUserPasswordB"></div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </div>
                        <!-- /.col -->
                    </div>

                </form>


                <p class="mt-3 mb-1">
                    Sudah punya akun ?
                    <a href="<?= base_url() ?>/admauth/index">Login</a>
                </p>

            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>



    <script>
    $('.daftar').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.errUserNama) {
                        $('#usernama').addClass('is-invalid');
                        $('.errorUserNama').html(err.errUserNama);
                    } else {
                        $('#usernama').removeClass('is-invalid');
                        $('#usernama').addClass('is-valid');
                    }

                    if (err.errUserKtp) {
                        $('#userktp').addClass('is-invalid');
                        $('.errorUserKtp').html(err.errUserKtp);
                    } else {
                        $('#userktp').removeClass('is-invalid');
                        $('#userktp').addClass('is-valid');
                    }

                    if (err.errUserID) {
                        $('#userid').addClass('is-invalid');
                        $('.errorUserID').html(err.errUserID);
                    } else {
                        $('#userid').removeClass('is-invalid');
                        $('#userid').addClass('is-valid');
                    }

                    if (err.errUserPasswordA) {
                        $('#userpassworda').addClass('is-invalid');
                        $('.errorUserPasswordA').html(err.errUserPasswordA);
                    } else {
                        $('#userpassworda').removeClass('is-invalid');
                        $('#userpassworda').addClass('is-valid');
                    }

                    if (err.errUserPasswordB) {
                        $('#userpasswordb').addClass('is-invalid');
                        $('.errorUserPasswordB').html(err.errUserPasswordB);
                    } else {
                        $('#userpasswordb').removeClass('is-invalid');
                        $('#userpasswordb').addClass('is-valid');
                    }

                }


                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil...',
                        text: response.sukses,
                    }).then((result) => {
                        window.location.href = "<?= base_url() ?>/admauth/";
                    });
                }


                if (response.gagal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.gagal,
                    }).then((result) => {
                        window.location.reload();
                    });
                }




            }
        });
    });



    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))

            return false;
        return true;
    }
    </script>





</body>

</html>