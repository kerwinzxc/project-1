<?php
/**
 * 总继承类
 * 
 * 主要判断是否登陆 
 * @author 王涛
 * @package admin
 */
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
	/**
	 * 分页数
	 *
	 * @var int
	 */
	protected $limit = 10;
	protected $admin = '';
    protected $menus = '';
    protected $golist = '';
    protected $orderConfig = array('0'=>'等待支付', '3'=>'订单完成', '9'=>'退款退票', '11'=>'退票成功');
    protected $dodds = 10000;
	/**
	 * 权限
	 *
	 * @var String
	 */
	protected $perm;
    /**
     * 系统基础控制器初始化,判断登录状态
     * 
     * @return void
     */
    protected function _initialize(){
    	$golist[]=array('0','选座页面');
    	$golist[]=array('1','外链网页');
    	$golist[]=array('2','影片详情');
    	$golist[]=array('3','排期列表');
    	$this->golist=$golist;

		$this->cinemaGroup=$this->getCinemaGroup();
        if(I('request.homeMid')){
            session('nowMid',I('request.homeMid'));
        }
        
        // 获取当前用户ID
        define('CPUID',admin_is_login());
        $this->admin = session('adminUserInfo');
        if(!CPUID){// 还没登录 跳转到登录页面
            $this->redirect('Public/login');
        }

        define('IS_ROOT',   is_administrator());
        if(!IS_ROOT && C('ADMIN_ALLOW_IP')){
            // 检查IP地址访问
            if(!in_array(get_client_ip(),explode(',',C('ADMIN_ALLOW_IP')))){
                $this->error('403:禁止访问');
            }
        }
        // 检测访问权限
        $access =   $this->accessControl();
        if ( $access === false ) {
            $this->error('403:禁止访问');
        }elseif( $access === null ){
			//检测非动态权限
			$rule  = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
			if ( !$this->checkRule($rule,array('in','1,2')) ){
				$this->tperror('未授权访问!');
			}
        }

        // $menus = S('zmaxfilmMenus' . CPUID);
        if(empty($menus)){
            $menus[0] = $this->getMenus(1, 0);
            foreach ($menus[0] as $value) {
                $menus[1][$value[0]] = $this->getMenus(2, $value[0]);

                foreach ($menus[1][$value[0]] as $valueThree) {
                    $menus[2][strtolower($valueThree[2])] = $this->getMenus(3, $valueThree[0]);
                }

            }
            S('zmaxfilmMenus' . CPUID, $menus);
        }
        foreach ($menus[1][session('nowMid')] as $key => $value) {
            $topMenu .= '<li><a href="' . U($value[2]) . '" class="'.$value[3].'" >' . $value[1] . '</a></li>';
        }
        if (strstr(strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME), strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/index'))) {
            $itemMenus = $menus[2][strtolower(MODULE_NAME.'/'.CONTROLLER_NAME . '/' . ACTION_NAME)];
            if(!empty($itemMenus)){
                session('leftMenusName', strtolower(MODULE_NAME.'/'.CONTROLLER_NAME . '/' . ACTION_NAME));
                $this->redirect($itemMenus[0][2]);
            }
        }

        // if(!strstr(session('leftMenusName'), strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/')) && !strstr(strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME), 'admin/index/')){
        //     echo strstr(session('leftMenusName'), MODULE_NAME.'/'.CONTROLLER_NAME.'/');
        //     echo session('leftMenusName');
        //     die();
        //     $this->redirect(session('leftMenusName'));
        // }
        // print_r($_SERVER);
        $isCut = false;
        foreach ($menus[2][session('leftMenusName')] as $key => $value) {
            $checkStr = '';
            if(strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME) == strtolower($value[2])){
                $checkStr = ' cur';
                $isCut = true;
            }
            $leftMenu .= '<li><a href="' . U($value[2]) . '"  class="' . $value[3] . $checkStr . '">' . $value[1] . '</a></li>';
        }

        if (!$isCut) {
            $preUrl = $this->getPreMenus(strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME));
            if (!empty($preUrl)) {
                $leftMenu = '';
                foreach ($menus[2][session('leftMenusName')] as $key => $value) {
                    $checkStr = '';
                    if(strtolower($preUrl) == strtolower($value[2])){
                        $checkStr = ' cur';
                        $isCut = true;
                    }
                    $leftMenu .= '<li><a href="' . U($value[2]) . '"  class="' . $value[3] . $checkStr . '">' . $value[1] . '</a></li>';
                }
            }
        }
        // print_r(session('adminUserInfo'));

        $this->assign('adminUserInfo', session('adminUserInfo'));
        $this->assign('orderConfig', $this->orderConfig);

        $this->assign('nowTopMenus', session('leftMenusName'));
        $this->assign('topMenu', $topMenu);
        $this->assign('leftMenu', $leftMenu);
        $this->assign('menus', $menus);
    }


    /**
     * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
     *
     * @return boolean|null  返回值必须使用 `===` 进行判断
     *
     *   返回 **false**, 不允许任何人访问(超管除外)
     *   返回 **true**, 允许任何管理员访问,无需执行节点权限检测
     *   返回 **null**, 需要继续执行节点权限检测决定是否允许访问
     * @author 
     */
    final protected function accessControl(){
        if(IS_ROOT){
            return true;//管理员允许访问任何页面
        }
		$allow = C('ALLOW_VISIT');
		$deny  = C('DENY_VISIT');

		$check = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);
        if ( !empty($deny)  && in_array_case($check,$deny) ) {
            return false;//非超管禁止访问deny中的方法
        }
        if ( !empty($allow) && in_array_case($check,$allow) ) {
            return true;
        }
        return null;//需要检测节点权限
    }



    /**
     * 获取控制器菜单数组,二级菜单元素位于一级菜单的'_child'元素中
     * @author 
     */
    final public function getMenus($position, $pid){

        $where['position'] = $position;
        $where['isshow'] = 1;
        $menu = M('adminMenu')->field('mid,pid,menuName,url,ico,isshow')->where($where)->order('sortOrder asc')->select();
        if($position == 1 && $pid == 0){
            foreach ($menu as $key => $value) {
                $menus[] = array($value['mid'], $value['menuName'], $value['url'], $value['ico']);
            }
        }else{
            $tree = new \Common\Controller\Tree();
            $tree->setData($menu);
            $tree->getMenuArray($pid);
            $menus = $tree->menuArray;
            $menus = $menus[$pid];  
        }
        return $menus;
    }


    /**
     * 获取控制器上级
     * @author 
     */
    final public function getPreMenus($noUrl){

        $where['url'] = $noUrl;

        $menu = M('adminMenu')->field('pid')->where($where)->find();
        
        if (!empty($menu)) {
            $map['mid']= $menu['pid'];
            $menu = M('adminMenu')->field('url')->where($map)->find();
            return $menu['url'];
        }
        return '';
    }
        
        /**
     * 权限检测
     * @param string  $rule    检测的规则
     * @param string  $mode    check模式
     * @return boolean
     * @author 
     */
    final protected function checkRule($rule, $type=1, $mode='url'){
        if(IS_ROOT){
            return true;//管理员允许访问任何页面
        }
        static $Auth    =   null;
        if (!$Auth) {
            $Auth       =   new \Common\Controller\Auth();
        }
        if(!$Auth->check($rule,CPUID,$type,$mode)){
            return false;
        }
        return true;
    }

    /**
     *
     * @param int $limitCount 
     * @param int $pageLength 
     * @return string
     */
	public function getPageList($limitCount , $pageLength, $map = ''){
		$Page       = new \Think\Page($limitCount,$pageLength); // 实例化分页类 传入总记录数和每页显示的记录数
		$config  = array(
	        'prev'   => '上一页',
	        'next'   => '下一页',
	        'first'  => '首页',
	        'last'   => '最后一页',
	        'theme'  => '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
	    );
		foreach($config as $key=>$val){
			$Page->setConfig($key , $val);
		}

		foreach($map as $key=>$val) {
		    $Page->parameter[$key]   =   $val;
		}

		$show  = $Page->show();
		
		if($show){
			$show = '<div class="pagination"><div class="page">' . $show . '</div></div>';
		}
		return $show ;// 分页显示输出
	}
/**
 * 
 * @param int $page 
 * @param int $count
 * @return Ambigous <number, unknown>
 */
	function curPage($page,$count){
		if($page < 0 || empty($page)){
			$page=1;
		}elseif($page > $count){
			$page = $count;
		}
		return $page;
	}

	public function success($content, $dataList = array())
	{
		$data['status']  = 0;
        $data['content'] = $content;
        $data['data'] = $dataList;
        $this->ajaxReturn($data);
	}

	public function error($content, $status = 1)
	{
		$data['status']  = $status;
        $data['content'] = $content;
        $this->ajaxReturn($data);
	}
	function getCinemaGroup(){
		$ncgs=S('cinemaGroups');
		if(empty($ncgs)){
			$cgs=M('cinemaGroup')->select();
			foreach ($cgs as $v){
				$ncgs[$v['id']]=$v['groupName'];
			}
			S('cinemaGroups',$ncgs,7200);
		}
		return $ncgs;
	}
	
	function msg($msg,$isClose=false,$parentNum=1,$url=''){
		$i=0;
		while($i<$parentNum){
			$str.='parent.';
			$i++;
		}
		echo '<script>';
		echo 'alert("'.$msg.'");';
		if($url){
			if($url!='reload'){
				echo $str.'location.href="'.$url.'"';
			}else{
				echo $str.'location.reload()';
			}
		}else if($isClose){
			echo 'setTimeout(function(){'.$str.'layer.closeAll();},1000)';
		}
		echo '</script>';
		exit;
	}

}