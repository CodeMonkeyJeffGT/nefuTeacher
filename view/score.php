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
				<div>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br>1<br></div>
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
					<label class="control-label">开课学期</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-term">全部<i></i></span>
						<ul>
							<li value="">
								全部
							</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">课程类型</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-type">全部<i></i></span>
						<ul>
							<li value="">
								全部
							</li>
							<li value="07">
								通识教育必修课
							</li>
							<li value="09">
								学科基础课
							</li>
							<li value="10">
								实践教学
							</li>
							<li value="11">
								通识教育课
							</li>
							<li value="01">
								公共课
							</li>
							<li value="02">
								公共基础课
							</li>
							<li value="03">
								专业基础课
							</li>
							<li value="04">
								专业课
							</li>
							<li value="05">
								专业选修课
							</li>
							<li value="06">
								通识教育选修课
							</li>
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
							<li value="2">
								显示全部成绩
							</li>
							<li value="1">
								显示最好成绩
							</li>
							<li value="0">
								显示最后成绩
							</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<div class="control-btn">搜索</div>
				</div>
			</div>
			<div class="operator-show">
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var college = 0;
		var flag = true;
		var rec_grade = '';
		var rec_major = '';
		$(function(){
			getDropdown();
			$('#control-grade').on('DOMNodeInserted',function(){
				var grade = $('#control-grade').val();
				if(grade != rec_grade)
				{
					rec_grade = grade;
					rec_major = '';
					var data = {
						'college': college,
						'grade' : rec_grade,
					}
					getDropdown(data, 1);
				}
			});
			$('#control-major').on('DOMNodeInserted',function(){
				var major = $('#control-major').val();
				if(major != rec_major)
				{
					rec_major = major;
					var data = {
						'college': college,
						'grade' : rec_grade,
						'major' : rec_major,
					}
					getDropdown(data, 2);
				}
			});
		})
		function getDropdown(data = {}, level = 0)
		{
			$.ajax({
				"url": "?c=score&f=getDropdown",
				"method": "post",
				"data": data,
				"dataType": 'json',
				"success": function(result){
					if(result.code != 0)
						window.location.reload();
					result = result.data;
					if(0 == level)
					{
						college = result.college;
						var grade = '';
						for(var key in result.grade)
						{
							grade = '<li value="' + key + '">' + result.grade[key] + '</li>' + grade;
						}
						grade = '<li value="">全部</li>' + grade;
						$($($('#control-grade')[0].parentElement)[0].children[1]).html(grade);
					}
					else if(1 == level)
					{
						var major = '<li value="">全部</li>';
						for(var key in result.major)
						{
							major += '<li value="' + key + '">' + result.major[key] + '</li>';
						}
						$($($('#control-major')[0].parentElement)[0].children[1]).html(major);
						$($($('#control-class')[0].parentElement)[0].children[1]).html('<li value="">全部</li>');
						$('#control-major').val('');
						$('#control-major').html('全部<i></i>');
						$('#control-class').val('');
						$('#control-class').html('全部<i></i>');
					}
					else if(2 == level)
					{
						var classs = '<li value="">全部</li>';
						for(var key in result.class)
						{
							classs += '<li value="' + key + '">' + result.class[key] + '</li>';
						}
						$($($('#control-class')[0].parentElement)[0].children[1]).html(classs);
						$('#control-class').val('');
						$('#control-class').html('全部<i></i>');

					}
				},
				"error": function(err){
					console.log(err);
				}
			});
		}
	</script>
</body>
</html>