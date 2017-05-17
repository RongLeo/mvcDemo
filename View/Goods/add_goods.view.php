<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>添加商品</title>
        <link rel="stylesheet" href="../../Public/css/form.css" />
	</head>
	<body>
		<form id="form" method="post" enctype="multipart/form-data" action="doAdd">
			<div class="form-container">
				<div class="field" >
					<label class="field-describe" for="gname">商品名称：</label>
					<span class="field-entity">
					<input id="gname" name="gname" type="text" placeholder="商品名称" />
					</span>
				</div>
				<div id="gname_info" class="info"></div>
				<div class="field">
					<label class="field-describe" for="price">单&nbsp;&nbsp;价：</label>
					<span class="field-entity">
					   <input id="price" name="price" type="text" placeholder="单价" />
					</span>
				</div>
				<div id="price_info" class="info"></div>
				<div class="field">
					<label class="field-describe" for="discount">折&nbsp;&nbsp;扣：</label>
					<span class="field-entity">
					   <input id="discount" name="discount" type="text" placeholder="折扣" />
					</span>
				</div>
				<div id="discount_info" class="info"></div>
				<div class="field">
					<label class="field-describe" for="store_num">库&nbsp;&nbsp;存：</label>
					<span class="field-entity">
					   <input id="store_num" name="store_num" type="number" placeholder="库存" />
					</span>
				</div>
				<div id="num_info" class="info"></div>
				<div class="field">
				    <label class="field-describe" for="category">商品类别：</label>
				    <span class="field-entity">
				      <select id="category" name="cid">
				        <option value="0">顶级类别</option>
				        <?php foreach ($data['ctgrList'] as $ctgr): ?>
				        <option value="<?php echo $ctgr['cid'];?>"><?php echo $ctgr['cname'];?></option>
				        <?php endforeach;?>
				      </select>
				    </span>
				</div>
				<div class="field">
					<label class="field-describe" for="art">商品图片：</label>
					<input type="file" id="art" name="art" />
				</div>
				<div class="field btn_space">
					<a id="btn_add" href="javascript:void(0);">
						添&nbsp;&nbsp;加
					</a>
				</div>
			</div>
		</form>
	</body>
	<script type="text/javascript">
		document.getElementById('btn_add').onclick = function() {
			document.getElementById('form').submit();
		}
	</script>
</html>