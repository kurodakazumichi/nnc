<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Module Entity
 *
 * @property int $id
 * @property string $name
 * @property string $prefix_script
 * @property string $postfix_script
 * @property int $order_no
 *
 * @property \App\Model\Entity\Asset[] $assets
 * @property \App\Model\Entity\Note[] $notes
 */
class Module extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'prefix_script' => true,
        'postfix_script' => true,
        'order_no' => true,
        'assets' => true,
        'notes' => true
    ];
}
