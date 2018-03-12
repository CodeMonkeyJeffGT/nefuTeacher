<html>
<head>
	<title>知派教师端 - 学生成绩</title>
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
				$now = '学生成绩';
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
							<li value="">全部</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">专业</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-major">全部<i></i></span>
						<ul>
							<li value="">全部</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">班级</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-class">全部<i></i></span>
						<ul>
							<li value="">全部</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">开课学期</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-term">全部<i></i></span>
						<ul>
							<li value="">全部</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">课程类型</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-type">全部<i></i></span>
						<ul>
							<li value="">全部</li>
							<li value="07">通识教育必修课</li>
							<li value="09">学科基础课</li>
							<li value="10">实践教学</li>
							<li value="11">通识教育课</li>
							<li value="01">公共课</li>
							<li value="02">公共基础课</li>
							<li value="03">专业基础课</li>
							<li value="04">专业课</li>
							<li value="05">专业选修课</li>
							<li value="06">通识教育选修课</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">课程名称</label>
					<input class="control-input" type-"text" id="control-lesson" />
				</div>
				<div class="control-element">
					<label class="control-label">学生</label>
					<input class="control-input" type-"text" id="control-student" />
				</div>
				<div class="control-element">
					<label class="control-label">显示方式</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-showWay">显示最好成绩<i></i></span>
						<ul>
							<li value="2">显示全部成绩</li>
							<li value="1">显示最好成绩</li>
							<li value="0">显示最后成绩</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<div class="control-btn">搜索</div>
				</div>
			</div>
			<div class="operator-show">
			<!-- --------------------------------------------------------- -->
				<div class="operator-show-up">
					<span class="o-s-up-message">正在为您加载...</span>
					<button class="o-s-up-cancle">取消加载</button>
					<button class="o-s-up-print">打印成绩单</button>
					<button class="o-s-up-close">关闭此页面</button>
				</div>
				<div class="operator-show-down">
					<div class="o-s-d-thead">
						<li>学号</li>
						<li class="shortLi">姓名</li>
						<li>开课学期</li>
						<li>班级名称</li>
						<li>课程名称</li>
						<li>总成绩</li>
						<li>课程性质</li>
						<li class="shortLi">学分</li>
						<li>考试性质</li>
					</div>
					<div class="o-s-d-tbody-container">
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li>2016-2017-01</li>
							<li>计算机科学与技术2班</li>
							<li>高等数学</li>
							<li>88.88</li>
							<li>学科基础课</li>
							<li class="shortLi">4</li>
							<li>鄙视</li>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">var type = 'score';</script>
</body>
</html>