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

$(document).ready(function () {
    $(document).on('click', '.view_data', function(){
        var user_id = $(this).attr('id');
        //alert(user_id);
        if(user_id !== ''){
            var dados = {
                user_id: user_id
            };
            $.post('../../adm/ver-usuario-modal/ver-usuario/' + user_id, dados, function(retorna){
                //Carregar o conteúdo para o usuário
                $("#visul_usuario").html(retorna);
                $('#visulUsuarioModal').modal('show');
            });
        }
    });
});