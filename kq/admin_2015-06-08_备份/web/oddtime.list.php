<div class="search">
      <?php if($_SESSION['role']!='1')
      {
      ?>
	  <a href="index.php?type=<?=$_GET['type']?>&do=info&cn=<?=$className?>">异常单申请</a>（注：在工作日期间，员工正常上下班却无打卡记录时使用）
      <?php
        }
        else
        {
            echo "异常单列表";
        }
        ?>
  </div>
  <table cellspacing="0" cellpadding="0" class="Admin_L">
    <tr>
      <th scope="col" class="T_title">姓名</th>
      <th scope="col" class="T_title">部门</th>
      <th scope="col">时间</th>
      <th scope="col">部门审核</th>
      <th scope="col">人事审核</th>
      <th scope="col" >总经理审核</th>
      <th scope="col" >状态</th>
      <th scope="col">操作</th>
    </tr>
    <?php
        $admin = new admin();
        $dep = new department();
    ?>
    <?foreach($list as $val){?>
    <tr class="Ls2" <?php if($val['depTag']=='1'||$val['perTag']=='1'||$val['manTag']=='1'){?> style="color: red;"<?php }?>>
      <td class="N_title"><?=$admin->getInfo($val['uid'],'real_name','pass')?></td>
      <td class="N_title"><?=$dep->getInfo($val['depId'],'name','pass')?></td>
      <td><?=$val['supdate'].' '.$val['addtime']?></td>
      <td><?=$val['depTag']=='0'?'未审核':($val['depTag']=='1'?'不通过':'通过')?></td>
      <td><?=$val['perTag']=='0'?'未审核':($val['perTag']=='1'?'不通过':'通过')?></td>
      <td><?=$val['manTag']=='0'?'未审核':($val['manTag']=='1'?'不通过':'通过')?></td>
      <td><?=$val['available']=='1'?'有效':'<font color="red">无效</font>'?></td>
      <td class="E_bd">
      	<a href="index.php?type=<?=$_GET['type']?>&do=info&cn=<?=$className?>&id=<?=$val['id']?>">查看</a>
        <?php
            $strs = acTime();
            $n =  strtotime($val['supdate'].' '.$val['fromtime'])-$strs;//时间差
            //$n = 1;
            //echo $n;
            //作废条件 1，5号前前一个月,否则当月 2，本人 3，状态必须是可作废
            //echo $n;
            if($n>=0 && $val['uid'] == $_SESSION['ADMIN_ID'] && $val['available']=='1' ){
        ?>
        |<a href="javascript:;" onclick="voidFun('<?=$className?>','<?=$val['id']?>','0')">作废</a>
        <?php 
            }
        ?>
      </td>
    </tr>
    <?}?>
  </table>