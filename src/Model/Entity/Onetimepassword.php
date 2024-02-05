<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Onetimepassword Entity
 *
 * @property int $id
 * @property string $email
 * @property string $otp
 * @property \Cake\I18n\FrozenTime $createdon
 */
class Onetimepassword extends Entity
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
        'otp' => true,
        'createdon' => true,
    ];
}
