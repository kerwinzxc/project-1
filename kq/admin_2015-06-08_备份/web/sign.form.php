    <?php
        $showtag = true;
        $user = new user();
        $uid='';
        if($_GET['id'])
        {
            $userinfo = $user->getUser($info['uid']);
            $uid = $info['uid'];
        }
        else
        {
            $userinfo = $user->getUser($_SESSION['ADMIN_ID']);
            $uid = $_SESSION['ADMIN_ID'];
        }
        $dep = new department();
        $depname = $dep->getInfo($userinfo['depId'],'name','pass');
    ?>
<?php
    if($_GET['id']){
        $strs = acTime();
        $n =  strtotime($info['addDate'].' 00:00:00')-$strs;//时间差
        //$n=1;
        //撤销条件 1，5号前前一个月即n>=0,否则当月 2，本人 3，状态必须是可作废
?>
    <tr>
      <td class="N_title">签呈人：</td><td class="N_title" colspan="7">
          <input type="text"  size="20" value="<?=$userinfo['real_name']?>" readonly>
          <input type="hidden" name="uid" value="<?=$uid?>">
      </td>
    </tr>
    <tr>
      <td class="N_title">部门：</td><td class="N_title" colspan="7">
          <input type="text"  size="20" value="<?=$depname?>" readonly>
          <input type="hidden" name="depId" value="<?=$userinfo['depId']?>">
      </td>
    </tr>
    <tr>
      <td class="N_title">日期：</td><td class="N_title" colspan="7">
        <input type="text" name="addDate" size="20" value="<?=date("Y-m-d")?>" readonly>
      </td>
    </tr>
    <tr>
      <td class="N_title">主旨：</td><td class="N_title" colspan="7">
          <input type="text"  size="30" name="subject"  readonly>
      </td>
    </tr>
    <tr>
      <td class="N_title">内容：</td><td class="N_title" colspan="7">
        <?=htmlEdit('content',$info['content'])?>
      </td>
    </tr>
    <tr>
      <td class="N_title">部门主管审核：</td><td class="N_title" colspan="7">
          <?
              $tag = ($_SESSION['role'] == '2' || ($_SESSION['role'] == '1' && $userinfo['depId']==$topDepId))&&$info['depTag']=='0'?'':'disabled';
              if($info['depTag']=='0')$showtag=false;
          ?>
          <select name="depTag" <?php echo $tag;?>  id="depTag">
              <option value="2" <?php echo $info['depTag']=='2'?'selected':'' ?>>通过</option>
              <option value="1" <?php echo $info['depTag']=='1'?'selected':'' ?>>不通过</option>
              <option value="0" <?php echo $info['depTag']=='0'?'selected':'' ?>>未审核</option>
          </select>&nbsp;<?php if($n>=0 &&$info['available']=='1'&&($_SESSION['role'] == '2' || ($_SESSION['role'] == '1' && $userinfo['depId']==$topDepId))&&$info['depTag']!='0'){ ?><a href="javascript:;" onclick="voidCancle('<?=$className?>','<?=$info['id']?>','dep')">撤销</a> <?php }?>&nbsp;<?php echo $info['depTime']?>
      </td>
    </tr>
    <tr>
        <td class="N_title">部门主管：</td><td class="N_title" colspan="7">
              <?=htmlEdit('noPassDep',$info['noPassDep'])?>
        </td>
    </tr>
    <tr>
      <td class="N_title">人事审核：</td><td class="N_title" colspan="7">
          <?
              $tag = $_SESSION['ADMIN_ID'] == $personnelId&&$info['perTag']=='0'&&$showtag?'':'disabled';
              if($info['perTag']=='0')$showtag=false;
          ?>
          <select name="perTag" <?php echo $tag;?> id="perTag">
              <option value="2" <?php echo $info['perTag']=='2'?'selected':'' ?>>通过</option>
              <option value="1" <?php echo $info['perTag']=='1'?'selected':'' ?>>不通过</option>
              <option value="0" <?php echo $info['perTag']=='0'?'selected':'' ?>>未审核</option>
          </select>&nbsp;<?php if($n>=0 &&$info['available']=='1'&&$_SESSION['ADMIN_ID'] == $personnelId&&$info['perTag']!='0'){ ?><a href="javascript:;" onclick="voidCancle('<?=$className?>','<?=$info['id']?>','per')">撤销</a> <?php }?>&nbsp;<?php echo $info['perTime']?>
      </td>
    </tr>
    <tr>
      <td class="N_title">人事：</td><td class="N_title" colspan="7">
              <?=htmlEdit('noPassPer',$info['noPassPer'])?>
      </td>
    </tr>
    <tr>
      <td class="N_title">总经理：</td><td class="N_title" colspan="7">
        <select name="manTag" <?php echo $_SESSION['role'] == '1'&&$info['manTag']=='0'&&$showtag?'':'disabled';?>  id="manTag">
            <option value="2" <?php echo $info['manTag']=='2'?'selected':'' ?>>通过</option>
            <option value="1" <?php echo $info['manTag']=='1'?'selected':'' ?>>不通过</option>
            <option value="0" <?php echo $info['manTag']=='0'?'selected':'' ?>>未审核</option> 
          </select>&nbsp;<?php if($n>=0 &&$info['available']=='1'&&$_SESSION['role'] == '1'&&$info['manTag']!='0'){ ?><a href="javascript:;" onclick="voidCancle('<?=$className?>','<?=$info['id']?>','man')">撤销</a> <?php }?>&nbsp;<?php echo $info['manTime']?>
      </td>
    </tr>
    <tr>
        <td class="N_title">总经理：</td><td class="N_title" colspan="7">
              <?=htmlEdit('noPassMan',$info['noPassMan'])?>
        </td>
    </tr>
    <?php
    }
    else
    {
    ?>
            <tr>
              <td class="N_title">签呈人：</td><td class="N_title" colspan="7">
                  <input type="text"  size="20" value="<?=$userinfo['real_name']?>" readonly>
                  <input type="hidden" name="uid" value="<?=$uid?>">
              </td>
            </tr>
            <tr>
              <td class="N_title">部门：</td><td class="N_title" colspan="7">
                  <input type="text"  size="20" value="<?=$depname?>" readonly>
                  <input type="hidden" name="depId" value="<?=$userinfo['depId']?>">
              </td>
            </tr>
            <tr>
              <td class="N_title">日期：</td><td class="N_title" colspan="7">
                <input type="text" name="addDate" size="20" value="<?=date("Y-m-d")?>" readonly>
              </td>
            </tr>
            
            <tr>
              <td class="N_title">主旨：</td><td class="N_title" colspan="7">
                 <input type="text"  size="30" name="subject" id="subject">
              </td>
            </tr>
            <tr>
              <td class="N_title">内容：</td><td class="N_title" colspan="7">
                <?=htmlEdit('content',$info['content'])?>
              </td>
            </tr>
    <?php
    }
    ?>
<script>
function checkForm(form){
	var msg='';
        if($('#subject').val()=='')
        {
            alert("请输入主旨");
            return false;
        }
        if(GetContents('content')=='')
        {
            alert("请输入内容");
            return false;
        }
	if(msg){
		alert(msg);
		return false;
	}else{
	    return true;
	}
}
</script>