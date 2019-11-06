(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[7],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ManagerMyLeads.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ManagerMyLeads.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
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
  data: function data() {
    return {
      leads: [],
      processing_leads: [],
      completing_leads: [],
      canceling_leads: [],
      modalTitle: '',
      comment: '',
      lead_id: 0
    };
  },
  methods: {
    getMyLeads: function getMyLeads() {
      var _this = this;

      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/manager/my/leads').then(function (res) {
        _this.leads = res.data.data;
        _this.processing_leads = _this.leads.filter(function (x) {
          return x.m_type === '1';
        });
        _this.completing_leads = _this.leads.filter(function (x) {
          return x.m_type === '0';
        });
        _this.canceling_leads = _this.leads.filter(function (x) {
          return x.m_type === '2';
        });
        console.log(res);
      })["catch"](function (err) {
        console.log(err);
      });
    },
    completeLead: function completeLead(lead_id) {
      var _this2 = this;

      if (confirm("Вы точно хотите закрывать запрос?")) {
        axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/manager/change/lead/status', {
          lead_id: lead_id,
          process: 'complete'
        }).then(function (res) {
          _this2.getMyLeads();

          console.log(res);
        })["catch"](function (err) {
          console.log(err);
        });
      }
    },
    cancelLead: function cancelLead() {
      var _this3 = this;

      if (this.comment.length != '') {
        axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/manager/change/lead/status', {
          lead_id: this.lead_id,
          process: 'cancel',
          comment: this.comment
        }).then(function (res) {
          _this3.getMyLeads();

          console.log(res);
          $('#modal_lead').addClass('fade').modal('toggle');
        })["catch"](function (err) {
          console.log(err);
        });
      }
    },
    cancelLeadForm: function cancelLeadForm(lead_id) {
      this.modalTitle = 'ПРИЧИНА ОТКАЗА ОТ ЗАПРОСА #' + lead_id;
      this.lead_id = lead_id;
      $('#modal_lead').removeClass('fade').modal('toggle');
    },
    closeForm: function closeForm() {
      $('#modal_lead').addClass('fade').modal('toggle');
      this.comment = '';
    }
  },
  created: function created() {
    this.getMyLeads();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ManagerMyLeads.vue?vue&type=template&id=760b7bee&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ManagerMyLeads.vue?vue&type=template&id=760b7bee& ***!
  \*****************************************************************************************************************************************************************************************************************/
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
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "tab-content", attrs: { id: "myTabContent" } }, [
      _c(
        "div",
        {
          staticClass: "tab-pane fade show active",
          attrs: { id: "home", role: "tabpanel", "aria-labelledby": "home-tab" }
        },
        [
          _c(
            "table",
            { staticClass: "table leads_table table-bordered table-striped" },
            [
              _vm._m(1),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.processing_leads, function(lead) {
                  return _c("tr", { key: lead.id }, [
                    _c("td", [_vm._v(_vm._s(lead.id))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.name))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.phone))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.comment))]),
                    _vm._v(" "),
                    _c("td", [
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-primary",
                          on: {
                            click: function($event) {
                              return _vm.completeLead(lead.id)
                            }
                          }
                        },
                        [
                          _c("i", { staticClass: "fas fa-check" }),
                          _vm._v(" Выполнено")
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-danger",
                          on: {
                            click: function($event) {
                              return _vm.cancelLeadForm(lead.id)
                            }
                          }
                        },
                        [
                          _c("i", { staticClass: "fas fa-times" }),
                          _vm._v("  Отказаться")
                        ]
                      )
                    ])
                  ])
                }),
                0
              )
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "tab-pane fade",
          attrs: {
            id: "profile",
            role: "tabpanel",
            "aria-labelledby": "profile-tab"
          }
        },
        [
          _c(
            "table",
            { staticClass: "table leads_table table-bordered table-striped" },
            [
              _vm._m(2),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.completing_leads, function(lead) {
                  return _c("tr", { key: lead.id }, [
                    _c("td", [_vm._v(_vm._s(lead.id))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.name))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.phone))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.comment))])
                  ])
                }),
                0
              )
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "tab-pane fade",
          attrs: {
            id: "contact",
            role: "tabpanel",
            "aria-labelledby": "contact-tab"
          }
        },
        [
          _c(
            "table",
            { staticClass: "table leads_table table-bordered table-striped" },
            [
              _vm._m(3),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.canceling_leads, function(lead) {
                  return _c("tr", { key: lead.id }, [
                    _c("td", [_vm._v(_vm._s(lead.id))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.name))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.phone))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(lead.comment))])
                  ])
                }),
                0
              )
            ]
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "modal_lead",
          tabindex: "-1",
          role: "dialog",
          "aria-labelledby": "exampleModalCenterTitle",
          "aria-hidden": "true"
        }
      },
      [
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-dialog-centered",
            attrs: { role: "document" }
          },
          [
            _c("div", { staticClass: "modal-content" }, [
              _c("div", { staticClass: "modal-header" }, [
                _c(
                  "h5",
                  {
                    staticClass: "modal-title",
                    attrs: { id: "exampleModalLongTitle" }
                  },
                  [_vm._v(_vm._s(_vm.modalTitle))]
                ),
                _vm._v(" "),
                _vm._m(4)
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "modal-body" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-md-12" }, [
                    _vm._m(5),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group" }, [
                      _c("label", { attrs: { for: "comment_id" } }),
                      _vm._v(" "),
                      _c("textarea", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.comment,
                            expression: "comment"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { id: "comment_id", cols: "30", rows: "5" },
                        domProps: { value: _vm.comment },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.comment = $event.target.value
                          }
                        }
                      })
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "modal-footer" }, [
                _c("div", { staticClass: "col-md-6 text-right" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary",
                      on: {
                        click: function($event) {
                          return _vm.closeForm()
                        }
                      }
                    },
                    [_vm._v("Отмена")]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6 text-right" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-danger",
                      on: {
                        click: function($event) {
                          return _vm.cancelLead()
                        }
                      }
                    },
                    [_vm._v("Отказаться от запроса")]
                  )
                ])
              ])
            ])
          ]
        )
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "ul",
      { staticClass: "nav nav-tabs", attrs: { id: "myTab", role: "tablist" } },
      [
        _c("li", { staticClass: "nav-item" }, [
          _c(
            "a",
            {
              staticClass: "nav-link active",
              attrs: {
                id: "home-tab",
                "data-toggle": "tab",
                href: "#home",
                role: "tab",
                "aria-controls": "home",
                "aria-selected": "true"
              }
            },
            [_vm._v("В процессе")]
          )
        ]),
        _vm._v(" "),
        _c("li", { staticClass: "nav-item" }, [
          _c(
            "a",
            {
              staticClass: "nav-link",
              attrs: {
                id: "profile-tab",
                "data-toggle": "tab",
                href: "#profile",
                role: "tab",
                "aria-controls": "profile",
                "aria-selected": "false"
              }
            },
            [_vm._v("Обработанные")]
          )
        ]),
        _vm._v(" "),
        _c("li", { staticClass: "nav-item" }, [
          _c(
            "a",
            {
              staticClass: "nav-link",
              attrs: {
                id: "contact-tab",
                "data-toggle": "tab",
                href: "#contact",
                role: "tab",
                "aria-controls": "contact",
                "aria-selected": "false"
              }
            },
            [_vm._v("Необработанные")]
          )
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead-light" }, [
      _c("th", { attrs: { width: "100" } }, [_vm._v("Дата")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "150" } }, [_vm._v("Имя")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "150" } }, [_vm._v("Тел")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "250" } }, [_vm._v("Комментарии")]),
      _vm._v(" "),
      _c("th", [_vm._v("Действие")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead-light" }, [
      _c("th", { attrs: { width: "100" } }, [_vm._v("Дата")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "150" } }, [_vm._v("Имя")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "150" } }, [_vm._v("Тел")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "250" } }, [_vm._v("Комментарии")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead-light" }, [
      _c("th", { attrs: { width: "100" } }, [_vm._v("Дата")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "150" } }, [_vm._v("Имя")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "150" } }, [_vm._v("Тел")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "250" } }, [_vm._v("Комментарии")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "close",
        attrs: {
          type: "button",
          "data-dismiss": "modal",
          "aria-label": "Close"
        }
      },
      [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c("p", [
        _vm._v(
          "Этот запрос будет обработан Колл - Центром! В связи с этим просим Вас описать причину отказа в разделе комментарий."
        )
      ])
    ])
  }
]
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
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
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

/***/ "./resources/js/components/ManagerMyLeads.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/ManagerMyLeads.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ManagerMyLeads_vue_vue_type_template_id_760b7bee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ManagerMyLeads.vue?vue&type=template&id=760b7bee& */ "./resources/js/components/ManagerMyLeads.vue?vue&type=template&id=760b7bee&");
/* harmony import */ var _ManagerMyLeads_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ManagerMyLeads.vue?vue&type=script&lang=js& */ "./resources/js/components/ManagerMyLeads.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ManagerMyLeads_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ManagerMyLeads_vue_vue_type_template_id_760b7bee___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ManagerMyLeads_vue_vue_type_template_id_760b7bee___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ManagerMyLeads.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/ManagerMyLeads.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/ManagerMyLeads.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ManagerMyLeads_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./ManagerMyLeads.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ManagerMyLeads.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ManagerMyLeads_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ManagerMyLeads.vue?vue&type=template&id=760b7bee&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/ManagerMyLeads.vue?vue&type=template&id=760b7bee& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ManagerMyLeads_vue_vue_type_template_id_760b7bee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./ManagerMyLeads.vue?vue&type=template&id=760b7bee& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ManagerMyLeads.vue?vue&type=template&id=760b7bee&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ManagerMyLeads_vue_vue_type_template_id_760b7bee___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ManagerMyLeads_vue_vue_type_template_id_760b7bee___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);