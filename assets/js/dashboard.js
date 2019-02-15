$(document).ready(function () {
    //Apresentar ou ocultar o menu
    $('.sidebar-toggle').on('click', function () {
        $('.sidebar').toggleClass('toggled');
    });
    
    //carregar aberto o submenu
    var active = $('.sidebar .active');
    if (active.length && active.parent('.collapse').length) {
        var parent = active.parent('.collapse');

        parent.prev('a').attr('aria-expanded', true);
        parent.addClass('show');
    }
});

function previewImagem() {
    var imagem = document.querySelector('input[name=imagem').files[0];
    var preview = document.querySelector('#preview-user');

    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imagem) {
        reader.readAsDataURL(imagem);
    } else {
        preview.src = "";
    }
}

function previewImagemUsuario() {
    var imagem = document.querySelector('input[name=imagem_nova').files[0];
    var preview = document.querySelector('#preview-user');

    var reader = new FileReader();
    reader.onloadend = function () {
        preview.src = reader.result;
    };
    if (imagem) {
        reader.readAsDataURL(imagem);
    } else {
        preview.src = "";
    }
}

$('.btnImg').on('click', function() {
    $('.arquivo').trigger('click');
});

$('.arquivo').on('change', function() {
    var fileName = $(this)[0].files[0].name;
    $('#file').val(fileName);
});

// Carregar a modal define para apagar
$(document).ready(function () {
    $('a[data-confirm]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-delete').length) {
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR ITEM<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza de que deseja excluir o item selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button><a class="btn btn-danger text-white" id="dataComfirmOK">Apagar</a></div></div></div></div>');
        }
        $('#dataComfirmOK').attr('href', href);
        $('#confirm-delete').modal({show: true});
        return false;
    });

    $('a[data-confirmDema]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-delete').length) {
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR DEMANDA<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que deseja excluir a demanda selecionada e todas as atividades nela cadastrada?</div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button><a class="btn btn-danger text-white" id="dataComfirmOK">Apagar</a></div></div></div></div>');
        }
        $('#dataComfirmOK').attr('href', href);
        $('#confirm-delete').modal({show: true});
        return false;
    });

    $('a[data-cancelar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-cancelar').length) {
            $('body').append('<div class="modal fade" id="confirm-cancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">CANCELAR ATENDIMENTO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que deseja cancelar o atendimento selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Sair</button><a class="btn btn-danger text-white" id="dataComfirmOKcan">Cancelar</a></div></div></div></div>');
        }
        $('#dataComfirmOKcan').attr('href', href);
        $('#confirm-cancelar').modal({show: true});
        return false;
    });

    $('a[data-arquivo]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-arquivo').length) {
            $('body').append('<div class="modal fade" id="confirm-arquivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-info text-white">ARQUIVAR ATENDIMENTO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que deseja arquivar o atendimento selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button><a class="btn btn-info text-white" id="dataComfirmOKarq">Arquivar</a></div></div></div></div>');
        }
        $('#dataComfirmOKarq').attr('href', href);
        $('#confirm-arquivo').modal({show: true});
        return false;
    });

    $('a[data-desarquivar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-des').length) {
            $('body').append('<div class="modal fade" id="confirm-des" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-info text-white">DESARQUIVAR ATENDIMENTO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que deseja desarquivar o atendimento selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button><a class="btn btn-info text-white" id="dataComfirmOKdes">Desarquivar</a></div></div></div></div>');
        }
        $('#dataComfirmOKdes').attr('href', href);
        $('#confirm-des').modal({show: true});
        return false;
    });

    //----------------------------------------------
    $('a[data-sitAtenIniciar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm').length) {
            $('body').append('<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-primary text-white">Iniciar Atendimento<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que deseja iniciar o atendimento?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button><a class="btn btn-primary text-white" id="dataComfirmOK">Iniciar</a></div></div></div></div>');
        }
        $('#dataComfirmOK').attr('href', href);
        $('#confirm').modal({show: true});
        return false;
    });

    $('a[data-sitAtenPausar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm').length) {
            $('body').append('<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-warning text-white">Pausar Atendimento<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que deseja pausar o atendimento?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button><a class="btn btn-warning text-white" id="dataComfirmOK">Pausar</a></div></div></div></div>');
        }
        $('#dataComfirmOK').attr('href', href);
        $('#confirm').modal({show: true});
        return false;
    });
});

//Apresentar tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});