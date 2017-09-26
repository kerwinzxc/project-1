<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-4
 * Time: 下午4:32
 */
include '../inc/servers.php';
$data = array();
set_time_limit(6000);
//9月份新增注册用户累充500+用户的人数
if (!empty($_GET['bt']) && !empty($_GET['et'])){
/**
  *  10月1日至10月15日这段时间注册的用户，累计充值500元以上的玩家名单导出来，
  * 需要有玩家的角色名，区服，注册时间以及充值金额
*/
    $bt = $_GET['bt'];
    $et = $_GET['et'];
    $some_money = intval($_GET['some_money']);
    $dsn = "mysql:dbname=u591;host=localhost;port=3306";
    $pdo = new PDO($dsn, 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8';");
    $sql = "select PayID,SUM(PayMoney) AS money,ServerID from pay_log "
	." where Add_Time > '{$bt} 00:00:00' AND Add_Time<='{$et} 25:59:59'"
	." GROUP BY PayID,ServerID HAVING money>={$some_money}";
    $stmt = $pdo->prepare($sql);
//    print_r(array($date1, $date2));
    $stmt->execute();
    $pay = array();
	$real_money = 0;
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
        $pay[$row['PayID'].'_'.$row['ServerID']] = $row['money'];
		$acc_ser[$row['PayID']] = $row['ServerID'];
		$real_money += $row['money'];
    }
	// print_r($pay);
	// print_r($acc_ser);
    $ids = array_keys($acc_ser);
    //print_r($ids);
    $idstr = implode(',', $ids);
    $pdo = null;
    unset($pdo);

    $btm = date('ymd0000', strtotime($bt));
    $etm = date('ymd2359', strtotime($et));
	
	// $btm = date('Ymd', strtotime($bt));
    // $etm = date('Ymd', strtotime($et));
    $dsn2 = "mysql:dbname=kdgamedata;host=localhost;port=3316";
    $pdo2 = new PDO($dsn2, 'root', 't,i7.8fg6sh,5i');
	$sidStr = implode(',', $acc_ser);
	$sqlNew = "SELECT accountid,createtime FROM newmac WHERE ";
    $sql2 = <<<SQL
    SELECT n.accountid,n.createtime,p.serverid,p.name as username FROM newmac_20141201 n
    LEFT JOIN player_20141201 p ON p.accountid=n.accountid
    where n.createtime>$btm and n.createtime<=$etm
    AND n.accountid IN({$idstr})
	group by p.serverid,p.accountid
SQL;
// $sql2 = <<<SQL
    // SELECT p.accountid,p.daytime,p.serverid,p.name as username FROM player_20141201 p where p.daytime>$btm and p.daytime<=$etm
    // AND p.accountid IN({$idstr})
	// group by p.serverid
// SQL;
    // echo $sql2;
    $stmt = $pdo2->prepare($sql2);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo $ids;
    $pdo2 = null;
    unset($pdo2);
} 
    // print_r($ids);
    // echo count($ids);
    // exit;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>新增注册用户累充1000+用户的人数</title>
    <style>
        table{border-spacing: 0;width: 90%;}
        td,th{border: 1px solid #000; padding:4px;}
    </style>
</head>
<body>
<form action="#" method="get">
    <p>注册时间： <input type="date" name="bt" placeholder="Y-m-d格式" value="<?=$bt?>"/>
    ~
    <input type="date" name="et" placeholder="Y-m-d" value="<?=$et?>"/>~
    </p>
    <p>
        累积充值:
        <input type="number" name="some_money" value="<?=$_GET['some_money'] ? intval($_GET['some_money']) : 500?>">
    </p>
    <input type="submit" value="提交"/>
</form>
<table>
    <tbody>
	<?php $cnt = $money = 0;?>
    <?foreach($data as $d):?>
		<?php if(!isset($pay[$d['accountid'].'_'.$d['serverid']])) continue;?>
		<?php $cnt += 1;?>
		<?php $money += $pay[$d['accountid'].'_'.$d['serverid']]; ?>
        <tr>
            <td><?=$d['accountid']?></td>
            <td><?=$pay[$d['accountid'].'_'.$d['serverid']]?></td>
            <td><?=date('Y-m-d H:i', strtotime('20'.$d['createtime']));?></td>
            <td><?=iconv('gbk', 'utf-8',$d['username'])?></td>
            <td><?=$acc_ser[$d['accountid']]?></td>
        </tr>
    <?endforeach;?>
    </tbody>
	 <thead>
        <tr>
            <td colspan="2">新创建角色数：<?php echo $cnt;?></td>
            <td colspan="2">新创建角色数充值总金额：<?php echo $money;?></td>
            <td colspan="1">所有玩家（包含很早之前注册的玩家）充值总金额：<?php echo $real_money;?></td>
        </tr>
    <tr>
        <th>账号ID</th>
        <th>充值总金额</th>
        <th>注册时间</th>
        <th>角色名</th>
        <th>区服ID</th>
    </tr>
    </thead>
</table>
</body>
</html>
