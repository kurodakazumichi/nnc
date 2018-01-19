<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

/**
 * App Table Model
 */
class AppTable extends Table
{
  //----------------------------------------------------------------------------
  // トランザクション開始
  public function begin() {
    $this->getConnection()->begin();
  }

  //----------------------------------------------------------------------------
  // コミット
  public function commit() {
    $this->getConnection()->commit();
  }

  //----------------------------------------------------------------------------
  // ロールバック
  public function rollback() {
    $this->getConnection()->rollback();
  }
}
