<?php
$className=$_POST['cn'];
$from = $_POST['fromTime'];
$to = $_POST['toTime'];
$uid = $_POST['uid'];
    if(!$_POST['fromTime'])
    {
        $from = date('Y-m')."-01";
    }
    if(!$_POST['toTime'])
    {
        $to = date('Y-m-d');
    }
    $adminList = new admin();
    $adminList->p=$_GET['p'];
    $adminList->wheres .=" and id<>'99'";
    if($uid)$adminList->wheres .=" and id='$uid'";
    $adminList->pageReNum = "100";
    $adminres = $adminList->getArray("pass");

if(!permission::check("overtime",'s_tag')){
    permission::errMsg();
    exit;
}

if($className)
{
    $sqlstr .= "addtag='1' and available='1'";
    if($from)
    {
        $sqlstr .=" and fromTime>='$from'";
    }
    if($to)
    {
        $sqlstr .=" and toTime<='$to'";
    }
    
        foreach($adminres as $key=>$val)
        {
            $total_time = 0;
            $ssql = "select fromTime,toTime,hour_s,minute_s,hour_e,minute_e from _web_$className where $sqlstr and uid='".$val['id']."'";
            $reslist = $webdb->getList($ssql);
            foreach($reslist as $v)
            {
                $totaltime = strtotime($v['toTime']." ".$v['hour_e'].":".$v['minute_e'].":00")-strtotime($v['fromTime']." ".$v['hour_s'].":".$v['minute_s'].":00");
                $total_time += $totaltime;
            }
            $adminres[$key]['totaltime'] = $total_time/60;
        }
    $pageCtrl=$adminList->getPageInfoHTML();
}
?>
<h1 class="title"><span>加班与调休统计查询</span></h1>
 <div class="pidding_5">
     <div class="search">
         <form action="" method="post">
             类型:<select name="cn">
                 <option value="">请选择</option>
                 <option value="overtime" <?php echo $className=='overtime'?'selected':'' ?>>加班</option>
                 <option value="hugh" <?php echo $className=='hugh'?'selected':'' ?>>调休</option>
             </select>
             时间：<input type="text" name="fromTime" size="10" id="date_s" value="<?=$from?>" readonly> 到：
        <input type="text" name="toTime" size="10" id="date_e" value="<?=$to?>" readonly>        
        姓名:<select name="uid">
              <option value="">全部</option>
                <?php
                    $sql = "select id,real_name from _sys_admin where id <>'99'";
                    $res = $webdb->getList($sql);
                    foreach($res as $val){
                ?>
              <option value="<?=$val['id']?>" <?php echo $val['id']==$uid?'selected':'' ?>><?=$val['real_name']?></option>   
        <?}?>
              </select>
        <input type="submit" name="sub" value="查 询" class="sub2">
         </form>
    </div>
   <?php if($className){?>
  <table cellspacing="0" cellpadding="0" class="Admin_L">
    <tr>
      <th scope="col" class="N_title">姓名</th>
      <th scope="col" class="N_title">总时间</th>
    </tr>
    
    <?foreach($adminres as $val){?>
    <tr class="Ls2">
        <td class="N_title"><?=$val['real_name']?></td>
        <td class="N_title"><?=number_format($val['totaltime']/60,1)?>小时</td>
    </tr>
    <?}?>
  </table>
  <div class="news-viewpage"><?=$pageCtrl?></div>
  <?php }?>
 </div>