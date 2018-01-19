<?php
/*******************************************************************************
* Ajaxs Controller.php
*
* @概要
* Ajaxによる処理をまとめたコントローラー、Ajax通信によるアクセスのみ許可する。
*
*******************************************************************************/
namespace App\Controller;

use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;
use Cake\Core\Configure;
use App\Controller\AppController;

/**
 * Ajaxs Controller
 *
 *
 */
class AjaxsController extends AppController
{
  //============================================================================
  // オーバーライド
  //============================================================================

  //----------------------------------------------------------------------------
  // Initialize
  public function initialize()
  {
    parent::initialize();
    $this->loadModel('Assets');
  }

  //----------------------------------------------------------------------------
  // beforeFilter
  public function beforeFilter($event)
  {
    parent::beforeFilter($event);

    // AjaxのみのアクションにAjax以外でアクセスされた場合は例外で処理する。
    // if(!$this->request->is("ajax")) {
    //   if(Configure::read('debug')) {
    //     throw new BadRequestException(__("Ajaxでのみアクセス可能です。"));
    //   } else {
    //     throw new NotFoundException();
    //   }
    // }
  }

  //============================================================================
  // Asset関連
  // @methods
  // get  :assetの検索
  // post :assetの新規作成
  //============================================================================
  public function asset($id = null)
  {

    switch($this->request->getMethod())
    {
      case 'GET' : $this->assetGet(); break;
      case 'POST': $this->assetPost(); break;
      default : throw new NotFoundException();
    }
  }

  //----------------------------------------------------------------------------
  // Asset検索(method:get)
  //
  // @return json
  // {0:{id => $asset_id, src: => $asset_src, memo: => $asset_memo},...}
  //
  //----------------------------------------------------------------------------
  private function assetGet()
  {
    // 変数定義
    $params = $this->request->query();
    $result = [];

    // 検索パラメータ取得
    $keyword = get($params['keyword']);

    // Assetsからキーワードに一致するデータを取得、キーワードがなければ全件。
    $assets = $this->Assets->find();

    if($keyword != "") {
      $assets->where([
        'OR' => [
          'Assets.src LIKE'  => "%$keyword%",
          'Assets.memo LIKE' => "%$keyword%"
        ],
      ]);
    }

    // レスポンスデータを生成
    foreach($assets as $asset) {
      $result[] = [
        'id'   => $asset->id,
        'src'  => $asset->src,
        'memo' => $asset->memo,
      ];
    }

    $this->outputJsonText($result);
  }

  //----------------------------------------------------------------------------
  // Asset新規作成(method:post)
  private function assetPost()
  {
    // 変数定義
    $params = $this->request->getData();
    $result = [];

    // 新Entity生成
    $asset = $this->Assets->newEntity();
    $asset = $this->Assets->patchEntity($asset, $params);

    if ($this->Assets->save($asset)) {
      $this->outputJsonText($asset->toArray());
    } else {
      $this->outputJsonText($asset->getErrors(), false);
    }
  }

}
