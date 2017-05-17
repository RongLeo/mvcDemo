<?php
namespace Filter;
use Framework\Core\Filter;

class AuthenticateAjaxFilter extends Filter {
	public function run() {
		// 登录验证
		if (! isset ( $_SESSION ['CURR_USER'] ) || empty ( $_SESSION ['CURR_USER'] )) {
			$this->ajaxResponse(array(
					'status' => -2,
					'msg' => '请先登录'
			))->render();
			return false;
		}
		return true;
	}
}