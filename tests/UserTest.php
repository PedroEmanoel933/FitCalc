<?php

use PHPUnit\Framework\TestCase;

use Controller\UserController;

use Model\User;

class UserTest extends TestCase{
    private $usercontroller;

    private $mockUserModel;

    public protected function setUp(): void{
            $this -> mockUserModel = $this -> createMock(user::class);
        
            $this -> usercontroller = new UserController($this -> mockUserModel);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_create(){
        $userResult = $this -> usercontroller -> createUser('Ana Luisa Santos', 'ana@example.com', '123456');
        $this -> assertTrue($userResult);
    }

    public function it_should_be_able_to_sign_in (){
        $this -> mockUserModel -> method('getUserByEmail') -> willReturn ([
            "id" => 1,
            "user_fullname" => "Ana Luisa Santos",
            "email" => "ana@example.com",
            "password" => password_hash("123456", PASSWORD_DEFAULT), 
        ]);
    }
}
?>  