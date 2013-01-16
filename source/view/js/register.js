$(function () {
    $('form').validate({
        rules: {
            email: {
                remote: '/user/not_taken'
            }
        },
        messages: {
            email: {
                remote: '此邮箱已经被占用，请使用其他邮箱'
            }
        }
    });
});
