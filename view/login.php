<html>
<head>
	<meta charset='utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>登录</title>
	<style type="text/css">
		html,body,.platform{
			width: 100%;
			height: 100%;
			text-align: center;
		}
		.login{
			background-color: #fff;
			width: 400px;
			height: 450px;
			box-shadow: 0 1px 3px rgba(26,26,26,.1);
			margin: 0 auto;
			margin-bottom: 50px;
		}
		.login-title{
			padding-top: 30px;
			color: #0084ff;
			font-family: "Microsoft YaHei",Tahoma, Arial;
			font-size: 60px;
		}
		.login-label{
			padding-bottom: 20px;
			color: #0084ff;
			border-bottom-width: 1px;
			border-bottom-color: rgb(230, 230, 230);
			border-bottom-style: solid;
			font-size: 16px;
		}
		.login-area{
			margin-top: 18px;
		}
		.login-input{
			margin: 18px 80px;
			width: 240px;
			border: none;
			font-size: 15px;
			padding: 5px 0px;
			border-bottom: lightgray solid 1px;
		}
		.login-input:focus{
			outline: none;
		}
		.login-btn{
			background-color: #0084ff;
			color: #fff;
			margin: 20px;
			width: 240px;
			display: inline-block;
		    	padding: 0 16px;
		    	font-size: 14px;
		    	line-height: 32px;
		    	text-align: center;
		    	cursor: pointer;
		    	border: 1px solid;
		    	border-radius: 3px;
		}
		.login-btn:focus{
			outline: none;
		}
		.login-btn:hover{
			background-color: #0074ff;
		}
		.login-warning{
			font-size: 13px;
			color: red;
			text-align: left;
			margin-left: 80px;
			height: 0px;
		}
		.login-reminder{
			margin-top: 10px;
			font-size: 13px;
			color: gray;
		}
		.login-claim{
			color: #0074ff;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<table class="platform"><tr class="platform"><td class="platform"><div class="login">
		<div class="login-title">知 派</div>
		<div class="login-label">教&nbsp;&nbsp;&nbsp;&nbsp;师&nbsp;&nbsp;&nbsp;&nbsp;端</div>
		<form class="login-area" onsubmit="return false;">
			<input class="login-input" type="text" placeholder="账号" name="账号" autofocus/>
			<input class="login-input" type="password" placeholder="密码" name="密码"/>
			<div class="login-warning"></div>
			<input class="login-btn" type="submit" value="登录">
			<div class="login-reminder">请使用教务处账号密码登录<br><span class="login-claim">安全声明</style></div>
		</form>
	</div></td></tr></table>
	<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
	<script src="src/js/jquery.md5.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".login-btn").on('click', function(){
				var account = $(".login-input[name='账号']").val();
				var password = $(".login-input[name='密码'").val();
				if(account == ''){
					$(".login-warning").text('请输入账号');
					return;
				}
				if(password == ''){
					$(".login-warning").text('请输入密码');
					return;
				}
				password = $.md5(password).toUpperCase();
				var data = {
					"account": account,
					"password": password
				};
				$(".login-warning").text('登录中...');
				$(".login-warning").css('color', 'gray');
				$.ajax({
					"url": '?c=user&f=login',
					"method": 'post',
					"data": data,
					"dataType": 'json',
					"success": function(result){
						console.log(result);
						$(".login-warning").css('color', 'red');
						$(".login-warning").text(result.message);
						if(result.code == 0){
							window.location.reload();
						}
					},
					"error": function(e){
						console.log(e);
					}
				});
			});

			$('.login-claim').on('click', function(){
				alert('我们会将您的密码加密处理，您不必担心您的密码被泄露');
			});
		});
	</script>
</body>
</html>
