var d = function (arg) {
    console.log(arg);
};
$(function () {
    $('#previewButton').click(function () {
        var content = $('[name=content]').val();
        var m = $('#previewModal');
        var title = $('[name=title]').val();
        m.find('#myModalTitle').text(title);
        m.modal();
        $.post(
            '/preview',
            { content: content},
            function (ret) {
                m.find('.modal-body').html(ret);
            });
        return false;
    });
});
