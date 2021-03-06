<section id="content">
    <div class="container">
        <div class="block-header">
            <h2><?php echo $page_title;?></h2>
        </div>
        <div class="col-md-12">
            <div class="card">
                <?php echo $search_form;?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="data-table-basic" class="table table-striped">
                        <thead>
                        <tr>
                            <th>类型</th>
                            <th>0-10级</th>
                            <th>11-20级</th>
                            <th>21-30级</th>
                            <th>31-40级</th>
                            <th>41-50级</th>
                            <th>51-60级</th>
                            <th>61-70级</th>
                            <th>71-80级</th>
                            <th>81-90级</th>
                            <th>91级以上</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="dataTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<script>-->
<!--    $("#submit").attr('type', 'submit');-->
<!--</script>-->
<script src="<?=base_url()?>public/ma/js/layer.js"></script>
<script>
function showdetail(actid,where){
	layer.open({
		  type: 2,
		  title: 'iframe父子操作',
		  maxmin: true,
		  shadeClose: true, //点击遮罩关闭层
		  area : ['800px' , '520px'],
		  content: '../frame/FixchangeDetail?actid='+actid
		  });
}

    var dataOption = {
        title:'',
        autoload: true,
        request_url:'<?php echo site_url('SystemFunction/Fixchange');?>',
        callback: function (result) {
            if (result) {
                if (result.status!='ok') {
                    $("#dataTable").html('');
                    notify(result.info);
                    return false;
                }
                //console.log(result.data);

                var table_html = '',
                    len = result.data.length;
                for (var i in result.data) {
                    //if (isNaN(i)) continue;
                    //for (var i=0;i<len; i++) {
                    table_html += '<tr>' +
                        '<td>'+result['data'][i]['act_name']+'</td>' +
                        '<td>'+result['data'][i]['level_1']+'</td>' +
                        '<td>'+result['data'][i]['level_2']+'</td>' +
                        '<td>'+result['data'][i]['level_3']+'</td>' +
                        '<td>'+result['data'][i]['level_4']+'</td>' +
                        '<td>'+result['data'][i]['level_5']+'</td>' +
                        '<td>'+result['data'][i]['level_6']+'</td>' +
                        '<td>'+result['data'][i]['level_7']+'</td>' +
                        '<td>'+result['data'][i]['level_8']+'</td>' +
                        '<td>'+result['data'][i]['level_9']+'</td>' +
                        '<td>'+result['data'][i]['level_10']+'</td>' +
                        '<td>'+result['data'][i]['text']+'</td>' +
                        '</tr>';
                }
                $("#dataTable").html(table_html);
            }
        }
    };
</script>
<script src="<?=base_url()?>public/ma/js/common_req.js"></script>
