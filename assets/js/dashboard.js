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
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR ITEM<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><h3 class="text-secondary text-center">Tem certeza de que deseja excluir o item selecionado?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-success" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-danger" id="dataComfirmOK"><i class="fas fa-trash-alt"></i> Apagar</a></div></div></div></div>');
        }
        $('#dataComfirmOK').attr('href', href);
        $('#confirm-delete').modal({show: true});
        return false;
    });

    $('a[data-confirmDema]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-delete').length) {
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR DEMANDA<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><h3 class="text-secondary text-center">Tem certeza que deseja excluir a demanda selecionada e todas as atividades nela cadastrada?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-success" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-danger" id="dataComfirmOK"><i class="fas fa-trash-alt"></i> Apagar</a></div></div></div></div>');
        }
        $('#dataComfirmOK').attr('href', href);
        $('#confirm-delete').modal({show: true});
        return false;
    });

    $('a[data-cancelar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-cancelar').length) {
            $('body').append('<div class="modal fade" id="confirm-cancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">CANCELAR ATENDIMENTO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><h3 class="text-secondary text-center">Tem certeza que deseja cancelar o atendimento selecionado?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-success" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-danger" id="dataComfirmOKcan"><i class="fas fa-check"></i> Confirmar</a></div></div></div></div>');
        }
        $('#dataComfirmOKcan').attr('href', href);
        $('#confirm-cancelar').modal({show: true});
        return false;
    });

    $('a[data-arquivo]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-arquivo').length) {
            $('body').append('<div class="modal fade" id="confirm-arquivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-info text-white">ARQUIVAR ATENDIMENTO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><h3 class="text-secondary text-center">Tem certeza que deseja arquivar o atendimento selecionado?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-info" id="dataComfirmOKarq"><i class="fas fa-archive"></i> Arquivar</a></div></div></div></div>');
        }
        $('#dataComfirmOKarq').attr('href', href);
        $('#confirm-arquivo').modal({show: true});
        return false;
    });

    $('a[data-desarquivar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-des').length) {
            $('body').append('<div class="modal fade" id="confirm-des" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-info text-white">DESARQUIVAR ATENDIMENTO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><h3 class="text-secondary text-center">Tem certeza que deseja desarquivar o atendimento selecionado?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-info" id="dataComfirmOKdes"><i class="fas fa-undo"></i> Desarquivar</a></div></div></div></div>');
        }
        $('#dataComfirmOKdes').attr('href', href);
        $('#confirm-des').modal({show: true});
        return false;
    });

    //----------------------------------------------
    $('a[data-sitAtenIniciar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirmIniciar').length) {
            $('body').append('<div class="modal fade" id="confirmIniciar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-dark text-white">Iniciar Atendimento<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><h3 class="text-secondary text-center">Tem certeza que deseja iniciar o atendimento agora?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-success" id="dataComfirmOKiniciar"><i class="fas fa-hourglass-start"></i> Iniciar</a></div></div></div></div>');
        }
        $('#dataComfirmOKiniciar').attr('href', href);
        $('#confirmIniciar').modal({show: true});
        return false;
    });

    $('a[data-sitAtenContinuar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirmContinuar').length) {
            $('body').append('<div class="modal fade" id="confirmContinuar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-primary text-white">Continuar Atendimento<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><h3 class="text-secondary text-center">Pronto para continuar o atendimento?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-primary" id="dataComfirmOKContinuar"><i class="fas fa-chart-line"></i> Continuar</a></div></div></div></div>');
        }
        $('#dataComfirmOKContinuar').attr('href', href);
        $('#confirmContinuar').modal({show: true});
        return false;
    });



    $('a[data-sitAtenPausar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirmPausar').length) {
            $('body').append('<div class="modal fade" id="confirmPausar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-warning text-white">Pausar Atendimento<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div><h3 class="text-secondary text-center">Tem certeza que deseja pausar o atendimento?</h3></div></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-warning" id="dataComfirmOKpausar"><i class="fas fa-pause"></i> Pausar</a></div></div></div></div>');
        }
        $('#dataComfirmOKpausar').attr('href', href);
        $('#confirmPausar').modal({show: true});
        return false;
    });



    $('a[data-confirmFinalizar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirmFinalizar').length) {
            $('body').append('<div class="modal fade" id="confirmFinalizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-success text-white">Finalizar Atendimento<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><h3 class="text-secondary text-center">Tem certeza que deseja finalizar o atendimento?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button><a class="btn btn-outline-success" id="dataComfirmOKfina"><i class="fas fa-check"></i> Finalizar</a></div></div></div></div>');
        }
        $('#dataComfirmOKfina').attr('href', href);
        $('#confirmFinalizar').modal({show: true});
        return false;
    });


    $('a[data-confirmEnviarCliente]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirmEnviarCliente').length) {
            $('body').append('<div class="modal fade" id="confirmEnviarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-info text-white">Concluir Atendimento<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><h3 class="text-secondary text-center">Tem certeza que deseja concluir o atendimento sem anexar nenhum documento?</h3></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-paperclip"></i> Anexar</button><a class="btn btn-outline-info" id="dataComfirmOKEnviarCliente"><i class="fas fa-check"></i> Concluir</a></div></div></div></div>');
        }
        $('#dataComfirmOKEnviarCliente').attr('href', href);
        $('#confirmEnviarCliente').modal({show: true});
        return false;
    });
});

//Apresentar tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});