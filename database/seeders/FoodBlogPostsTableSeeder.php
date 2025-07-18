<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodBlogPost;

class FoodBlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'admin_id' => 1,
                'cafe_name' => 'Altitude Coffee',
                'location' => '29 W Capitol Dr, Philippines, Pasig, 1603 Metro Manila',
                'opening_hours' => '11 AM - 8 PM',
                'description' => "Altitude Coffee is a cozy, third-wave café nestled in the heart of Pasig. Known for its warm ambiance, minimalist interiors, and elevated coffee experience, it's a popular spot among creatives and remote workers looking for a relaxing coffee break.",
                'blogger_top_drink' => 'Spanish Latte',
                'blogger_top_food' => 'Grilled Cheese with Tomato Soup',
                'score_affordability' => 7,
                'score_ambiance' => 9,
                'score_taste' => 8,
                'score_overall' => self::calculateOverall([7, 9, 8]),
                'like_count' => 0,
            ],
            [
                'admin_id' => 1,
                'cafe_name' => 'Drip Kofi - Pantok',
                'location' => '240 Manila E Rd, Pantok, Binangonan, Rizal',
                'opening_hours' => '9 AM - 11 PM',
                'description' => 'Drip Kofi - Pantok offers a vibrant, youthful twist on café culture with street-side seating, neon signs, and strong brews. Its chill and open-air setup makes it a go-to hangout spot for late-night coffee runs in Binangonan.',
                'blogger_top_drink' => 'Iced Dirty Matcha',
                'blogger_top_food' => 'Spam & Egg Rice Bowl',
                'score_affordability' => 9,
                'score_ambiance' => 8,
                'score_taste' => 7,
                'score_overall' => self::calculateOverall([9, 8, 7]),
                'like_count' => 0,
            ],
            [
                'admin_id' => 1,
                'cafe_name' => 'Maestro Café',
                'location' => 'CPV Business Center Manila East Road, Cor. Col Guido, San Roque, Angono, 1940 Rizal',
                'opening_hours' => '10 AM - 12 PM',
                'description' => "Maestro Café brings a musical flair to its cozy dining atmosphere, with instrument-themed decor and live acoustic nights. It's a gem in Angono that mixes hearty meals with laid-back vibes.",
                'blogger_top_drink' => 'Caramel Macchiato',
                'blogger_top_food' => 'Chicken Parmigiana',
                'score_affordability' => 8,
                'score_ambiance' => 9,
                'score_taste' => 9,
                'score_overall' => self::calculateOverall([8, 9, 9]),
                'like_count' => 0,
            ],
            [
                'admin_id' => 1,
                'cafe_name' => 'Cafe Detour',
                'location' => 'National Rd., Calumpang, Binangonan, 1940 Rizal',
                'opening_hours' => '11 AM - 10 PM',
                'description' => 'Cafe Detour is a charming roadside café ideal for quick stops or slow mornings. It features rustic wood furniture and panoramic views, offering an ideal detour from the hustle and bustle.',
                'blogger_top_drink' => 'Cold Brew',
                'blogger_top_food' => 'Longganisa Silog',
                'score_affordability' => 8,
                'score_ambiance' => 7,
                'score_taste' => 7,
                'score_overall' => self::calculateOverall([8, 7, 7]),
                'like_count' => 0,
            ],
            [
                'admin_id' => 1,
                'cafe_name' => 'Bricks & Brew',
                'location' => '4427 Old Sta. Mesa St., Sta. Mesa, First District, Sampaloc, 1008 Metro Manila',
                'opening_hours' => '9 AM - 9 PM',
                'description' => "Bricks & Brew combines vintage charm and modern coffee craft in an industrial-style café setting. It's known for its cozy corners and artisanal drinks—perfect for casual meetups or solo visits.",
                'blogger_top_drink' => 'Mocha Frappe',
                'blogger_top_food' => 'Truffle Pasta',
                'score_affordability' => 7,
                'score_ambiance' => 8,
                'score_taste' => 9,
                'score_overall' => self::calculateOverall([7, 8, 9]),
                'like_count' => 0,
            ],
        ];

        foreach ($posts as $post) {
            FoodBlogPost::create($post);
        }
    }

    /**
     * Calculate the overall score as the average of the given scores.
     */
    private static function calculateOverall(array $scores): float
    {
        return round(array_sum($scores) / count($scores), 1);
    }
}