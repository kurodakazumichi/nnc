/**
* Nekonecodeライブラリ
*/
(function(){
  class NNC
  {
    // モジュール格納庫
    private modules: any;

    /**
    * コンストラクタ
    */
    constructor()
    {
      this.modules = {};
    }

    /**
    * モジュールをセットする。
    */
    public setModule(name:string, module:any): void
    {
      this.modules[name] = module;
    }

    /**
    * モジュールをゲットする。
    */
    public getModule(name:string): any
    {
      return this.modules[name];
    }
  }

  var ins = new NNC();

  (<any>window).nnc = function (name: string, mod?: any): any
  {
    if(mod) {
      ins.setModule(name, mod);
    } else {
      return ins.getModule(name);
    }
  };
})();
