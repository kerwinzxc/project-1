<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"F:\wamp\www\project\guanwang\public/../application/pokemon\view\index\index_ru.html";i:1516074117;s:78:"F:\wamp\www\project\guanwang\public/../application/pokemon\view\header_ru.html";i:1516002709;s:78:"F:\wamp\www\project\guanwang\public/../application/pokemon\view\footer_ru.html";i:1516002709;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta name="keywords" content="Покемон  ,  Покемон  vs  ,  эльфы  мира  покемонов  ,  домашних животных  ,  эльф  ,  тур,  игры,  бесплатный  тур,  опеку  ,  сбор" /> 
  <meta name="description" content="Покемон  vs  нового поколения  "  эльфов  "  идеальный  мир  детства  опеку  сбросить  сложный момент  классический  маршрут  , это  эльфы  стратегии  сбора  опеку  ,  га  для  войны  ,  РПГ  роль  приключения  мобильных игр  . " /> 
  <title>Эльфы  мира  официальный сайт  _  Покемон  vs  сети  нового поколения  _  ламантин</title> 
    <link rel="stylesheet" type="text/css" href="__static__/pokemon/dist/assets/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="__static__/pokemon/dist/assets/owl.theme.default.css" />
    <link rel="stylesheet" type="text/css" href="__static__/pokemon/css/carousel_pc.css" />
    <link rel="stylesheet" type="text/css" href="__static__/pokemon/css/pmstyle.css" />
    <link rel="stylesheet" type="text/css" href="__static__/pokemon/css/switch.css" />
</head>
<body>
<header id="top">
	<div class="language clearfix">
        <a id="english" class="" href="/pokemon?us"><img src="__static__/index/img/English.png"></a>
        <a id="chinese" class="active" href="/pokemon?cn"><img src="__static__/index/img/chinese.png"></a>
    </div>
    <img class="top_bg" src="__static__/pokemon/img/russia/top_bg.png">
    <div class="content clearfix" style="width: 1460px;">
        <div class="nav" style="width: 200px;">
            <div class="nav_line"></div>
            <a class="nav_btn" style="padding-top: 10px;" href="<?php echo url('Index/index'); ?>">Главная</a>
        </div>
        <div class="nav" style="width: 200px;">
            <div class="nav_line"></div>
            <a class="nav_btn" style="padding-top: 10px;" href="<?php echo url('News/news'); ?>">Новости</a>
        </div>
        <div class="nav" style="width: 200px;">
            <div class="nav_line"></div>
            <a class="nav_btn" style="padding-top: 10px;" href="<?php echo url('Activity/activity'); ?>">Центр акции</a>
        </div>
        <img id="logo" src="__static__/pokemon/img/russia/logo.png">
        <div class="nav" style="width: 200px;">
            <div class="nav_line"></div>
            <a class="nav_btn" style="padding-top: 10px;" href="<?php echo $fuli_url['value']; ?>">Подарочный центр</a>
        </div>
        <div class="nav" style="width: 200px;" id="community">
            <div class="nav_line"></div>
            <a class="nav_btn" style="padding-top: 10px;" href="javascript:void(0)">Сообщество</a>
        </div>
        <div class="nav" style="width: 200px;" id="contact">
            <div class="nav_line"></div>
            <a class="nav_btn" style="padding-top: 10px;" href="javascript:void(0)">Поддержка</a>
        </div>
    </div>
    <div class="nav_hover community">
        <img class="hover_bg" src="__static__/pokemon/img/russia/top_nav_bg.png">
        <div class="content clearfix">
        	 <div class="hover_block">
                <div class="box">
                    <img class="code" src="/public/static/pokemon/img/russia/code.png">
                    <p style="font-size: 14px;">сканирование здесь FB</p>
                </div>
            </div>
            <!--<div class="hover_block">
                <a href="<?php echo $baidu_bbs['value']; ?>" class="box">
                    <img class="baidu" src="__static__/pokemon/img/russia/baidu.png">
                    <p><?php echo $baidu_bbs['desc']; ?></p>
                </a>
            </div>
            <div class="hover_block">
                <div class="box">
                    <img class="code" src="<?php echo $qrcode_wechart['value']; ?>">
                    <p><?php echo $qrcode_wechart['desc']; ?></p>
                </div>
            </div>
            <div class="hover_block">
                <div class="box">
                    <img class="code" src="<?php echo $qrcode_wb['value']; ?>">
                    <p><?php echo $qrcode_wb['desc']; ?></p>
                </div>
            </div>-->
            <div class="community_block" style="width: 600px;">
            	<p style="margin-top: 40px;">FB Page: <a href="https://business.facebook.com/LegendsofMonsters/" target="_blank">https://business.facebook.com/LegendsofMonsters/</a></p>
            <!--<?php if(is_array($qq_group) || $qq_group instanceof \think\Collection || $qq_group instanceof \think\Paginator): $i = 0; $__LIST__ = $qq_group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <p><?php echo $vo['desc']; ?>：<?php echo $vo['value']; ?></p>
            <?php endforeach; endif; else: echo "" ;endif; ?>-->
            </div>
        </div>
    </div>
    <div class="nav_hover contact">
        <img class="hover_bg" src="__static__/pokemon/img/russia/top_nav_bg.png">
        <div class="content clearfix">
            <!--<div class="contact_block">
                <img src="__static__/pokemon/img/russia/QQ.png">
                <div class="text_block">
                <?php if(is_array($qq_service) || $qq_service instanceof \think\Collection || $qq_service instanceof \think\Paginator): $i = 0; $__LIST__ = $qq_service;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <p><?php echo $vo['desc']; ?>：<?php echo $vo['value']; ?></p>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="contact_block long_fix">
                <img src="__static__/pokemon/img/russia/tel_nav.png">
                <div class="text_block">
                    <h1><?php echo $service_phone['desc']; ?>：<?php echo $service_phone['value']; ?></h1>
                    <p><?php echo $service_online['desc']; ?>：<?php echo $service_online['value']; ?></p>
                </div>
            </div>-->
            <div class="contact_block long_fix" style="width: 100%;">
                <img src="__static__/pokemon/img/russia/tel_nav.png">
                <div class="text_block">
                    <h1 style="margin-top: 30px;"><?php echo $service_online['desc']; ?>：<?php echo $service_online['value']; ?></h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="index_1">
    <!--英文-->
    <div class="dl_block">
        <div class="tips_text">
            пэт сбора / га стратегии vs / PRG роль
        </div>
        <div class="dl">
            <p style="text-indent: 1em;">сканирование здесь FB</p>
            <img class="dl_code" style="width: 145px;" src="__static__/pokemon/img/russia/code.png">
            <div class="dl_btn">
                <a class="ios" href="" style="font-size: 15px;width: 245px;" target="_blank">
                    <img style="left:18px;top:11px;" src="__static__/pokemon/img/russia/ios.png">Загрузите на IOS
                </a>
                <a class="adr" href="" style="font-size: 15px;width: 245px;" target="_blank">
                    <img style="left:12px;top:10px;" src="__static__/pokemon/img/russia/adr.png">Загрузите на андроид</a>
            </div>
            <a class="dl_gift" href="javascript:;">
                <img src="__static__/pokemon/img/russia/gift.png">
                <div class="gift" style="font-size: 12px;">Подарки</div>
            </a>

        </div>
    </div>
    <!---->
    <!--英文-->
    <img class="index_1_bg" src="__static__/pokemon/img/russia/bg.jpg"/>
    <!---->
    <!--英文-->
    <div class="index_1_content ">
        <div class="position_fix_btm">
            <div class="content clearfix">
                <div class="auto_play_box">
                    <div id="owl-demo" class="owl-carousel owl-theme">
                    <?php if(is_array($bannerList) || $bannerList instanceof \think\Collection || $bannerList instanceof \think\Paginator): $i = 0; $__LIST__ = $bannerList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['type'] == 1): ?>
                        <div class="item"><a href="<?php if(($vo['url'] != null) and ($vo['url'] != '')): ?><?php echo $vo['url']; else: ?>javascript:void(0);<?php endif; ?>" alt="<?php echo $vo['name']; ?>"><img src="<?php echo $vo['image_url']; ?>" alt="<?php echo $vo['name']; ?>" style="width: 520px;height: 300px;"></a></div>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="list_box">
                    <ul class="list_tit clearfix">
                        <?php if(is_array($newsTypeList) || $newsTypeList instanceof \think\Collection || $newsTypeList instanceof \think\Paginator): $i = 0; $__LIST__ = $newsTypeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <li <?php if($key == 0): ?>class="active"<?php endif; ?>><a href="javascript:void(0)"><?php echo $vo['name']; ?></a><img class="triangle" src="__static__/pokemon/img/russia/blue_triangle.png"></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <a class="more" href="<?php echo url('News/news'); ?>">more+</a>
                    </ul>
                    <?php if(is_array($newsTypeList) || $newsTypeList instanceof \think\Collection || $newsTypeList instanceof \think\Paginator): $i = 0; $__LIST__ = $newsTypeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <div class="list_block" id="list_<?php echo $key; ?>" <?php if($key > 0): ?>style="display: none;"<?php endif; ?>>
                        <div class="list_first">
                            <a href="javascript:openNews(<?php echo $vo['id']; ?>)" style="color: #fff;"><span style="display:block;width:100%;overflow:hidden;white-space: nowrap;text-overflow:ellipsis;"><?php echo $vo['description']; ?></span></a>
                            <img class="bird" src="__static__/pokemon/img/russia/nan_bird.png">
                        </div>
                        <?php $var = '1'; if(is_array($newsList) || $newsList instanceof \think\Collection || $newsList instanceof \think\Paginator): $i = 0; $__LIST__ = $newsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$news): $mod = ($i % 2 );++$i;if($news['type_id'] == $vo['id']): if($var <= 3): ?>
                        <a href="javascript:openDetail(<?php echo $news['id']; ?>)" class="list">
                            <?php echo $news['title']; ?>
                            <span><?php echo $news['create_time']; ?></span>
                        </a>
                        <?php $var = $var+1; endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="content clearfix" style="margin-top:70px">
                <?php if(is_array($linkList) || $linkList instanceof \think\Collection || $linkList instanceof \think\Paginator): $i = 0; $__LIST__ = $linkList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['platform'] == 1): ?>
                <a href="<?php echo (isset($vo['url']) && ($vo['url'] !== '')?$vo['url']:'javascript:void(0)'); ?>" class="switch_block">
                    <img style="left:20px;top:0;" src="<?php echo $vo['image_url']; ?>">
                    <div class="switch"><div class="switch_content"></div></div>
                    <div class="switch_text"><?php echo $vo['name']; ?></div>
                </a>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <!---->
</div>
<div class="index_2">
    <img class="index_2bg" src="__static__/pokemon/img/russia/index_2.png">
    <div class="content">
        <!--英文-->
        <div class="index_2_tit" style="font-size: 25px;">
            игра предлагает
        </div>
        <!---->
        <div class="caroursel_box">
            <div class = "caroursel poster-main" data-setting = '{
	        "width":1100,
	        "height":500,
	        "posterWidth":780,
	        "posterHeight":480,
	        "scale":0.8,
	        "dealy":"5000",
	        "algin":"middle"
	    }'>
                <ul class = "poster-list">
                <?php if(is_array($bannerList) || $bannerList instanceof \think\Collection || $bannerList instanceof \think\Paginator): $i = 0; $__LIST__ = $bannerList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['type'] == 2): ?>
                    <li class = "poster-item">
                    <a href="<?php if(($vo['url'] != null) and ($vo['url'] != '')): ?><?php echo $vo['url']; else: ?>javascript:void(0);<?php endif; ?>" alt="<?php echo $vo['name']; ?>">
                    <img src="<?php echo $vo['image_url']; ?>" width = "100%" height="100%">
                    </a>
                    </li>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <div class = "poster-btn poster-prev-btn"></div>
                <div class = "poster-btn poster-next-btn"></div>
            </div>
        </div>
    </div>
</div>
<div class="alert-win" style="display: none">
    <img class="close" src="__static__/pokemon/img/russia/close.png">
    <div class="item"><span>Поздравляю！</span>получить</div>
    <div class="item">официальный сайт  пакет  привилегии.</div>
    <div class="item"><input id="privilegeCode" type="text" value="<?php echo $privilege_code['value']; ?>"><a style="width: 50px;" href="javascript:copyCode();">копия</a> </div>
</div>
<footer>
    <img src="__static__/pokemon/img/english/logo_btm.png">
    <p><?php echo $copyright['value']; ?></p>
    <p><?php echo $contact_us['value']; ?></p>
    <p>FB Page: <a href="https://business.facebook.com/LegendsofMonsters/" target="_blank">https://business.facebook.com/LegendsofMonsters/</a></p>
</footer>
<script type="text/javascript" src="__static__/pokemon/js/jquery.js"></script>
<script type="text/javascript" src="__static__/pokemon/dist/owl.carousel.js"></script>
<script type="text/javascript" src="__static__/pokemon/js/top_nav.js"></script>
<script type="text/javascript" src="__static__/pokemon/js/jquery.carousel.js"></script>
</body>
<script>
    Caroursel.init($('.caroursel'));
</script>
<script>
    var newsUrl="<?php echo url('News/news'); ?>";
    var detailUrl="<?php echo url('News/detail'); ?>";
    var owl = $('.owl-carousel');
    $(document).ready(function(){
        owl.owlCarousel({
            items:1,
            loop:true,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:false,
            nav:true,
            navText:["<",">"]
        });
    });
    owl.mouseenter(function(){
        owl.trigger('stop.owl.autoplay')
    }).mouseleave(function(){
        owl.trigger('play.owl.autoplay',[1000])
    });
    $(".close").click(function(){
        $(this).parent(".alert-win").hide()
    });
    $(".dl_gift").click(function(){
        $(".alert-win").show()
    })

    function copyCode(){   
        var e=document.getElementById("privilegeCode");//对象是contents 
        e.select(); //选择对象 
        document.execCommand("копия"); 
        alert("повторение успеха");
    }   

    $(".list_tit li").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
        var i=$(this).index();
        $("#list_"+i).show().siblings(".list_block").hide()
    })

    function openNews(id){
        location.href=newsUrl.substr(0,newsUrl.length-5)+"/typeId/"+id;
    }

    function openDetail(id){
        location.href=detailUrl.substr(0,detailUrl.length-5)+"/id/"+id;
    }
</script>
</html>