<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_check_if_user_colums_is_correct(): void
    {
        $user = new User;

        $expected = [
            'name',
            'password',
            'email'
        ];

        //  Vai comparar o array expected com o array que retorna do filable no model
        //  e criar um novo array dos campo que não tiverem 
        // em um ou em outro
        $arrayCompared = array_diff($expected, $user->getFillable());

        // Se for igual a 0 o resultado retorna true se não mostra a contagem da diferença
        $this->assertEquals(0, count($arrayCompared));
    }
}
