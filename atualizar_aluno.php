<?php

// Conexão com o banco de dados (mesmas credenciais do script principal)
$hostname = "localhost";
$username = "root";
$password = ""; // **Senha vazia - Não recomendada para produção**
$database = "coment"; // Nome do seu banco de dados

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Receber dados do formulário
$idAluno = $_POST["id"];
$nomeNovo = mysqli_real_escape_string($conn, $_POST["nome"]);
$comentarioNovo = mysqli_real_escape_string($conn, $_POST["comentario"]);

// Consulta para atualizar os dados do aluno
$sqlUpdate = "UPDATE alunos SET nome = '$nomeNovo', comentario = '$comentarioNovo' WHERE id = $idAluno";
$resultUpdate = mysqli_query($conn, $sqlUpdate);

if ($resultUpdate) {
    echo "<p>Aluno '$nomeNovo' atualizado com sucesso!</p>";
    echo '<a href="index1.php">Voltar à Consulta</a>';
} else {
    echo "<p>Erro ao atualizar aluno: " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);

?>
