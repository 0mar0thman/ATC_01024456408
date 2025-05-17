<?php
// database/factories/CategoryFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition()
    {
        $faker = \Faker\Factory::create('ar_EG');

        $names = [
            'حفلات',
            'ورش عمل',
            'ندوات',
            'مهرجانات',
            'عروض مسرحية',
            'مؤتمرات',
            'كورسات',
            'أمسيات شعرية',
            'سينما',
            'معارض فن',
            'رياضة',
            'بطولات',
            'ألعاب أطفال',
            'رحلات',
            'عروض كوميدية',
            'موسيقى',
            'تكنولوجيا',
            'برمجة',
            'تصوير',
            'عزف وغناء',
            'طبخ',
            'كتب ومطالعة',
            'أنشطة عائلية',
            'أنشطة للشباب',
            'أنشطة للأطفال',
            'مسابقات',
            'تسوق ومعارض',
        ];

        $name = $faker->unique()->randomElement($names);

        return [
            'name' => $name,
            // 'slug' => \Str::slug($name), // تحويل الاسم للـ slug بشكل أنيق
            'description' => $faker->realText(50),
        ];
    }
}
