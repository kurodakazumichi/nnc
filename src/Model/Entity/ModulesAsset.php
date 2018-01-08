<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ModulesAsset Entity
 *
 * @property int $module_id
 * @property int $asset_id
 * @property int $order_no
 *
 * @property \App\Model\Entity\Module $module
 * @property \App\Model\Entity\Asset $asset
 */
class ModulesAsset extends Entity
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
        'order_no' => true,
        'module' => true,
        'asset' => true
    ];
}
