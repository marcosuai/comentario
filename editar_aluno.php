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

// Consulta para buscar dados do aluno específico
$sql = "SELECT id, nome, comentario FROM alunos WHERE id = $idAluno";
$result = mysqli_query($conn, $sql);

// Verificar se o aluno foi encontrado
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $nomeAtual = $row["nome"];
    $comentarioAtual = $row["comentario"];

    // Cabeçalho HTML e inclusão do arquivo CSS
    echo '<!DOCTYPE html>';
    echo '<html lang="pt-BR">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Editar Aluno</title>';
    echo '<link rel="stylesheet" href="estilo.css">'; // Atualize o caminho do arquivo CSS
    echo '</head>';
    echo '<body>';
    echo '<div class="container">';
    echo '<div>';
    // Formulário para editar dados do aluno
    echo '<h2>Editar Aluno</h2>';
    echo '<form action="atualizar_aluno.php" method="post">';
    echo '<input type="hidden" name="id" value="' . $idAluno . '">'; // Campo oculto para armazenar o ID
    echo '<label for="nome">Nome:</label>';
    echo '<input type="text" id="nome" name="nome" value="' . $nomeAtual . '" required>';
    echo '<br>';
    echo '<label for="comentario">Comentário:</label>';
    echo '<textarea id="comentario" name="comentario" rows="5" required>' . $comentarioAtual . '</textarea>';
    echo '<br>';
    echo '<button type="submit" class="botao-globo">Salvar</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
} else {
    echo "<p>Aluno não encontrado com o ID '$idAluno'.</p>";
}

mysqli_close($conn);

?>
