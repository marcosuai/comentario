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
    $sql = "SELECT id, nome, comentario FROM alunos WHERE nome LIKE '%$nomeConsulta%'";
    $result = mysqli_query($conn, $sql);

    // Verificar se há resultados
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Resultados da Consulta para '$nomeConsulta':</h2>";
        echo '<table class="data-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Nome</th>';
        echo '<th>Comentário</th>';
        echo '<th>Ações</th>'; // Nova coluna para botões
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_row($result)) {
            $idAluno = $row[0];
            $nome = $row[1];
            $comentario = nl2br($row[2]);

            echo '<tr>';
            echo '<td>' . $nome . '</td>';
            echo '<td>' . $comentario . '</td>';
            echo '<td>';
            echo '<a href="editar_aluno.php?id=' . $idAluno . '">Editar</a>'; // Link para editar
            echo ' | '; // Separador
            echo '<a href="excluir_aluno.php?id=' . $idAluno . '">Excluir</a>'; // Link para excluir
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo "<p>Nenhum aluno encontrado com o nome '$nomeConsulta'.</p>";
        echo '<a href="index1.php">Voltar à Consulta</a>';
    }

    mysqli_close($conn);
    ?>
</body>
</html>
