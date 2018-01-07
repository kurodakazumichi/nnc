<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Breadcrumb list.
     */
    protected $breadcrumbs = [];

    /**
     * Action list of ajax only.
     */
    protected $ajaxOnlyActions = [];

    /**
     * Gadget List.
     */
    protected $gadgets = ["related_link"];

    /**
     * Related Link list.
     */
    protected $relatedLinks = [];

    /**
     * load css list.
     */
    protected $styles = [];

    /**
     * load js list.
     */
    protected $jscripts = [];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            // 未認証の場合、直前のページに戻します
            'unauthorizedRedirect' => $this->referer()
        ]);

        // display アクションを許可して、PagesController が引き続き
        // 動作するようにします。また、読み取り専用のアクションを有効にします。
        $this->Auth->allow(['display']);

        // replace from default table class to ex table class.
        TableRegistry::config('Categories', ['className' => 'App\Model\Table\CategoriesTableEx']);
        TableRegistry::config('Notes'     , ['className' => 'App\Model\Table\NotesTableEx']);
        TableRegistry::config('Articles'  , ['className' => 'App\Model\Table\ArticlesTableEx']);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * パンくずリストの最初の項目を構築する。
     */
    protected function buildFirstBreadCrumb()
    {
      // ちゃんねる対応
      $ch = substr($this->request->url, 0, 3);

      switch($ch) {
        case '1ch':
        case '2ch':
        case '3ch':
        case '4ch':
        case '5ch':
        case '6ch':
        case '7ch':
        case '8ch':
         $this->addCrumb($ch, $ch);
          break;
        default:
          break;
      }

    }

    public function beforeFilter(Event $event)
    {
      parent::beforeFilter($event);

      $this->buildFirstBreadCrumb();

      // beforeRenderで呼ぶと例外時にInternal server errorになる。
      $this->set('logined', $this->Auth->user() != null);

      // AjaxのみのアクションにAjax以外でアクセスされた場合は例外で処理する。
      if(!$this->request->is("ajax")) {
        if(in_array($this->request->action, $this->ajaxOnlyActions)){
          if(Configure::read('debug')) {
            throw new BadRequestException(__("Ajaxでのみアクセス可能です。"));
          } else {
            throw new NotFoundException();
          }
        }
      }
    }

    /**
     * before rendering hook method.
     */
    public function beforeRender(Event $event)
    {
      parent::beforeRender($event);

      $this->set('breadcrumbs', $this->breadcrumbs);
      $this->set('gadgets', $this->gadgets);
      $this->set('relatedLinks', $this->relatedLinks);
      $this->set('styles', $this->getStyles());
      $this->set('jscripts', $this->getScripts());



    }

    public function getLayoutName()
    {
      $layout = $this->viewBuilder()->getLayout();
      return is_null($layout)? "default" : $layout;
    }

    /**
     * パンくずリストにリンクを追加したい場合はこのメソッドを使用する。
     */
    protected function addCrumb($title, $url = "") {
      $this->breadcrumbs[] = ['title' => $title, 'url' => $url];
    }

    /**
     * 関連リンクリストにデータを追加する。
     */
    protected function addRelatedLink($url, $title) {

      $this->relatedLinks[] = [$title, ['controller' => $url[0], 'action' => $url[1]]];
    }

    /**
     * 読み込みたいCSSのパスを追加します。
     * reset.css、common.css、またLayout,Controller,Actionに関連するstyleなど
     * 一部のCSSはbeforeRenderのタイミングで自動追加されるため
     * このメソッドで明示的に追加する必要はありません。
     */
    protected function addStyle($path) {
      if(is_array($path)) {
        $this->styles += $path;
      } else {
        $this->styles[] = $path;
      }
    }

    /**
    * 読み込みたいJSのパスを追加します。
    * jqueryやLayout,Controller,Actionに関連するjsなど
    * 一部のJSはbeforeRenderのタイミングで自動追加されるため
    * このメソッドで明示的に追加する必要はありません。
     */
    protected function addScript($path) {
      if(is_array($path)) {
        $this->jscripts += $path;
      } else {
        $this->jscripts[] = $path;
      }
    }

    /**
     * Layout,Controller,Actionに対応するCSSが存在すればそのリストを返す
     */
    private function getStyles_LCA()
    {
      $l = $this->getLayoutname();
      $c = mb_strtolower($this->request->controller);
      $a = $this->request->action;
      $list = [];

      // レイアウトに対応したCSSが存在すればリストに追加
      if(!empty($l)) {
        $path = "layout/$l";
        if(file_exists(WWW_ROOT . "css/$path.css")) {
          $list[] = $path;
        }
      }

      // コントローラーに対応したCSSが存在すればリストに追加
      $path = "controller/$c";
      if(file_exists(WWW_ROOT ."css/$path.css")) {
        $list[] = $path;
      }

      // アクションに対応したCSSが存在すればリストに追加
      $path = "$c/$a";
      if(file_exists(WWW_ROOT . "css/$path.css")) {
        $list[] = $path;
      }
      return $list;
    }

    /**
     * Layout,Controller,Actionに対応するJSが存在すればそのリストを返す
     */
    private function getScripts_LCA()
    {
      $l = $this->getLayoutname();
      $c = mb_strtolower($this->request->controller);
      $a = $this->request->action;
      $list = [];

      // レイアウトに対応したCSSが存在すればリストに追加
      if(!empty($l)) {
        $path = "layout/$l";
        if(file_exists(WWW_ROOT . "js/$path.js")) {
          $list[] = $path;
        }
      }

      // コントローラーに対応したCSSが存在すればリストに追加
      $path = "controller/$c";
      if(file_exists(WWW_ROOT ."js/$path.js")) {
        $list[] = $path;
      }

      // アクションに対応したCSSが存在すればリストに追加
      $path = "$c/$a";
      if(file_exists(WWW_ROOT . "js/$path.js")) {
        $list[] = $path;
      }
      return $list;
    }

    /**
     * 読み込むCSSリストを取得する。
     */
    private function getStyles()
    {
      // デフォルトで読み込むCSS
      $css = [
        'https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css'
        ,'cssreset-min.css'
        ,'common.css'
      ];

      // Layout,Controller,Actionに関するCSSを追加
      $css = array_merge($css, $this->getStyles_LCA());

      // 管理者用(ログイン時のみ読み込む)
      $css[] = "admin.css";
      $css[] = '/venders/jquery/ui/jquery-ui.min.css';

      // 他に読み込むものがあればマージする。
      $css = array_merge($css, $this->styles);

      return $css;
    }

    /**
     * 読み込むJSリストを取得する。
     */
    private function getScripts()
    {
      $js = [
        '/venders/jquery/jquery-3.2.1.min.js'
      ];

      // 管理者の時だけ読み込む
      $js[] = '/venders/jquery/ui/jquery-ui.min.js';

      // アクションに対応したJSが存在すれば読み込む
      $js = array_merge($js, $this->getScripts_LCA());

      // 他にあればマージする。
      $js = array_merge($js, $this->jscripts);

      return $js;
    }

    /**
     * Viewを使用せず、シンプルなテキストを出力して終了します。
     */
    protected function outputSimpleText($text)
    {
      $this->autoRender = false;
      header("Content-Type: text/plain; charset=utf-8");
      echo $text;
    }

    /**
     * Viewを使用せず、JSONテキストを出力して終了します。
     */
    protected function outputJsonText($msg, $status)
    {
      $this->autoRender = false;
      header("Content-Type: application/json; charset=utf-8");
      $json = ["msg" => $msg, "status" => $status];
      echo json_encode($json);
    }

}
