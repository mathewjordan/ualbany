webpackJsonp([0],{

/***/ 45:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _SubmenuBlock = __webpack_require__(46);

var _SubmenuBlock2 = _interopRequireDefault(_SubmenuBlock);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var add_new_block = function add_new_block($parent) {
    var length = window.submenuBlocks.length;

    var filtered = window.submenuBlocks.filter(function (submenuBlock) {

        var $submenuBlock = jQuery(submenuBlock);

        return $submenuBlock.data('id') !== $parent.data('id');
    }).length;

    return !length || length === filtered;
}; /*global jQuery*/
/*global acf*/


jQuery(function () {

    window.submenuBlocks = [];

    var selectors = ['.acf-field-column-one-keysubmenu-menu', '.acf-field-column-two-keysubmenu-menu', '.acf-field-column-three-keysubmenu-menu', '.acf-field-column-four-keysubmenu-menu'];

    var $submenuBlocks = jQuery(selectors.join(', '));

    if ($submenuBlocks.length) {

        $submenuBlocks.each(function () {

            var $parent = jQuery(this).closest('[data-layout="submenu_block"]');

            if ($parent.data('id') && !$parent.is('.acf-clone') && add_new_block($parent)) {

                window.submenuBlocks.push(new _SubmenuBlock2.default({
                    parent: $parent
                }));
            }
        });
    }

    if (typeof acf !== 'undefined') {

        acf.add_action('append', function ($el) {

            var $submenuBlocks = jQuery(selectors.join(', '));

            if ($submenuBlocks.length) {

                $submenuBlocks.each(function () {

                    var $parent = jQuery(this).closest('[data-layout="submenu_block"]');

                    if ($parent.data('id') && !$parent.is('.acf-clone') && add_new_block($parent)) {

                        window.submenuBlocks.push(new _SubmenuBlock2.default({
                            parent: $parent
                        }));
                    }
                });
            }
        });
    }
});

/***/ }),

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _keys = __webpack_require__(47);

var _keys2 = _interopRequireDefault(_keys);

var _assign = __webpack_require__(7);

var _assign2 = _interopRequireDefault(_assign);

var _classCallCheck2 = __webpack_require__(3);

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _createClass2 = __webpack_require__(15);

var _createClass3 = _interopRequireDefault(_createClass2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/*global jQuery*/

var SubmenuBlock = function () {
    function SubmenuBlock(options) {
        (0, _classCallCheck3.default)(this, SubmenuBlock);
        this.options = {
            parent: null
        };

        this.options = (0, _assign2.default)({}, this.options, options);
        this.events();
    }

    (0, _createClass3.default)(SubmenuBlock, [{
        key: 'events',
        value: function events() {
            var _this = this;

            jQuery('select:eq(0)', this.options.parent).on('change', function (ev) {

                var menu_id = jQuery(ev.currentTarget).val();

                if (menu_id) {

                    SubmenuBlock.get_item_list(menu_id).then(function (data) {
                        var json = JSON.parse(data);

                        if (json.success) {

                            _this.build_list_options(json.result);
                        } else console.error(json);
                    });
                }
            });
        }
    }, {
        key: 'build_list_options',
        value: function build_list_options(menu_items) {

            if ((0, _keys2.default)(menu_items).length) {

                var $menu_item_select = jQuery('select:eq(1)', this.options.parent);

                $menu_item_select.find('option').remove().end().append('<option value="">Select Menu Item</option>');

                (0, _keys2.default)(menu_items).forEach(function (key) {

                    $menu_item_select.append('<option value="' + key + '">' + menu_items[key] + '</option>');
                });
            }
        }
    }], [{
        key: 'get_item_list',
        value: function get_item_list(menu_id) {
            return jQuery.get(ajaxurl, {
                action: 'acf_submenu_item_list',
                menu_id: menu_id
            });
        }
    }]);
    return SubmenuBlock;
}();

exports.default = SubmenuBlock;

/***/ }),

/***/ 47:
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(48), __esModule: true };

/***/ }),

/***/ 48:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(49);
module.exports = __webpack_require__(0).Object.keys;


/***/ }),

/***/ 49:
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.14 Object.keys(O)
var toObject = __webpack_require__(14);
var $keys = __webpack_require__(9);

__webpack_require__(50)('keys', function () {
  return function keys(it) {
    return $keys(toObject(it));
  };
});


/***/ }),

/***/ 50:
/***/ (function(module, exports, __webpack_require__) {

// most Object methods by ES6 should accept primitives
var $export = __webpack_require__(4);
var core = __webpack_require__(0);
var fails = __webpack_require__(2);
module.exports = function (KEY, exec) {
  var fn = (core.Object || {})[KEY] || Object[KEY];
  var exp = {};
  exp[KEY] = exec(fn);
  $export($export.S + $export.F * fails(function () { fn(1); }), 'Object', exp);
};


/***/ })

},[45]);
//# sourceMappingURL=module-build-submenu-blocks.js.map