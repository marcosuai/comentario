<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Alunos</title>
    <link rel="stylesheet" href="consulta.css">

</head>
<body>
    <h1>Consulta de Alunos</h1>

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

// Receber o nome do aluno da URL
$nomeConsulta = $_GET["nome"];

// Consulta para buscar dados do aluno específico
$sql = "SELECT nome, comentario FROM alunos WHERE nome LIKE '%$nomeConsulta%'";
$result = mysqli_query($conn, $sql);

// Verificar se há resultados
if (mysqli_num_rows($result) > 0) {
    echo "<h2>Resultados da Consulta para '$nomeConsulta':</h2>";
    echo '<table class="data-table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nome</th>';
    echo '<th>Comentário</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['nome'] . '</td>';
        echo '<td>' . nl2br($row['comentario']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo "<p>Nenhum aluno encontrado com o nome '$nomeConsulta'.</p>";
}

mysqli_close($conn);

 ?>

</body>
</html>
