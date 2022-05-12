$(document).ready(function() {
	$("#telefone").mask('(00) 0000-0000'); //telefone de clientes, fornecedores
	$("#tel_sistema").mask('(00) 0000-0000'); //telefone de clientes, fornecedores
	$("#cpf").mask('000.000.000-00'); //cpf dos alunos
    $("#cpf_usu").mask('000.000.000-00'); //cpf dos administradores e professores
	$("#cep").mask('00000-000');
	$("#cnpj").mask('00.000.000/0000-00'); //CNPJ de fornecedores
	$("#cnpj_sistema").mask('00.000.000/0000-00');

});