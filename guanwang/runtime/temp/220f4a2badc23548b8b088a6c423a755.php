<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:84:"F:\wamp\www\project\guanwang\public/../application/admin\view\config\pokemon_us.html";i:1516329958;s:78:"F:\wamp\www\project\guanwang\public/../application/admin\view\public\base.html";i:1516329961;s:86:"F:\wamp\www\project\guanwang\public/../application/admin\view\public\admin_load_t.html";i:1516329960;s:83:"F:\wamp\www\project\guanwang\public/../application/admin\view\public\admin_top.html";i:1516329961;s:84:"F:\wamp\www\project\guanwang\public/../application/admin\view\public\admin_left.html";i:1516329961;s:86:"F:\wamp\www\project\guanwang\public/../application/admin\view\public\admin_bottom.html";i:1516329961;s:86:"F:\wamp\www\project\guanwang\public/../application/admin\view\public\admin_load_b.html";i:1516329961;}*/ ?>
<?php if($box_is_pjax != 1): ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<?php endif; ?>
<title><?php if($data): ?><?php echo \think\Lang::get('edit'); else: ?><?php echo \think\Lang::get('create'); endif; ?></title>

<?php if($box_is_pjax != 1): ?>
<link rel="stylesheet" type="text/css" href="__static__/global/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="__static__/global/bootstrap/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="__static__/system/iCheck/minimal/blue.css" />
<link rel="stylesheet" type="text/css" href="__static__/system/select2/select2.min.css" />
<link rel="stylesheet" type="text/css" href="__static__/system/dist/css/AdminLTE.min.css" />
<link rel="stylesheet" type="text/css" href="__static__/system/dist/css/skins/skin-blue.min.css" />

<script type="text/javascript" src="__static__/global/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="__static__/global/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__static__/system/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="__static__/system/dist/js/app.min.js"></script>
<script type="text/javascript" src="__static__/global/jQuery/jquery.pjax.js"></script>

<link rel="stylesheet" type="text/css" href="__static__/system/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="__static__/system/kindeditor/kindeditor-all.js"></script>
<script type="text/javascript" src="__static__/system/kindeditor/lang/zh-CN.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="__static__/system/dist/js/html5shiv.min.js"></script>
<script type="text/javascript" src="__static__/system/dist/js/respond.min.js"></script>
<![endif]-->
<?php endif; if($box_is_pjax != 1): ?>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
<?php endif; if($box_is_pjax != 1): ?>
    <header class="main-header">
        <a href="#" class="logo"><span class="logo-mini">HN</span><span class="logo-lg">HN game</span></a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
<!--                     <li class="dropdown messages-menu">
    <a href="/" target="_blank" ><?php echo \think\Lang::get('web_home'); ?></a>
</li>
<li class="dropdown messages-menu">
    <a href="javascript:void(0);" class="delete-one" data-url="<?php echo url('Index/cleanCache'); ?>" data-id="-1" ><?php echo \think\Lang::get('clean_cache'); ?></a>
</li> -->
                    <li class="dropdown user user-menu">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo cookie('avatar'); ?>" class="user-image">
                            <span class="hidden-xs"><?php echo cookie('name'); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="<?php echo cookie('avatar'); ?>" class="img-circle">
                                <p><?php echo cookie('name'); ?><small>Member since admin</small></p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left"><a href="<?php echo url('User/edit', ['id' => cookie('uid')]); ?>" class="btn btn-default btn-flat">个人设置</a></div>
                                <div class="pull-right"><a href="<?php echo url('Login/loginOut'); ?>" class="btn btn-default btn-flat">退出</a></div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<?php endif; if($box_is_pjax != 1): ?>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image"><img src="<?php echo cookie('avatar'); ?>" class="img-circle" alt="<?php echo cookie('name'); ?>"></div>
                <div class="pull-left info">
                    <p><?php echo cookie('name'); ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i>在线</a>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li class="header">菜单</li>
                <?php if(is_array($treeMenu) || $treeMenu instanceof \think\Collection || $treeMenu instanceof \think\Paginator): $i = 0; $__LIST__ = $treeMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$oo): $mod = ($i % 2 );++$i;if($oo['level'] == '1' && $oo['name'] == 'Index/index'): ?>
                    <li><a href="<?php echo url(MODULE_NAME.'/'.$oo['name']); ?>"><i class="<?php echo $oo['icon']; ?>"></i><span><?php echo $oo['title']; ?></span></a></li>
                    <?php elseif($oo['level'] == '1'): ?>
                    <li class="treeview">
                        <a href="javascript:void(0);">
                            <i class="<?php echo $oo['icon']; ?>"></i><span><?php echo $oo['title']; ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if(is_array($treeMenu) || $treeMenu instanceof \think\Collection || $treeMenu instanceof \think\Paginator): $i = 0; $__LIST__ = $treeMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$to): $mod = ($i % 2 );++$i;if($to['pid'] == $oo['id']): ?>
                            <li><a href="<?php echo url(MODULE_NAME.'/'.$to['name']); ?>"><i class="<?php echo $to['icon']; ?>"></i><?php echo $to['title']; ?></a></li>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </section>
    </aside>
<?php endif; ?>
    
    
    <div class="content-wrapper" id="pjax-container">
        
<section class="content-header">
    <h1>配置信息(VS)</h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> 配置信息(VS)</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="POST" action="<?php echo url('Config/save'); ?>" onsubmit="return false" >
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo \think\Lang::get('base_param'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <input type="hidden" name="type" value="<?php echo $type; ?>" />
                            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['texttype'] == 'textarea'): else: ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $vo['desc']; ?></label>
                                <div class="col-sm-7"><input class="form-control" name="<?php echo $vo['key']; ?>" value="<?php echo $vo['value']; ?>"></div>
                            </div>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-7">
                            <div class="btn-group">
                                <?php echo authAction(CONTROLLER_NAME.'/save', 'save'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script type="text/javascript">
$(function(){
    /*ajax页面加载icheck，有该控件的页面才需要*/
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    
    /*ajax页面加载icheck，有该控件的页面才需要*/
    $(".select2").select2({language:"zh-CN"});
    
    <?php if($rest_login == 1): ?>
    restlogin('<?php echo $rest_login_info; ?>');   //登录超时
    <?php endif; ?>
})
</script>

    </div>
    
        
<?php if($box_is_pjax != 1): ?>
    <footer class="main-footer">
        <div class="pull-right">Version 1.0</div>
        Copyright &copy; 2017-2018 海牛游戏
    </footer>
<?php endif; if($box_is_pjax != 1): ?>
</div>
<?php endif; if($box_is_pjax != 1): ?>
<script type="text/javascript" src="__static__/global/jQuery/jquery.form.js"></script>

<script type="text/javascript" src="__static__/system/editable/bootstrap-editable.js"></script>
<link rel="stylesheet" type="text/css" href="__static__/system/editable/bootstrap-editable.css" />

<script type="text/javascript" src="__static__/global/nprogress/nprogress.js"></script>
<link rel="stylesheet" type="text/css" href="__static__/global/nprogress/nprogress.css" />

<link rel="stylesheet" type="text/css" href="__static__/global/jQuery-gDialog/animate.min.css" />
<link rel="stylesheet" type="text/css" href="__static__/global/Amaranjs/amaran.min.css" />
<script type="text/javascript" src="__static__/global/Amaranjs/jquery.amaran.min.js"></script>
<link rel="stylesheet" type="text/css" href="__static__/global/bootstrap/js/bootstrap-dialog.min.css" />
<script type="text/javascript" src="__static__/global/bootstrap/js/bootstrap-dialog.min.js"></script>

<script type="text/javascript" src="__static__/system/datetimepicker/moment-with-locales.min.js"></script>
<link rel="stylesheet" type="text/css" href="__static__/system/datetimepicker/bootstrap-datetimepicker.min.css" />
<script type="text/javascript" src="__static__/system/datetimepicker/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="__static__/system/multiselect/multiselect.min.js"></script>

<script type="text/javascript" src="__static__/system/iCheck/icheck.min.js"></script>

<script type="text/javascript" src="__static__/system/select2/select2.min.js"></script>
<script type="text/javascript" src="__static__/system/select2/i18n/zh-CN.js"></script>

<link rel="stylesheet" type="text/css" href="__static__/global/cropper/cropper.min.css" />
<script type="text/javascript" src="__static__/global/cropper/cropper.min.js"></script>
<link rel="stylesheet" type="text/css" href="__static__/global/cropper/cropper.main.css" />
<script type="text/javascript" src="__static__/global/cropper/cropper.main.js"></script>

<script type="text/javascript" src="__static__/system/chart/Chart.min.js"></script>
<script type="text/javascript" src="__static__/system/dist/js/md5.js"></script>
<script type="text/javascript" src="__static__/system/dist/js/common.js"></script>
<script type="text/javascript" src="__static__/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="__static__/ckfinder/ckfinder.js"></script>
<?php endif; if($box_is_pjax != 1): ?>
</body>
</html>
<?php endif; ?>