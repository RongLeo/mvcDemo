$(function() {
	// 页面导航栏的登录按钮单击
	$("#login").click(function() {
		$('#mask').show();
		var loginPage = $('#login_page');
		var left = (window.innerWidth - loginPage.width()) / 2;
		loginPage.css('left', left).show().animate({
			top: '100px'
		}, 400);
	});

	// 执行登录
	$("#btn_login").click(function(e) {
		// e.preventDefault();
		if(validateInput()) {
			ajaxLogin();
		}
	});

	// 验证表单输入，所有项都验证通过，则返回true
	function validateInput() {
		var uname = $('#uname').val();
		var pwd = $('#pwd').val();
		unameReg = /^\w+@?\w*\.*\w+$/;

		var isValid = true;
		if(unameReg.test(uname)) {
			$('#img_uname').css('visibility', 'visible').prop('src', '../../Public/img/true.png');
			$('#uname_info').css('visibility', 'hidden');
		} else {
			isValid = false;
			$('#uname_info').css('visibility', 'visible').text('请输入合法的用户名或邮箱');
			$('#img_uname').css('visibility', 'visible').prop('src', '../../Public/img/false.png');
		}
		if(pwd.length >= 6) {
			$('#img_pwd').css('visibility', 'visible').prop('src', '../../Public/img/true.png');
			$('#pwd_info').css('visibility', 'hidden');
		} else {
			isValid = false;
			$('#pwd_info').css('visibility', 'visible').text('密码长度必须大于等于6位');
			$('#img_pwd').css('visibility', 'visible').prop('src', '../../Public/img/false.png');
		}
		if($('#vcode').val() == '') {
			isValid = false;
			$('#vcode_info').css('visibility', 'visible').text('验证码不能为空');
		} else {
			$('#vcode_info').css('visibility', 'hidden');
		}
		return isValid;
	}

	// 异步执行登录请求
	function ajaxLogin() {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../user/dologin', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		// 打包表单字段，得到请求参数（n1=v1&n2=v2）
		var params = $('#login_form').serialize();
		xhr.send(params);
		xhr.onreadystatechange = function() {
			if(xhr.readyState == 4) {
				if(xhr.status == 200) {
					var resp = JSON.parse(xhr.responseText);
					switch(resp.status) {
						case 1:
							hideLoginPage();
							var li = $("#header ul li");
							li.eq(0).hide();
							li.eq(1).find('a').html(resp.data.uname);
							li.eq(1).show();
							li.eq(2).show();
							if (resp.url) {
								window.location.href = '../' + resp.url;
							}
							break;
						case 0:
							$('#uname_info').css('visibility', 'visible').text(resp.msg);
							break;
						case -1:
							$('#vcode_info').css('visibility', 'visible').text(resp.msg);
							break;
					}
				}
			}
		}
	}

	// 验证码图片单击
	$("#img_vcode").click(function() {
		$(this).prop('src', '../user/getVerifyCode?' + Math.random());
	});

	// 登录页的取消按钮单击
	$("#btn_cancel").click(function() {
		hideLoginPage();
	});

	function hideLoginPage() {
		$('#uname').val('');
		$('#pwd').val('');
		$('#vcode').val('');
		$('#img_uname').css('visibility','hidden');
		$('#uname_info').css('visibility','hidden');
		$('#img_pwd').css('visibility','hidden');
		$('#pwd_info').css('visibility','hidden');
		$('#img_vcode').prop('src','../user/getVerifyCode?' + Math.random());
		$('#vcode_info').css('visibility','hidden');
		var loginPage = $('#login_page');
		loginPage.animate({
			top: -250
		}, 200, function() {
			$('#mask').hide();
			loginPage.hide();
		});
	}

	// 退出按钮单击
	$("#logout").click(function() {
		$.ajax({
			type: 'GET',
			url: '../user/logout',
			success: function(resp) {
				if(resp.status == 1) {
					var li = $("#header ul li");
					li.eq(0).show();
					li.eq(1).find('a').html('');
					li.eq(1).hide();
					li.eq(2).hide();
				}
			},
			error: function(err) {
				//
			}
		});
	});
});