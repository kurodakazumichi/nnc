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
    var ins = new NNC();
    window.nnc = function (name, mod) {
        if (mod) {
            ins.setModule(name, mod);
        }
        else {
            return ins.getModule(name);
        }
    };
})();
