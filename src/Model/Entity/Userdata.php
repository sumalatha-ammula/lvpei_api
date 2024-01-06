<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Userdata Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string|null $role
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property \Cake\I18n\FrozenTime|null $last_login
 * @property string|null $token_key
 * @property string|null $device_info
 * @property string|null $location_info
 * @property bool $status
 * @property string $company_id
 */
class Userdata extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'name' => true,
        'role' => true,
        'created_by' => true,
        'created_on' => true,
        'last_login' => true,
        'token_key' => true,
        'device_info' => true,
        'location_info' => true,
        'status' => true,
        'company_id' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];
}
