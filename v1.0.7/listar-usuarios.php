<h1 class="path" style="text-align: center;">Listar Doadores</h1>
<br>

<div class="search-container" style="display: flex; justify-content: center;">
    <input type="text" id="searchInput" placeholder="Buscar por nome" class="form-control" onkeyup="filterTable()" style="width: 300px;">
    <button onclick="clearSearch()" class="btnlimp">Limpar</button>
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('dataTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td')[1]; // Coluna do Nome
        if (td) {
            const txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
        }
    }
}

function clearSearch() {
    document.getElementById('searchInput').value = ''; // Limpa o campo de pesquisa
    filterTable(); // Chama a função de filtragem para mostrar todas as linhas
}
</script>

<br>
<div style="display: flex; justify-content: center;">
    <table class='table' id="dataTable" style="width: 80%; max-width: 800px;">
        <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">Nome</th>
                <th style="text-align: center;">Sexo</th> <!-- Coluna para Sexo -->
                <th style="text-align: center; min-width: 150px;">CPF</th>
                <th style="text-align: center; min-width: 150px;">Telefone</th>
                <th style="text-align: center;">Email</th>
                <th style="max-width: 200px; white-space: normal; text-align: center;">Endereço</th>
                <th style="text-align: center;">Número</th>
                <th style="text-align: center;">CEP</th>
                <th style="text-align: center;">Complemento</th>
                <th style="text-align: center;">Bairro</th>
                <th style="text-align: center;">Nascimento</th>
                <th style="white-space: nowrap; text-align: center;">Tipo Sanguíneo</th>
                <th style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta SQL para buscar todos os registros da tabela cadastrobs
            $sql = "SELECT * FROM cadastrobs";
            $res = $conn->query($sql); // Executa a consulta
            $qtd = $res->num_rows; // Obtém a quantidade de registros retornados

            if ($qtd > 0) { // Se houver registros
                // Loop para exibir cada registro
                while ($row = $res->fetch_object()) {
                    // Converte o valor de sexo de 'Masculino' e 'Feminino' para 'M' e 'F'
                    $sexo = ($row->sexo == 'Masculino') ? 'M' : ($row->sexo == 'Feminino' ? 'F' : $row->sexo);
                    echo "<tr>";
                    echo "<td style='text-align: center;'>" . $row->id . "</td>";
                    echo "<td style='text-align: center;'>" . htmlspecialchars($row->nome) . "</td>";
                    echo "<td style='text-align: center;'>" . $sexo . "</td>"; // Exibe "M" ou "F" para o Sexo
                    echo "<td style='text-align: center;'>" . htmlspecialchars($row->cpf) . "</td>";
                    echo "<td style='text-align: center;'>" . htmlspecialchars($row->telefone) . "</td>";
                    echo "<td style='text-align: center;'>" . htmlspecialchars($row->email) . "</td>";
                    echo "<td class='endereco' style='text-align: center; max-width: 200px; overflow-wrap: break-word; line-height: 1.2; height: 40px; overflow: hidden;'>" . htmlspecialchars($row->endereco) . "</td>";
                    echo "<td style='text-align: center;'>" . htmlspecialchars($row->numero) . "</td>";
                    echo "<td style='text-align: center; min-width: 120px;'>" . htmlspecialchars($row->cep) . "</td>";
                    echo "<td style='text-align: center;'>" . htmlspecialchars($row->complemento) . "</td>";
                    echo "<td style='text-align: center;'>" . htmlspecialchars($row->bairro) . "</td>";
                    echo "<td style='text-align: center;'>" . (new DateTime($row->nasc))->format('d/m/Y') . "</td>"; // Formato de data brasileiro
                    echo "<td style='text-align: center; white-space: nowrap;'>" . htmlspecialchars($row->ts) . "</td>"; // Exibe o Tipo Sanguíneo
                    echo "<td style='text-align: center;'>
                        <div style='display: flex; justify-content: center; gap: 5px;'> <!-- Container flexível -->
                            <button onclick=\"location.href='?page=editar&id={$row->id}';\" type='button' class='btn btn-success'>Editar</button>
                            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')) location.href='?page=salvar&acao=excluir&id={$row->id}';\" type='button' class='btn btn-danger'>Excluir</button>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                // Se não houver dados
                echo "<tr><td colspan='13' class='text-center alert alert-danger'>Não há cadastros disponíveis!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
