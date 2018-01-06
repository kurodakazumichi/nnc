<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property int $id
 * @property int $note_id
 * @property int $layer
 * @property int $category_id
 * @property bool $published
 *
 * @property \App\Model\Entity\Note $note
 * @property \App\Model\Entity\Category $category
 */
class Article extends Entity
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
        'note_id' => true,
        'layer' => true,
        'category_id' => true,
        'published' => true,
        'note' => true,
        'category' => true
    ];
}
