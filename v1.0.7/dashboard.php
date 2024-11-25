<?php
include('config.php'); // Inclui a conexão com o banco de dados

// Consulta para buscar os tipos sanguíneos e suas respectivas quantidades
$sql = "SELECT tipo_sangue, quantidade FROM estoque_sangue";
$result = $conn->query($sql);

$estoqueSangue = [];
$cadastrosExistem = $result->num_rows > 0; // Verifica se há registros na tabela

if ($cadastrosExistem) {
    // Preenche o array com os tipos sanguíneos e quantidades
    while ($row = $result->fetch_assoc()) {
        $estoqueSangue[$row['tipo_sangue']] = $row['quantidade'];
    }
}
?>

<!-- Novo painel de dashboard -->
<div class="dashboard">
    <h1 class="path3">DASHBOARD</h1>
    <h2 id="dashboardh2">Estoque de Sangue</h2>

    <!-- Mensagem para ausência de cadastros -->
    <?php if (!$cadastrosExistem): ?>
        <div id="no-data-message" style="color: red;">Nenhum cadastro encontrado.</div>
    <?php else: ?>
        <!-- Canvas para o gráfico com aviso de erro -->
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 20px;">
            <canvas id="bloodStockChart" width="300" height="300" style="max-width: 100%; height: auto;"></canvas>
            <p id="error-message" style="color: red; display: none;">Erro ao carregar o gráfico. Verifique o console.</p>
        </div>

        <div class="blood-stock">
            <?php
            $tiposSanguineos = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            foreach ($tiposSanguineos as $tipo) {
                $quantidade = isset($estoqueSangue[$tipo]) ? $estoqueSangue[$tipo] : 0;
                $alerta = '';
                $mensagem = '';

                if ($quantidade < 8) {
                    $alerta = 'alert'; // Classe de alerta se o estoque for baixo
                    $mensagem = '<p class="warning">Atenção: Estoque baixo!</p>';
                } else {
                    $alerta = 'regular'; // Classe para estoque regular
                    $mensagem = '<p class="regular">Regular</p>';
                }

                echo "<div class='blood-type $alerta' id='blood-type-$tipo'>";
                echo "<h3>Tipo $tipo</h3>";
                echo "<p>$quantidade bolsas</p>";
                echo $mensagem;
                echo "</div>";
            }
            ?>
        </div>

    <?php endif; ?>
</div>

<style>
.blood-type {
    padding: 10px;
    margin: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.alert {
    background-color: rgba(255, 0, 0, 0.2); /* Fundo vermelho para alerta */
    color: red;
}

.regular {
    background-color: rgba(0, 255, 0, 0.2); /* Fundo verde para estoque regular */
    color: green;
}

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const canvas = document.getElementById('bloodStockChart');
    const errorMessage = document.getElementById('error-message');
    
    if (!canvas) {
        console.error("Elemento canvas não encontrado!");
        errorMessage.style.display = 'block';
        return;
    }

    const ctx = canvas.getContext('2d');
    let bloodStockChart = null;

    function initializeChart() {
        bloodStockChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
                datasets: [{
                    label: 'Bolsas de Sangue',
                    data: [], // Dados inicialmente vazios
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',   // A+
                        'rgba(54, 162, 235, 1)',   // A-
                        'rgba(255, 206, 86, 1)',    // B+
                        'rgba(75, 192, 192, 1)',    // B-
                        'rgba(153, 102, 255, 1)',   // AB+
                        'rgba(255, 159, 64, 1)',    // AB-
                        'rgba(255, 0, 0, 1)',        // O+ 
                        'rgba(0, 255, 0, 1)'         // O- 
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 0, 0, 1)',      
                        'rgba(0, 255, 0, 1)'       
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Permite que a altura do gráfico seja ajustada
                cutout: '40%', // valor para aumentar ou diminuir a parte interna da torta
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    }

    function updateDashboard() {
        // Atualiza os dados diretamente do PHP
        const estoqueSangue = <?php echo json_encode($estoqueSangue); ?>;

        // Verifica se os dados são válidos
        if (Object.keys(estoqueSangue).length === 0) {
            console.error("Nenhum dado recebido ou dados inválidos.");
            errorMessage.style.display = 'block';
            return;
        }

        // Monta o array com as quantidades para o gráfico
        const quantidades = [
            estoqueSangue['A+'] || 0,
            estoqueSangue['A-'] || 0,
            estoqueSangue['B+'] || 0,
            estoqueSangue['B-'] || 0,
            estoqueSangue['AB+'] || 0,
            estoqueSangue['AB-'] || 0,
            estoqueSangue['O+'] || 0,
            estoqueSangue['O-'] || 0
        ];

        console.log("Quantidades para o gráfico:", quantidades);

        // Atualiza o gráfico
        if (bloodStockChart) {
            bloodStockChart.data.datasets[0].data = quantidades;
            bloodStockChart.update();
        } else {
            initializeChart();
            bloodStockChart.data.datasets[0].data = quantidades;
            bloodStockChart.update();
        }
    }

    // Inicializa o dashboard e gráfico imediatamente
    initializeChart();
    updateDashboard();
    setInterval(updateDashboard, 60000); // Atualiza a cada 60 segundos
});
</script>
