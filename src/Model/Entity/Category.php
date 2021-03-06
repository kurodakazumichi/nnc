<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $name
 * @property int $order_no
 *
 * @property \App\Model\Entity\Article[] $articles
 * @property \App\Model\Entity\Book[] $books
 * @property \App\Model\Entity\Note[] $notes
 */
class Category extends Entity
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
        'order_no' => true,
        'articles' => true,
        'books' => true,
        'notes' => true
    ];
}
