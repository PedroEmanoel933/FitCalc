<?php

use Controller\ImcController;
use PHPUnit\Framework\TestCase;
use Model\Imcs;

class ImcTest extends TestCase{

    //Irá fazer referência a classe ImcController 
    //Responsável por realizar a comunicação com o banco de dados e a lógica da aplicação
    private $imcController;

    // ATRIBUTO FAKE PARA O BANCO DE DADOS
    private $mockImcModel;

    protected function setUp(): void{
        
        // CRIO O BANCO DE DADOS FAKE ACESSANDO O ATRIBUTO (mockImcModel) QUE VAI RECENER A FUNÇÃO createMock() 
        $this ->mockImcModel = $this -> createMock(Imcs::class);
        
        // PASSO ESSE FAKE PARA O CONTROLLER, ASSIM QUE ME PERMITE UTILIZAR
        // AS MESMAS FUNCIONALIDADES, SÓ QUE SEM MODIFICAR O BANCO DE DADOS REAL
        $this->imcController = new ImcController($this -> mockImcModel);
    }

//Verificar cálculo do IMC

#[\PHPUnit\Framework\Attributes\Test]
public function it_should_be_able_to_calculate_bmi (){
    $weight = 68;
    $height = 1.68;
    $imcResult = $this->imcController->calculateImc($weight, $height);
    
    $this->assertArrayHasKey('imc', $imcResult);
    $this->assertArrayHasKey('BMIrange', $imcResult);

    $this->assertEquals(24.09, $imcResult['imc']);
    $this->assertEquals('Peso normal', $imcResult['BMIrange']);

}


//Verificar a validação de campos inválidos
#[PHPUnit\Framework\Attributes\Test]
public function it_shouldnt_be_able_to_calculate_bmi_with_invalid_inputs (){
$imcResult = $this->imcController->calculateImc(-68, 1.68);
$this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);

$imcResult = $this->imcController->calculateImc(68, -1.68);
$this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);

$imcResult = $this->imcController->calculateImc(-68, -1.68);
$this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
}


//Verificar a validação de campos nulos ou vazios
#[PHPUnit\Framework\Attributes\Test]
public function it_shouldnt_be_able_to_calculate_bmi_with_null_empty_inputs (){
    $imcResult = $this->imcController->calculateImc(null, 0);
    $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

    $imcResult = $this->imcController->calculateImc(0, null);
    $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

    $imcResult = $this->imcController->calculateImc(null, null);
    $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

}


//Obter o IMC e Classificar
#[PHPUnit\Framework\Attributes\Test]
public function it_should_be_able_to_get_an_bmi_range(){
    $weight = 68;
    $height = 1.68;
    $imcResult = $this->imcController->calculateImc($weight, $height);
    $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
    $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC', $imcResult['BMIrange']);
}

//Obter o IMC e Classificar (Baixo Peso)
#[PHPUnit\Framework\Attributes\Test]
public function it_returns_underweight_for_bmi(){
    $weight = 50;
    $height = 1.75;

    $imcResult = $this->imcController->calculateImc($weight, $height);
    $this->assertArrayHasKey('imc', $imcResult);
    $this->assertArrayHasKey('BMIrange', $imcResult);

    $this->assertEquals(16.33, $imcResult['imc']);
    $this->assertEquals('Baixo peso', $imcResult['BMIrange']);
}

//Obter o IMC e Classificar (Sobrepeso)
#[PHPUnit\Framework\Attributes\Test]
public function it_returns_overweight_for_bmi(){
    $weight = 85;
    $height = 1.70;

    $imcResult = $this->imcController->calculateImc($weight, $height);
    $this->assertArrayHasKey('imc', $imcResult);
    $this->assertArrayHasKey('BMIrange', $imcResult);

    $this->assertEquals(29.41, $imcResult['imc']);
    $this->assertEquals('Sobrepeso', $imcResult['BMIrange']);
}

//Obter o IMC e Classificar (Obesidade grau I)
#[PHPUnit\Framework\Attributes\Test]
public function it_returns_obesity_I_for_bmi(){
    $weight = 95;
    $height = 1.70;

    $imcResult = $this->imcController->calculateImc($weight, $height);
    $this->assertArrayHasKey('imc', $imcResult);
    $this->assertArrayHasKey('BMIrange', $imcResult);

    $this->assertEquals(32.87, $imcResult['imc']);
    $this->assertEquals('Obesidade grau I', $imcResult['BMIrange']);
}

//Obter o IMC e Classificar (Obesidade grau II)
#[PHPUnit\Framework\Attributes\Test]
public function it_returns_obesity_II_for_bmi(){
    $weight = 110;
    $height = 1.75;

    $imcResult = $this->imcController->calculateImc($weight, $height);
    $this->assertArrayHasKey('imc', $imcResult);
    $this->assertArrayHasKey('BMIrange', $imcResult);

    $this->assertEquals(35.92, $imcResult['imc']);
    $this->assertEquals('Obesidade grau II', $imcResult['BMIrange']);
}

//Obter o IMC e Classificar (Obesidade grau III)
#[PHPUnit\Framework\Attributes\Test]
public function it_returns_obesity_III_for_bmi(){
    $weight = 130;
    $height = 1.70;

    $imcResult = $this->imcController->calculateImc($weight, $height);
    $this->assertArrayHasKey('imc', $imcResult);
    $this->assertArrayHasKey('BMIrange', $imcResult);

    $this->assertEquals(44.98, $imcResult['imc']);
    $this->assertEquals('Obesidade grau III', $imcResult['BMIrange']);
}

// Salvar o IMC
#[PHPUnit\Framework\Attributes\Test]
public function it_should_be_able_to_save_bmi(){
    $imcResult = $this -> imcController -> calculateImc(68, 1.68);

    $this -> assertStringNotContainsString("Por favor, informe peso e altura para obter o seu IMC.", $imcResult["BMIrange"]);

    $this->mockImcModel->expects($this->once())->method('createImc')->with($this->equalTo(68), $this->equalTo(1.68))->willReturn(true);    

    $result = $this-> imcController-> saveIMC(68, 1.68, $imcResult['imc']);

    $this -> assertTrue($result);
}

}
?>


