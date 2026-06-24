<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'source' => fake()->randomElement(['website', 'blog', 'event']),
            'subscribed' => true,
            'opted_in' => true,
            'subject' => fake()->sentence(4),
            'message' => fake()->paragraph(3),
            'is_read' => false,
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }

    public function unsubscribed(): static
    {
        return $this->state(fn (array $attributes) => [
            'subscribed' => false,
        ]);
    }
}
