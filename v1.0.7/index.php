<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>SCBST</title>
</head>
<body>
    <!-- Navegação -->
    <header>
    <nav>
        <a class="navbar-brand" href="?page=dashboard">
            <img class="logo" src="logo.png" alt="Logo">
        </a>

        <!-- Container da navbar (links) -->
        <div class="navbar-nav">
            <a class="nav-link" href="?page=info">
                Informações <ion-icon class="icones" name="information-circle-outline"></ion-icon>
            </a>

            <!-- Menu Doador com submenu -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Doador <ion-icon class="icones" name="list-circle-outline"></ion-icon>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="?page=novo">Cadastrar Doadores</a></li>
                    <li><a class="dropdown-item" href="?page=listar">Listar Doadores</a></li>
                    <li><a class="dropdown-item" href="?page=listar2">Informações Principais</a></li>
                </ul>
            </div>

            <a class="nav-link" href="?page=help">
                Ajuda <ion-icon class="icones" name="help-circle-outline"></ion-icon>
            </a>
        </div>
    </nav>
</header>


    <!-- Espaçamento -->
    <br><br>

    <!-- Conteúdo -->
    <div class="container">
        <div class="content">
            <?php
                include("config.php"); // Inclui o arquivo de configuração para conexão ao banco de dados
                $page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 'home'; // Verifica se a página foi solicitada, padrão é 'home'

                // Switch para incluir a página correspondente
                switch($page) {
                    case "novo":
                        include("novo-usuario.php");
                        break;
                    case "listar":
                        include("listar-usuarios.php");
                        break;
                    case "salvar":
                        include("salvar-usuario.php");
                        break;
                    case "editar":
                        include("editar-usuario.php");
                        break;
                    case "help":
                        include("help.php");
                        break;
                    case "info":
                        include("info.php");
                        break;
                    case "listar2":
                        include("listar2.php");
                        break;
                    case "mapa":
                        include("mapa.php");
                        break;
                    default:
                        include("dashboard.php");
                }
            ?>
        </div>
    </div>

    <!-- Rodapé -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2024 Banco de Sangue de Taquaritinga. Todos os direitos reservados.</p>
                <!---------------Mapa de navegação----------->
                <div class="footer-address">
                <p><strong>Navegação:</strong></p>
                <a href="?page=mapa" class="footer-link" target="_blank">Mapa de Navegação</a>
                 <!---------------Fim do Mapa de navegação----------->
                </div>
                <!-- Seção Endereço com ícone e link -->
                <div class="footer-address">
                    <p><strong>Endereço:</strong></p>
                    <p>
                        <i class="fas fa-map-marker-alt"></i> 
                        <a href="https://www.google.com.br/maps/place/R.+dos+Can%C3%A1rios,+341+-+Taquaritinga,+SP,+15900-000/@-21.3976807,-48.4936795,17z/data=!3m1!4b1!4m6!3m5!1s0x94b93947a011ca25:0x96c783fe4250946d!8m2!3d-21.3976857!4d-48.4911046!16s%2Fg%2F11w7q64gb7?entry=ttu&g_ep=EgoyMDI0MTExMy4xIKXMDSoASAFQAw%3D%3D" 
                        class="footer-link" target="_blank" rel="noopener noreferrer">
                        Rua dos Canários, 341<br>
                        
                        </a>
                    </p>
                </div>

                <!-- Seção Contato -->
                <div class="footer-contact">
                    <p><strong>Contato:</strong></p>
                    <p>
                        <i class="fas fa-envelope"></i> 
                        <a href="mailto:contato@bancodesanguetaq.com" class="footer-link">contato@bancodesanguetaq.com</a>
                    </p>
                    <p>
                        <i class="fas fa-phone"></i> (16) 1234-5678
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Seleciona todos os links de dropdown
            var dropdowns = document.querySelectorAll('.nav-item.dropdown');

            // Adiciona um evento de clique para cada dropdown
            dropdowns.forEach(function(dropdown) {
                var link = dropdown.querySelector('.nav-link');
                link.addEventListener('click', function(event) {
                    // Previne o comportamento padrão do link
                    event.preventDefault();

                    // Alterna a classe 'show' que controla a visibilidade
                    dropdown.classList.toggle('show');
                });
            });
        });

    </script>
</body>
</html>
