/** Подтверждение удаление */
$('.js-delete').click(function () {
    var res = confirm('Подтвердите действие Удаления');
    if (!res) return false;
});