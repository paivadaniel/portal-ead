$(document).ready(function() {//quando alunos.php carregar (já que js/ajax.js está sendo chamado dentro de alunos.php), chama a função listar
	listar();
});

function listar(){
    $.ajax({
        url: 'paginas/' + pag + "/listar.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
        method: 'POST',
        data: $('#form').serialize(), //se tiver algum formulário serializa os dados, mas não é esse caso
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
            $('#mensagem-excluir').text('');
        }
    });
}

function inserir() {
    $('#mensagem').text('');
    $('#tituloModal').text('Inserir Registro');
    $('#modalForm').modal('show'); //abrir a modal por script, a outra forma é abrir a modal via data-target
    limparCampos();
}   

$("#form").submit(function () {	
	event.preventDefault();
	var formData = new FormData(this);

	$.ajax({
		url: 'paginas/' + pag + "/inserir.php", //em sistema/painel-admin/paginas/alunos.php foi definido que $pag= 'alunos';

		type: 'POST',
		data: formData,

		success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {                    
                    $('#btn-fechar').click();
                    listar(); //lista os dados dos alunos na tela
                } else {
                	$('#mensagem').addClass('text-danger')
                    $('#mensagem').text(mensagem)
                }

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

});

function excluir(id){
    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {            
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listar();                
            } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)
                }

        },      

    });
}

function ativar(id, acao){
    $.ajax({
        url: 'paginas/' + pag + "/mudar-status.php",
        method: 'POST',
        data: {id, acao},
        dataType: "text",

        success: function (mensagem) {
            if (mensagem.trim() == "Alterado com Sucesso") {
                 listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger');
                $('#mensagem-excluir').text(mensagem);
            }
        },

    });
}