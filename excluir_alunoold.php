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

// Receber o ID do aluno da URL
$idAluno = $_GET["id"];

// Consulta para buscar o nome do aluno a ser excluído
$sql = "SELECT nome FROM alunos WHERE id = $idAluno";
$result = mysqli_query($conn, $sql);

// Verificar se o aluno foi encontrado
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nomeAluno = $row["nome"];

    // Confirmação de exclusão
    echo '<h2>Confirmar Exclusão</h2>';
    echo "<p>Tem certeza que deseja excluir o aluno '$nomeAluno'?</p>";
    echo '<a href="excluir_aluno.php?id=' . $idAluno . '&confirmar=1">Sim</a>'; // Link para confirmar
    echo ' | ';
    echo '<a href="consulta_alunos.php">Cancelar</a>'; // Link para voltar à consulta
} else {
    echo "<p>Aluno não encontrado com o ID '$idAluno'.</p>";
}

// Excluir aluno se confirmado
if (isset($_GET["confirmar"]) && $_GET["confirmar"] == 1) {
    $sqlDelete = "DELETE FROM alunos WHERE id = $idAluno";
    $resultDelete = mysqli_query($conn, $sqlDelete);

    if ($resultDelete) {
        echo "<p>Aluno '$nomeAluno' excluído com sucesso!</p>";
        echo '<a href="consulta_alunos.php">Voltar à Consulta</a>';
    } else {
        echo "<p>Erro ao excluir aluno: " . mysqli_error($conn) . "</p>";
    }
}

mysqli_close($conn);

?>
