$(function () {
    var attitudeBtnClick = function () {
        var answer = $(this).parents('li');
        var id = answer.data('id');
        var action = $(this).data('action');
        $.get(
            '/attitude',
            {
                id: id,
                action: action
            },
            function (ret) {
                console.log(ret);
                answer.find('.attitude').html(ret);
                answer.find('.attitude-btn').click(attitudeBtnClick);
            });
    };
    $('.attitude-btn').click(attitudeBtnClick);

    $('.comment-trigger').click(function () {
        var answer = $(this).parents('li');
        var id = answer.data('id');
        var commentDiv = answer.find('div.comments');
        if (commentDiv.html()) {
            commentDiv.toggle();
        } else {
            commentDiv.load('/get_comment_div', {id: id}, function () {
                var ajaxFormFunc = function () {
                    commentDiv.find('form').ajaxForm(function (ret) {
                        commentDiv.html(ret);
                        ajaxFormFunc();
                    });
                };
                ajaxFormFunc();
            }).show();
        }
    })
});
