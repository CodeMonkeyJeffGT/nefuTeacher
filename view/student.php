<html>
<head>
	<title>知派教师端 - 学生列表</title>
</head>
<body>
	<div class="platform">
		<div class="menu">
			<div class="menu-userinfo">
				<?php 
				$hour = date('H');
				if($hour > 4 && $hour < 8){
					$hour = '0';
				}elseif($hour < 11){
					$hour = '1';
				}elseif($hour < 13){
					$hour = '2';
				}elseif($hour < 18){
					$hour = '3';
				}elseif($hour < 23){
					$hour = '4';
				}else{
					$hour = '5';
				}
				$sentences = array('早上好','上午好','中午好','下午好','晚上好','夜深了');
				$css = array('sunrise','sun','sun','tea','moon','sleep');
				?>
				<div class="userinfo-name"><?=$sentences[$hour]?>，<?= mb_substr($_SESSION['teacher']['name'], 0, 1) ?>老师 <div class="userinfo-img img-<?=$css[$hour]?>"></div></div>
				<div class="userinfo-college"><?=$_SESSION['teacher']['college']?>学院</div>
			</div>
			<div class="menu-menu">
				<?php 
				$now = '学生列表';
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
					<label class="control-label">政治面貌</label>
					<div class="control-select">
						<span class="c-s-checkspan">-- 请选择 --<i></i></span>
						<ul>
							<li>
								-- 请选择 --
							</li>
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
				<div class="control-element">
					<label class="control-label">姓名</label>
					<input class="control-input" type-"text" />
				</div>
				<div class="control-element">
					<label class="control-label"></label>
					<div class="control-multselect">
						<span class="c-ms-checkspan">-- 请选择 --<i></i></span>
						<div>
							<ul>
								<li>
									-- 请选择 --
								</li>
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
				</div>
			</div>
			<div class="operator-show">
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$(function(){
		console.log($('.control-multselect > div'));
	})
	</script>
</body>
</html>