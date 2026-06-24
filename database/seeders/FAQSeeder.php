<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What types of video production do you offer?',
                'answer' => 'We offer a full range of production services including corporate videos, music videos, documentaries, commercials, event coverage, animation, and motion graphics.',
                'category' => 'General',
            ],
            [
                'question' => 'How long does a typical project take?',
                'answer' => 'Project timelines vary depending on complexity. A typical corporate video takes 2-4 weeks, while larger productions may take 6-8 weeks from pre-production to final delivery.',
                'category' => 'Process',
            ],
            [
                'question' => 'What is your pricing model?',
                'answer' => 'We provide custom quotes based on project scope, complexity, and requirements. Contact us for a free consultation and detailed proposal.',
                'category' => 'Pricing',
            ],
            [
                'question' => 'Do you offer post-production services?',
                'answer' => 'Yes, we offer comprehensive post-production services including editing, color grading, sound design, mixing, visual effects, and motion graphics.',
                'category' => 'Services',
            ],
            [
                'question' => 'What file formats do you deliver?',
                'answer' => 'We deliver in a wide range of formats suitable for broadcast, web, social media, and mobile. Common formats include MP4, MOV, and custom formats as needed.',
                'category' => 'Technical',
            ],
            [
                'question' => 'Can you work with our existing footage?',
                'answer' => 'Absolutely. We regularly work with client-provided footage for editing, color grading, and post-production projects.',
                'category' => 'Services',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            FAQ::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'category' => $faq['category'],
                'display_order' => $index,
                'is_published' => true,
            ]);
        }
    }
}
