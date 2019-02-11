/*JS CARREGAR USUARIOS*/
$(document).ready(function () {
    var pagina = 1; //página inicial
    listar_usuario(pagina);
});

function listar_usuario(pagina,  varcomp = null) {
    var dados = {
        pagina: pagina
    };
    $.post('../../adm/usuarios/listar/' + pagina + '?tiporesult=1', dados, function (retorna) {
        $("#conteudo").html(retorna);
    });
}


$(function () {
    //Verificado se o usuário digitou algum valor no campo
    $("#pesqUser").keyup(function () {
        var pesqUser = $(this).val();

        //Verificar se há valor na variável "pesqUser".
        if(pesqUser !== ''){
            var dados = {
                palavraPesq: pesqUser
            };
            $.post('../../adm/usuarios/listar/1?tiporesult=2', dados, function(retorna){
                //Carregar o conteúdo para o usuário
                $("#conteudo").html(retorna);
            });
        }else{
            var pagina = 1; //página inicial
            listar_usuario(pagina);
        }
    });
});