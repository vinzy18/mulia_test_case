<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Portal - Mulia Industry</title>

    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
	<link rel="shortcut icon" href="https://muliaindustrindo.com/img/logo.ico"/>

</head>

<body style="background-image: url(assets/img/bg.png);">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
									<div class="mb-3 text-center">
										<img src="<?= base_url('assets'); ?>/img/logo.png" alt="">
									</div>
									<div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Mulia Industry Billing System</h1>
                                    </div>
									<?php if ($this->session->flashdata('error')): ?>
										<div class="alert alert-danger">
											<?= $this->session->flashdata('error') ?>
										</div>
									<?php endif; ?>
                                    <form action="<?= site_url('auth/login') ?>" method="post" class="user">
                                        <div class="form-group">
											<label for="username">Username</label>
                                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Username" name="username">
                                        </div>
                                        <div class="form-group">
											<label for="password">Password</label>
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
										</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
