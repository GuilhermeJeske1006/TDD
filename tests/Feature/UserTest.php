<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{

      use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_check_if_usuarios_api_is_correct(): void
    {
        User::factory(3)->create();

        $response = $this->getJson('/api/usuarios');

        $response->assertStatus(200);

        // Verficar a quantidade retornada do json
        $response->assertJsonCount(3);

        //  verificar se os tipos dos campos são esses
        $response->assertJson(function (AssertableJson $json) {
            $json->whereAllType([
                '0.name' => 'string',
                '0.email' => 'string',
                '0.password' => 'string'
            ]);

            // veifica se a posicao 0 possui os seguintes campos
            $json->hasAll(['0.id', '0.name', '0.password']);
            
        });
     }

    public function test_post_api_user(): void
    {
        $userData = [
            'name' => 'guilherme',
            'email' => 'contato1@teste.com',
            'password' => 'password',
        ];
        // User::factory()->create($userData);

        // Faça a solicitação POST para criar um usuário
        $response = $this->postJson('/api/usuarios', $userData);
 
        $response->assertStatus(201);
           
    }

    public function test_update_user_api(): void
    {
        // Crie um usuário para testar
        $user = User::factory()->create();

        // Dados para atualização
        $updatedData = [
            'name' => 'guilherme',
            'email' => 'contato@teste.com',
            'password' => 'password',
        ];

        // Faça a solicitação PUT para atualizar o usuário
        $response = $this->putJson('/api/usuarios/' . $user->id, $updatedData);

        // Verifique o código de status
        $response->assertStatus(200);

        // Verifique se os campos do usuário foram atualizados no banco de dados
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
            // Adicione outros campos, se aplicável
        ]);
    }

    public function test_delete_api_user(): void
    {
       // Crie um usuário para testar
       $user = User::factory()->create();

       // Faça a solicitação DELETE para excluir o usuário
       $response = $this->deleteJson('/api/usuarios/' . $user->id);

       // Verifique o código de status
       $response->assertStatus(200);

       // Verifique se o usuário foi excluído do banco de dados
        // $this->assertDeleted('users', ['id' => $user->id]);

       // Verifique se o usuário não existe mais no banco de dados
       $this->assertDatabaseMissing('users', ['id' => $user->id]);
           
    }
}
