<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PartcipantsFixture
 */
class PartcipantsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'field_executive_id' => 1,
                'survey_id' => 1,
                'is_survey' => 'Lorem ipsum dolor sit amet',
                'created_on' => 1706113367,
                'created_by' => 1,
                'age' => 'Lorem ipsum dolor sit amet',
                'mobile' => 'Lorem ipsu',
                'adharnumber' => 'Lorem ipsum dolor sit amet',
                'occupation' => 'Lorem ipsum dolor sit amet',
                'gender' => 'Lorem ipsum dolor ',
                'status' => 'Lorem ipsum dolor sit amet',
                'monthlyincome' => 1,
                'dateofbirth' => '2024-01-24',
                'country' => 'Lorem ipsum dolor sit amet',
                'state' => 'Lorem ipsum dolor sit amet',
                'district' => 'Lorem ipsum dolor sit amet',
                'education' => 'Lorem ipsum dolor sit amet',
                'idcode' => 1,
                'landmark' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'clustercode' => 1,
                'indiviadualcode' => 1,
                'unid' => 1,
                'is_examine' => 1,
            ],
        ];
        parent::init();
    }
}
