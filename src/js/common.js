$(function(){
	$(".c-s-checkspan").bind("click",function(){
		var ul = $(this).siblings('ul')
		if(ul.is(":hidden")){
			$('.control-select ul').slideUp(400);
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
					$('.control-select ul').slideUp(400);
				});
			});
		}else{
			$(this).siblings('ul').slideUp(400)
		}	
	})
})