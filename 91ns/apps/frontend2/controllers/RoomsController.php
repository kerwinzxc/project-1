<?php

namespace Micro\Controllers;

use Phalcon\DI\FactoryDefault;
use Micro\Models\Rooms;

class RoomsController extends ControllerBase {

    public function initialize() {
        if (!$this->request->isAjax()) {
            $this->view->ns_title = '房间';
            $this->view->ns_name = 'room';
            //$this->view->setTemplateAfter('main');
        }
        //$this->view->setTemplateAfter('main');  //use views/layouts/main.volt
        parent::initialize();
    }

    public function indexAction($uid) {
        $this->view->ns_room = TRUE;
        $user = $this->userAuth->getUser();
        if ($user != null) {
            $userInfo['uid'] = $user->getUid();
            $userInfo['isAnchor'] = $userInfo['uid'] == $uid;
            $this->view->userInfo = $userInfo;
        }

        //判断到非主播，并且无房间则跳到404
        $roomData = Rooms::findFirst("uid = " . $uid);
        if (empty($roomData)) {
            $isOwnRoom = false;
            if ($user != null) {
                if ($uid == $user->getUid())
                    $isOwnRoom = true;
            }
            if (!$isOwnRoom) {
                return $this->redirect("errors/show404");
            }
        }

        //分享回访操作
        $fromuid = $this->request->get('fromuid');
        $fromuid && $this->taskMgr->shareBack($fromuid);

        $this->view->loggerLevel = $this->config->loggerLevel;
        $anchorInfo['uid'] = $uid;
        $this->view->anchorInfo = $anchorInfo;
        //$this->flash->notice('It is a test flash notice');

         //渠道来源
        $log = new \Micro\Frameworks\Logic\Base\BaseStatistics();
        $source = $log->getSource();
        if ($source != NULL) {
            $this->view->ns_source = $source;
        }

        $content = $this->config->urlConfig->flashFileName;
        $this->view->roomFileName = $content ? $content : 'room';
        $this->view->roomType = 'room';
    }

    public function familyAction($roomId) {
        $this->view->ns_room = TRUE;
        $user = $this->userAuth->getUser();
        if ($user != null) {
            $userInfo['uid'] = $user->getUid();
            $userInfo['isAnchor'] = $userInfo['uid'] == $roomId;
            $this->view->userInfo = $userInfo;
        }

        //分享回访操作
        $fromuid = $this->request->get('fromuid');
        $fromuid && $this->taskMgr->shareBack($fromuid);

        $this->view->loggerLevel = $this->config->loggerLevel;
        $anchorInfo['uid'] = $roomId;
        $this->view->anchorInfo = $anchorInfo;
        //$this->flash->notice('It is a test flash notice');

        //渠道来源
        $log = new \Micro\Frameworks\Logic\Base\BaseStatistics();
        $source = $log->getSource();
        if ($source != NULL) {
            $this->view->ns_source = $source;
        }

        $content = $this->config->urlConfig->flashFileName;
        $this->view->roomFileName = $content ? $content : 'room';
        $this->view->roomType = 'family';
    }

    // 只有分类，一次性获取
    public function getRoomListAction() {
        if ($this->request->isPost()) {
            $uid = $this->request->getPost('uid');
            $skip = $this->request->getPost('skip');
            $limit = $this->request->getPost('limit');
            $roomType = $this->request->getPost('roomType') ? $this->request->getPost('roomType') : 0;
            $result = $this->roomModule->getRoomMgrObject()->getNewRoomList($uid, $skip, $limit,$roomType);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // for 搜索
    public function getRoomListNewAction() {
        if ($this->request->isPost()) {
            $result = $this->roomModule->getRoomMgrObject()->getNewRoomList('', 0, 16, 0, 1, 1);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }


    public function enterAction($uid) {
        $result = $this->roomModule->getRoomOperObject()->enterRoom($uid);
        $this->status->ajaxReturn($result['code'], $result['data']);
    }

    public function enterFamilyAction($uid) {
        $result = $this->roomModule->getRoomOperObject()->enterRoom($uid, $this->config->roomType->family);
        $this->status->ajaxReturn($result['code'], $result['data']);
    }

    /* public function enterAction($roomId)
      {
      $resultData = $this->roommgr->getRoomData($roomId);
      if ($resultData['code'] == $this->status->getCode('OK')) {
      $roomdata = $resultData['data'];

      $this->view->roominfo = $roomdata;
      //$this->view->creatorinfo = $userinfo;
      if ($this->session->get($this->config->websiteinfo->authkey) != NULL)
      {
      $UserData = $this->session->get($this->config->websiteinfo->authkey);
      $this->view->userid = $UserData['uid'];
      }
      else {
      $this->view->userid = time();   //游客
      }

      //下发下载资源的路径
      $host = "http://".$_SERVER['HTTP_HOST'];
      $this->view->pubfile = $this->url->getStatic('web/down/liveCaptain.exe');   //需要修改
      $this->view->videopublish = $this->config->websiteinfo->pushmediastream_url;
      $this->view->videoplay = $this->config->websiteinfo->pullmediastream_url;
      $controllerName = "/Rooms";  //控制器名称，先写死，不知道怎么在当前类获取控制器的名称字符串
      $this->view->phpStartURL = $host.$controllerName.'/startPublishFromC';
      $this->view->phpStopURL = $host.$controllerName.'/stopPublishFromC';
      $this->view->phpUpdateURL = $host.$controllerName.'/updatePublishInfoFromC';
      $this->view->serverTime = time();
      $this->view->validateURL = $host.$controllerName.'/validatePublish';
      $this->view->validateTag = "ooxx";
      }
      else {
      //..错误如何处理..可以考虑跳到404错误页面，或者说跳到房间不存在的页面之类的
      return $this->forward("errors/404");
      }
      } */

    // 登录NodeJS
    public function loginToNodeJSAction() {
        if ($this->request->isPost()) {
            $roomid = $this->request->getPost('roomId');
            $result = $this->userAuth->loginToNodeJS($roomid);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 进入NodeJS房间
    public function enterNodeJSRoomAction() {
        if ($this->request->isPost()) {
            $roomid = $this->request->getPost('roomId');
            $token = $this->request->getPost('token');
            $isRepeat = $this->request->getPost('repeat');

            $result = $this->roomModule->getRoomOperObject()->enterNodeJSRoom($roomid, $token, $isRepeat);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    /**
     * 获得房间标题
     */
    public function getRoomTitleAction(){
        if($this->request->isGet()){
            $result = $this->roomModule->getRoomMgrObject()->getRoomTitle();
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    /**
     * 获得房间公告
     */
    public function getRoomAnnouncementAction(){
        if($this->request->isGet()){
            $result = $this->roomModule->getRoomMgrObject()->getRoomAnnouncement();
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    // 开始直播之前，修改房间标题
    public function setRoomTitleAction() {
        if ($this->request->isPost()) {
            $title = $this->request->getPost('title');
            $announcement = $this->request->getPost('announcement');
            $publishRoute = $this->request->getPost('publishRoute');
            $useAccelarate = $this->request->getPost('useAccelarate');
            $nextTime = $this->request->getPost('nextTime');
            $result = $this->roomModule->getRoomMgrObject()->setRoomTitle($title, $announcement, $publishRoute, $useAccelarate, $nextTime);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 上传海报
    public function uploadPosterAction() {
        if ($this->request->isPost()) {
            if ($this->request->hasFiles()) {
                foreach ($this->request->getUploadedFiles() as $file) {
                    $result = $this->roomModule->getRoomMgrObject()->uploadPoster($file);
                    $this->status->ajaxReturn($result['code'], $result['data']);
                }
            }
            return $this->status->ajaxReturn($this->status->getCode('UPLOADFILE_ERROR'));
        }
        $this->proxyError();
    }

    // 获取房间座驾列表
    public function getCarsInRoomAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');

            $result = $this->roomModule->getRoomMgrObject()->getCarsInRoom($roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 获取房间守护列表
    public function getGuardDataListAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');

            $result = $this->roomModule->getRoomMgrObject()->getGuardDataList($roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 获取抢座列表
    public function getGrabSeatListAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');

            $result = $this->roomModule->getRoomMgrObject()->getGrabSeatList($roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 获取房间总人数接口
    public function getTotalCountAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');

            $result = $this->roomModule->getRoomMgrObject()->getCountInRoom($roomId);
            //session充值
            $this->baseCode->updateSession();
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 修改用户权限
    public function levelUpPermissionAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $uid = $this->request->getPost('uid');
            $level = $this->request->getPost('level');
            $token = $this->request->getPost('token');
            $tempManageType = $this->request->getPost('tempManageType');//是否临时管理员

            $result = $this->roomModule->getRoomOperObject()->levelUpPermission($roomId, $uid, $level, $token,$tempManageType);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //  禁言
    public function forbidTalkAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $uid = $this->request->getPost('uid');
            $isForbid = $this->request->getPost('isForbid');
            $token = $this->request->getPost('token');

            $result = $this->roomModule->getRoomOperObject()->forbidTalk($roomId, $uid, $isForbid, $token);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //  踢人
    public function kickUserAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $uid = $this->request->getPost('uid');
            $token = $this->request->getPost('token');

            $result = $this->roomModule->getRoomOperObject()->kickUser($roomId, $uid, $token);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 获取房间消费排行榜
    public function getRoomConsumeRankAction() {
 
        if ($this->request->isPost()) {
            $rankType = $this->request->getPost('rankType');
            $roomId = $this->request->getPost('roomId');
            $topNum = $this->request->getPost('topNum');
            $result = $this->rankMgr->getRoomConsumeRank($rankType, $roomId, $topNum);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // Flash向服务器发起请求说明，当前房间开始直播
    public function startPublishFromFlashAction() {
        if ($this->request->isPost()) {
            $roomid = $this->request->getPost('roomId');
            $streamName = $this->request->getPost('streamName');// ? $this->request->getPost('streamName') : '';
            $isREC = $this->request->getPost('isREC');
            //$validateTag = $this->request->getPost('tag');

            $result = $this->roomModule->getRoomOperObject()->startPublishFromFlash($roomid, $streamName, $isREC);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // Flash向服务器发起请求说明，更新直播时间
    public function updatePublishFromFlashAction() {
        if ($this->request->isPost()) {
            $roomid = $this->request->getPost('roomId');
            //$validateTag = $this->request->getPost('tag');

            $result = $this->roomModule->getRoomOperObject()->updatePublishFromFlash($roomid);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 主播客户端向服务器发起请求说明，当前房间停止直播
    public function pausePublishFromFlashAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            //$validateTag = $this->request->getPost('tag');

            $result = $this->roomModule->getRoomOperObject()->pausePublishFromFlash($roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 主播客户端向服务器发起请求说明，当前房间开始直播
    public function startPublishAction() {
        if ($this->request->isPost()) {
            $roomid = $this->request->getPost('roomId');
            //$validateTag = $this->request->getPost('tag');

            $result = $this->roomModule->getRoomOperObject()->startPublish($roomid);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    // 主播客户端向服务器发起请求说明，当前房间停止直播
    public function stopPublishAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            //$validateTag = $this->request->getPost('tag');

            $result = $this->roomModule->getRoomOperObject()->stopPublish($roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    public function updatePublishAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            //$validateTag = $this->request->getPost('tag');

            $result = $this->roomModule->getRoomOperObject()->updatePublish($roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    public function validatePublishAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            //查询是否禁播
            $result = $this->roomModule->getRoomMgrObject()->checkLiveStatus($roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //获取猜猜看
    public function getGuessRoomAction() {
        if ($this->request->isPost()) {
            $uid = $this->request->getPost('uid');
            $limit = $this->request->getPost('limit');
            $result = $this->roomModule->getRoomMgrObject()->getGuessHoster($uid, $limit);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //抢座
    public function grabSeatAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $seatPos = $this->request->getPost('seatPos');
            $seatCount = $this->request->getPost('seatCount');
            $result = $this->roomModule->getRoomOperObject()->grabSeat($roomId, $seatPos, $seatCount);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //发送房间广播(银喇叭)
    public function sendRoomBroadcastAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $content = $this->request->getPost('content');
            $isUseItem = $this->request->getPost('isUseItem'); //是否使用道具
            $result = $this->roomModule->getRoomOperObject()->sendRoomBroadcast($roomId, $content, $isUseItem);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //发送全服广播（金喇叭）
    public function sendAllRoomBroadcastAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $content = $this->request->getPost('content');
            $isUseItem = $this->request->getPost('isUseItem');//是否使用道具
            $result = $this->roomModule->getRoomOperObject()->sendAllRoomBroadcast($roomId, $content,$isUseItem);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //发送礼物
    public function sendGiftAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $uid = $this->request->getPost('uid');
            $giftId = $this->request->getPost('giftId');
            $giftCount = $this->request->getPost('giftCount');
            $anonymous = $this->request->getPost('anonymous');
            $hitsNum = $this->request->getPost('hitsNum');
            $result = $this->roomModule->getRoomOperObject()->sendGift($roomId, $uid, $giftId, $giftCount, $anonymous, 0, $hitsNum);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //获取在线的免费聊豆
    public function getOnlineCoinAction() {
        if ($this->request->isPost()) {
            $result = $this->roomModule->getRoomMgrObject()->onlineActivities();
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //直播间包裹
    public function getRoomBagAction() {
         if ($this->request->isPost()) {
            $result = $this->roomModule->getRoomOperObject()->getRoomBag();
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    
    
    //使用包裹里礼物
    public function sendBagGiftAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $uid = $this->request->getPost('uid');
            $id = $this->request->getPost('id');
            $giftCount = $this->request->getPost('giftCount');
            $anonymous = $this->request->getPost('anonymous');
            $type = $this->request->getPost('type');
            $hitsNum = $this->request->getPost('hitsNum');
            $result = $this->roomModule->getRoomOperObject()->sendBagGift($roomId, $uid, $id, $giftCount, $anonymous, $type, $hitsNum);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    
    
    //直播间领取vip奖品
    public function getVipRewardAction() {
        if ($this->request->isPost()) {
            $result = $this->roomModule->getRoomOperObject()->getVipReward();
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    //获取用户签到内容
    public function getUserSignAction(){
          if ($this->request->isPost()) {
            $result = $this->signMgr->getUserSign();;
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();  
    }
    //用户签到
    public function setUserSignAction(){
        if ($this->request->isPost()) {
            $result = $this->signMgr->setSign();
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    //获取用户签到奖励
    public function getUserSignRewardAction(){
        if ($this->request->isPost()) {
            $type=$this->request->getPost("type");
            $roomId=$this->request->getPost("roomId");
            $result = $this->signMgr->getSignReward($type,$roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    //获取用户签到状态
    public function getUserSignStatusAction(){
        if ($this->request->isPost()) {
            $result = $this->signMgr->getSignStatus();
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    
    
    // 开始直播之后，修改房间标题/公告
    public function setRoomContentAction() {
        if ($this->request->isPost()) {
            $title = $this->request->getPost('title');
            $announcement = $this->request->getPost('announcement');
            $result = $this->roomModule->getRoomOperObject()->setRoomContent($title, $announcement);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    
    //直播间送礼物列表
    public function getSendGiftListAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $num = $this->request->getPost('num');
            $result = $this->roomModule->getRoomOperObject()->getLastSendGiftList($roomId, $num);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //直播间送礼物列表
    /*public function hotRoomAction() {
        $result = $this->roomModule->getRoomMgrObject()->getHotRoom();
        if($result['code'] != $this->status->getCode('OK')){
            return $this->redirect('');
        }
        return $this->redirect(''.$result['data']['uid']);
    }*/
    public function test() {
        try {
            $sql = "SELECT uid FROM \Micro\Models\Rooms WHERE liveStatus=1 AND showStatus=1 ORDER BY rand() LIMIT 0,1";
            $query = $this->modelsManager->createQuery($sql);
            $data = $query->execute();
            if (!$data->valid()) {
                return $this->status->retFromFramework($this->status->getCode("NO_PUBLISHED_ROOM"));
            }
            $result['uid'] = $data->toArray()[0]['uid'];
            return $this->status->retFromFramework($this->status->getCode("OK"), $result);
        } catch (Exception $e) {
            $this->errLog('getHotRoom errorMessage = ' . $e->getMessage());
            return $this->status->retFromFramework($this->status->getCode('DB_OPER_ERROR'), $result);
        }
    }
    public function hotRoomAction() {
        /*$result = $this->test();
        if($result['code'] != $this->status->getCode('OK')){
            return $this->forward('');
        }*/

        // $this->roomModule->getRoomOperObject()->getJumpAnchorId(0)
        $result = $this->normalLib->getHotRoom();

        $param = $this->request->get();
        $val = '?';

        foreach ($param as $key => $value) {
            if($key == '_url'){
                continue;
            }else{
                $val .= $key.'='.$value.'&';
            }
        }
        
        $val = substr($val, 0, -1);
        if($result){
            $this->redirect($result.$val);
        }else{
            $this->redirect(''.$val);
        }

         //$this->forward('shop');
        //$this->view->uid = $result['data']['uid'];
        //return $this->redirect(''.$result['data']['uid']);
        //return $this->forward('/'.$result['data']['uid']);
    }
    
    //获取vip礼物领取状态
    public function getVipGiftStatusAction(){  
        if ($this->request->isPost()) {
            $result = $this->roomModule->getRoomOperObject()->getVipGiftStatus();
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
	
    //获取物品基本配置
    public function getItemConfigListAction() {
        if ($this->request->isPost()) {
            $result = $this->roomModule->getRoomOperObject()->getItemsBaseConfiglist();
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //获取用户喇叭拥有数量
    public function getUserHornAction() {
        if ($this->request->isPost()) {
            $type = $this->request->getPost('type');
            $result = $this->roomModule->getRoomOperObject()->checkUserHorn($type);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    
    //获取礼包基本配置
    public function getgiftPackageConfigAction() {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $result = $this->configMgr->getgiftPackageBaseConfig($id,1);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }
    
    //获取房间某个用户信息
    public function getUserDataAction() {
        if ($this->request->isPost()) {
            $uid = $this->request->getPost('uid');
            $roomId = $this->request->getPost('roomId');
            $result = $this->roomModule->getRoomOperObject()->getRoomUserData($uid, $roomId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //提交新手引导下的某个任务
    public function setGuideTaskAction() {
        if ($this->request->isPost()) {
            $taskId = $this->request->getPost('taskId');
            $result = $this->taskMgr->setUserGuideTask($taskId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //领取新手引导下的某个任务奖励
    public function getGuideTaskRewardAction() {
        if ($this->request->isPost()) {
            $taskId = $this->request->getPost('taskId');
            $result = $this->taskMgr->getUserGuideTaskReward($taskId);
            $this->status->ajaxReturn($result['code'], $result['data']);
        }
        $this->proxyError();
    }

    //获得守护配置
    public function getGuardConfigAction() {
        if ($this->request->isPost()) {
            $guardConfig['1'] = $this->config->goldGuard;
            $guardConfig['2'] = $this->config->silverGuard;
            $guardConfig['3'] = $this->config->boGuard;
            $this->status->ajaxReturn($this->status->getCode('OK'), $guardConfig);
        }

        $this->proxyError();
    }

    public function getSongListAction(){
        if ($this->request->isGet()) {
            $uid = $this->request->get('uid');
            $result = $this->roomModule->getRoomMgrObject()->getSongList($uid);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    public function addSongAction(){
        if ($this->request->isPost()) {
            $songName = $this->request->getPost('songName');
            $result = $this->roomModule->getRoomMgrObject()->addSong($songName);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    public function delSongAction(){
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $result = $this->roomModule->getRoomMgrObject()->delSong($id);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    /**
     * 设置麦
     *
     * @param fromPos 原位置 未上麦则为0
     * @param toPos  目标位置 0表示下麦
     * @param fromUid 原位置主播
     * @param toUid 目标位置主播
     */
    public function setPublishPosAction(){
        if($this->request->isPost()){
            $fromPos = $this->request->getPost('fromPos');
            $toPos = $this->request->getPost('toPos');
            $fromUid = $this->request->getPost('fromUid');
            $toUid = $this->request->getPost('toUid');
            $result = $this->roomModule->getRoomMgrObject()->setPublishPos($fromPos, $toPos, $fromUid, $toUid);
            return $this->status->mobileReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }
    //查询用户在房间状态信息
    public function roomStatusDataAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $result = $this->roomModule->getRoomOperObject()->getRoomUserStatusData($roomId);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }
        return $this->proxyError();
    }

    /**
     * 添加宝箱可领取日志
     *
     */
    // public function addRewardLogAction(){
    //     if($this->request->isPost()){
    //         $result = $this->roomModule->getRoomMgrObject()->addRewardLog();
    //         return $this->status->ajaxReturn($result['code'], $result['data']);
    //     }

    //     return $this->proxyError();
    // }

    /**
     * 开启宝箱
     */
    // public function openRewardAction(){
    //     if($this->request->isPost()){
    //         $result = $this->roomModule->getRoomMgrObject()->openReward();
    //         return $this->status->ajaxReturn($result['code'], $result['data']);
    //     }

    //     return $this->proxyError();
    // }

    /**
     * 检查是否存在未领取宝箱
     */
    public function checkRewardAction(){
        if($this->request->isPost()){
            $result = $this->roomModule->getRoomMgrObject()->checkReward();
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    //获取直播间用户列表
    public function getRoomUsersAction(){
        if($this->request->isPost()){
            $nodejstoken = $this->request->getPost('nodejstoken');
            $roomid = $this->request->getPost('roomId');
            $count = $this->request->getPost('count');
            $result = $this->roomModule->getRoomMgrObject()->getRoomUsers($nodejstoken, $roomid, $count);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    //获取直播间管理列表
    public function getRoomManagersAction(){
        if($this->request->isPost()){
            $nodejstoken = $this->request->getPost('nodejstoken');
            $roomid = $this->request->getPost('roomId');
            $result = $this->roomModule->getRoomMgrObject()->getRoomManagers($nodejstoken, $roomid);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    /**
     * 开启宝箱New
     */
    public function openRewardBoxAction(){
        if($this->request->isPost()){
            $result = $this->roomModule->getRoomMgrObject()->openRewardBox();
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    /**
     * 获取宝箱记录
     */
    public function getRewardLogAction(){
        if($this->request->isPost()){
            $lastId = $this->request->getPost('lastId');
            $result = $this->roomModule->getRoomMgrObject()->getRewardLog($lastId);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    /**
     * 直播间搜索
     */
    public function searchAnchorsAction(){
        if($this->request->isPost()){
            $search = $this->request->getPost('search');
            $result = $this->roomModule->getRoomMgrObject()->searchAnchors($search);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    /**
     * 详细页面搜索
     */
    public function searchDetailAction(){
        if($this->request->isPost()){
            $search = $this->request->getPost('search');
            $type = $this->request->getPost('type');
            if($type == 1){
                $result = $this->roomModule->getRoomMgrObject()->searchByRoomid($search);
            }else{
                $page = $this->request->getPost('page');
                $pageSize = $this->request->getPost('pageSize');
                $result = $this->roomModule->getRoomMgrObject()->searchByNickname($search, $page, $pageSize);
            }
            
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    // 设置直播间密码
    public function setRoomPwdAction(){
        if($this->request->isPost()){
            
            $roomPwd = $this->request->getPost('roomPwd');
            $result = $this->roomModule->getRoomOperObject()->setRoomPwd($roomPwd);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    // 直播间角色设置
    public function setRoomRolesAction(){
        if($this->request->isPost()){
            
            $roleType = $this->request->getPost('roleType');
            $roleMems = $this->request->getPost('roleMems');
            $result = $this->roomModule->getRoomOperObject()->setRoomRoles($roleType, $roleMems);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    // 直播间角色设置
    public function setRoomPrivilegesAction(){
        if($this->request->isPost()){
            
            $useRole = $this->request->getPost('useRole');
            $isAnchor = $this->request->getPost('isAnchor');
            $isFamily = $this->request->getPost('isFamily');
            $isManage = $this->request->getPost('isManage');
            $minRicherRank = $this->request->getPost('minRicherRank');
            $usePwd = $this->request->getPost('usePwd');
            $roomPwd = $this->request->getPost('roomPwd');
            $result = $this->roomModule->getRoomOperObject()->setRoomPrivileges($useRole, $isAnchor, $isFamily, $isManage, $minRicherRank, $usePwd, $roomPwd);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    // 进入检测房间限制
    public function checkRoomLimitAction(){
        if($this->request->isPost()){
            
            $uid = $this->request->getPost('uid');
            $result = $this->roomModule->getRoomOperObject()->checkRoomLimit($uid);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    // 检测房间密码
    public function checkRoomPwdAction(){
        if($this->request->isPost()){
            
            $uid = $this->request->getPost('uid');
            $roomPwd = $this->request->getPost('roomPwd');
            $result = $this->roomModule->getRoomOperObject()->checkRoomPwd($uid, $roomPwd);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }

        return $this->proxyError();
    }

    //积分下注
    public function betPointsAction(){
        if ($this->request->isPost()) {

            $times = $this->request->getPost('times');
            $type = $this->request->getPost('type');
            $nums = $this->request->getPost('nums');

            $result = $this->roomModule->getRoomOperObject()->betPoints($type, $times, $nums, 1);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }
        return $this->proxyError();
    }

    //获取用户投注记录
    public function getBetPointLogAction(){
        if ($this->request->isPost()) {

            $times = $this->request->getPost('times');
            $type = $this->request->getPost('type');

            $result = $this->roomModule->getRoomOperObject()->getBetPointLog($type, $times);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }
        return $this->proxyError();
    }

    //获取用户投注记录New
    public function getBetLogAction(){
        if ($this->request->isPost()) {

            $result = $this->roomModule->getRoomOperObject()->getBetLog(0);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }
        return $this->proxyError();
    }

    //获取进行中的夺宝列表
    public function getBettingListAction(){
        if ($this->request->isPost()) {

            // $times = $this->request->getPost('times');
            // $type = $this->request->getPost('type');

            $result = $this->roomModule->getRoomOperObject()->getBettingList(0);

            return $this->status->ajaxReturn($result['code'], $result['data']);
        }
        return $this->proxyError();
    }

    //检查对否有90%的夺宝
    public function checkHasWarningBetAction(){
        if ($this->request->isPost()) {

            $result = $this->roomModule->getRoomOperObject()->checkHasWarningBet();

            return $this->status->ajaxReturn($this->status->getCode('OK'),$result);
        }
        return $this->proxyError();
    }
    
    
    //主播召集粉丝
    public function conveneFansAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $result = $this->roomModule->getRoomMgrObject()->pushFansByConvene($roomId);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }
        return $this->proxyError();
    }

    
    //主播是否可召集粉丝
    public function isConveneFansAction() {
        if ($this->request->isPost()) {
            $roomId = $this->request->getPost('roomId');
            $result = $this->roomModule->getRoomMgrObject()->isCanConveneFans($roomId);
            return $this->status->ajaxReturn($result['code'], $result['data']);
        }
        return $this->proxyError();
    }
    
    //获取富豪等级配置
    public function getRicherConfigAction() {
        if ($this->request->isPost()) {
            $Configs = $this->config->richerConfigs;
            $data['privateChatLevelLimit'] = $Configs->privateChatLevelLimit;
            $data['privateChatLevelName'] = $Configs->privateChatLevelName;
            $data['expressionLevelLimit'] = $Configs->expressionLevelLimit;
            $data['forbidLevelLimit'] = $Configs->forbidLevelLimit;
            $data['forbidLevelInterval'] = $Configs->forbidLevelInterval;
            $data['kickLevelLimit'] = $Configs->kickLevelLimit;
            $data['kickLevelInterval'] = $Configs->kickLevelInterval;
            return $this->status->ajaxReturn($this->status->getCode("OK"), $data);
        }
        return $this->proxyError();
    }

}
