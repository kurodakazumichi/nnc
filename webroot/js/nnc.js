"use strict";
(function () {
    class NNC {
        constructor() {
            this.modules = {};
        }
        setModule(name, module) {
            this.modules[name] = module;
        }
        getModule(name) {
            return this.modules[name];
        }
    }
    var _nnc = new NNC();
    window.nnc = function (name, mod) {
        if (mod) {
            _nnc.setModule(name, mod);
        }
        else {
            return _nnc.getModule(name);
        }
    };
})();
