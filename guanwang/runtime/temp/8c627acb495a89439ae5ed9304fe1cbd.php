<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"F:\wamp\www\project\guanwang\public/../application/admin\view\login\restlogin.html";i:1516329961;}*/ ?>
<form action="<?php echo url('Login/checkLogin'); ?>" method="POST" onsubmit="return false" >
    <div class="form-group has-feedback">
        <input type="text" class="form-control" name="username" placeholder="用户名">
        <span class="glyphicon form-control-feedback fa fa-user fa-lg"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="密码">
        <span class="glyphicon form-control-feedback fa fa-lock fa-lg"></span>
    </div>
<!--     <div class="row form-group">
    <div class="col-xs-6"><input class="form-control" name="code" placeholder="验证码"></div>
    <div class="col-xs-4">
        <img src="<?php echo captcha_src(); ?>" id="code" alt="captcha" onclick="this.src='<?php echo captcha_src(); ?>?rnd=' + Math.random();" />
    </div>
</div> -->
</form>