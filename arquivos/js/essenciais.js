
function campoPesquisa(url, pag) {

    $("#search").click(function () {
        $("#busca").focus();
    });
    var typingTimer; //timer identifier
    var doneTypingInterval = 1000; //time in ms, 5 second for example

    //on keyup, start the countdown
    $('#busca').keyup(function () {
        clearTimeout(typingTimer);
        if ($('#busca').val()) {
            typingTimer = setTimeout(function () {
                pesquisarajax($('#busca').val())
            }, doneTypingInterval);
        }
    });
    function pesquisarajax(termo, pag) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                busca: termo,
                pag: pag
            },
            success: function (data) {
                $('#pesquisa-painel').html(data);
            },
            error: function (data) {
                $('#pesquisa-painel').html('Ooops! não foi possível carregar a página, tente novamente mais tarde.');
            }
        });
    }
    document.onkeyup = function (e) {

        if (e.which == 8) {
            pesquisarajax($('#busca').val());
        }
    }
    pesquisarajax('', (pag ? pag : 1));
}
 