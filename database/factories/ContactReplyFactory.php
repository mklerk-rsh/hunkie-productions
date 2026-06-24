<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactReplyFactory extends Factory
{
    protected $model = ContactReply::class;

    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory(),
            'admin_id' => User::factory(),
            'message' => fake()->paragraph(),
            'quotation_path' => null,
            'quotation_filename' => null,
        ];
    }

    public function withQuotation(): static
    {
        return $this->state(fn (array $attributes) => [
            'quotation_path' => 'quotations/sample-quote.pdf',
            'quotation_filename' => 'Quotation - ' . fake()->company() . '.pdf',
        ]);
    }
}
