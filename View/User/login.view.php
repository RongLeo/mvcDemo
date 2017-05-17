<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>登录</title>
<link rel="stylesheet" type="text/css" href="../../Public/css/form.css" />
</head>
<body>
  <form id="login_form" method="post">
  <input type="hidden" name="a" value="<?php echo $data['a']; ?>" />
  <div class="form-container">
    <div class="field" >
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
	    <img id="img_vcode" style="width:100px;height:30px; visibility: visible;" src="getVerifyCode?<?php echo mt_rand();?>" />
	</div>
    <div class="field btn_space">     
      <a id="btn_login" href="javascript:void(0);">登&nbsp;&nbsp;录</a>
      <a id="btn_register" href="register">注&nbsp;&nbsp;册</a> 
    </div>
  </div>
  </form>
</body>
<script type="text/javascript" src="../../Public/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../../Public/js/login.js" ></script>
</html>