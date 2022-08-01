$(document).ready(function () {
	/** Подтверждение удаление */
	$('.js-delete').click(function () {
	    var res = confirm('Подтвердите действие Удаления');
	    if (!res) return false;
	});

	/*аккордеон*/
	$(".group > .group__header").on("click", function(){
		if($(this).hasClass('close_group')) {
			$(this).removeClass("close_group");
			$(this).siblings('.group__content').slideDown(200);
		}
		else{
			$(this).addClass("close_group");
			$(this).siblings('.group__content').slideUp(200);
		}
		return false
	});

	/*скрывать поле редиректа когда редиректор не выбран*/
	$('#redirector').on('change', function() {
		if ($('#redirector').prop('checked')) {
			$('#js-redirect_url').css('display', 'block');
		}
		else {
			$('#js-redirect_url').css('display', 'none');
		}
	});
});