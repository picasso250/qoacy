$(function () {
    $('.attitude-btn').click(function () {
    	var id = $(this).parents('li').data('id');
    	var action = $(this).data('action');
    	$.get(
    		'/attitude',
    		{
    			id: id,
    			action: action
    		},
    		function (ret) {
    			console.log('ok');
    		});
    });
});
