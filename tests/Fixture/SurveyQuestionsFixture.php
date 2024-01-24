<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SurveyQuestionsFixture
 */
class SurveyQuestionsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'survey_id' => 1,
                'section' => 'Lorem ipsum dolor sit amet',
                'question' => 'Lorem ipsum dolor sit amet',
                'option_type' => 'Lorem ipsum dolor sit amet',
                'master_main_id' => 1,
                'parent_id' => 1,
                'show_if' => 'Lorem ipsum dolor sit amet',
                'created_on' => 1706089751,
                'created_by' => 1,
                'is_clinical' => 1,
            ],
        ];
        parent::init();
    }
}
