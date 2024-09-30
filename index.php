<?php // comando phpusado para conectar o script PHP ao servidor de banco de dados SQL
// Verificar se o formulário foi enviado metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Capturar entrada do usuário
  $nomeAluno = $_POST["nome"];//converte valor nome Capturado formulario HTML em variavel php $nomeAluno
  $comentario = $_POST["comentario"];//converte valor COMENTARIO Capturado formulario HTML em variael php $comentario

  // Verifica SE(if) os campos 'nomeAluno' e 'comentario' estão vazios sim frase sera exibida, senão script continua
  if (empty($nomeAluno) || empty($comentario)) {
    echo "<p>Erro: Preencha todos os campos obrigatórios.</p>";//frase se dados estiver vazio
    return;
  }

  // Conexão com o banco de dados 4 informações importantes serão tranformadas em variaveis php
  $hostname = "localhost";//nome do servidor no caso servidor e local
  $username = "root";// usuario administrador do banco de dados
  $password = ""; // senha do usuario root no caso vazia
  $database = "coment"; // Nome do seu banco de dados

  $conn = mysqli_connect($hostname, $username, $password, $database);// atribui o comando da conexão  
  //banco de dadosa variavel $conn
  if (!$conn) {// ! FALSE se(if) não (!) conectar ao banco de dados exiba frase falha, VERDADEIRA continue
    die("Falha na conexão: " . mysqli_connect_error());
  }

  // Inserir dados no banco (prepared statement para segurança)
  $stmt = mysqli_prepare($conn, "INSERT INTO alunos (nome, comentario) VALUES (?, ?)"); //prepara comando sql
  mysqli_stmt_bind_param($stmt, "ss", $nomeAluno, $comentario);// Vincula valores às variáveis na instrução SQL preparada
 // comando abaixo Tenta executar a instrução SQL preparada armazenada em $stmt 
  if (mysqli_stmt_execute($stmt)) { // Se a instrução for executada com sucesso:
    echo "<p>Aluno cadastrado com sucesso!</p>"; // positivo frase exibida
  } else { // senão
    echo "<p>Erro ao cadastrar aluno: " . mysqli_error($conn) . "</p>"; //frase exibida
  }
  mysqli_stmt_close($stmt);// Feche a instrução SQL preparada, evita invasão

  mysqli_close($conn);// Feche a conexão com o banco de dados barrando intrusos-
}

?>

<!DOCTYPE html> 
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coletar e Consultar Dados de Alunos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Cadastro de Alunos</h1>

  <form action="" method="post">
    <label for="nome">Nome do Aluno:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="comentario">Comentário:</label>
    <textarea id="comentario" name="comentario" required></textarea>

    <button type="submit">Cadastrar Aluno</button>
  </form>

  <h2>Consulta de Alunos</h2>

  <form action="consulta_dados01.php" method="get">
    <label for="nomeConsulta">Nome do Aluno:</label>
    <input type="text" id="nomeConsulta" name="nome">

    <button type="submit">Consultar</button>
  </form>

  <?php
  // Verificar se há dados para consulta na URL
  if (isset($_GET["nome"])) {
    $nomeConsulta = $_GET["nome"];

    // Conexão com o banco de dados (mesmas credenciais de antes)
    $conn = mysqli_connect($hostname, $username, $password, $database);

    if (!$conn) {
      die("Falha na conexão: " . mysqli_connect_error());
    }

    // Consulta para buscar dados do aluno específico
    $sql = "SELECT nome, comentario FROM alunos WHERE nome LIKE '%$nomeConsulta%'";
    $result = mysqli_query($conn, $sql);

    // Exibir dados se resultados forem encontrados
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
              echo '<td>' . nl2br($row['comentario']) . '</td>'; // Converte quebra de linhas para melhor visualização
              echo '</tr>';
            }
          
            echo '</tbody>';
            echo '</table>';
          } else {
            echo "<p>Nenhum aluno encontrado com o nome '$nomeConsulta'.</p>";
          }
          
          mysqli_close($conn);
          }
          
          ?>