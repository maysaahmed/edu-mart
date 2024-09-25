<?php

namespace Modules\Assessment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Assessment\Domain\Entities\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // #1
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Love the life of the party.',
                    'ar' => 'أحب حضور المناسبات الكبيره.'
                ],
                'order' => 1,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #2
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Have difficulty understanding abstract ideas.',
                    'ar' => 'أجد صعوبه في استيعاب الافكار المجرده الغير ملموسه.'
                ],
                'order' => 2,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);

        // #3
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Feel Comfortable around people.',
                    'ar' => 'أشعر بالراحة مع الآخرين.'
                ],
                'order' => 3,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #4
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Insult people.',
                    'ar' => 'أهين الآخرين.'
                ],
                'order' => 4,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #5
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Pay attention to details.',
                    'ar' => 'أولي اهتمامًا للتفاصيل.'
                ],
                'order' => 5,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #6
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Worry about things.',
                    'ar' => 'كثير الخشيه من حدوث الأسوأ.'
                ],
                'order' => 6,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #7
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Have a vivid imagination.',
                    'ar' => 'أحب أن أسرح في تفكيري.'
                ],
                'order' => 7,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #8
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Keep in the background.',
                    'ar' => 'أبقى في الخلفية.'
                ],
                'order' => 8,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #9
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Sympathize with others feelings.',
                    'ar' => 'أتعاطف مع من حالهم أسوأ مني.'
                ],
                'order' => 9,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #10
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Make a mess of things.',
                    'ar' => 'أفسد الأمور.'
                ],
                'order' => 10,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #11
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Seldom feel blue.',
                    'ar' => 'نادراً ما أشعر بالحزن.'
                ],
                'order' => 11,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #12
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Feel little concern for others.',
                    'ar' => 'لا تعنيني مشاكل الآخرين.'
                ],
                'order' => 12,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #13
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am not interested in abstract ideas.',
                    'ar' => 'لست مهتماً بالنقاشات النظريه.'
                ],
                'order' => 13,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #14
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Start conversations.',
                    'ar' => 'أبادر بمحادثة الآخرين.'
                ],
                'order' => 14,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #15
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am not interested in other people\'s problems.',
                    'ar' => 'لست مهتمًا بمشاكل الآخرين.'
                ],
                'order' => 15,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #16
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Get chores done right away.',
                    'ar' => 'أُنجز الأعمال المنزلية على الفور.'
                ],
                'order' => 16,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #17
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am easily disturbed.',
                    'ar' => 'أتوتر بسهولة.'
                ],
                'order' => 17,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #18
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Have excellent ideas.',
                    'ar' => 'لدي أفكار ممتازة.'
                ],
                'order' => 18,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #19
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Have little to say.',
                    'ar' => 'ليس لدي الكثير لأقوله.'
                ],
                'order' => 19,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #20
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Have a soft heart.',
                    'ar' => 'لدي قلب رقيق.'
                ],
                'order' => 20,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #21
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Often forget to put things back in their proper place.',
                    'ar' => 'غالباً أنسي وضع الأشياء في مكانها المخصص.'
                ],
                'order' => 21,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #22
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Get upset easily.',
                    'ar' => 'أشعر بالانزعاج بسهولة.'
                ],
                'order' => 22,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #23
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am always prepared.',
                    'ar' => 'أنا دائماً علي استعداد.'
                ],
                'order' => 23,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #24
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Don\'t have a good imagination.',
                    'ar' => 'ليس لدي خيال جيد.'
                ],
                'order' => 24,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #25
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Talk to a lot of different of peoples in parties.',
                    'ar' => 'أتحدث مع الكثير من الأشخاص المختلفين في الحفلات.'
                ],
                'order' => 25,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #26
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am not really interested in others.',
                    'ar' => 'لست مهتمًا بالآخرين حقًا.'
                ],
                'order' => 26,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #27
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Like order.',
                    'ar' => 'أحب الترتيب والنظام.'
                ],
                'order' => 27,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #28
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Change my mood a lot.',
                    'ar' => 'مزاجي يتغير كثيرًا.'
                ],
                'order' => 28,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #29
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am quick to understand things.',
                    'ar' => 'سريع الفهم.'
                ],
                'order' => 29,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #30
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Don\'t like to draw attention to myself.',
                    'ar' => 'لا أرغب في أن أكون محط الأنظار.'
                ],
                'order' => 30,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #31
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Take time out for others.',
                    'ar' => 'أخصص وقتًا للآخرين.'
                ],
                'order' => 31,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #32
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Shirk my duties.',
                    'ar' => 'أتهرب من مسؤولياتي.'
                ],
                'order' => 32,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #33
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Have frequent mood swings.',
                    'ar' => 'لدي تقلبات مزاجية متكررة.'
                ],
                'order' => 33,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #34
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Get stressed out easily.',
                    'ar' => 'كثير القلق.'
                ],
                'order' => 34,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #35
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Use difficult words.',
                    'ar' => 'أستخدم كلمات صعبة.'
                ],
                'order' => 35,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #36
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Don\'t mind being the center of attention.',
                    'ar' => 'لا أمانع أن أكون محور الاهتمام.'
                ],
                'order' => 36,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #37
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Feel others\' emotions .',
                    'ar' => 'أحس بمشاعر الآخرين.'
                ],
                'order' => 37,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #38
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Follow a schedule.',
                    'ar' => 'ألتزم بجدول زمني.'
                ],
                'order' => 38,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #39
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Get irritated easily.',
                    'ar' => 'يتم استفزازي بسهولة.'
                ],
                'order' => 39,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #40
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Spend time reflecting on things.',
                    'ar' => 'أمضي وقتًا في التأمل في الأمور.'
                ],
                'order' => 40,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #41
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am quiet around strangers.',
                    'ar' => 'ألتزم الصمت مع الأشخاص الغرباء.'
                ],
                'order' => 41,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #42
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Make people feel at ease.',
                    'ar' => 'أجعل الناس يشعرون بالراحة.'
                ],
                'order' => 42,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #43
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am exacting at my work.',
                    'ar' => 'أعمل باجتهاد.'
                ],
                'order' => 43,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #44
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Often feel blue.',
                    'ar' => 'غالبًا ما أشعر بالحزن.'
                ],
                'order' => 44,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #45
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Have a rich vocabulary.',
                    'ar' => 'أمتلك حصيلة لغوية واسعة.'
                ],
                'order' => 45,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #46
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am full of ideas.',
                    'ar' => 'أمتلك العديد من الأفكار.'
                ],
                'order' => 46,
                'factor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #47
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Don\'t talk a lot.',
                    'ar' => 'لا أتحدث كثيرًا.'
                ],
                'order' => 47,
                'factor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #48
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am interested in people.',
                    'ar' => 'أبدي اهتمامًا بالآخرين.'
                ],
                'order' => 48,
                'factor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #49
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Leave my belongings around.',
                    'ar' => 'أترك أغراضي مبعثرة.'
                ],
                'order' => 49,
                'factor_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
        // #50
       Question::updateorCreate([
                'ques' =>  [
                    'en' => 'Am relaxed most of the time.',
                    'ar' => 'أشعر بالراحة في أغلب الأوقات.'
                ],
                'order' => 50,
                'factor_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
        ]);
    }
}
