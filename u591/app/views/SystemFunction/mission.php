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
                        
                            <th> VIP</th>
                            <th>活跃人数</th>
                            <th>参与人数</th>
                            <th>参与率</th>
                            <th>完成1次人数</th>
                            <th>完成2次人数</th>
                            <th>完成3次人数</th>
                            <th>完成4次人数</th>
                            <th>完成5次人数</th>
                            <th>完成6次人数</th> 
                            <th>完成7次人数</th>
                            <th>完成8次人数</th>
                            <th>完成9次人数</th>
                            <th>完成1轮人数</th>
                            <th>完成2轮人数 </th>
                              <th>完成3轮人数</th>
                                <th>完成4轮人数</th>
                                
                                  <th>消耗钻石总数 </th>
                                    <th> 一键完成次数</th>
                                     
                         
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


$('#btype').change(function(){
	if($(this).val()==4){
		$('#gametype').hide();
	}else{
		$('#gametype').show();
	}
});
    var dataOption = {
        title:'',
        autoload: false,
        request_url:'<?php echo site_url('SystemFunction/mission');?>',
        callback: function (result) {
            if (result) {
                if (result.status!='ok') {
                    $("#dataTable").html('');
                    notify(result.info);
                    return false;
                }
                //console.log(result.data);

                 var table_html='';
                if(result['data']!='')
                for(var i in result['data']){
                    if(!isNaN(i)){
						var h = ((result['data'][i]['v'])/(result['data'][i]['c'])*100).toFixed(2)
                    	table_html += '<tr>' +
                        '<td>'+result['data'][i]['vip_level']+'</td>' +
                        '<td>'+result['data'][i]['c']+'</td>' +
                        '<td>'+result['data'][i]['v']+'</td>' +
                        '<td>'+h+'%</td>' +
                        '<td>'+result['data'][i]['v1']+'</td>' +
                        '<td>'+result['data'][i]['v2']+'</td>' +
                        '<td>'+result['data'][i]['v3']+'</td>' +
                        '<td>'+result['data'][i]['v4']+'</td>' +
                        '<td>'+result['data'][i]['v5']+'</td>' +
                        '<td>'+result['data'][i]['v6']+'</td>' +
                        '<td>'+result['data'][i]['v7']+'</td>' +
                        '<td>'+result['data'][i]['v8']+'</td>' +
                        '<td>'+result['data'][i]['v9']+'</td>' +
                        '<td>'+result['data'][i]['p1']+'</td>' +
                        '<td>'+result['data'][i]['p2']+'</td>' +
                        '<td>'+result['data'][i]['p3']+'</td>' +
                        '<td>'+result['data'][i]['p4']+'</td>' +
                        '<td>'+result['data'][i]['consume']+'</td>' +
                        '<td>'+result['data'][i]['achieve']+'</td>' +             
           
                        '</tr>';
                        }
                	
                    }
                
                $("#dataTable").html(table_html);
            }
        }
    };
</script>
<script src="<?=base_url()?>public/ma/js/common_req.js"></script>
