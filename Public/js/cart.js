$(function() {
	// 首页头部购物车按钮鼠标悬停
	$('#btn-cart').on('mouseover', function() {
		$('#cart-list').show();
		loadCartList();
	});

	function loadCartList() {
		$.ajax({
			type: "get",
			url: "../cart/cartList",
			async: true,
			success: function(resp) {
				if(resp.status == 1) {
					var cart = resp.data;
					renderCartList(cart);
				}
			}
		});
	}

	function renderCartList(cart) {
		$('#cart-list').find('table').remove();
		var table = $('<table>');
		for(var i = 0; i < cart.length; i++) {
			var tr = $('<tr>');
			var tdArt = $('<td>').append($('<img>').prop('src',cart[i].art_path));
			
			var gname = cart[i].gname.length > 6 ? cart[i].gname.substring(0,6) + '...' : cart[i].gname;
			var tdName = $('<td>').text(gname);
			var tdPrice = $('<td>').text('¥' + cart[i].price);
			var tdRemove = $('<td>').append($('<input>').prop('type','hidden').val(cart[i].gid)).append($('<a>').text('删除').prop('href','javascript:void(0);').click(removeCartItem));
			
			tr.append(tdArt);
			tr.append(tdName);
			tr.append(tdPrice);
			tr.append(tdRemove);
			table.append(tr);
		}
		$('#cart-list').prepend(table);
	}
	
	function removeCartItem(e) {
		var gid = $(e.target).parent().find(':hidden').val();
		$.ajax({
			type:"get",
			url:"../cart/delete",
			data: {gid:gid},
			async:true,
			success: function(resp) {
				if (resp.status == 1) {
					$(e.target).parents('tr').remove();
				}
			}
		});
	}
	$('#cart-list').on('mouseleave', function() {
		$(this).hide();
	});

	// 首页 添加到购物车按钮单击
	$('.btn_cart').click(function(e) {
		var parent = $(e.target).parent();
		var gid = parent.find('.gid').val();
		var gname = $.trim(parent.find('.name').text());
		var artPath = parent.parent().find('img').prop('src');
		var price = $.trim(parent.find('.price').text());

		$.ajax({
			type: "POST",
			url: "../cart/add",
			data: {
				gid: gid,
				gname: gname,
				art_path: artPath,
				price: price
			},
			async: true,

			success: function(resp) {
				if(resp.status != 1) {
					alert(resp.msg);
				}
			}
		});
	});

	// 购物车信息页面，更改数量按钮
	$('.decr').click(updateNum);
	$('.incr').click(updateNum);

	function updateNum(e) {
		var op = 0;
		if($(e.target).prop('class') == 'incr') {
			op = 1;
		}
		var numSpan = $(e.target).parent().find('span');
		var num = parseInt(numSpan.text());
		if((op == 0) && (num == 1)) {
			op = -1;
		}
		var gid = $(e.target).parents('tr').find(':hidden').val();
		$.ajax({
			type: "get",
			url: "updateNum",
			async: true,
			data: {
				gid: gid,
				op: op
			},
			success: function(resp) {
				if(resp.status == 1) {
					if(op == 0) {
						num--;
					} else if(op == 1) {
						num++;
					} else {
						// 删除
						$(e.target).parents('tr').remove();
					}
					numSpan.text(num);
				}
			}
		});
	}
	
	// 删除购物车链接点击
	$('.remove').click(removeCartItem);
});