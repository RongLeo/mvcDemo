<?php

namespace Controller;

use Framework\Core\Controller;
use Model\CartModel;

class CartController extends Controller {
	public function index() {
		$cartModel = new CartModel ();
		$uid = $_SESSION ['CURR_USER'] ['uid'];
		$cart = $cartModel->where ( 'uid=?', array (
				$uid 
		) )->select ();
		return $this->view ( 'cart/index' )->with ( 'cart', $cart );
	}
	
	public function cartList() {
		if (empty ( $_SESSION ['CURR_USER'] )) {
			return $this->ajaxResponse ( array (
					'status' => 0,
					'msg' => 'not login' 
			) );
		}
		
		$cartModel = new CartModel ();
		$uid = $_SESSION ['CURR_USER'] ['uid'];
		$cart = $cartModel->where ( 'uid=?', array (
				$uid 
		) )->limit ( 0, 6 )->select ();
		return $this->ajaxResponse ( array (
				'status' => 1,
				'msg' => 'ok',
				'data' => $cart 
		) );
	}
	
	public function add() {
		$resp = array (
				'status' => - 1,
				'msg' => '加入购物车时发生错误' 
		);
		
		$cartModel = new CartModel ();
		if ($cartModel->create ()) {
			$cartModel->uid = $_SESSION ['CURR_USER'] ['uid'];
			// 先判定该商品是否已经添加到购物车，如果已添加，则更改购买数量，否则新增记录
			$rows = $cartModel->where ( 'gid=? and uid=?', array (
					$cartModel->gid,
					$cartModel->uid 
			) )->select ( 'count(*) as count' );
			$count = $rows [0] ['count'];
			$isSucc = false;
			if ($count > 0) {
				// 购买数量加1
				$isSucc = $cartModel->execUpdate ( 'update shop_cart set num=num+1 where gid=? and uid=?', array (
						$cartModel->gid,
						$cartModel->uid 
				) );
			} else {
				// 新增记录
				$isSucc = $cartModel->add ();
			}
			if ($isSucc) {
				$resp ['status'] = 1;
				$resp ['msg'] = 'ok';
			} else {
				$resp ['status'] = 0;
				$resp ['msg'] = 'ok';
			}
		}
		return $this->ajaxResponse ( $resp );
	}
	
	public function updateNum() {
		$gid = $this->getParam ( 'gid' );
		$uid = $_SESSION ['CURR_USER'] ['uid'];
		$op = $this->getParam ( 'op' );
		$sql = 'update shop_cart set num=num-1 where gid=? and uid=?';
		if ($op == 1) {
			$sql = 'update shop_cart set num=num+1 where gid=? and uid=?';
		}
		if ($op == - 1) {
			$sql = 'delete from shop_cart where gid=? and uid=?';
		}
		$resp = array (
				'status' => 0,
				'msg' => '更改数量发生错误' 
		);
		$cartModel = new CartModel ();
		if ($cartModel->execUpdate ( $sql, array (
				$gid,
				$uid 
		) )) {
			$resp ['status'] = 1;
			$resp ['msg'] = 'ok';
		}
		return $this->ajaxResponse ( $resp );
	}
	
	public function delete() {
		$gid = $this->getParam ( 'gid' );
		$uid = $_SESSION ['CURR_USER'] ['uid'];
		$sql = 'delete from shop_cart where gid=? and uid=?';
		$resp = array (
				'status' => 0,
				'msg' => '删除购物车记录发生错误'
		);
		$cartModel = new CartModel ();
		if ($cartModel->execUpdate ( $sql, array (
				$gid,
				$uid 
		) )) {
			$resp ['status'] = 1;
			$resp ['msg'] = 'ok';
		}
		return $this->ajaxResponse ( $resp );
	}
}