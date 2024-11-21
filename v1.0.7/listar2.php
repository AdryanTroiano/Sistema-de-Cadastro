<?php
include('config.php'); // Conexão com o banco de dados

// Consulta para buscar as informações dos doadores
$sql = "SELECT nome, cpf, ts, sexo, datedonation FROM cadastrobs";
$result = $conn->query($sql);

$doadores = [];
$cadastrosExistem = $result->num_rows > 0;

if ($cadastrosExistem) {
    while ($row = $result->fetch_assoc()) {
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

<div class="donor-info">
    <h1 class="path">Informações Principais dos Doadores</h1><br>

    <!-- Barra de Pesquisa -->
    <div class="search-container">
        <input 
            type="text" 
            id="searchInput" 
            onkeyup="filterTable()" 
            placeholder="Pesquise por nome." 
        >
        <button onclick="clearSearch()">Limpar</button>
    </div>

    <?php if (!$cadastrosExistem): ?>
        <p style="color: red;">Nenhum cadastro encontrado.</p>
    <?php else: ?>
        <table id="dataTable">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Sexo</th>
                    <th>Tipo Sanguíneo</th>
                    <th>Data da Doação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doadores as $doador): 
                    $formattedDate = date('d/m/Y', strtotime($doador['datedonation'])); 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($doador['nome']); ?></td>
                        <td><?php echo htmlspecialchars($doador['cpf']); ?></td>
                        <td><?php echo htmlspecialchars($doador['sexo']); ?></td>
                        <td><?php echo htmlspecialchars($doador['ts']); ?></td>
                        <td><?php echo $formattedDate; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('dataTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;

        // Verifica todas as células da linha
        for (let j = 0; j < cells.length; j++) {
            const txtValue = cells[j].textContent || cells[j].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}

function clearSearch() {
    document.getElementById('searchInput').value = ''; // Limpa o campo de pesquisa
    filterTable(); // Atualiza a tabela
}
</script>

<style>
.donor-info {
    margin-top: 30px;
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 8px;
}

/* Alinhamento do campo de busca e botão */
.search-container {
    display: flex;
    align-items: center;
    gap: 10px; /* Espaçamento entre o input e o botão */
    margin-bottom: 20px;
}

input#searchInput {
    width: 20%; /* Reduz o tamanho do input para 50% */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

button {
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    margin-bottom: 16px;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 14px;
}

button:hover {
    background-color: #0056b3;
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
