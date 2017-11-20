webpackJsonp([1],{

/***/ 16:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _TestimonialPanels = __webpack_require__(17);

var _TestimonialPanels2 = _interopRequireDefault(_TestimonialPanels);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

jQuery(function () {

    var $testimonialPanels = jQuery('.component-testimonial-panels-wrap');

    if ($testimonialPanels.length) {
        new _TestimonialPanels2.default();
    }
}); /*global jQuery*/

/***/ }),

/***/ 17:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _classCallCheck2 = __webpack_require__(3);

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _Slider = __webpack_require__(18);

var _Slider2 = _interopRequireDefault(_Slider);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var TestimonialPanels = function TestimonialPanels() {
    (0, _classCallCheck3.default)(this, TestimonialPanels);

    window.sliders = window.sliders ? window.sliders : [];

    var $sliders = jQuery('.component-testimonial-panels-wrap');

    if ($sliders.length) {

        $sliders.each(function () {

            window.sliders.push(new _Slider2.default({
                parent: jQuery(this),
                slideSelector: '.slider-item',
                thumbnailSelector: '.slider-thumbnail'
            }));
        });
    }
}; /*global jQuery*/


exports.default = TestimonialPanels;

/***/ }),

/***/ 18:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _assign = __webpack_require__(7);

var _assign2 = _interopRequireDefault(_assign);

var _classCallCheck2 = __webpack_require__(3);

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _createClass2 = __webpack_require__(15);

var _createClass3 = _interopRequireDefault(_createClass2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/*global jQuery*/

var SHOW_PREV = 'prev',
    SHOW_NEXT = 'next';

var Slider = function () {
    function Slider() {
        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        (0, _classCallCheck3.default)(this, Slider);

        this.options = (0, _assign2.default)({}, Slider.defaultOptions(options), options);
        this._slides = jQuery([]);
        this._thumbnails = jQuery([]);
        this._autoSlide = false;
        this.events();
        this.autoSlide();
    }

    (0, _createClass3.default)(Slider, [{
        key: 'error',
        value: function error(message) {
            var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

            console.error(message);
            console.warn("Options:", options ? options : this.options);
        }
    }, {
        key: 'slides',
        value: function slides() {
            if (!this._slides.length && this.options.parent) this._slides = jQuery(this.options.slideSelector, this.options.parent);

            return this._slides;
        }
    }, {
        key: 'thumbnails',
        value: function thumbnails() {
            if (!this._thumbnails.length && this.options.parent && this.options.targets.thumbnail.length) {
                this._thumbnails = this.options.targets.thumbnail;
            }

            return this._thumbnails;
        }
    }, {
        key: 'events',
        value: function events() {
            var _this = this;

            //@todo Not needed right now, could be used in future component
            // if( this.options.targets.prev && this.options.targets.prev.length )
            //     this.options.targets.prev.on('click', (ev) => {
            //         ev.preventDefault();
            //         this.move( SHOW_PREV );
            //     });
            //
            // if( this.options.targets.next && this.options.targets.next.length )
            //     this.options.targets.next.on('click', (ev) => {
            //         ev.preventDefault();
            //         this.move( SHOW_NEXT );
            //     });

            if (this.options.targets.thumbnail && this.options.targets.thumbnail.length) this.options.targets.thumbnail.on('click', function (ev) {
                ev.preventDefault();

                var $thumbnail = jQuery(ev.currentTarget);

                _this.jump_to($thumbnail);
            });

            if (this.options.parent) {

                this.options.parent.on('mouseover', function () {
                    clearInterval(_this._autoSlide);
                    _this._autoSlide = false;
                });

                this.options.parent.on('mouseout', function () {

                    if (_this._autoSlide === false && _this.options.autoSlide) _this.autoSlide();
                });
            }
        }

        //@todo Not needed right now, could be used in future component
        // move(direction = SHOW_NEXT)
        // {
        //     switch ( direction )
        //     {
        //         case SHOW_NEXT:
        //             console.log("next");
        //             break;
        //         case SHOW_PREV:
        //             console.log("prev");
        //             break;
        //     }
        // }

    }, {
        key: 'jump_to',
        value: function jump_to($thumbnail) {
            var index = this.thumbnails().index($thumbnail),
                tempSlides = this.slides();

            tempSlides.filter('.current');
            tempSlides.removeClass('current');

            jQuery(this.slides()[index]).addClass('current');

            this.thumbnails().removeClass('current');
            $thumbnail.addClass('current');
        }
    }, {
        key: 'autoSlide',
        value: function autoSlide() {
            var _this2 = this;

            if (this.options.autoSlide && this.options.autoSlideDelay) {

                this._autoSlide = setInterval(function () {

                    var currentThumbnail = _this2.thumbnails().filter('.current'),
                        currentIndex = _this2.thumbnails().index(currentThumbnail),
                        nextIndex = currentIndex + 1;

                    if (nextIndex + 1 > _this2.thumbnails().length) nextIndex = 0;

                    _this2.jump_to(jQuery(_this2.thumbnails()[nextIndex]));
                }, this.options.autoSlideDelay);
            }
        }
    }], [{
        key: 'defaultOptions',
        value: function defaultOptions(options) {
            var parent = options.parent,
                prevSelector = options.prevSelector,
                nextSelector = options.nextSelector,
                thumbnailSelector = options.thumbnailSelector,
                customOptions = {};


            if (!parent) {
                this.error("Parent element is required when creating a new VC Page Builder Slider.", options);
            }

            if (typeof parent == 'string') parent = jQuery(parent);

            if (parent && parent.length) {

                customOptions.targets = {
                    prev: jQuery(prevSelector ? prevSelector : '.vc-pb-slider-prev', parent),
                    next: jQuery(nextSelector ? nextSelector : '.vc-pb-slider-next', parent),
                    thumbnail: jQuery(thumbnailSelector ? thumbnailSelector : '.vc-pb-slider-thumbnail', parent)
                };
            }

            return (0, _assign2.default)({}, {
                parent: null,
                targets: {
                    prev: null,
                    next: null
                },
                slideSelector: 'vc-pb-slide-item',
                autoSlide: true,
                autoSlideDelay: 10000
            }, customOptions);
        }
    }]);
    return Slider;
}();

exports.default = Slider;

/***/ })

},[16]);
//# sourceMappingURL=vc-page-builder-content.js.map