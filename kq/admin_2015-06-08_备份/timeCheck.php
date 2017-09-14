<?php
include_once('common.inc.php');
$id = $_REQUEST['id'];
//echo $id;
$ov = new overtime();
$info = $ov->getInfo($id, '', 'pass');
//审核提交时间:如果有考勤数据，按考勤规则增加时间判断 ....start
            $ad = new admin();
            $card_id = $ad->getInfo($info['uid'],'card_id','pass');
            $record = new record();
            $record->wheres = "(recorddate>='".$info['fromTime']."' and recorddate<='".$info['toTime']."') and card_id='$card_id' ";
            $record->setOrder(' recorddate asc');
            $relist = $record->getList();

            $time1 = strtotime($info['fromTime']." ".$info['hour_s'].":".$info['minute_s'].":00");
            $time2 = strtotime($info['toTime']." ".$info['hour_e'].":".$info['minute_e'].":00");
            $outtag = false;//跳出循环变量
            $yestodaytag = '0';   //通宵加班标记
            $lastv = '';//前一天最后一次是进门的打卡的时间
            $lastdate = '';//前一天19点的时间戳
            foreach($relist as $list)
            {
                $timea = strtotime($list['recorddate']." 12:00:00");
                $timeb = strtotime($list['recorddate']." 13:30:00");
                $timec = strtotime($list['recorddate']." 18:30:00");
                $timed = strtotime($list['recorddate']." 19:00:00");
                $ary = array();
                preg_match_all("/(\d{2}:\d{2}:\d{2}\s\[进门\]|\d{2}:\d{2}:\d{2}\s\[出门\])/",$list['addtime'],$out);
                if($yestodaytag=='1' && substr($out[0][0],9)=='[出门]') //表示通宵加班 条件：前一天最后一次打进门卡，第2天第一次打的是出门卡 且加班起始时间大于前一天晚上7点
                {
                   if(strtotime($lastv)<=$time1 && strtotime($list['recorddate']." ".substr($out[0][0],0,8))>=$time2 && $time1>=$lastdate && $time2<=$timea)
                   {
                        $outtag = true;
                   }
                }
                foreach($out[0] as $key=>$v)
                {
                    $ary[$key]['val'] = substr($v,0,8);
                    if(substr($v,9)=='[进门]')
                    {
                        $ary[$key]['tag'] = '1';
                        $yestodaytag = '1';
                        $lastv = $list['recorddate']." ".$ary[$key]['val'];
                        $lastdate = $timed;
                    }
                    elseif(substr($v,9)=='[出门]')
                    {
                        $ary[$key]['tag'] = '0';
                        $yestodaytag = '0';
                    }
                }
                $j =count($ary)-1;
                for($i=0;$i<$j;$i++)
                {
                    if($i<$j)//判断是否最后一条数据
                    {
                        if($ary[$i]['tag']=='1'||$ary[$i+1]['tag']=='0')//判断加班时间是否在一次进出的时间内并且时间在（小于12点段） 或者 （在13点半到18点半段）或者（大于19点段） 是则通过，不是则继续判断
                        {
                           if(strtotime($list['recorddate']." ".$ary[$i]['val'])<=$time1 && strtotime($list['recorddate']." ".$ary[$i+1]['val'])>=$time2 && (($time1>=$timeb&&$time2<=$timec) || $time2<=$timea || $time1>=$timed))
                           {
                                $outtag = true;
                           }
                        }
                    }
                    if($outtag)break;
                }
                if($outtag)break;
            }
            if($outtag)echo "yes";
            else echo "no";
            //审核提交时间....end
?>