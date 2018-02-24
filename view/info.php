<html>
<head>
	<title>知派教师端 - 个人信息</title>
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
				$css = array('sunrise','sun','noon','tea','moon','sleep');
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
				<div class="control-element">
				</div>
				<div class="control-element">
					<label class="control-label">姓名</label>
					<input class="control-input" type-"text" id="control-student" value="<?=$_SESSION['teacher']['name']?>" disabled />
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
					<label class="control-label">学院</label>
					<input class="control-input" type-"text" id="control-student" value="<?=$_SESSION['teacher']['college']?>学院" disabled />
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
					<div class="control-btn" id="reload">刷新个人信息</div>
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
					<div class="control-btn" id="logout">退出登录</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>