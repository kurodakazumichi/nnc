<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Note Entity
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $css
 * @property string $js
 * @property string $search_word
 * @property string $description
 * @property int $category_id
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Tag[] $tags
 */
class Note extends Entity
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
        'title' => true,
        'body' => true,
        'css' => true,
        'js' => true,
        'search_word' => true,
        'description' => true,
        'category_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'category' => true,
        'tags' => true
    ];
}
