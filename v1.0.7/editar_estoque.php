<?php
include('config.php'); // Inclui a conexão com o banco de dados

// Inicia a sessão para utilizar mensagens flash
session_start();

// Verifica se foi enviado um formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sucesso = true; // Variável para controlar o sucesso da operação

    // Atualiza a quantidade no banco de dados
    foreach ($_POST as $tipo => $quantidade) {
        // Previne injeção SQL
        $tipo = mysqli_real_escape_string($conn, $tipo);
        $quantidade = mysqli_real_escape_string($conn, $quantidade);

        // Verifica se a quantidade é um número válido
        if (is_numeric($quantidade) && $quantidade >= 0) {
            $sql = "UPDATE estoque_sangue SET quantidade = '$quantidade' WHERE tipo_sangue = '$tipo'";
            if ($conn->query($sql) !== TRUE) {
                // Se ocorrer um erro, define sucesso como falso
                $sucesso = false;
            }
        } else {
            $sucesso = false; // Caso a quantidade seja inválida
        }
    }

    // Define a mensagem de sucesso ou erro
    if ($sucesso) {
        $_SESSION['mensagem'] = 'Estoque de sangue editado com sucesso!';
        $_SESSION['mensagem_tipo'] = 'success'; // Para aplicar estilos de sucesso
    } else {
        $_SESSION['mensagem'] = 'Houve um erro ao editar o estoque.';
        $_SESSION['mensagem_tipo'] = 'error'; // Para aplicar estilos de erro
    }

    // Redireciona para o dashboard
    header("Location: ?page=dashboard");
    exit(); // Evita que o código continue executando após o redirecionamento
}

// Consulta para buscar os tipos sanguíneos e suas respectivas quantidades
$sql = "SELECT tipo_sangue, quantidade FROM estoque_sangue";
$result = $conn->query($sql);

$estoqueSangue = [];
$cadastrosExistem = $result->num_rows > 0; // Verifica se há registros

if ($cadastrosExistem) {
    // Preenche o array com os tipos sanguíneos e quantidades
    while ($row = $result->fetch_assoc()) {
        $estoqueSangue[$row['tipo_sangue']] = $row['quantidade'];
    }
} else {
    echo "Nenhum cadastro encontrado.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estoque de Sangue</title>
    <style>
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Editar Estoque de Sangue</h1>

    <!-- Exibe a mensagem de sucesso ou erro -->
    <?php if (isset($_SESSION['mensagem'])): ?>
        <p class="<?php echo $_SESSION['mensagem_tipo']; ?>">
            <?php echo $_SESSION['mensagem']; ?>
        </p>
        <?php 
        // Limpa a mensagem após exibição
        unset($_SESSION['mensagem']);
        unset($_SESSION['mensagem_tipo']);
        ?>
    <?php endif; ?>

    <?php if ($cadastrosExistem): ?>
        <form method="POST" action="editar_estoque.php">
            <?php foreach ($estoqueSangue as $tipo => $quantidade): ?>
                <div>
                    <label for="tipo_<?php echo $tipo; ?>">Tipo <?php echo $tipo; ?>:</label>
                    <input type="number" id="tipo_<?php echo $tipo; ?>" name="<?php echo $tipo; ?>" value="<?php echo $quantidade; ?>" min="0" required>
                </div>
            <?php endforeach; ?>

            <button type="submit">Atualizar Estoque</button>
        </form>
    <?php else: ?>
        <p>Nenhum estoque encontrado para edição.</p>
    <?php endif; ?>

</body>
</html>
