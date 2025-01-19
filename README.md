# Laravel AI Faker

Laravel AI Faker is a package that enhances Laravel's default Faker functionality by leveraging AI to generate realistic, context-aware fake data. This package scans your models, analyzes their attributes and relationships, and produces meaningful data for development and testing environments.

---

## Features

- **AI-Powered Data Generation**: Generates more realistic fake data using AI (e.g., OpenAI).
- **Model Analysis**: Automatically detects model attributes and relationships to provide context-aware data.
- **Seamless Integration**: Works seamlessly with Laravel factories and database seeding.
- **Configurable**: Customize AI prompts and settings for tailored results.

---

## Installation

Require the package via Composer:

```bash
composer require kimani/laravel-ai-faker
```

If you're using AI services like OpenAI, publish the configuration file:

```bash
php artisan vendor:publish --provider="Kimani\AIFaker\AIFakerServiceProvider"
```

Then, add your API key to the configuration file or `.env` file:

```env
AIFAKER_API_KEY=your-api-key-here
```

---

## Usage

### Generating Fake Data

Use the `AIFaker` service in your factories:

```php
use Kimani\AIFaker\Services\AIFaker;

$aiFaker = app(AIFaker::class);

return $aiFaker->generateFakeData(new \App\Models\YourModel());
```

### Example Factory Integration

In your Laravel factory:

```php
use Kimani\AIFaker\Services\AIFaker;

/** @var \Kimani\AIFaker\Services\AIFaker $aiFaker */
$aiFaker = app(AIFaker::class);

\App\Models\YourModel::factory()->define(function () use ($aiFaker) {
    return $aiFaker->generateFakeData(new \App\Models\YourModel());
});
```

---

## Configuration

The configuration file (`config/aifaker.php`) allows you to customize:

- AI provider and API key
- AI model and parameters
- Default behavior for data generation

---

## Testing

Run the tests with:

```bash
vendor/bin/phpunit
```

---

## Contributing

Contributions are welcome! Please submit a pull request or open an issue to report bugs or suggest features.

---

## License

This package is open-source and licensed under the [MIT License](LICENSE).

---

## Credits

Developed by David Kimani.

