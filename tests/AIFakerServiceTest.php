<?php

namespace Kimani\LaravelAiFaker\Tests;

use Kimani\LaravelAiFaker\Services\AIFaker;
use Kimani\LaravelAiFaker\Tests\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class AIFakerServiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected $aifaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->aifaker = new AIFaker();
    }

    public function test_it_can_generate_fake_data_for_a_user_model_with_real_api_call()
    {
        // Setup: Ensure you have real credentials set in .env (AIFAKER_API_KEY)
        $this->assertNotEmpty(config('aifaker.api_key'), 'API key is not set');

        // Mock Schema and model analysis without the database
        Schema::shouldReceive('getColumnListing')
            ->with('users')
            ->andReturn(['name', 'email', 'password', 'created_at', 'updated_at']);

        // Create a User model instance (this can be a real instance)
        $user = new User();
        
        // Analyze the model and generate fake data via real OpenAI API
        $generatedData = $this->aifaker->generateFakeData($user);

        // Assertions: Make sure the generated data is in the expected format
        $this->assertIsArray($generatedData);
        $this->assertArrayHasKey('name', $generatedData);
        $this->assertArrayHasKey('email', $generatedData);
        $this->assertArrayHasKey('password', $generatedData);
        
        // Additional assertions based on expected API behavior
        $this->assertMatchesRegularExpression('/\S+@\S+\.\S+/', $generatedData['email']);
        $this->assertNotEmpty($generatedData['password']);
    }
}
