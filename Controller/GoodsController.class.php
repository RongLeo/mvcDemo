<?php
namespace Controller;

use Framework\Core\Controller;
use Model\CategoryModel;
use Model\GoodsModel;

class GoodsController extends Controller {
	public function index() {
		// 当前登录用户信息
		$isLogin = !empty($_SESSION['CURR_USER']);
		$uname = $isLogin ? $_SESSION['CURR_USER']['uname'] : '';

		// 展示类别信息
		$cid = 0;
		$path = '0';
		$currCtgr = '所有分类';
		if (! empty ( $this->getParam ( 'c' ) ) && ! empty ( $this->getParam ( 'p' ) ) && ! empty ( $this->getParam ( 'r' ) ) && !empty($this->getParam('n'))) {
			$cid = $this->getParam ( 'c' );
			$path = $this->getParam ( 'p' );
			$currCtgr = $this->getParam('r');
			$currCtgr .= '_' . $this->getParam('n');
		}
		
		$goods = new GoodsModel ();
		$ctgr = new CategoryModel ();
		
		// 查询当前类别的子类别
		$ctgrList = $ctgr->where ( 'parent_id=?', array (
				$cid 
		) )->select ( 'cid,cname,path' );
		// 查询当前类别下的所有商品
		$goodsList = $goods->query ( 'select gid, gname,price,discount,store_num,art_path from shop_goods where cid in (select cid from shop_category where path like ?"-%" or path=?)', array (
				$path ,$path
		) ); 
		
		return $this->view ( 'Goods/list' )->with('isLogin',$isLogin)->with('uname',$uname)->with('currCtgr',$currCtgr)->with ( 'ctgrList', $ctgrList )->with('path', $path)->with('goodsList', $goodsList);
	}
	
	public function goodsList() {
		$path = '0';
		if ( ! empty ( $this->postParam( 'p' ) ) ) {
			$path = $this->postParam ( 'p' );
		}
		// 查询当前类别下的所有商品
		$goods = new GoodsModel();
		$goodsList = $goods->query ( 'select gid, gname,price,discount,store_num,art_path from shop_goods where cid in (select cid from shop_category where path like ?"-%" or path=?)', array (
				$path ,$path
		) );
		return $this->ajaxResponse(array(
				'status' => 1,
				'msg' => 'ok',
				'data' => $goodsList
		));
	}
	
	public function add() {
		$ctgr = new CategoryModel ();
		$ctgrList = $ctgr->getSortOutList ( 'cid,cname,path' );
		return $this->view ( 'Goods/add_goods' )->with ( 'ctgrList', $ctgrList );
	}
	
	public function doAdd() {
		// 校验上传图片
		$fileInfo = $_FILES ['art'];
		if ($fileInfo ['size'] == 0 || $fileInfo ['size'] > 2 * 1024 * 1024) {
			$this->error ( '请上传小于2M的图片哦，亲~' );
			return;
		}
		if (($fileInfo ['type'] != 'image/png') && ($fileInfo ['type'] != 'image/jpg') && ($fileInfo ['type'] != 'image/jpeg') && ($fileInfo ['type'] != 'image/gif')) {
			$this->error ( '请上传正确格式的图片哦，亲~' );
			return;
		}
		if ($fileInfo ['error'] > 0) {
			$this->error ( '上传图片发生错误' );
			return;
		}
		if (! preg_match ( '/^[\w-]+\.[a-zA-Z]{3,4}$/', $fileInfo ['name'] )) {
			$this->error ( '图片名不合法' );
			return;
		}
		// 处理图片上传
		$filePath = 'upload/image/' . md5 ( '' . mt_rand () . time () ) . '.jpg';
		if (! move_uploaded_file ( $fileInfo ['tmp_name'], $filePath )) {
			$this->error ( '上传图片发生错误' );
			return;
		}
		$goods = new GoodsModel ();
		if ($goods->create ()) {
			$goods->art_path = $filePath;
			if ($goods->add ()) {
				$this->success ( '添加商品成功');
			} else {
				$this->error ( '添加商品发生错误');
			}
		}
	}
}