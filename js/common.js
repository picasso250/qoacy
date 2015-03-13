$(function () {
	var alert = $('.alert');
	var postForm = $('form[method="post"][role=post]').on('submit', function (e) {
		e.preventDefault();
		var $this = $(this);
		var $btn = $(this).find('button[type=submit]');
		$btn.button('loading');
		$.post($this.attr('action'), $this.serialize(), function (ret) {
			if (ret.code === 0) {
				if (ret.data && ret.data.url) {
					location.href = ret.data.url;
					return;
				}
			}
			$btn.button('reset');
			alert.removeClass('alert-hidden').text(ret.message);
		}, 'json');
	});
});
