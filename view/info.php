<html>
<head>
	<title>知派教师端 - 个人信息</title>
	<style>
		.select{width: 200px; line-height: 25px;  border:1px solid #ccc; font-size: 12px; position: relative; display: inline-block;  float: left; margin: 25px 0px 0px 39px;}
		.select i{width: 0; height: 0; border-top: 5px solid #333; border-left: 5px solid transparent;  border-right: 5px solid transparent;
			position: absolute; top: 10px; right: 10px;}
		.select span{display: block; padding: 0 10px; font-size: 13px; height: 25px; cursor: pointer;}
		.select ul{ width: 100%; position: absolute; z-index: 999}
		.select ul,.select li{padding: 0; margin:0 }
		.select li{padding: 0 10px;line-height: 30px; background-color: #ffffff; color: #666; list-style-type: none; border:1px solid #ccc; border-top: none; cursor: pointer;transition: all 1s ease 0s;}
		.select li:first-child{border-top: 1px solid #ccc;}
		.select li:hover{ background-color: rgb(240, 255, 255); padding-left: 20px; font-weight: bold; }
		.select ul{display: none;}
	</style>
</head>
<body>
	<div class="platform">
		<div class="menu">
			<div class="menu-userinfo">
				<?php 
				$now = date('H');
				if($now > 4 && $now < 8){
					$now = '0';
				}elseif($now < 11){
					$now = '1';
				}elseif($now < 13){
					$now = '2';
				}elseif($now < 18){
					$now = '3';
				}elseif($now < 23){
					$now = '4';
				}else{
					$now = '5';
				}
				$sentences = array('早上好','上午好','中午好','下午好','晚上好','夜深了');
				$css = array('sunrise','sun','sun','tea','moon','sleep');
				?>
				<div class="userinfo-name"><?=$sentences[$now]?>，<?= mb_substr($_SESSION['teacher']['name'], 0, 1) ?>老师 <div class="userinfo-img img-<?=$css[$now]?>"></div></div>
				<div class="userinfo-college"><?=$_SESSION['teacher']['college']?>学院</div>
			</div>
			<div class="menu-menu">
				<?php 
				$now = '个人信息';
				$menulist = json_decode(file_get_contents(ROOT . '/store/menu.store'), true);
				foreach ($menulist as $element) { ?>
				<div class="menu-element <?=$now==$element['name'] ? ' menu-ele-select' : '' ?>" <?php if($now!=$element['name']){?>onclick="window.location.assign('<?=$element["url"]?>')"<?php }?>>
					<?= $element['name']?>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="operator">
			<div class="operator-control">
				<div class="select">
					<span class="checkspan">学院<i></i></span>
					<ul>
						<li>
							信息与计算机工程学院
						</li>
						<li>
							理学院
						</li>
						<li>
							文法学院
						</li>
						<li>
							经济管理学院
						</li>
						<li>
							林学院
						</li>
						<li>
							园林学院
						</li>
						<li>
							机电工程学院
						</li>
					</ul>
				</div>
			</div>
			<div class="operator-show">
			</div>
		</div>
	</div>
	<script>
		$(function(){
			$(".checkspan").bind("click",function(){
				var ul = $(this).siblings('ul')
				if(ul.is(":hidden")){
					$('.select ul').slideUp(400);
					ul.slideDown('400', function() {
						$(this).find("li").unbind('click');
						$(this).find("li").bind("click",function(){
							var selectLi=$(this).text() + '<i></i>';
							var tmpRoot = $($($(this)[0].parentElement)[0].parentElement);
							$(tmpRoot[0].children[0]).text('');
							$(tmpRoot[0].children[0]).append(selectLi);
							$(tmpRoot[0].children[1]).slideUp(400);
						})
						ul.mouseleave(function() {
							$('.select ul').slideUp(400);
						});
					});
				}else{
					$(this).siblings('ul').slideUp(400)
				}
				
			})
			
		})
	</script>
</body>
</html>