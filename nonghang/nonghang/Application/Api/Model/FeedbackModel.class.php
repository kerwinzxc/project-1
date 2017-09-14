<?php

namespace Api\Model;
use Think\Model;

class FeedbackModel extends Model {
	function getList($map=array(),$order='time',$start=0,$limit=999999999){
		 $feedbacks= M('feedback')->where($map)->order($order)->select();
		 $user=M('member')->find($map['uid']);
		 if(!empty($user['headImage'])){
		 	$icon=C('IMG_URL').'Uploads/'.$user['headImage'];
		 }else{
		 	$icon=C('HEAD_IMG_URL');
		 }
		foreach ($feedbacks as $k=>$v){
		 	$feedbacks[$k]['icon']=$icon;
		 	$feedbacks[$k]['time']=date('Y-m-d H:i:s',$v['time']);
		 	$feedbacks[$k]['img']=C('IMG_URL').'Uploads/'.$v['img'];
		 	 /*$nf=M('feedback')->where('pid='.$v['id'])->order($order)->select();
		 	foreach ($nf as $key=>$val){
		 		$nf[$key]['time']=date('Y-m-d H:i:s',$val['time']);
		 	}
		 	if(!empty($nf)){
		 		$feedbacks[$k]['answer']=$nf;
		 	}*/
		 }
		 return $feedbacks;
	}
}