<?php
/*
 * 递归某个表,获得下拉菜单
 */
function dgArray($tab,$where='',$pid=0,$ex='',$nf='name',$pf='parent_id',$kf='id'){
	global $webdb;
	$sql="select ".$kf.",".$nf." from ".$tab." where ".$pf."='".$pid."' ";
	if($where) $sql.=$where;
	$res=$webdb->getList($sql);
	!$res && $res=array();
	foreach($res as $val){
		$val['dicval']=$val[$kf];
		$val['name']=$ex.$val[$nf];
		$reAry[]=$val;
		$reAry=array_merge($reAry,dgArray($tab,$where,$val[$kf],$ex.'&nbsp;&nbsp;',$nf,$pf,$kf));
	}
	!$reAry && $reAry=array();
	return $reAry;
}

function arrayOption($ary,$def=null,$py=true,$desc=true){
	foreach($ary as $val){
		if($val['id']==$def) $selected='selected';
		else $selected='';
		$str.='<option value="'.$val['id'].'" '.$selected.'>'.$val['py'].' '.$val['name'].'</option>';
	}
	return $str;
}

function resetArray($parent_id,$array){
	$retVal=array();
	foreach($array as $val){
	   if($parent_id==$val["parent_id"]){
	    $retVal[]=$val;
	    //$retVal[count($retVal)-1]['indent'].='&nbsp;&nbsp;&nbsp;&nbsp;';
	    $tmp=array();
	    $tmp=resetArray($val["id"],$array);
	    if($tmp){
	     foreach($tmp as $val2){
	      $retVal[]=$val2;
	      $retVal[count($retVal)-1]['indent'].='&nbsp;&nbsp;&nbsp;&nbsp;';
		  $retVal[count($retVal)-1]['flag']++;
	     }
	    }
	    unset($tmp);
	   }
	}
	return $retVal;
}
function hasSub($id,$array){
	$retVal=false;
	foreach($array as $ary){
		if($ary["parent_id"]==$id){
			$retVal=true;
			break;
		}
	}
	return $retVal;
}
function createmenu($array,$imgRootPath,$divIdPrefix="",$parent_id=0){
	$result="";
	$rs=resetArray($parent_id,$array);
	$result= '<div class="tree_menu" id="'.$divIdPrefix.'_tree_menu" >';
	for($i=0;$i<count($rs);$i++){
		if($rs[$i]["name"]=='请假报备' && $_SESSION["ADMIN_ID"]!='106' &&  $_SESSION['role']!=1){	
			continue;
		}
		$result.="<div width='100%'>";
		for($j=0;$j<$rs[$i]["flag"];$j++){
			if($rs[$i]["name"]&&(($j+1)==$rs[$i]["flag"])){
				if($rs[$i+1]["parent_id"]==$rs[$i]["parent_id"]){
					$result.= '<img src="'.$imgRootPath.'images/tree/H.gif">';
				}else{
					if($rs[$i]["flag"]<=($rs[$i+1]["flag"]+1)){
						$result.= '<img src="'.$imgRootPath.'images/tree/H.gif">';
					}else{
						$result.= '<img src="'.$imgRootPath.'images/tree/L.gif">';
					}
				}
				//echo "<hr />";
			}else{
				$result.= '<img src="'.$imgRootPath.'images/tree/I.gif">';
			}
		}
		
		$rsid=$rs[$i]["id"];
		$flag_img="nfolder.gif";
		$onclick="";
		$A_onclick="";
		if(hasSub($rs[$i]["id"],$array)){
			$flag_img="ofolder.gif";
			//隐藏
			if($rs[$i]["hide_sub"]==1) $flag_img="folder.gif";
			
			$onclick=' onclick="OnClickOutline(\''.$imgRootPath.'\','.$rsid.')" ';
			$A_onclick="javascript:OnClickOutline('".$imgRootPath."',".$rsid.")";
		}
		
		
			
		
		$result.= '<img class="Outline" id="ID'.$rsid.'" style="CURSOR: pointer" '.$onclick.' alt="" src="'.$imgRootPath.'images/tree/'.$flag_img.'" />&nbsp;';
		if($rs[$i]["link"]){
			$result.='<a href="'.$rs[$i]["link"].'">';
		}else{
			if($A_onclick){
				$result.='<a href='.$A_onclick;
			}else{
				$result.='<a href="javascript:void(0);"';
			}
//			$result.='<a href="javascript:void(0);"';
//			if($onclick) $result.=$onclick;
			$result.='>';
		}
		$result.= $rs[$i]["name"];
		$result.='</a>';
		
		$result.="</div>";
		
//		if($rs[$i]["pid"]==0) $result.= "<br />";
		
		//</div>
		if($rs[$i]["flag"]>$rs[$i+1]["flag"]){
			$div_n=$rs[$i]["flag"]-$rs[$i+1]["flag"];
			for($div_i=0;$div_i<$div_n;$div_i++){
				$result.=  "</div>";
			}
		}
		//end </div>
		//<div>
		if(hasSub($rs[$i]["id"],$array)){
			$result.= '<div id="ID'.$rsid.'d"';
			if($rs[$i]["hide_sub"]==1) $result.= ' style="display:none" ';
			$result.= '>';
		}
		//end <div>
	}
	//$result.= '  <div id="infodisplay"><font color="#999999">点击＋展开节点</font></div>';
	$result.= '</div>';
	$result.="<script>";
	$result.="	$('#".$divIdPrefix."_tree_menu a').click(function (){";
	$result.="		if($(this).attr('href')!='javascript:void(0);')";
	$result.="			SetCookie('".$divIdPrefix."_tree_menu',$(this).attr('href'));";
	$result.="	});";
	$result.="	tree_menu_setNow(GetCookie('".$divIdPrefix."_tree_menu'),'".$divIdPrefix."_tree_menu');";
	$result.="</script>";
	return $result;
}
function get_hide_sub($hide_sub){
	$result="";
	if($hide_sub==1){
		$result="是";
	}else $result="否";
	return $result;
}

function get_group_id_by_admin_id($admin_id){
	if(empty($admin_id)) return false;
	global $webdb;
	return $webdb->getValue("select * from _sys_admin where id=".$admin_id,"gpid");
}
function getMenuData($admin_id){
	if(empty($admin_id)) return false;
	global $webdb;
	$where =" or admin_id=".$admin_id;
	$group_id=get_group_id_by_admin_id($admin_id);
        if($group_id!='1') $strsql = " and s.id <>'32' ";
	if($group_id) $where.=" or group_id=".$group_id.") ".$strsql;
	return $webdb->getList("select id,name,link,parent_id,hide_sub
from _sys_section  where id in(
	SELECT perm_id from _sys_group_perm 
		where (group_id='".$_SESSION['gpid']."' or admin_id='".$_SESSION['ADMIN_ID']."') 
		and perm_id not in(72,73,74,75,76,77,78,79,80,81,82,83)
)
order by sort,id asc");
	//return $webdb->getList("select s.id,s.name,s.link,s.parent_id,s.hide_sub from _sys_section s inner join _sys_group_perm p on p.perm_id=s.id where (1 ".$where."  group by s.id order by s.sort,s.id asc");
}
function getMenuAllData(){
	global $webdb;
	return $webdb->getList("select * from _sys_section order by sort,id asc");
}
?>