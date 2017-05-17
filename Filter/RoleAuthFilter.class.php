<?php
namespace Filter;
use Framework\Core\Filter;

class RoleAuthFilter extends Filter {
	public function run() {
		if (isset($_SESSION['CURR_USER']) && !empty($_SESSION['CURR_USER'])) {
			$user = $_SESSION['CURR_USER'];
			if ($user['role_id'] != 1) {
				$this->error('权限不足' , '../goods/index');
				return false;
			}
		} else {
			$this->redirect('../goods/index');
			return false;
		}
		return true;
	}
}