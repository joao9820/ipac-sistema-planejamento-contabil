/*JS CARREGAR USUARIOS*/
/*
$(document).ready(function () {
    var pagina = 1; //página inicial
    listar_atendimento(pagina);
});

function listar_atendimento(pagina,  varcomp = null) {
    var dados = {
        pagina: pagina
    };
    $.post('../../adm/gerenciar-atendimento/listar/' + pagina + '?tiporesult=1', dados, function (retorna) {
        $("#conteudoAtendimento").html(retorna);
    });
}


$(function () {
    //Verificado se o usuário digitou algum valor no campo
    $("#pesqAtendimento").keyup(function () {
        var pesqAtendimento = $(this).val();

        //Verificar se há valor na variável "pesqAtendimento".
        if(pesqAtendimento !== ''){
            var dados = {
                palavraPesq: pesqAtendimento
            };
            $.post('../../adm/gerenciar-atendimento/listar/1?tiporesult=2', dados, function(retorna){
                //Carregar o conteúdo para o usuário
                $("#conteudoAtendimento").html(retorna);
            });
        }else{
            var pagina = 1; //página inicial
            listar_atendimento(pagina);
        }
    });
});
*/
/*
$(document).ready(function () {
    $(document).on('click', '.view_atendimento', function(){
        var aten_id = $(this).attr('id');
        //alert(aten_id);
        if(aten_id !== ''){
            var dados = {
                user_id: aten_id
            };
            $.post('../../adm/ver-atendimento-modal/ver-atendimento/' + aten_id, dados, function(retorna){
                //Carregar o conteúdo para o atendimento
                $("#visul_atendimento").html(retorna);
                $('#visulAtendimentoModal').modal('show');
            });
        }
    });
});
*/
