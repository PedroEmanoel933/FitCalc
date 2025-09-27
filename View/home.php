<?php
// VERIFICA SE AS INFORMAÇÕES DO USUÁRIO EXISTEM DENTRO DA SESSÃO DO MEU NAVEGADOR
session_start();
require_once '../vendor/autoload.php';
// IMPORTANDO O CONTROLLER
use Controller\ImcController;
use Controller\UserController;

// CRIANDO UM OBJETO PARA REPRESENTAR CADA IMC CRIADO
$imcController = new ImcController();
$userController = new UserController();

$imcResult = null;
$userInfo = null;

// VERIFICANDO SE HOUVE LOGIN
if(!$userController->isLoggedIn()){
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['id'];
$user_fullname = $_SESSION['user_fullname'];
$email = $_SESSION['email'];
// var_dump($_SESSION['id'], $_SESSION['user_fullname'],  $_SESSION['email']);

$userInfo = $userController->getUserData($user_id, $user_fullname, $email);
// var_dump($userInfo);
//var_dump($imcController->calculateImc($weight, $height));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['weight'], $_POST['height'])) {
        $weight = $_POST['weight'];
        $height = $_POST['height'];

        // UTILIZANDO O CONTROLER COMO INTERMEDIÁRIO DA MANIPULAÇÃO E GERENCIAMENTO DE DADOS FRONT/BACK(BANCO DE DADOS)
        $imcResult = $imcController->calculateImc($weight, $height);

        // VERIFICAR SE OS CAMPOS FORAM PREENCHIDOS
        if ($imcResult['BMIrange'] != "O peso e a altura devem conter valores positivos.") {
            $imcController->saveIMC($weight, $height, $imcResult['imc']);
        }
    }
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../templates/assets/css/index.css">
    <title>FitCalc | Calculadora de IMC</title>
</head>

<body>

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>


    <header class="bgLinearGradient">
        <nav class="d-flex justify-content-between flex-md-row flex-column-reverse gap-2">
            <div class="user_info d-flex justify-content-center align-items-center gap-3">
                <figure class="rounded-circle d-flex justify-content-center align-items-center "
                    style="background-color: #fff3; width: 40px; height: 40px; border-radius: 50%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" class="bi bi-person"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                </figure>
                <!-- INFORMAÇÃO DO USUÁRIO -->
                <?php if ($userInfo): ?>
                    <div class="user_info_details d-flex flex-column">
                        <p class="text-white m-0"><?php echo htmlspecialchars($userInfo['user_fullname']) ?></p>
                        <p><?php echo htmlspecialchars($userInfo['email']) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-4">
                <button class="bg-button rounded-3 border-0 d-flex flex-row justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-calculator"
                        viewBox="0 0 16 16">
                        <path
                            d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                        <path
                            d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <a href="home.php">Calculadora</a>
                </button>
            </div>

            <button class="bg-button rounded-3 border-0 d-flex flex-row justify-content-center align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                    class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                    <path fill-rule="evenodd"
                        d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                </svg>
                <a href="../index.php">Sair</a>
            </button>
        </nav>
    </header>

    <main>
        <div class="main__header text-center">
            <h1>Calculadora de IMC</h1>

            <p>Calcule seu Índice de Massa Corporal e monitore a sua saúde</p>
        </div>

        <div class="calc__IMC d-flex flex-md-row gap-4 justify-content-center flex-column align-items-center w-100">
            <div class="calc__data rounded-3 w-100">
                <div class="calc__data__header d-flex gap-2 align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="blue" class="bi bi-calculator"
                        viewBox="0 0 16 16" data-component-line="76">
                        <path
                            d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                        <path
                            d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    <h2>Dados para Cálculo</h2>
                </div>

                <form method="POST" action="home.php">
                    <label for="userWeight">Peso (kg)</label>
                    <div class="input-group mb-3">
                        <i class="input-group-text bi bi-duffle" id="weightIcon"></i>
                        <input type="number" name="weight" class="form-control" placeholder="Ex: 70.5" id="userWeight"
                            aria-label="userWeight" aria-describedby="weightIcon" step="0.01" required>
                    </div>
                    <label for="userHeight">Altura (m)</label>
                    <div class="input-group mb-3">
                        <i class="input-group-text bi bi-rulers" id="heightIcon"></i>
                        <input type="number" name="height" class="form-control" placeholder="Ex: 1.75" id="userHeight"
                            aria-label="userHeight" aria-describedby="heightIcon" step="0.01" required>
                    </div>

                    <button type="submit" class="bgLinearGradient button w-100 border-0 text-light rounded-3">Calcular
                        IMC</button>
                </form>
            </div>

            <div class="result__IMC rounded-3 w-100">
                <h2>Resultado</h2>

                <div class="result">
                    <div class="result__info">
                        <!-- RESULTADO DO IMC -->
                        <?php if ($imcResult): ?>
                            <p>Seu IMC é: <?php echo $imcResult['imc'] ?? ''; ?> </p>
                            <p>Categoria: <?php echo $imcResult['BMIrange']; ?> </p>

                        <?php else: ?>
                            <i class="bi bi-calculator"></i>
                            <p>Preencha os dados ao lado para ver o resultado</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>


</body>

</html>