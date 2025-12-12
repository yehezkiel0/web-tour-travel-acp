<?php

namespace Database\Seeders;

use App\Models\ServiceTestimonial;
use Illuminate\Database\Seeder;

class ServiceTestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            // Medical testimonials
            [
                'name' => 'Sarah Johnson',
                'location' => 'Jakarta, Indonesia',
                'photo' => null,
                'title' => 'Life-Changing Medical Experience',
                'message' => 'The medical services at ACP Tours are exceptional! From the initial consultation to post-treatment care, everything was handled professionally. The staff was caring and attentive to all my needs.',
                'service_type' => 'medical',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Michael Chen',
                'location' => 'Surabaya, Indonesia',
                'photo' => null,
                'title' => 'Outstanding Beauty Treatment',
                'message' => 'I am amazed by the transformation! The beauty treatments were top-notch, using the latest technology. The results exceeded my expectations and the staff made me feel comfortable throughout.',
                'service_type' => 'medical',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Diana Putri',
                'location' => 'Bandung, Indonesia',
                'photo' => null,
                'title' => 'Professional and Caring Service',
                'message' => 'The medical team at ACP Tours is highly professional. They explained every procedure clearly and ensured I was comfortable. The facility is modern and clean. Highly recommended!',
                'service_type' => 'medical',
                'rating' => 5,
                'is_approved' => true,
            ],

            // Recruitment testimonials
            [
                'name' => 'Robert Anderson',
                'location' => 'Seoul, South Korea',
                'photo' => null,
                'title' => 'Found My Dream Job in Korea',
                'message' => 'ACP Tours helped me secure a fantastic position in Seoul. The recruitment process was smooth, and they provided excellent support with visa processing and accommodation. Thank you for making my dream come true!',
                'service_type' => 'recruitment',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Amanda Wijaya',
                'location' => 'Busan, South Korea',
                'photo' => null,
                'title' => 'Seamless Recruitment Process',
                'message' => 'I was impressed by how efficient and professional the recruitment team was. They matched me with a perfect job opportunity and guided me through every step. Now I am working in my dream company in Korea!',
                'service_type' => 'recruitment',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Kevin Tan',
                'location' => 'Incheon, South Korea',
                'photo' => null,
                'title' => 'Excellent Career Support',
                'message' => 'The recruitment service provided by ACP Tours is exceptional. They not only found me a great job but also helped with cultural adaptation and language training. Truly comprehensive service!',
                'service_type' => 'recruitment',
                'rating' => 5,
                'is_approved' => true,
            ],

            // Entertainment testimonials
            [
                'name' => 'Lisa Park',
                'location' => 'Jakarta, Indonesia',
                'photo' => null,
                'title' => 'Unforgettable K-Pop Concert Experience',
                'message' => 'ACP Tours organized the most amazing K-Pop concert experience! From VIP tickets to meet-and-greet sessions, everything was perfectly arranged. It was a dream come true for a K-Pop fan like me!',
                'service_type' => 'entertainment',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'David Kim',
                'location' => 'Bali, Indonesia',
                'photo' => null,
                'title' => 'Best Festival Experience Ever',
                'message' => 'The Korean culture festival organized by ACP Tours was incredible! Great performances, delicious food, and authentic Korean cultural experiences. The organization was flawless!',
                'service_type' => 'entertainment',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Jessica Lee',
                'location' => 'Yogyakarta, Indonesia',
                'photo' => null,
                'title' => 'Amazing K-Drama Fan Meeting',
                'message' => 'I attended a K-Drama fan meeting organized by ACP Tours and it exceeded all expectations! Meeting my favorite actors was a dream come true. The team handled everything professionally!',
                'service_type' => 'entertainment',
                'rating' => 5,
                'is_approved' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            ServiceTestimonial::create($testimonial);
        }
    }
}