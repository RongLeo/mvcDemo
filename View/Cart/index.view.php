<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>购物车</title>
<link rel="stylesheet" type="text/css" href="css/pagination.css" />
<style type="text/css">
body {
	margin: 0px;
	font-family: "微软雅黑";
}

.table {
	border: 1px solid #cccccc;
	border-collapse: collapse;
	width: 100%;
}

.table tr {
	height: 35px;
}

.table tr th, .table tr td {
	border: 1px solid #cccccc;
}

.table tr td {
	text-align: center;
}
</style>
</head>
<body>
	<table class="table" cellpadding="0" cellspacing="0">
		<tr>
			<th>&nbsp;&nbsp;</th>
			<th>&nbsp;&nbsp;</th>
			<th>品名</th>
			<th>价格</th>
			<th>数量</th>
			<th>操作</th>
		</tr>
		<?php foreach ($data['cart'] as $row): ?>
		<tr>
			<input type="hidden" value="<?php echo $row['gid']; ?>" />
			<td><input class="selected" type="checkbox" /></td>
			<td><img style="width:35px;height:35px;" src="<?=$row['art_path'] ?>" /></td>
			<td><?php echo $row['gname'];?></td>
			<td><?php echo $row['price']; ?></td>
			<td>
			    <button class="decr">-</button>
				<span><?php echo $row['num'];?></span>
				<button class="incr">+</button>
		    </td>
			<td>
			  <input type="hidden" value="<?php echo $row['gid']; ?>" />
			  <a class="remove" href="javascript:void(0);">删除</a>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
	<div>
		<a href="#">结算</a>
	</div>
	<script type="text/javascript" src="../../Public/js/jquery-1.11.3.min.js" ></script>
	<script type="text/javascript" src="../../Public/js/cart.js" ></script>
</body>
</html>