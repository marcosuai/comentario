<?php
// Conexão com o banco de dados (substitua com suas credenciais)
$hostname = "localhost";
$username = "root";
$password = ""; // Substitua por uma senha segura!
$database = "coment";

// Estabelecer conexão com o banco de dados
$conn = mysqli_connect($hostname, $username, $password, $database);

// Verificar se a conexão foi bem-sucedida
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Função para sanitizar a entrada do usuário (evitar injeção de SQL)
function sanitize($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Receber o nome do aluno da URL e sanitizá-lo
$nomeConsulta = sanitize($_GET["nome"]);

// Preparar a consulta SQL usando prepared statements para segurança
$stmt = mysqli_prepare($conn, "SELECT nome, comentario FROM alunos WHERE nome LIKE ?");
mysqli_stmt_bind_param($stmt, "s", "%" . $nomeConsulta . "%");

// Executar a consulta e verificar se há resultados
if (mysqli_stmt_execute($stmt)) {
    $result = mysqli_stmt_get_result($stmt);

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
} else {
    echo "<p>Erro na consulta: " . mysqli_error($conn) . "</p>";
}

// Fechar recursos e conexão com o banco de dados
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
