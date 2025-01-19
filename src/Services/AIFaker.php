<?php

namespace Kimani\LaravelAiFaker\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use OpenAI;

class AIFaker
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('AIFAKER_API_KEY'));
    }

    /**
     * Analyze the model's structure and relationships.
     *
     * @param Model $model
     * @return array
     */
    public function analyzeModel(Model $model): array
    {
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);

        // Identify relationships
        $relationships = [];
        foreach (get_class_methods($model) as $method) {
            $reflection = new \ReflectionMethod($model, $method);
            if ($reflection->getNumberOfParameters() === 0) {
                $result = $model->$method();
                if ($result instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
                    $relationships[$method] = class_basename($result->getRelated());
                }
            }
        }

        return [
            'table' => $table,
            'columns' => $columns,
            'relationships' => $relationships,
        ];
    }

     /**
     * Generate fake data using AI.
     *
     * @param Model $model
     * @return array
     */
    public function generateFakeData(Model $model): array
    {
        $modelInfo = $this->analyzeModel($model);

        $prompt = "Generate realistic fake data for the following model: \n";
        $prompt .= "Table: {$modelInfo['table']}\n";
        $prompt .= "Columns: " . implode(', ', $modelInfo['columns']) . "\n";
        $prompt .= "Relationships: " . json_encode($modelInfo['relationships']) . "\n";

        $response = $this->client->completions()->create([
            'model' => 'gpt-4o-mini',
            'prompt' => $prompt,
            'max_tokens' => 300,
        ]);

        $generatedData = json_decode($response['choices'][0]['message'], true);

        return $generatedData ?? [];
    }
}
