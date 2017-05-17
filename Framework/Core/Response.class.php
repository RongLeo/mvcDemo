<?php
namespace Framework\Core;

/**
 * 控制器操作方法返回的响应信息的抽象描述
 */
interface Response {
	public function render();
}