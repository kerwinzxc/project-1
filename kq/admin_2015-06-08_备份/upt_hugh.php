<?php
include_once('common.inc.php');

$id =$_REQUEST['id'];
$sql="select id,real_name,totalOverTime from _sys_admin where id!='99'";
if($id){
	$sql.=" and id='$id'";
}
$query=$webdb->query($sql);
$list=array();
while ($rs=mysql_fetch_assoc($query)){
	$list[]=$rs;
}

if($_POST['upt']){
	foreach ($_POST as $key=>$val){
		if(strstr($key,'hugh')){
			$tmp_id=str_replace('hugh','',$key);
			if($val&&$_POST['old'.$tmp_id]-$val>0){
				$hughTime=$val*60;
				$totalOverTime=($_POST['old'.$tmp_id]-$val)*60;
				$sql="update _sys_admin set totalOverTime='$totalOverTime' where id='$tmp_id'";
				$query=$webdb->query($sql);
				//$hughTime=$val-$_POST['old'.$tmp_id]*60;//修改的总调休时间减去原来的,得到调休多少时间
				$sql="insert into hugh_time_log(operaterID,hughID,hughTime,addTime) 
				values('$_SESSION[ADMIN_ID]','$tmp_id','$hughTime','".date("Y-m-d H:i:s")."')";
				$query=$webdb->query($sql);
			}
		}
	}
	echo '<script>alert(\'修改完成\');</script>';
	echo '<script>location.replace(document.referrer);</script>';exit;
}
$p=$_REQUEST['p'];
if(!$p)$p='1';
$pn = '15';
$pageCtrl=getPageInfoHTMLForRecord($list,$p,'',$pn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>海牛考勤管理系统</title>
<!-- JQuery文件 -->
<script src="../include/jscode/jquery.js" type="text/javascript"></script>
<script src="../include/jscode/jquery/jquery.datepick.js" type="text/javascript"></script>
<script src="../include/jscode/jquery/jquery.datepick-zh-CN.js" type="text/javascript"></script>
<link href="../include/jscode/jquery/jquery.datepick.css" rel="stylesheet" type="text/css" />
<!-- Cookie文件 -->
<script src="../include/jscode/cookie.js" type="text/javascript"></script>
<!-- 公共JS文件 -->
<script type="text/javascript" src="../comm/comm.js"></script>
<script type="text/javascript" src="index.js"></script>
<link href="../include/jscode/messager.css" rel="stylesheet"  type="text/css" />
<link href="style/css/admin2.css" rel="stylesheet" type="text/css" />
<LINK rev=stylesheet media=all href="../images/tree/tree_menu.css" type="text/css" rel=stylesheet />
<script language="JavaScript" src="../images/tree/tree_menu.js"></script>
<script src="../include/jscode/jquery.messager.js"></script>
</head>
<body>
<form action="upt_hugh.php?p=<?php echo $p?>" method="post">
<div style="width:100%;">
	<div style="float:left; padding:0 0 5px 0"><img src="admin_logo.jpg" border="0"  width="202" height="45"></div>
 <div style="float:right;padding:5px"><A HREF="login.php?out=yes"><img src="style/images/main_r1_c35.gif" width="16" height="40" border="0" title="登出"></A></div>
 <div style="float:right;padding:20px">欢迎使用：<? $admin = new admin();echo $admin->getInfo($_SESSION['ADMIN_ID'], 'real_name', 'pass')?></div>
</div>
<div style="width:100%; height: 90%; float: left;">
	<div id="left">
		<div class="left_box">
			 <?php include('index.menu.php')?>
		</div>
	</div>
	<div id="right">
	<div class="search">
调休时间更改<font color="red">(扣除的时间超过总调休时间，将不做更改)</font><br/>
 姓名:<select name="id">
		<option value="">全部</option>
                <?php
                    $sql = "select id,real_name from _sys_admin where id!='99'";
                    $res = $webdb->getList($sql);
                    foreach($res as $val){
                ?>
		<option value="<?=$val['id']?>" <?php echo $val['id']==$_POST['id']?'selected':'' ?>><?=$val['real_name']?></option>
				<?}?>
	</select>
	<input type="submit" value="查询" class="sub2" name="sel"/>&nbsp;&nbsp;&nbsp;
	<input type="submit" value="修改" class="sub2" name="upt" onclick="return confirm('确认提交?')"/>

</div>
  <table cellspacing="0" cellpadding="0" class="Admin_L">
    <tr>
        <th scope="col" class="T_title">ID</th>
        <th scope="col" class="T_title">姓名</th>
        <th scope="col" class="T_title">现有总调休时间(小时)</th>
		<th scope="col" class="T_title">扣调休时间(小时)</th>
    </tr>
       <?
    //计算第一条
    $first = $pn*($p-1);
    $f =0;
      for($i=0;$i<$pn;$i++){
      $f=$first+$i;
          if($f<=count($list)-1)
          {
            $vs = $list[$f];
    ?>
    <tr class="Ls2">
        <td class="N_title"><?php echo $vs['id'];?></td>
        <td class="N_title"><?php echo $vs['real_name'];?></td>
        <td class="N_title"><input type="text" readonly="readonly" size="10" name="old<?php echo $vs['id'];?>" value="<?php echo number_format($vs['totalOverTime']/60,1);?>" /></td>
        <td class="N_title"><input type="text" size="10" maxlength="6" name="hugh<?php echo $vs['id'];?>" value="" /></td>
    </tr>
    <?
          }
    }
    ?>
  </table>
<div class="news-viewpage"><?=$pageCtrl?></div>
	</div>
</div>
</form>
</body>
</html>
<script>
$(document).ready(function (){
        $('#date_s').datepick({dateFormat: 'yy-mm-dd'});
        $('#date_e').datepick({dateFormat: 'yy-mm-dd'});
	//时间控件
	//$("input[date]").jSelectDate({ yearEnd: 2010, yearBegin: 1995, disabled : false, css:"select", isShowLabel : true });
});
</script>
<?if($altmsg || $altmsg=$_GET['altmsg']){?>
<script>alert('<?=$altmsg?>');</script>
<?}?>