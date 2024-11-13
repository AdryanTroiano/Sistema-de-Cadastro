<?php
include('config.php'); // Conexão com o banco de dados

// Consulta para buscar as informações dos doadores, incluindo nome, CPF, tipo sanguíneo, sexo e data da doação
$sql = "SELECT nome, cpf, ts, sexo, datedonation FROM cadastrobs";
$result = $conn->query($sql);

$doadores = [];
$cadastrosExistem = $result->num_rows > 0; // Verifica se há cadastros

if ($cadastrosExistem) {
    // Preenche os dados dos doadores
    while ($row = $result->fetch_assoc()) {
        // Adiciona doador
        $doadores[] = [
            'nome' => $row['nome'],
            'cpf' => $row['cpf'],
            'sexo' => $row['sexo'],  
            'ts' => $row['ts'],
            'datedonation' => $row['datedonation']
        ];
    }
}
?>

<!-- Exibição da tabela de doadores -->
<div class="donor-info">
    <h1 class="path">Informações Principais dos Doadores</h3><br>

    <!-- Verifica se há doadores para mostrar -->
    <?php if (!$cadastrosExistem): ?>
        <p style="color: red;">Nenhum cadastro encontrado.</p>
    <?php else: ?>

        <!-- Tabela com as informações dos doadores -->
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Sexo</th>  <!-- Nova coluna Sexo -->
                    <th>Tipo Sanguíneo</th>
                    <th>Data da Doação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doadores as $doador): 
                    // Converte a data para o formato brasileiro
                    $formattedDate = date('d/m/Y', strtotime($doador['datedonation'])); 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($doador['nome']); ?></td>
                        <td><?php echo htmlspecialchars($doador['cpf']); ?></td>
                        <td><?php echo htmlspecialchars($doador['sexo']); ?></td>  <!-- Exibe o sexo -->
                        <td><?php echo htmlspecialchars($doador['ts']); ?></td>
                        <td><?php echo $formattedDate; ?></td> <!-- Exibe a data formatada -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
</div>

<style>
.donor-info {
    margin-top: 30px;
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}
</style>
