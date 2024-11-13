<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>SCBST</title>
</head>
<body>
<nav>
    <a class="navbar-brand" href="?page=dashboard">
        <img class="logo" src="logo.png" alt="Logo">
    </a>
    <div class="navbar-nav">
        <a class="nav-link" href="?page=info">Informações <ion-icon class="icones" name="information-circle-outline"></ion-icon></a>
        
        <!-- Menu Doador com submenu -->
         
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Doador <ion-icon class="icones" name="list-circle-outline"></ion-icon>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="?page=novo">Cadastrar Doadores</a></li>
                <li><a class="dropdown-item" href="?page=listar">Listar Doadores</a></li>
                <li><a class="dropdown-item" href="?page=listar2">Informações Principais</a><li>
            </ul>
        </div>

        <a class="nav-link" href="?page=help">Ajuda<ion-icon class="icones" name="help-circle-outline"></ion-icon></a>
    </div>
</nav>


<br><br>

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
            default:
                include("dashboard.php");
                
        }
        ?>
    </div>
</div>

<footer>
    <div class="container">
        <p>&copy; 2024 Banco de Sangue de Taquaritinga. Todos os direitos reservados.</p>
        <p>Contato: <a href="mailto:contato@bancodesanguetaq.com">contato@bancodesanguetaq.com</a></p>
        <p>Telefone: (16) 1234-5678</p>
    </div>
</body>
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


</html>
