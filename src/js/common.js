var college = 0;
var rec_grade = '';
var rec_major = '';
var historyNow = -1;
var historyStore = '';

$(function(){
	try{
		loadHistory(type, true);
	}
	catch(e){
	}
	//下拉框
	$(".c-s-checkspan").bind("click",function(){
		var ul = $(this).siblings('ul')
		if(ul.is(":hidden")){
			$('.control-select ul').slideUp(300);
			ul.slideDown(300, function() {
				$(this).find("li").unbind('click');
				$(this).find("li").bind("click",function(){
					var selectLi=$(this).text() + '<i></i>';
					$(this).parent().find('li').css('background-color', '#fff');
					$(this).css('background-color', 'rgb(240, 255, 255)');
					var tmpRoot = $(this).parent().parent();
					tmpRoot.find('span').val($(this).attr('value'));
					tmpRoot.find('span').html(selectLi);
					tmpRoot.find('ul').slideUp(300);
				})
				ul.mouseleave(function() {
					$('.control-select ul').slideUp(300);
				});
			});
		}else{
			$(this).siblings('ul').slideUp(300)
		}
	});
	if($('#control-grade').length != 0)
	{
		$('#control-major').parent().find('ul').find('li').eq(0).css('background-color', 'rgb(240, 255, 255)');
		$('#control-class').parent().find('ul').find('li').eq(0).css('background-color', 'rgb(240, 255, 255)');
		$('#control-type').parent().find('ul').find('li').eq(0).css('background-color', 'rgb(240, 255, 255)');
		$('#control-showWay').parent().find('ul').find('li').eq(1).css('background-color', 'rgb(240, 255, 255)');
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
	}
});

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
				$('#control-grade').parent().find('ul').html(grade);
				$('#control-grade').parent().find('ul').find('li').eq(0).css('background-color', 'rgb(240, 255, 255)');
				if($('#control-term').length != 0){
					var term = '<li value="">全部</li>';
					for(var key in result.term)
					{
						term += '<li value="' + key + '">' + result.term[key] + '</li>';
					}
					$('#control-term').parent().find('ul').html(term);
					$('#control-term').parent().find('ul').find('li').eq(0).css('background-color', 'rgb(240, 255, 255)');
				}
			}
			else if(1 == level)
			{
				var major = '<li value="">全部</li>';
				for(var key in result.major)
				{
					major += '<li value="' + key + '">' + result.major[key] + '</li>';
				}
				$('#control-major').parent().find('ul').html(major);
				$('#control-class').parent().find('ul').html('<li value="">全部</li>');
				$('#control-major').val('');
				$('#control-major').html('全部<i></i>');
				$('#control-major').parent().find('ul').find('li').eq(0).css('background-color', 'rgb(240, 255, 255)');
				$('#control-class').val('');
				$('#control-class').html('全部<i></i>');
				$('#control-class').parent().find('ul').find('li').eq(0).css('background-color', 'rgb(240, 255, 255)');
			}
			else if(2 == level)
			{
				var classs = '<li value="">全部</li>';
				for(var key in result.class)
				{
					classs += '<li value="' + key + '">' + result.class[key] + '</li>';
				}
				$('#control-class').parent().find('ul').html(classs);
				$('#control-class').val('');
				$('#control-class').html('全部<i></i>');
				$('#control-class').parent().find('ul').find('li').eq(0).css('background-color', 'rgb(240, 255, 255)');
			}
		},
		"error": function(err){
			console.log(err);
		}
	});
}

function loadHistory(type, loop = false, id = false){
	if(id != false)
	{
		historyNow = id;
	}
	var data = {
		"type": type
	};
	$.ajax({
		"url": "?c=history",
		"method": "post",
		"data": data,
		"dataType": "json",
		"success": function(result){
			if(result.code == 1)
			{
				alert(result.message);
				return;
			}
			else if(result.code == 2)
			{
				window.location.reload();
				return;
			}
			result = result.data;
			var str = JSON.stringify(result);
			if(loop){
				setTimeout(function(){loadHistory(type, true)}, 1000);
			}
			if(historyStore == str){
				return;
			}
			historyStore = str;
			if(result.length == 0)
			{
				return;
			}
			var str = '';
			for(var i in result){
				var tstr = '<div class="history-element';
				if(result[i].id == historyNow)
				{
					tstr += ' history-selected';
				}
				tstr += '" value=' + result[i].id + '><div class="history-ele-title">' + result[i].title + '</div><span class="history-ele-time">' + result[i].time + '</span> <span class="history-ele-status h-e-s-' + (result[i].status == 0 ? 'done' : result[i].status == 1 ? 'doing' : 'fail') + '"></span></div>';
				str = tstr + str;
			}
			$('.history-content').html(str);
			$('.history-element').on('click', function(){
				$('.history-selected').removeClass('history-selected');
				$(this).addClass('history-selected');
				historyNow = $(this).attr('value');
				var data = {
					"id": historyNow,
				};
				$.ajax({
					"url": "?c=" + type + "&f=info",
					"method": "post",
					"data": data,
					"dataType": 'json',
					"success": function(result){
						console.log(result);
					},
					"error": function(err){
						console.log(err);
					}
				});
			});
		},
		"error": function(err){
			console.log(err);
		}
	});
}