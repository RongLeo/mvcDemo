<?php
namespace Controller;
use Framework\Core\Controller;
use Framework\Util\Verify\VerifyCode;
use Model\UserModel;

class UserController extends Controller {
	public function login() {
		$target = 'goods/index';
		if (!empty($this->getParam('a'))) {
			$target = $this->getParam('a');
		}
		return $this->view('User/login')->with('a',$target);
	}
	
	public function getVerifyCode() {
		$vcode = new VerifyCode();
		$vcode->getVerifyCodeImage();
	}
	
	/**
	 * 执行登录，以JSON字符串返回登录结果
	 * 
	 * 例如：
	 *   {status:1,msg:'ok',data:{uid:1,uname:'用户名'}}表示登录成功
	 *   {status:0,msg:'用户名或密码错误'}
	 *   {status:-1, msg:'验证码错误'}
	 */
	public function doLogin() {
		// JSON数据结构定义
		$resp = array();
		
		$vcode = new VerifyCode();
		$code = $this->postParam('vcode');
		if ($vcode->check($code)) {
			$userModel = new UserModel();
			$uname = $this->postParam('uname');
			$pwd = md5($this->postParam('pwd'));
			
			$userList = $userModel->where('(email=? or uname=?) and password=?', array($uname,$uname,$pwd))->select('uid,email,uname,avatar_path,role_id');
			if (!empty($userList) && count($userList) > 0) {
				$user = $userList[0];
				$_SESSION['CURR_USER'] = $user;
				// 修改最后登录时间
				$now = new \DateTime();
				$user['last_login'] = $now->format('Y-m-d H:i:s');
				$userModel->create($user);
				$userModel->update();
				
				// $target = $this->getParam('a');
				$target = $this->postParam('a');
				$resp['status'] = 1;
				$resp['msg'] = 'ok';
				$resp['data'] = $user;
				$resp['url'] = $target;
			} else {
				$resp['status'] = 0;
				$resp['msg'] = '用户名或密码错误';
			}
		} else {
			$resp['status'] = -1;
			$resp['msg'] = '验证码错误';
		}
		return $this->ajaxResponse($resp);
	}
	
	public function logout() {
		$_SESSION['CURR_USER'] = null;
		return $this->ajaxResponse(array(
				'status' => 1,
				'msg' => 'ok'
		));
	}
}