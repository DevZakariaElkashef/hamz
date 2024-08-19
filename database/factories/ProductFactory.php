<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $apps = config('app.apps'); // return array of values
        $arabicProductNames = [
            'جهاز كمبيوتر محمول','هاتف ذكي','تلفاز 4K','ساعة ذكية','كاميرا رقمية','أحذية رياضية','جهاز تابلت','سماعات أذن','حقيبة ظهر','مكيف هواء','خلاط عصير','غسالة ملابس','ثلاجة','ميكروويف','مكنسة كهربائية',
        ];

        $arabicProductDescriptions = [
            'جهاز كمبيوتر محمول قوي ومناسب للألعاب والعمل.',
            'هاتف ذكي مزود بكاميرا عالية الدقة وميزات متعددة.',
            'تلفاز 4K يعرض الصورة بدقة عالية وبجودة رائعة.',
            'ساعة ذكية تقدم تتبع للياقة البدنية وتنبيهات ذكية.',
            'كاميرا رقمية تلتقط صوراً واضحة وفيديوهات بجودة عالية.',
            'أحذية رياضية مريحة ومثالية للتمارين اليومية.',
            'جهاز تابلت بشاشة كبيرة وأداء عالٍ.',
            'سماعات أذن توفر تجربة صوتية ممتازة ومريحة.',
            'حقيبة ظهر متينة وقابلة للتعديل ومناسبة لجميع الاستخدامات.',
            'مكيف هواء يوفر تبريداً فعالاً وسريعاً.',
            'خلاط عصير قوي يساعدك في تحضير العصائر والمشروبات.',
            'غسالة ملابس ذات قدرة كبيرة وكفاءة عالية في تنظيف الملابس.',
            'ثلاجة كبيرة بسعة تخزين واسعة للحفاظ على الأطعمة.',
            'ميكروويف مع ميزات متعددة لطهي الطعام بسرعة وسهولة.',
            'مكنسة كهربائية تعمل بكفاءة لتنظيف الأسطح بفعالية.'
        ];

        return [
            'name_ar' => $this->faker->randomElement($arabicProductNames),
            'name_en' => fake()->word(),
            'description_ar' => $this->faker->randomElement($arabicProductDescriptions),
            'description_en' => fake()->sentence(),
            'image' => str_replace(['public', '\\'], ['', '/'], fake()->image('public/uploads/products', 640, 480, 'art4muslim')),
            'price' => fake()->numberBetween(111, 9999),
            'offer' => fake()->numberBetween(111, 9999),
            'start_offer_date' => fake()->date(),
            'end_offer_date' => fake()->date(),
            'qty' => fake()->numberBetween(11111, 99999),
            'app' => fake()->randomElement($apps)
        ];
    }
}
