<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $apps = config('app.apps'); // return array of values
        $arabicStoreNames = [
            'المتجر الذهبي','سوق المدينة','الأسواق الكبرى','المعرض العصري','محل الأناقة','بوتيك النخبة','سوق الأزياء','متجر الإلكترونيات','دكان التحف','محل الصحة والجمال','عالم الأطفال','المتجر الحديث','متجر الكتب','محل الأثاث','مركز التسوق الكبير'
        ];
        $arabicStoreDescriptions = [
            'متجر يقدم مجموعة متنوعة من المنتجات الفاخرة والمميزة.','سوق يضم مجموعة واسعة من المنتجات بأسعار تنافسية.','أسواق كبيرة توفر كل ما تحتاجه تحت سقف واحد.','معرض عصري يحتوي على أحدث التصاميم والابتكارات.','محل متخصص في الأزياء الراقية والأنيقة.','بوتيك يقدم أرقى الأزياء والإكسسوارات.','سوق مخصص لأحدث صيحات الموضة والأزياء.','متجر متكامل للإلكترونيات والأجهزة التقنية.','دكان يقدم مجموعة مميزة من التحف القديمة والحديثة.','محل يركز على منتجات الصحة والجمال والعناية الشخصية.','عالم مخصص للأطفال من ملابس وألعاب وإكسسوارات.','متجر حديث يعرض أحدث المنتجات والتقنيات.','متجر لبيع الكتب من جميع الأنواع والتخصصات.','محل يقدم أثاثاً عصريًا ومريحًا للمنزل.','مركز تسوق شامل يحتوي على مجموعة متنوعة من المتاجر.'
        ];


        return [
            'name_ar' => $this->faker->randomElement($arabicStoreNames),
            'name_en' => fake()->word(),
            'description_ar' => $this->faker->randomElement($arabicStoreDescriptions),
            'description_en' => fake()->sentence(),
            'image' => str_replace(['public', '\\'], ['', '/'], fake()->image('public/uploads/stores', 640, 480, 'art4muslim')),
            'lat' => fake()->latitude(),
            'lng' => fake()->longitude(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'app' => fake()->randomElement($apps),
            'delivery_type' => rand(0, 1)
        ];
    }
}
