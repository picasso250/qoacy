$(function () {
    $('.post-action-btn').click(function () {
        var action = $(this).data('action');
        var backurl = $(this).data('backurl');
        $.post(action, {}, function (ret) {
            window.location.href = backurl;
        });
    });
});
