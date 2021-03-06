<style>
    .table-striped th{text-align: center;}
    #thead td,#thead th{line-height: 25px !important;}
    .table-striped td{line-height: 50px !important;}
    .table-striped td, .table-striped th{ border:1px solid #c0c0c0 !important;}
    #ul-list .checkbox input{opacity: 0;}
    .ul-event-list {list-style: none;margin: 0;}
    .ul-event-list li{float: left;width: 150px;}
    .table > tbody > tr > td{padding-left: 30px;}
    .chart {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 60px;
        /*margin-top: 50px;*/
        /*margin-bottom: 50px;*/
        text-align: center;
    }
    .chart canvas {
        position: absolute;
        top: 0;
        left: 0;
    }
    .percent {
        display: inline-block;
        line-height: 60px;
        z-index: 2;
        font-size: 10px;
    }
    .percent:after {
        content: '%';
        margin-left: 0.1em;
        /*font-size: .4em;*/
    }
</style>
<section id="content">
    <div class="container">
        <div class="block-header">
            <h2><?php echo $page_title;?></h2>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>选择查询条件<small></small></h2>
                </div>
                <div class="card-body card-padding">
                    <form id="search_form" method="get" action="">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="fg-line">
                                        <input title="查询开始时间" type="text" name="date1" value="<?php echo $bt?>" class="form-control date-picker" placeholder="查询开始时间">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="fg-line">
                                        <input title="查询截止时间" type="text" name="date2" value="<?php echo $et?>" class="form-control date-picker" placeholder="查询截止时间">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select multiple='multiple' id="channel_id_mul" data-name="channel_id" class="mul">
                                        <option value="0">选择渠道</option>
                                        <?php foreach($channel_list as $channel_id=>$channel_name):?>
                                            <option value="<?php echo $channel_id?>"> <?php echo $channel_name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select multiple='multiple' id="type_id_mul" data-name="type_id" class="mul">
                                        <option value="0">选择类型</option>
                                        <?php foreach($events as $key=>$event):?>
                                            <option value="<?php echo $key?>"> <?php echo $key . '-'. $event;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                                <!--输出其它查下条件-->
                                <div class="col-sm-7">
                                    <button type="button" id="submit"class="btn btn-primary btn-sm m-t-10 waves-effect">查询</button>
                                </div>
                        </div>
                        <!--<div id="ul-list" class="row">
                            <ul class="col-sm-12 ul-event-list">
                                <li><label class="checkbox checkbox-inline m-r-20">
                                        <input id="chk-all" type="checkbox" value="0">
                                        <i class="input-helper"></i>
                                        <strong style="color:#ff0000">全选/反选</strong>
                                    </label>
                                </li>
                                <li><label class="checkbox checkbox-inline m-r-20">
                                        <input id="unSelect" type="checkbox" value="0">
                                        <i class="input-helper"></i>
                                        <strong style="color:#ff0000">全不选</strong>
                                    </label>
                                </li>
                            </ul>
                            <ul id="list" class="col-sm-12 ul-event-list">
                                <?php /*foreach ($events as $key=>$event):*/?>
                                    <li><label class="checkbox checkbox-inline m-r-20">
                                            <input class="events" name="type_id[]" type="checkbox" value="<?php /*echo $key;*/?>">
                                            <i class="input-helper"></i>
                                            <?php /*echo $event*/?>
                                        </label>
                                    </li>
                                <?php /*endforeach;*/?>
                            </ul>
                        </div>-->
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="data-table-basic" class="table table-striped">
                        <thead id="thead">
                            <tr>
                                <th>总数:</th>
                                <td id="total_col" colspan="3">结果</td>
                            </tr>
                            <tr>
                                <th>事件名称</th>
                                <th>结果</th>
                                <th>数量</th>
                                <th>比例</th>
                            </tr>
                        </thead>
                        <tfoot id="tfoot">
                            <tr>
                                <th>事件名称</th>
                                <th>结果</th>
                                <th>数量</th>
                                <th>比例</th>
                            </tr>
                        </tfoot>
                        <tbody id="dataTable"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var events = <?=json_encode($events, JSON_UNESCAPED_UNICODE);?>;
    var dataOption = {
        title:'',
        autoload: true,
        request_url:'<?php echo site_url('Home/FoolBird');?>',
        callback: function (result) {
            if (result) {
                if (result.status!='ok') {
                    $("#dataTable").html('');
                    notify(result.info);
                    return false;
                }
                $("#total_col").html(result.total);
                $("#dataTable").html(result.data);
                $('.chart').easyPieChart({
                    size:60,
                    easing: 'easeOutBounce',
                    onStep: function(from, to, percent) {
                        $(this.el).find('.percent').text($(this.el).data('percent'));
                    }
                });
            }
        }
    };
</script>
<script src="https://cdn.bootcss.com/easy-pie-chart/2.1.6/jquery.easypiechart.min.js"></script>
<script src="<?=base_url()?>public/ma/js/common_req.js"></script>
