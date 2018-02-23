var college = 0;
var rec_grade = '';
var rec_major = '';

$(function(){
	//下拉框
	$(".c-s-checkspan").bind("click",function(){
		var ul = $(this).siblings('ul')
		if(ul.is(":hidden")){
			$('.control-select ul').slideUp(400);
			ul.slideDown('400', function() {
				$(this).find("li").unbind('click');
				$(this).find("li").bind("click",function(){
					var selectLi=$(this).text() + '<i></i>';
					var tmpRoot = $($($(this)[0].parentElement)[0].parentElement);
					$(tmpRoot[0].children[0]).val($(this).attr('value'));
					$(tmpRoot[0].children[0]).html(selectLi);
					$(tmpRoot[0].children[1]).slideUp(400);
				})
				ul.mouseleave(function() {
					$('.control-select ul').slideUp(400);
				});
			});
		}else{
			$(this).siblings('ul').slideUp(400)
		}
	});
	if($('#control-grade').length != 0)
	{
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