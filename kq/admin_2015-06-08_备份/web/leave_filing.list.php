<?php 
/**
* ==============================================
* Copyright (c) 2015 All rights reserved.
* ----------------------------------------------
* 请假报备列表页面
* ==============================================
* @date: 2015-5-25
* @author: Administrator
* @return:
*/
?>
<div class="search">	
	<?php
		if($_SESSION['role']!='1')
  			echo "<a href='index.php?type={$_GET['type']}&do=info&cn=$className'>请假报备申请</a>";
    	else
            echo "请假报备列表";
    ?>
</div>
<?php if($allow_show){?>
  	<form action="" method="post">	
	    <span>时间：</span>
	    <input type="text" name="fromTime" size="10" id="date_s" value="<?=$fromTime?>" readonly /> 
	    <span> 到：</span>
	    <input type="text" name="toTime" size="10" id="date_e" value="<?=$toTime?>" readonly />        
	    <span>姓名:</span>
	    <select name="uid">
	        <option value="">无</option>
	        <?php
				if($_SESSION['gpid']!='1')
					$sql = "select id,real_name from _sys_admin where id <>'99' and depId='".$_SESSION['depId']."'";
				else
					$sql = "select id,real_name from _sys_admin where id <>'99'";
				$res = $webdb->getList($sql);
				foreach($res as $val){
					if($val['id']==$uid)
						$selected='selected';
					else 
						$selected='';
					echo "<option value='{$val['id']}' $selected>{$val['real_name']}</option>";
				}
	        ?>   		 
		</select>
    	<input type="submit" name="sub" value="查 询" class="sub2">
    	<?php if($_SESSION['ADMIN_ID']==106 || $_SESSION['ADMIN_ID']=='99'){ ?>
    	<a href="leave_filingExcel.php?fromTime=<?=$_POST['fromTime']; ?>&toTime=<?=$_POST['toTime']; ?>&uid=<?=$_POST['uid']; ?>">导出excel</a>
		<?php } ?>
	</form>
<?php 
} 
?>
<table cellspacing="0" cellpadding="0" class="Admin_L">
    <tr>
      	<th scope="col" class="T_title">姓名</th>
      	<th scope="col" class="T_title">部门</th>
      	<th scope="col">时间</th>
      	<th scope="col">添加时间</th>
      	<th scope="col">状态</th>
      	<th scope="col">操作</th>
    </tr>
    <?php
        $admin = new admin();
        $dep = new department();
    ?>
    <? if($list){
    	foreach($list as $val){
	?>
    <tr class="Ls2">
        <td class="N_title"><?=$admin->getInfo($val['uid'],'real_name','pass')?></td>
        <td class="N_title"><?=$dep->getInfo($val['depId'],'name','pass')?></td>
      	<td><?=$val['fromTime'].' '.$val['hour_s'].':'.$val['minute_s']."~".$val['toTime'].' '.$val['hour_e'].':'.$val['minute_e']?></td>   	
      	<td><?=$val['addDate']?></td>
      	<td><?=$val['available']=='1'?'有效':'<font color="red">无效</font>'?></td>
      	<td class="E_bd">    
      		<a href="index.php?type=<?=$_GET['type']?>&do=info&cn=<?=$className?>&id=<?=$val['id']?>">查看</a>
      		<?if($val['available']=='1' ){?>
        |		<a href="javascript:;" onclick="voidFun('<?=$className?>','<?=$val['id']?>')">作废</a>
        	<?}?>
      	</td>
    </tr>
    <?}}else{?>
    	<tr class="Ls2">
    		<td class="N_title" colspan="8">无数据</td>
    	</tr>  
    <? 
		}
    	if($total && $list){
	?>
	<tr class="Ls2">
		<td class="N_title" colspan="8">总报备时间:<?=$total ?>小时</td>
	</tr>    
    <?php }?>
</table>