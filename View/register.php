<?php
// BUSCANDO E CARREGANDO O ARQUIVO AUTOLOAD
require_once '../vendor/autoload.php';

// IMPORTANDO O USERCONTROLLER
use Controller\UserController;

$userController = new UserController();

$registerUserMessage = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['user_fullname'], $_POST['email'], $_POST['password'])) {
        $user_fullname = $_POST['user_fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // USO DO CONTROLLER PARA VERIFICAÇÃO DE E-MAIL E CADASTRO DE USUÁRIO
        
        // JÁ EXISTE UM E-MAIL CADASTRADO?
        if($userController->checkUserByEmail($email)) {
            $registerUserMessage = "Já existe um usuário cadastrado com esse endereço de e-mail.";
        } else {
            // SE O E-MAIL JÁ EXISTE, CRIE O USUÁRIO
            if($userController->createUser($user_fullname, $email, $password)) {
                // REDIRECIONAR PARA UMA OUTRA PÁGINA, QUANDO O USUÁRIO FOR CADASTRADO
                header('Location: ../index.php');
                exit();
            } else {
                $registerUserMessage = 'Erro ao registrar informações.';
            }
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
    <link rel="stylesheet" href="../templates/assets/css/register.css">
    <title>FitCalc | Criar Conta</title>
</head>

<body class="bgLinearGradient">
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

    <main class="d-flex justify-content-center align-items-center flex-column h-100">
        <form method="POST" class="bg-light p-5 rounded-4 w-25">
            <div class="form__create-account d-flex flex-column justify-content-center align-items-center">
                <figure class="rounded-circle d-flex justify-content-center align-items-center bgLinearGradient">
                    <i class="bi bi-calculator-fill fs-5 text-white"></i>
                </figure>

                <h2 class="fw-bold">Criar Conta</h2>

                <p>Preencha seus dados</p>

            </div>

            <div class="mb-3 position-relative">
                <label for="userName" class="form-label">Nome completo</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="user_fullname" class="form-control border-start-0 inputPlaceholder p-2"
                        id="userName" placeholder="Seu nome completo" aria-describedby="userName">
                </div>
            </div>

            <div class="mb-3 position-relative">
                <label for="userEmailAddress" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" name="email" class="form-control border-start-0 inputPlaceholder p-2"
                        id="userEmailAddress" placeholder="seu@email.com" aria-describedby="emailAddress">
                </div>
            </div>

            <div class="mb-3 position-relative">
                <label for="userPassword" class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control border-start-0 inputPlaceholder p-2"
                        id="userPassword" placeholder="Sua senha">
                </div>
            </div>

            <div class="mb-3 position-relative">
                <label for="userConfirmPassword" class="form-label">Confirmar senha</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="userConfirmPassword"
                        class="form-control border-start-0 inputPlaceholder p-2" id="userConfirmPassword"
                        placeholder="Confirme sua senha">
                </div>
            </div>

            <button type="submit"
                class="border-0 text-white rounded-3 w-100 mb-4 p-2 bgLinearGradient">Cadastrar</button>

            <p class="text-center">Já tem uma conta? <a href="../index.php">Faça login aqui</a></p>
            </div>
        </form>
        <p> <?php echo $registerUserMessage; ?> </p>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>