<?php

namespace Feature\Http\Controllers;

use App\Http\Middleware\CheckZohoToken;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ZohoControllerTest extends TestCase
{
    public function test_it_allows_to_see_deals(): void
    {
        $response = $this->get(route('zoho.deals'));

        $response->assertSuccessful()
            ->assertStatus(200)
            ->assertJsonIsArray()
            ->assertJsonStructure([
                '*' => [
                    'Deal_Name',
                    'Stage',
                    'Account_Name',
                ],
            ]);
    }

    public function test_it_fails_when_access_token_not_found()
    {
        $this->withoutMiddleware(CheckZohoToken::class);

        $response = $this->get(route('zoho.deals'));

        $response->assertStatus(500)
            ->assertJson(['message' => 'Failed to retrieve deals.']);
    }

    public function test_it_fails_with_invalid_access_token()
    {
        $this->withoutMiddleware(CheckZohoToken::class);

        session(['zoho_access_token' => 'invalid_token']);

        $response = $this->get(route('zoho.deals'));

        $response->assertStatus(500)
        ->assertJson(['message' => 'Failed to retrieve deals.']);
    }

    public function test_it_creates_deal_and_account_successfully(): void
    {
        $data = [
            'account' => [
                'Account_Name' => 'Test Account',
            ],
            'deal' => [
                'Deal_Name' => 'Test Deal',
                'Stage' => 'Test Stage',
            ],
        ];

        $response = $this->post(route('zoho.create'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Deal and Account created successfully',
            ]);
    }

    public function test_it_fails_when_account_creation_fails(): void
    {
        $this->withoutExceptionHandling();

        $data = [
            'account' => [
                'Account_Name' => 'Test Account',
            ],
            'deal' => [
                'Deal_Name' => 'Test Deal',
            ],
        ];

        try {
            $this->post(route('zoho.create'), $data);
        } catch (ValidationException $e) {
            $this->assertStringContainsString('The Stage field is required.', $e->getMessage());

            $this->assertEquals(422, $e->status);

            $this->assertArrayHasKey('deal.Stage', $e->validator->errors()->toArray());
        }

    }
}
