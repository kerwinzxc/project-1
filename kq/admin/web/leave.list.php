<div class="search">
	<? if($_SESSION['role']!='1'){ ?>
		<a href="index.php?type=<?=$_GET['type']?>&do=info&cn=<?=$className?>">请假申请</a>
    <? }else{ echo "请假列表"; } ?>
</div>
<? if($allow_show){?>
<form action="" method="post">
  	<span>时间：</span>
  	<input type="text" name="fromTime" size="10" id="date_s" value="<?=$fromTime?>" readonly>
  	<span>到：</span>
  	<input type="text" name="toTime" size="10" id="date_e" value="<?=$toTime?>" readonly>        
  	<span>姓名:</span>
  	<?if($_SESSION['role']!=3 || $_SESSION['ADMIN_ID']=='106'){ //财务特殊所以加个判断?>     
  	<span>部门:</span>
  	<select name="depId" id="departmentSelect">
  		<option value=''>请选择...</option>
    	<? foreach ($depList as $v){?>
			<option value='<?=$v['id'] ?>' <? if($depId==$v['id']){ echo 'selected';} ?>><?=$v['name']?></option>
		<? }?>
	</select>
	<span>姓名:</span> 
    <select name="uid" id="uidSelect">
        <option value=''>请选择...</option>
       	<? foreach ($userList as $v){ ?>
        	<option value='<?=$v['id']?>' <? if($uid==$v['id']){ echo 'selected';} ?>><?=$v['real_name'] ?></option>
        <? } ?>
	</select>
	<?} ?>
    <input type="submit" name="sub" value="查 询" class="sub2">
</form>
<? } ?>
<table cellspacing="0" cellpadding="0" class="Admin_L">
    <tr>
      	<th scope="col" class="T_title">姓名</th>
      	<th scope="col" class="T_title">部门</th>
      	<th scope="col">时间</th>
		<th scope="col">请假类型</th>
      	<th scope="col">部门审核</th>
      	<th scope="col">人事审核</th>
      	<th scope="col" >总经理审核</th>
      	<th scope="col" >状态</th>
      	<th scope="col">操作</th>
    </tr>
    <?
        $admin = new admin();
        $dep = new department();
    ?>
    <? if($list){foreach($list as $val){?>
    <tr class="Ls2" <? if($val['depTag']=='1'||$val['perTag']=='1'||$val['manTag']=='1'){?> style="color: red;"<? }?>>
    	<td class="N_title"><?=$admin->getInfo($val['uid'],'real_name','pass')?></td>
        <td class="N_title"><?=$dep->getInfo($val['depId'],'name','pass')?></td>
      	<td><?=$val['fromTime'].' '.$val['hour_s'].':'.$val['minute_s']."~".$val['toTime'].' '.$val['hour_e'].':'.$val['minute_e']?></td>
		<td><?=$val['leaveType']?></td>
      	<td><?=$val['depTag']=='0'?'未审核':($val['depTag']=='1'?'不通过':'通过')?></td>
      	<td><?=$val['perTag']=='0'?'未审核':($val['perTag']=='1'?'不通过':'通过')?></td>
      	<td><?=$val['manTag']=='0'?'未审核':($val['manTag']=='1'?'不通过':'通过')?></td>
      	<td><?=$val['available']=='1'?'有效':'<font color="red">无效</font>'?></td>
      	<td class="E_bd">
      		<a href="index.php?type=<?=$_GET['type']?>&do=info&cn=<?=$className?>&id=<?=$val['id']?>">查看</a>
        	<?
            	$strs = acTime();
            	$n =  strtotime($val['fromTime'].' '.$val['hour_s'].':'.$val['minute_s'].':00')-$strs;//时间差 
            	//$n =  strtotime($val['fromTime'].' '.$val['hour_s'].':'.$val['minute_s'].':00')-time();//时间差
            	//作废条件 1，半个小时以上 2，本人 3，状态必须是可作废
            	if($n>=0 && $val['uid'] == $_SESSION['ADMIN_ID'] && $val['available']=='1' ){
        	?>
        |	<a href="javascript:;" onclick="voidFun('<?=$className?>','<?=$val['id']?>')">作废</a>
        	<? } ?>
        	<!-- |
      		<a href="javascript:;" onclick="delFun('<?=$className?>','<?=$val['id']?>')">刪除</a>-->
      </td>
    </tr>
    <? }}else{ ?>
    	<tr class="Ls2"><td class="N_title" colspan="8">无数据</td></tr>  
    <? } ?>
   	<? if($total && $list){?>
		<tr class="Ls2"><td class="N_title" colspan="8">总请假时间:<?=$total ?>小时</td></tr>    
    <? }?>
</table>