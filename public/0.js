(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _graph_SmallGraph__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./graph/SmallGraph */ "./resources/js/components/graph/SmallGraph.vue");
/* harmony import */ var _graph_LineGraph__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./graph/LineGraph */ "./resources/js/components/graph/LineGraph.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Dashboard",
  components: {
    SmallGraph: _graph_SmallGraph__WEBPACK_IMPORTED_MODULE_0__["default"],
    LineGraph: _graph_LineGraph__WEBPACK_IMPORTED_MODULE_1__["default"]
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/graph/LineGraph.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/graph/LineGraph.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
!(function webpackMissingModule() { var e = new Error("Cannot find module '../../mixin/colorHelper'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["id", "title", "labels", "datasets"],
  mixins: [!(function webpackMissingModule() { var e = new Error("Cannot find module '../../mixin/colorHelper'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())],
  data: function data() {
    return {
      labelsChart: ['January', 'February', 'March', 'April', 'May', 'June'],
      dataChart: [{
        name: 'Accepted',
        data: [20, 13, 48, 78, 40, 90]
      }, {
        name: 'Pending',
        data: [70, 6, 90, 84, 5, 60]
      }, {
        name: 'Declined',
        data: [70, 80, 120, 72, 70, 50]
      }]
    };
  },
  mounted: function mounted() {
    var app = this;
    var series = app.dataChart;
    Highcharts.setOptions({
      colors: ['#A3A1FB', '#54d8ff', '#ff5454', '#ffbc07', '#909db7', '#9DFCFF', '#FFD59D', '#FC46FC']
    });
    var seriesData = series.map(function (serie) {
      return {
        name: serie.name,
        data: serie.data.map(function (d) {
          return parseInt(d);
        }),
        fillColor: {
          linearGradient: [0, 0, 0, 300],
          stops: [[0, Highcharts.getOptions().colors[series.indexOf(serie)]], [1, Highcharts.Color(Highcharts.getOptions().colors[series.indexOf(serie)]).setOpacity(0).get('rgba')]]
        },
        marker: {
          symbol: 'circle'
        }
      };
    });
    var options = {
      chart: {
        type: 'areaspline',
        style: {
          fontFamily: 'Poppins, Avenir'
        },
        width: null
      },
      title: {
        text: null
      },
      xAxis: {
        categories: app.labelsChart
      },
      yAxis: {
        title: {
          text: null
        }
      },
      tooltip: {
        shared: true //valuePrefix: prefix + ' '

      },
      credits: {
        enabled: false
      },
      plotOptions: {
        areaspline: {
          fillOpacity: 0.5,
          pointPlacement: 'on'
        },
        marker: {
          symbol: 'circle'
        },
        column: {
          pointPadding: 0.2,
          borderWidth: 0
        },
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: false
          },
          showInLegend: true
        }
      },
      series: seriesData
    };
    Highcharts.chart(app.$props.id, options);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/graph/SmallGraph.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/graph/SmallGraph.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      dataChart: [12, 31, 27, 36, 65, 42, 76, 23, 19, 37, 16],
      color: '#62dbfe'
    };
  },
  props: ["id", "title", "data", "type"],
  mounted: function mounted() {
    var app = this;
    var options = {
      chart: {
        type: 'column',
        style: {
          fontFamily: 'Poppins, Avenir'
        },
        width: null
      },
      title: {
        text: null
      },
      xAxis: {
        categories: null,
        labels: {
          enabled: false
        },
        gridLineWidth: 0,
        lineWidth: 0,
        tickWidth: 0
      },
      yAxis: {
        title: {
          text: null
        },
        labels: {
          enabled: false
        },
        gridLineWidth: 0,
        minorGridLineWidth: 0,
        startOnTick: false,
        endOnTick: false,
        tickPositions: [],
        lineWidth: 0,
        tickWidth: 0,
        visible: false
      },
      tooltip: {
        shared: true
      },
      credits: {
        enabled: false
      },
      legend: {
        enabled: false
      },
      plotOptions: {
        areaspline: {
          fillOpacity: 0.5
        },
        marker: {
          symbol: 'circle'
        },
        column: {
          pointPadding: 0.2,
          borderWidth: 0,
          groupPadding: 0
        },
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: false
          },
          showInLegend: true
        }
      },
      series: [{
        name: null,
        data: app.dataChart.map(function (d) {
          return parseInt(d);
        }),
        color: app.color,
        fillColor: {
          linearGradient: [0, 0, 0, 300],
          stops: [[0, app.color], [1, Highcharts.Color(app.color).setOpacity(0).get('rgba')]]
        }
      }]
    };
    Highcharts.chart(app.$props.id, options);
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "w-100 p-3" }, [
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-4" }, [
      _c("div", { staticClass: "col-md-12" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-4 mb-3" }, [
            _c(
              "div",
              { staticClass: "unicef-card unicef-dashboard-menu p-4" },
              [
                _c("h5", [_vm._v("Forms")]),
                _vm._v(" "),
                _c("div", { staticClass: "unicef-menu-values" }, [
                  _c("div", { staticClass: "row" }, [
                    _vm._m(1),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-md-5" }, [
                      _c(
                        "div",
                        { staticClass: "unicef-menu-chart" },
                        [
                          _c("SmallGraph", {
                            attrs: {
                              width: "100%",
                              id: "bar1",
                              color: "#54d8ff"
                            }
                          })
                        ],
                        1
                      )
                    ])
                  ])
                ])
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4 mb-3" }, [
            _c(
              "div",
              { staticClass: "unicef-card unicef-dashboard-menu p-4" },
              [
                _c("h5", [_vm._v("Data")]),
                _vm._v(" "),
                _c("div", { staticClass: "unicef-menu-values" }, [
                  _c("div", { staticClass: "row" }, [
                    _vm._m(2),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-md-5" }, [
                      _c(
                        "div",
                        { staticClass: "unicef-menu-chart" },
                        [
                          _c("SmallGraph", {
                            attrs: {
                              width: "100%",
                              id: "bar2",
                              color: "#54d8ff"
                            }
                          })
                        ],
                        1
                      )
                    ])
                  ])
                ])
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4 mb-3" }, [
            _c(
              "div",
              { staticClass: "unicef-card unicef-dashboard-menu p-4" },
              [
                _c("h5", [_vm._v("Users")]),
                _vm._v(" "),
                _c("div", { staticClass: "unicef-menu-values" }, [
                  _c("div", { staticClass: "row" }, [
                    _vm._m(3),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-md-5" }, [
                      _c(
                        "div",
                        { staticClass: "unicef-menu-chart" },
                        [
                          _c("SmallGraph", {
                            attrs: {
                              width: "100%",
                              id: "bar3",
                              color: "#54d8ff"
                            }
                          })
                        ],
                        1
                      )
                    ])
                  ])
                ])
              ]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-12" }, [
        _c("div", { staticClass: "row mt-4" }, [
          _c("div", { staticClass: "col-md-7 mb-3" }, [
            _c(
              "div",
              { staticClass: "unicef-card unicef-dashboard-menu p-4" },
              [
                _c("h3", { staticStyle: { "font-size": "17px" } }, [
                  _vm._v("Created Forms")
                ]),
                _vm._v(" "),
                _c("LineGraph", {
                  staticClass: "mt-3",
                  attrs: { id: "graph-trend", width: "100%", height: "320px" }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _vm._m(4)
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "container-fliud" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-6 col-lg-6 col-sm-12" }, [
          _c("h5", { staticStyle: { float: "left" } }, [
            _vm._v("Forms Manager")
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-6 col-lg-6 col-sm-12" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary",
              staticStyle: { float: "right" },
              attrs: { type: "button" }
            },
            [_vm._v("New Form")]
          )
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-7" }, [
      _c("h2", [_vm._v("32")]),
      _vm._v(" "),
      _c("p", { staticClass: "red" }, [
        _c("i", { staticClass: "fas fa-long-arrow-alt-down" }),
        _c("span", [_vm._v("13.8%")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-7" }, [
      _c("h2", [_vm._v("230")]),
      _vm._v(" "),
      _c("p", { staticClass: "green" }, [
        _c("i", { staticClass: "fas fa-long-arrow-alt-up" }),
        _c("span", [_vm._v("13.8%")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-7" }, [
      _c("h2", [_vm._v("21")]),
      _vm._v(" "),
      _c("p", { staticClass: "red" }, [
        _c("i", { staticClass: "fas fa-long-arrow-alt-down" }),
        _c("span", [_vm._v("13.8%")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-5" }, [
      _c(
        "select",
        {
          staticClass: "form-control custom-select",
          attrs: { name: "#", id: "#" }
        },
        [
          _c("option", { attrs: { value: "30" } }, [_vm._v("Last 30 days")]),
          _vm._v(" "),
          _c("option", { attrs: { value: "6" } }, [_vm._v("Last 6 months")]),
          _vm._v(" "),
          _c("option", { attrs: { value: "12" } }, [_vm._v("Last 12 months")])
        ]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/graph/LineGraph.vue?vue&type=template&id=69cc661e&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/graph/LineGraph.vue?vue&type=template&id=69cc661e& ***!
  \******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", {
      staticClass: "mt-3",
      staticStyle: { width: "100%", height: "340px" },
      attrs: { id: _vm.id }
    })
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/graph/SmallGraph.vue?vue&type=template&id=ad35db5a&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/graph/SmallGraph.vue?vue&type=template&id=ad35db5a& ***!
  \*******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", {
      staticStyle: { width: "100%", height: "60px" },
      attrs: { id: _vm.id }
    })
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/components/Dashboard.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/Dashboard.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Dashboard_vue_vue_type_template_id_040e2ab9_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=template&id=040e2ab9&scoped=true& */ "./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9&scoped=true&");
/* harmony import */ var _Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=script&lang=js& */ "./resources/js/components/Dashboard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Dashboard_vue_vue_type_template_id_040e2ab9_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Dashboard_vue_vue_type_template_id_040e2ab9_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "040e2ab9",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Dashboard.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Dashboard.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/components/Dashboard.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Dashboard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9&scoped=true&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9&scoped=true& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_040e2ab9_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Dashboard.vue?vue&type=template&id=040e2ab9&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard.vue?vue&type=template&id=040e2ab9&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_040e2ab9_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_040e2ab9_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/graph/LineGraph.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/graph/LineGraph.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _LineGraph_vue_vue_type_template_id_69cc661e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LineGraph.vue?vue&type=template&id=69cc661e& */ "./resources/js/components/graph/LineGraph.vue?vue&type=template&id=69cc661e&");
/* harmony import */ var _LineGraph_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./LineGraph.vue?vue&type=script&lang=js& */ "./resources/js/components/graph/LineGraph.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _LineGraph_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _LineGraph_vue_vue_type_template_id_69cc661e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _LineGraph_vue_vue_type_template_id_69cc661e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/graph/LineGraph.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/graph/LineGraph.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/graph/LineGraph.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LineGraph_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./LineGraph.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/graph/LineGraph.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LineGraph_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/graph/LineGraph.vue?vue&type=template&id=69cc661e&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/graph/LineGraph.vue?vue&type=template&id=69cc661e& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LineGraph_vue_vue_type_template_id_69cc661e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./LineGraph.vue?vue&type=template&id=69cc661e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/graph/LineGraph.vue?vue&type=template&id=69cc661e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LineGraph_vue_vue_type_template_id_69cc661e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LineGraph_vue_vue_type_template_id_69cc661e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/graph/SmallGraph.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/graph/SmallGraph.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SmallGraph_vue_vue_type_template_id_ad35db5a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SmallGraph.vue?vue&type=template&id=ad35db5a& */ "./resources/js/components/graph/SmallGraph.vue?vue&type=template&id=ad35db5a&");
/* harmony import */ var _SmallGraph_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SmallGraph.vue?vue&type=script&lang=js& */ "./resources/js/components/graph/SmallGraph.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SmallGraph_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SmallGraph_vue_vue_type_template_id_ad35db5a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SmallGraph_vue_vue_type_template_id_ad35db5a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/graph/SmallGraph.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/graph/SmallGraph.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/graph/SmallGraph.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SmallGraph_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./SmallGraph.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/graph/SmallGraph.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SmallGraph_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/graph/SmallGraph.vue?vue&type=template&id=ad35db5a&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/graph/SmallGraph.vue?vue&type=template&id=ad35db5a& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SmallGraph_vue_vue_type_template_id_ad35db5a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./SmallGraph.vue?vue&type=template&id=ad35db5a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/graph/SmallGraph.vue?vue&type=template&id=ad35db5a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SmallGraph_vue_vue_type_template_id_ad35db5a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SmallGraph_vue_vue_type_template_id_ad35db5a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);