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
				$css = array('sunrise','sun','noon','tea','moon','sleep');
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
			<div class="menu-history">
				<div class="history-content">
				</div>
			</div>
		</div>
		<div class="operator">
			<div class="operator-control">
				<div class="control-element">
					<label class="control-label">年级</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-grade">全部<i></i></span>
						<ul>
							<li value="">
								全部
							</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">专业</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-major">全部<i></i></span>
						<ul>
							<li value="">
								全部
							</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">班级</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-class">全部<i></i></span>
						<ul>
							<li value="">
								全部
							</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">政治面貌</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-zzmm">全部<i></i></span>
						<ul>
							<li value="">
								全部
							</li>
							<li value="01">
								中国党员
							</li>
							<li value="02">
								中国预备党员
							</li>
							<li value="03">
								共青团员
							</li>
							<li value="13">
								群众
							</li>
							<li value="04">
								中国国民党革命委员会会
							</li>
							<li value="05">
								中国民主同盟盟员
							</li>
							<li value="06">
								中国民主建国会会员
							</li>
							<li value="07">
								中国民主促进会会员
							</li>
							<li value="08">
								中国农工民主党党员
							</li>
							<li value="09">
								中国致公党党员
							</li>
							<li value="10">
								九三学社社员
							</li>
							<li value="11">
								台湾民主自治同盟盟员
							</li>
							<li value="12">
								无党派人士
							</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">性别</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-sex">全部<i></i></span>
						<ul>
							<li value="">
								全部
							</li>
							<li value="1">
								男
							</li>
							<li value="2">
								女
							</li>
							<li value="9">
								未说明的性别
							</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">学号</label>
					<input class="control-input" type-"text" id="control-number" />
				</div>
				<div class="control-element">
					<label class="control-label">姓名</label>
					<input class="control-input" type-"text" id="control-name" />
				</div>
				<div class="control-element">
					<label class="control-label">身份证号</label>
					<input class="control-input" type-"text" id="control-id" />
				</div>
				<div class="control-element">
					<div class="control-btn">搜索</div>
				</div>
			</div>
			<div class="operator-show">
			</div>
		</div>
	</div>
	<script type="text/javascript">var type = 'student';</script>
</body>
</html>