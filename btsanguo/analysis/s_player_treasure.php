<?php
$initDbSource = true;
include 'header.php';

$columns = array('treasure', 'mibao', 'sky');
$col_id  = intval($_GET['_col']);
if (!array_key_exists($col_id,  $columns)) {
    exit('错误的ID');
}
$col_nm  = $columns[$col_id];

$bt = !empty($_GET['bt']) ? $_GET['bt'] : date('Y-m-d', strtotime('-2 days'));
$et = !empty($_GET['et']) ? $_GET['et'] : date('Y-m-d');

$s_date = !empty($bt) ? date('1ymd',strtotime($bt)) : date('1ymd',$_SERVER['REQUEST_TIME']);
$e_date = !empty($et) ? date('1ymd',strtotime($et)) : date('1ymd',$_SERVER['REQUEST_TIME']);

$where = "where daytime BETWEEN $s_date AND $e_date AND level>24 and viplev>0";
if (isset($_GET['level']) && $_GET['level']>0) {
    $min = intval($_GET['level']) * 100;
    $max = $min + 99;
    $where .= " AND `{$col_nm}` BETWEEN $min AND $max";
}
if (count($serverids)) {
    $where .= " AND serverid IN(".implode(',', $serverids).")";
}
$sql = <<<SQL
SELECT `viplev`,`{$col_nm}` as col from player_info $where
SQL;
if ($_GET['debug']) {
    echo '<prev>';
    echo $sql;
    echo '</prev>';
}
$stmt = $db_source->prepare($sql);
$stmt->execute();
while( $tmp = $stmt->fetch(PDO::FETCH_ASSOC) ){
//    print_r($tmp);
    $hundred = floor($tmp['col'] / 100);
//    echo $hundred;
//    exit;
    //百位数表示层数
//    echo $hundred,'<br/>';
    //十位个位表示完成的个数（12为积满）
    $complete = $tmp['col'] - ($hundred * 100);
    $lists[$tmp['viplev']]['people']  += 1;
    $lists[$tmp['viplev']]['total']   += $tmp['col'];
//    $lists[$tmp['viplev']]['cnt']     += $complete;
    if ($complete==12) {
        $lists[$tmp['viplev']]['full']     += 1;
    }
}
if ($_GET['debug']) {
    echo '<pre>',$sql,'</pre>';
    print_r($lists);
}
?>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form class="form-inline" role="form" action="<?=$action;?>">
                        <input name="_col" type="hidden" value="<?=$col_id?>"/>
                        <div class="form-group">
                            <label>时间</label>
                            <input name="bt" type="text" class="form-control" size="18" value="<?=$bt?>" onfocus="SelectDate(this,'yyyy-MM-dd<?=$time_format?>',0,0)">
                            --
                            <input name="et" type="text" class="form-control" size="18" value="<?=$et?>" onfocus="SelectDate(this,'yyyy-MM-dd<?=$time_format?>',0,0)">
                        </div>
                        <div class="form-group">
                            <label>区服ID</label>
                            <input type="number" name="min_sid" placeholder="请输入区服ID（数字）" value="<?=$_GET['min_sid']?>" class="form-control" size="12"/>至
                            <input type="number" name="max_sid" placeholder="请输入区服ID（数字）" value="<?=$_GET['max_sid']?>" class="form-control" size="12"/>
                        </div>
                        <div class="form-group">
                            <label>层数</label>
                            <input type="number" name="level" placeholder="数字1到9" value="<?=$_GET['level']?>" class="form-control" size="1"/>
                        </div>
                         <button type="submit" class="btn btn-primary">查 询</button>
                    </form>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover onlineFlag">
                            <thead>
                            <tr>
                                <th>vip 等级</th>
                                <th>人数</th>
                                <th>平均完成个数</th>
                                <th>集满的人数</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (count($lists)>0):?>
                            <?php ksort($lists);?>
                            <?php foreach($lists as $viplev=>$list):?>
                                <tr>
                                    <td>VIP <?=$viplev?></td>
                                    <td><?=$list['people']?></td>
                                    <td><?=$list['total']/$list['people']  ?></td>
                                    <td><?=isset($list['full']) ? $list['full'] : 0?></td>
                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
<?php include 'footer.php';?>