<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FieldExecutiveFixture
 */
class FieldExecutiveFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'field_executive';
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
                'username' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'phone' => 'Lorem ip',
            ],
        ];
        parent::init();
    }
}
