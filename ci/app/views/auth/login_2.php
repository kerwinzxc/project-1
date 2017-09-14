<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SeaCow Data</title>

    <!-- Vendor CSS -->
    <link href="<?=base_url()?>public/ma/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?=base_url()?>public/ma/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

    <!-- CSS -->
    <link href="<?=base_url()?>public/ma/css/app.min.1.css" rel="stylesheet">
    <link href="<?=base_url()?>public/ma/css/app.min.2.css" rel="stylesheet">
</head>

<body class="login-content">
<!-- Login -->
<?php echo form_open("auth/login");?>

<div class="lc-block toggled" id="l-login">
    <div class="input-group m-b-20">
        <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
        <div class="fg-line">
            <?php echo form_input($identity, '', array('autofous','placeholder'=>'邮箱/用户名','class'=>'form-control'));?>
        </div>
    </div>

    <div class="input-group m-b-20">
        <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
        <div class="fg-line">
            <?php echo form_input($password,'', array('placeholder'=>'请输入密码', 'class'=>'form-control'));?>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="checkbox">
        <label>
            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
<!--            <input type="checkbox" value="">-->
            <i class="input-helper"></i>
            Keep me signed in
        </label>
    </div>
<!--    --><?php //echo form_submit('submit', lang('login_submit_btn'), array('class'=>'btn btn-lg btn-success btn-block'));?>
    <button class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>

    <ul class="login-navigation">
        <li data-block="#l-register" class="bgm-red">Register</li>
        <li data-block="#l-forget-password" class="bgm-orange">Forgot Password?</li>
    </ul>
</div>
<?php echo form_close();?>

<!-- Older IE warning message -->
<!--[if lt IE 9]>
<div class="ie-warning">
    <h1 class="c-white">Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="img/browsers/chrome.png" alt="">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="img/browsers/firefox.png" alt="">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="img/browsers/opera.png" alt="">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="img/browsers/safari.png" alt="">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="img/browsers/ie.png" alt="">
                    <div>IE (New)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->

<!-- Javascript Libraries -->
<script src="<?=base_url()?>public/ma/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url()?>public/ma/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?=base_url()?>public/ma/vendors/bower_components/Waves/dist/waves.min.js"></script>

<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
<script src="<?=base_url()?>public/ma/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
<![endif]-->

<script src="<?=base_url()?>public/ma/js/functions.js"></script>

</body>
</html>