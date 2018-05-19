<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link href="<?php echo base_url(); ?>assets/css/adminLogin.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>

    <style>
        .login-form{
            background:rgba(255,255,255,0.8);
            padding:20px;
            border-top:3px solid#3e4043;
        }
        .innter-form{
            padding-top:20px;
        }
        .final-login li{
            width:50%;
        }

        .nav-tabs {
            border-bottom: none !important;
        }

        .nav-tabs>li{
            color:#222 !important;
        }
        .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
            color: #fff;
            background-color: #d14d42;
            border: none !important;
            border-bottom-color: transparent;
            border-radius:none !important;
        }
        .nav-tabs>li>a {
            margin-right: 2px;
            line-height: 1.428571429;
            border: none !important;
            border-radius:none !important;
            text-transform:uppercase;
            font-size:16px;
            background: rgba(255, 255, 255, .1);
        }

        .social-login{
            text-align:center;
            font-size:12px;
        }
        .social-login p{
            margin:15px 0;
        }
        .social-login ul{
            margin:0;
            padding:0;
            list-style-type:none;
        }
        .social-login ul li{
            width:33%;
            float:left;
            clear:fix;
        }
        .social-login ul li a{
            font-size:13px;
            color:#fff;
            text-decoration:none;
            padding:10px 0;
            display:block;
        }
        .social-login ul li:nth-child(1) a{
            background:#3b5998;
        }
        .social-login ul li:nth-child(2) a{
            background:#e74c3d;
        }
        .social-login ul li:nth-child(3) a{
            background:#3698d9;
        }
        .sa-innate-form input[type=text], input[type=password], input[type=file], textarea, select, email{
            font-size:13px;
            padding:10px;
            border:1px solid#ccc;
            outline:none;
            width:100%;
            margin:8px 0;

        }
        .sa-innate-form input[type=submit]{
            border:1px solid#e64b3b;
            background:#e64b3b;
            color:#fff;
            padding:10px 25px;
            font-size:14px;
            margin-top:5px;
        }
        .sa-innate-form input[type=submit]:hover{
            border:1px solid#db3b2b;
            background:#db3b2b;
            color:#fff;
        }

        .sa-innate-form button{
            border:1px solid#e64b3b;
            background:#e64b3b;
            color:#fff;
            padding:10px 25px;
            font-size:14px;
            margin-top:5px;
        }
        .sa-innate-form button:hover{
            border:1px solid#db3b2b;
            background:#db3b2b;
            color:#fff;
        }
        .sa-innate-form p{
            font-size:13px;
            padding-top:10px;
        }
    </style>

</head>

<body>
<!-- start site-wrapper -->
<div class="site-wrapper">

    <!-- start site-wrapper-inner -->
    <div class="site-wrapper-inner clearfix">

        <!-- start cover-container -->
        <div class="cover-container container">

            <!-- start inner cover -->
            <div class="inner cover clearfix">
                <div class="col-xs-12 col-sm-6 intro-cont">
                    <?php $logo = get_option('login_logo')?>
                    <?php $title = get_option('login_title')?>
                    <?php $description = get_option('login_description')?>
                    <span>
                    <?php if(empty($logo)){ ?>
                        <img class="img-responsive" src="<?php echo base_url('assets/img/eoffice_logo_w.png') ?>">
                    <?php }else{ ?>
                        <img class="img-responsive" src="<?php echo site_url(UPLOAD_LOGO.$logo)?>" width="250" height="200">
                    <?php } ?>
                </span>
                    <?php if(empty($title)){ ?>
                        <h1 class="page-intro">Ultimate HRM & Accounts Features </h1>
                    <?php }else{ ?>
                        <h1 class="page-intro"><?= $title ?> </h1>
                    <?php } ?>

                    <?php if(empty($description)){ ?>
                        <p>eOffice is an office management software where you can easily manage your Employee, Accounts, Business Transaction, Manage product, customer, Vendor, Sales and Purchase etc.</p>
                    <?php }else{ ?>
                        <p><?= $description ?></p>
                    <?php } ?>


                </div>
                <div class="col-xs-12 col-sm-5 col-sm-offset-1 sign-in-outer">
                    <div class="sign-in-wrap">
                        <h2 class="form-heading"><?= lang('sign_in') ?></h2>
                        <div class="form-body">

                            <p>
                                <?php echo $form->messages(); ?>
                            </p>

                            <ul class="nav nav-tabs final-login">
                                <li><a data-toggle="tab" href="#adminLogin">Admin Login</a></li>
                                <li class="active" style="color: white"><a data-toggle="tab" href="#employeeLogin">Employee Login</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="adminLogin" class="tab-pane fade">
                                    <div class="innter-form">
                                        <?php echo form_open(site_url('admin/login'), $attr = array('class' => 'sa-innate-form')) ?>
                                        <label style="color: white"><?= lang('username') ?></label>
                                        <input type="text" name="email">
                                        <label style="color: white"><?= lang('password') ?></label>
                                        <input type="password" name="password">
                                        <button type="submit"><?= lang('log_in') ?></button>
                                        <a href="<?php echo base_url('admin/auth/forgot_password') ?>">Forgot Password?</a>
                                        <?php echo form_close()?>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                                <div id="employeeLogin" class="tab-pane fade in active">
                                    <div class="innter-form">
                                        <?php echo form_open(site_url(), $attr = array('class' => 'sa-innate-form')) ?>
                                        <label style="color: white"><?= lang('employee_id') ?></label>
                                        <input type="text" name="username">
                                        <label style="color: white"><?= lang('password') ?></label>
                                        <input type="password" name="password">
                                        <button type="submit"><?= lang('log_in') ?></button>
                                        <?php echo form_close()?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--  </form> -->
                    </div>

                </div>
            </div>
            <!-- end inner cover -->

        </div>
        <!-- end cover-container -->

    </div>
    <!-- end site-wrapper-inner -->

</div>
<!-- end site-wrapper -->


</body>
</html>