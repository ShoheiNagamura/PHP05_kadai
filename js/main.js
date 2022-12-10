//パスワードの表示、非表示を切り替える
$(function () {
    $('.toggle-pass').on('click', function () {
        $(this).toggleClass('fa-eye fa-eye-slash');
        var input = $(this).prev('input');
        if (input.attr('type') == 'text') {
            input.attr('type', 'password');
        } else {
            input.attr('type', 'text');
        }
    });
});
