<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>首页</title>
		<style type="text/css">
			* {
				margin: 0px auto;
				padding: 0px;
			}
			body {
				font-family: "微软雅黑";
			}
			#header {
				min-width: 700px;
				height: 45px;
				background: #101010;
				color: #ffffff;
			}
			#header h1 {
				width: 100px;
				float: left;
				height: 45px;
				line-height: 45px;
				margin-left: 16px;
			}
			#header ul {
				float: right;
				list-style: none;
				height: 45px;
			}
			#header ul li {
				float: left;
			}
			#header ul li a {
				display: block;
				min-width: 80px;
				height: 45px;
				line-height: 45px;
				color: #ffffff;
				padding: 0px 4px;
				text-decoration: none;
				text-align: center;
			}
			#header ul li a:hover {
				background: #333333;
			}
			#category_bar {
				min-width: 700px;
				height: 40px;
				line-height: 40px;
				font-size: 16px;
				background: #1c1c1c;
			}
			
			#category_bar .ctgr {
				text-align: center;
				position: relative;
				top: -40px;
			}
			#category_bar a,
			#category_bar span {
				margin: 10px;
				text-decoration: none;
				color: #ffffff;
			}
			#category_bar a:hover {
				color: #9d9d9d;
			}
			#content {
				width: 100%;
				min-width: 700px;
				min-height: 800px;
				background: #d7d7d7;
			}
			#content .goods_list {
				width: 100%;
				min-height: 800px;
			}
			#content .goods_list .item {
				min-width: 140px;
				width: 32%;
				height: 260px;
				float: left;
				border: 1px solid #cccccc;
				margin: 4px;
			}
			#content .goods_list .item img {
				width: 100%;
				height: 260px;
			}
			#content .goods_list .item .info {
				width: 100%;
				height: 97px;
				background: #000000;
				opacity: 0.8;
				position: relative;
				top: -100px;
			}
			#content .goods_list .item .info .name {
				color: #FFFFFF;
				text-align: center;
				font-weight: bolder;
				font-size: 14px;
				position: relative;
				top: 8px;
			}
			#content .goods_list .item .info .price_num {
				color: #e5e5e5;
				text-align: center;
				font-size: 12px;
				position: relative;
				top: 16px;
			}
			.price_num span {
				display: inline-block;
				margin-left: 8px;
			}
			.btn_cart {
				display: block;
				text-decoration: none;
				background: #e83a3b;
				width: 100px;
				height: 20px;
				line-height: 20px;
				padding: 8px;
				position: relative;
				top: 22px;
				text-align: center;
				color: #ffffff;
			}
			.btn_cart:hover {
				background: #f94b4c;
			}
			#mask {
				position: absolute;
				top:0px;
				left:0px;
				width: 100%;
				min-height: 900px;
				background: #000000;
				opacity: 0.8;
				display: none;
			}
			#login_page {
				position: fixed;
				top: -255px;
				width: 500px;
				height: 255px;
				padding: 50px auto;
				border: 1px solid #cccccc;
				background: #ffffff;
				display: none;
			}
			#cart-list {
				width:260px;
				min-height: 90px;
				background: #ffffff;
				border:1px solid #cccccc;
				position: absolute;
				top:45px;
				right:0px;
				z-index: 3;
				color:#393939;
				font-size: 12px;
				display: none;
			}
			#cart-list img {
				width:30px;
				height: 30px;
			}
			#cart-list table {
				width:100%;
			}
			#cart-list table tr {
				height:30px;
			}
			#cart-list a {
				color:#df3536;
				font-weight: bolder;
				text-decoration: none;
			}
			#cart-list a:hover {
				color:#ff5758;
			}
		</style>
		<link rel="stylesheet" href="../../Public/css/form.css" />
	</head>
	<body>
		<div id="header">
			<h1>LOGO</h1>
			<ul>
				<li style="display: <?php if($data['isLogin']) echo 'none'; else echo 'block';?>;">
					<a id="login" href="javascript:void(0);">登录</a>
				</li>
				<li style="display: <?php if($data['isLogin']) echo 'block'; else echo 'none';?>;">
					<a href="javascript:void(0);"><?=$data['uname']?></a>
				</li>
				<li style="display: <?php if($data['isLogin']) echo 'block'; else echo 'none';?>;">
					<a id="logout" href="javascript:void(0);">退出</a>
				</li>
				<li>
					<a id="btn-cart" href="javascript:void(0);">购物车</a>
				</li>
			</ul>
			<div id="cart-list">
				<table></table>
				<div style="text-align: center; margin-top: 8px;"><a href="../cart/index">去购物车结算</a></div>
			</div>
		</div>
		<div id="category_bar">
			<input id="currCPath" type="hidden" value="<?=$data['path'] ?>"/>
			<span style="font-size:12px;">
		  <?=str_replace('_', '&nbsp;&gt;&gt;&nbsp;',$data['currCtgr']) ?>
		  </span>
			<div class="ctgr">
				<?php foreach ($data['ctgrList'] as $c): ?>
				<a href="?c=<?=$c['cid'] ?>&n=<?=$c['cname']?>&p=<?=$c['path']?>&r=<?=$data['currCtgr'] ?>">
					<?=$c['cname'] ?>
				</a>
				<?php endforeach;?>
			</div>
		</div>
		<div id="content" ng-app="content">
			<div class="goods_list">
				<?php foreach($data['goodsList'] as $g): ?>
				<div class="item">
					<img src="../../<?php echo $g['art_path']?>" />
					<div class="info">
						<input class="gid" type="hidden" value="<?php echo $g['gid']?>"/>
						<div class="name">
							<?php echo $g['gname']?>
						</div>
						<div class="price_num">
							<span style="text-decoration:line-through">原价:¥<?php echo $g['price']?></span>
							<span>价格:¥<span class="price" style="margin: 0px;"><?php echo $g['price'] * $g['discount']?></span></span>
							<span>数量:<?php echo $g['store_num']?></span>
						</div>
						<a class="btn_cart" href="javascript:void(0);">加入购物车</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div id="mask"></div>
		<div id="login_page">
			<form id="login_form" method="post">
				<div class="form-container">
					<div class="field">
						<label class="field-describe" for="uname">用户名/邮箱：</label>
						<span class="field-entity">
                        <input id="uname" name="uname" type="text" placeholder="用户名/邮箱" />
                        <img id="img_uname" />
                        </span>
					</div>
					<div id="uname_info" class="info"></div>
					<div class="field">
						<label class="field-describe" for="pwd">密&nbsp;&nbsp;码：</label>
						<span class="field-entity">
                        <input id="pwd" name="pwd" type="password" placeholder="密码" />
                        <img id="img_pwd" />
                        </span>
					</div>
					<div id="pwd_info" class="info"></div>
					<div class="field" style="text-align:left;">
						<label class="field-describe" for="vcode">验证码：</label>
						<input type="text" id="vcode" name="vcode" style="border: solid 1px #cccccc; width: 100px; height: 30px;" />
						<img id="img_vcode" style="width:100px;height:30px; visibility: visible;" src="../user/getVerifyCode?<?php echo mt_rand();?>" />
					</div>
					<div id="vcode_info" class="info"></div>
					<div class="field btn_space">
						<a id="btn_login" href="javascript:void(0);">登&nbsp;&nbsp;录</a>
						<a id="btn_cancel" href="javascript:void(0);">取&nbsp;&nbsp;消</a>
					</div>
				</div>
			</form>
		</div>
	<script type="text/javascript" src="../../Public/js/jquery-1.11.3.min.js" ></script>
	<!--<script type="text/javascript" src="../../Public/js/angular.min.js" ></script>
	<script type="text/javascript" src="../../Public/js/goods-list.js" ></script>-->
	<script type="text/javascript" src="../../Public/js/login.js" ></script>
	<script type="text/javascript" src="../../Public/js/cart.js" ></script>	
	</body>
</html>