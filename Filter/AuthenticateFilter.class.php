<?php
namespace Filter;
use Framework\Core\Filter;

class AuthenticateFilter extends Filter {
	public function run() {
		// 登录验证
		if (! isset ( $_SESSION ['CURR_USER'] ) || empty ( $_SESSION ['CURR_USER'] )) {
			$this->redirect('../user/login?a=' . $this->action);
			return false;
		}
		return true;
	}
}