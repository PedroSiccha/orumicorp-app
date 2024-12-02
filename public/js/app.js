// /******/ (() => { // webpackBootstrap
// /******/ 	var __webpack_modules__ = ({

// /***/ "./node_modules/@popperjs/core/lib/createPopper.js":
// /*!*********************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/createPopper.js ***!
//   \*********************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   createPopper: () => (/* binding */ createPopper),
// /* harmony export */   detectOverflow: () => (/* reexport safe */ _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_8__["default"]),
// /* harmony export */   popperGenerator: () => (/* binding */ popperGenerator)
// /* harmony export */ });
// /* harmony import */ var _dom_utils_getCompositeRect_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./dom-utils/getCompositeRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getCompositeRect.js");
// /* harmony import */ var _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./dom-utils/getLayoutRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js");
// /* harmony import */ var _dom_utils_listScrollParents_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dom-utils/listScrollParents.js */ "./node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js");
// /* harmony import */ var _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./dom-utils/getOffsetParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
// /* harmony import */ var _utils_orderModifiers_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./utils/orderModifiers.js */ "./node_modules/@popperjs/core/lib/utils/orderModifiers.js");
// /* harmony import */ var _utils_debounce_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./utils/debounce.js */ "./node_modules/@popperjs/core/lib/utils/debounce.js");
// /* harmony import */ var _utils_mergeByName_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./utils/mergeByName.js */ "./node_modules/@popperjs/core/lib/utils/mergeByName.js");
// /* harmony import */ var _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./utils/detectOverflow.js */ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js");
// /* harmony import */ var _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dom-utils/instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");









// var DEFAULT_OPTIONS = {
//   placement: 'bottom',
//   modifiers: [],
//   strategy: 'absolute'
// };

// function areValidElements() {
//   for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
//     args[_key] = arguments[_key];
//   }

//   return !args.some(function (element) {
//     return !(element && typeof element.getBoundingClientRect === 'function');
//   });
// }

// function popperGenerator(generatorOptions) {
//   if (generatorOptions === void 0) {
//     generatorOptions = {};
//   }

//   var _generatorOptions = generatorOptions,
//       _generatorOptions$def = _generatorOptions.defaultModifiers,
//       defaultModifiers = _generatorOptions$def === void 0 ? [] : _generatorOptions$def,
//       _generatorOptions$def2 = _generatorOptions.defaultOptions,
//       defaultOptions = _generatorOptions$def2 === void 0 ? DEFAULT_OPTIONS : _generatorOptions$def2;
//   return function createPopper(reference, popper, options) {
//     if (options === void 0) {
//       options = defaultOptions;
//     }

//     var state = {
//       placement: 'bottom',
//       orderedModifiers: [],
//       options: Object.assign({}, DEFAULT_OPTIONS, defaultOptions),
//       modifiersData: {},
//       elements: {
//         reference: reference,
//         popper: popper
//       },
//       attributes: {},
//       styles: {}
//     };
//     var effectCleanupFns = [];
//     var isDestroyed = false;
//     var instance = {
//       state: state,
//       setOptions: function setOptions(setOptionsAction) {
//         var options = typeof setOptionsAction === 'function' ? setOptionsAction(state.options) : setOptionsAction;
//         cleanupModifierEffects();
//         state.options = Object.assign({}, defaultOptions, state.options, options);
//         state.scrollParents = {
//           reference: (0,_dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isElement)(reference) ? (0,_dom_utils_listScrollParents_js__WEBPACK_IMPORTED_MODULE_1__["default"])(reference) : reference.contextElement ? (0,_dom_utils_listScrollParents_js__WEBPACK_IMPORTED_MODULE_1__["default"])(reference.contextElement) : [],
//           popper: (0,_dom_utils_listScrollParents_js__WEBPACK_IMPORTED_MODULE_1__["default"])(popper)
//         }; // Orders the modifiers based on their dependencies and `phase`
//         // properties

//         var orderedModifiers = (0,_utils_orderModifiers_js__WEBPACK_IMPORTED_MODULE_2__["default"])((0,_utils_mergeByName_js__WEBPACK_IMPORTED_MODULE_3__["default"])([].concat(defaultModifiers, state.options.modifiers))); // Strip out disabled modifiers

//         state.orderedModifiers = orderedModifiers.filter(function (m) {
//           return m.enabled;
//         });
//         runModifierEffects();
//         return instance.update();
//       },
//       // Sync update – it will always be executed, even if not necessary. This
//       // is useful for low frequency updates where sync behavior simplifies the
//       // logic.
//       // For high frequency updates (e.g. `resize` and `scroll` events), always
//       // prefer the async Popper#update method
//       forceUpdate: function forceUpdate() {
//         if (isDestroyed) {
//           return;
//         }

//         var _state$elements = state.elements,
//             reference = _state$elements.reference,
//             popper = _state$elements.popper; // Don't proceed if `reference` or `popper` are not valid elements
//         // anymore

//         if (!areValidElements(reference, popper)) {
//           return;
//         } // Store the reference and popper rects to be read by modifiers


//         state.rects = {
//           reference: (0,_dom_utils_getCompositeRect_js__WEBPACK_IMPORTED_MODULE_4__["default"])(reference, (0,_dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_5__["default"])(popper), state.options.strategy === 'fixed'),
//           popper: (0,_dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_6__["default"])(popper)
//         }; // Modifiers have the ability to reset the current update cycle. The
//         // most common use case for this is the `flip` modifier changing the
//         // placement, which then needs to re-run all the modifiers, because the
//         // logic was previously ran for the previous placement and is therefore
//         // stale/incorrect

//         state.reset = false;
//         state.placement = state.options.placement; // On each update cycle, the `modifiersData` property for each modifier
//         // is filled with the initial data specified by the modifier. This means
//         // it doesn't persist and is fresh on each update.
//         // To ensure persistent data, use `${name}#persistent`

//         state.orderedModifiers.forEach(function (modifier) {
//           return state.modifiersData[modifier.name] = Object.assign({}, modifier.data);
//         });

//         for (var index = 0; index < state.orderedModifiers.length; index++) {
//           if (state.reset === true) {
//             state.reset = false;
//             index = -1;
//             continue;
//           }

//           var _state$orderedModifie = state.orderedModifiers[index],
//               fn = _state$orderedModifie.fn,
//               _state$orderedModifie2 = _state$orderedModifie.options,
//               _options = _state$orderedModifie2 === void 0 ? {} : _state$orderedModifie2,
//               name = _state$orderedModifie.name;

//           if (typeof fn === 'function') {
//             state = fn({
//               state: state,
//               options: _options,
//               name: name,
//               instance: instance
//             }) || state;
//           }
//         }
//       },
//       // Async and optimistically optimized update – it will not be executed if
//       // not necessary (debounced to run at most once-per-tick)
//       update: (0,_utils_debounce_js__WEBPACK_IMPORTED_MODULE_7__["default"])(function () {
//         return new Promise(function (resolve) {
//           instance.forceUpdate();
//           resolve(state);
//         });
//       }),
//       destroy: function destroy() {
//         cleanupModifierEffects();
//         isDestroyed = true;
//       }
//     };

//     if (!areValidElements(reference, popper)) {
//       return instance;
//     }

//     instance.setOptions(options).then(function (state) {
//       if (!isDestroyed && options.onFirstUpdate) {
//         options.onFirstUpdate(state);
//       }
//     }); // Modifiers have the ability to execute arbitrary code before the first
//     // update cycle runs. They will be executed in the same order as the update
//     // cycle. This is useful when a modifier adds some persistent data that
//     // other modifiers need to use, but the modifier is run after the dependent
//     // one.

//     function runModifierEffects() {
//       state.orderedModifiers.forEach(function (_ref) {
//         var name = _ref.name,
//             _ref$options = _ref.options,
//             options = _ref$options === void 0 ? {} : _ref$options,
//             effect = _ref.effect;

//         if (typeof effect === 'function') {
//           var cleanupFn = effect({
//             state: state,
//             name: name,
//             instance: instance,
//             options: options
//           });

//           var noopFn = function noopFn() {};

//           effectCleanupFns.push(cleanupFn || noopFn);
//         }
//       });
//     }

//     function cleanupModifierEffects() {
//       effectCleanupFns.forEach(function (fn) {
//         return fn();
//       });
//       effectCleanupFns = [];
//     }

//     return instance;
//   };
// }
// var createPopper = /*#__PURE__*/popperGenerator(); // eslint-disable-next-line import/no-unused-modules



// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/contains.js":
// /*!***************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/contains.js ***!
//   \***************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ contains)
// /* harmony export */ });
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");

// function contains(parent, child) {
//   var rootNode = child.getRootNode && child.getRootNode(); // First, attempt with faster native method

//   if (parent.contains(child)) {
//     return true;
//   } // then fallback to custom implementation with Shadow DOM support
//   else if (rootNode && (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isShadowRoot)(rootNode)) {
//       var next = child;

//       do {
//         if (next && parent.isSameNode(next)) {
//           return true;
//         } // $FlowFixMe[prop-missing]: need a better way to handle this...


//         next = next.parentNode || next.host;
//       } while (next);
//     } // Give up, the result is false


//   return false;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js":
// /*!****************************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js ***!
//   \****************************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getBoundingClientRect)
// /* harmony export */ });
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
// /* harmony import */ var _utils_math_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/math.js */ "./node_modules/@popperjs/core/lib/utils/math.js");
// /* harmony import */ var _getWindow_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
// /* harmony import */ var _isLayoutViewport_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./isLayoutViewport.js */ "./node_modules/@popperjs/core/lib/dom-utils/isLayoutViewport.js");




// function getBoundingClientRect(element, includeScale, isFixedStrategy) {
//   if (includeScale === void 0) {
//     includeScale = false;
//   }

//   if (isFixedStrategy === void 0) {
//     isFixedStrategy = false;
//   }

//   var clientRect = element.getBoundingClientRect();
//   var scaleX = 1;
//   var scaleY = 1;

//   if (includeScale && (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element)) {
//     scaleX = element.offsetWidth > 0 ? (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_1__.round)(clientRect.width) / element.offsetWidth || 1 : 1;
//     scaleY = element.offsetHeight > 0 ? (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_1__.round)(clientRect.height) / element.offsetHeight || 1 : 1;
//   }

//   var _ref = (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isElement)(element) ? (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_2__["default"])(element) : window,
//       visualViewport = _ref.visualViewport;

//   var addVisualOffsets = !(0,_isLayoutViewport_js__WEBPACK_IMPORTED_MODULE_3__["default"])() && isFixedStrategy;
//   var x = (clientRect.left + (addVisualOffsets && visualViewport ? visualViewport.offsetLeft : 0)) / scaleX;
//   var y = (clientRect.top + (addVisualOffsets && visualViewport ? visualViewport.offsetTop : 0)) / scaleY;
//   var width = clientRect.width / scaleX;
//   var height = clientRect.height / scaleY;
//   return {
//     width: width,
//     height: height,
//     top: y,
//     right: x + width,
//     bottom: y + height,
//     left: x,
//     x: x,
//     y: y
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getClippingRect.js":
// /*!**********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getClippingRect.js ***!
//   \**********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getClippingRect)
// /* harmony export */ });
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
// /* harmony import */ var _getViewportRect_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getViewportRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getViewportRect.js");
// /* harmony import */ var _getDocumentRect_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./getDocumentRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentRect.js");
// /* harmony import */ var _listScrollParents_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./listScrollParents.js */ "./node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js");
// /* harmony import */ var _getOffsetParent_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./getOffsetParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
// /* harmony import */ var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./getDocumentElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
// /* harmony import */ var _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./getComputedStyle.js */ "./node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
// /* harmony import */ var _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getBoundingClientRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
// /* harmony import */ var _getParentNode_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./getParentNode.js */ "./node_modules/@popperjs/core/lib/dom-utils/getParentNode.js");
// /* harmony import */ var _contains_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./contains.js */ "./node_modules/@popperjs/core/lib/dom-utils/contains.js");
// /* harmony import */ var _getNodeName_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./getNodeName.js */ "./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
// /* harmony import */ var _utils_rectToClientRect_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/rectToClientRect.js */ "./node_modules/@popperjs/core/lib/utils/rectToClientRect.js");
// /* harmony import */ var _utils_math_js__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ../utils/math.js */ "./node_modules/@popperjs/core/lib/utils/math.js");















// function getInnerBoundingClientRect(element, strategy) {
//   var rect = (0,_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element, false, strategy === 'fixed');
//   rect.top = rect.top + element.clientTop;
//   rect.left = rect.left + element.clientLeft;
//   rect.bottom = rect.top + element.clientHeight;
//   rect.right = rect.left + element.clientWidth;
//   rect.width = element.clientWidth;
//   rect.height = element.clientHeight;
//   rect.x = rect.left;
//   rect.y = rect.top;
//   return rect;
// }

// function getClientRectFromMixedType(element, clippingParent, strategy) {
//   return clippingParent === _enums_js__WEBPACK_IMPORTED_MODULE_1__.viewport ? (0,_utils_rectToClientRect_js__WEBPACK_IMPORTED_MODULE_2__["default"])((0,_getViewportRect_js__WEBPACK_IMPORTED_MODULE_3__["default"])(element, strategy)) : (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isElement)(clippingParent) ? getInnerBoundingClientRect(clippingParent, strategy) : (0,_utils_rectToClientRect_js__WEBPACK_IMPORTED_MODULE_2__["default"])((0,_getDocumentRect_js__WEBPACK_IMPORTED_MODULE_5__["default"])((0,_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_6__["default"])(element)));
// } // A "clipping parent" is an overflowable container with the characteristic of
// // clipping (or hiding) overflowing elements with a position different from
// // `initial`


// function getClippingParents(element) {
//   var clippingParents = (0,_listScrollParents_js__WEBPACK_IMPORTED_MODULE_7__["default"])((0,_getParentNode_js__WEBPACK_IMPORTED_MODULE_8__["default"])(element));
//   var canEscapeClipping = ['absolute', 'fixed'].indexOf((0,_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_9__["default"])(element).position) >= 0;
//   var clipperElement = canEscapeClipping && (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isHTMLElement)(element) ? (0,_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_10__["default"])(element) : element;

//   if (!(0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isElement)(clipperElement)) {
//     return [];
//   } // $FlowFixMe[incompatible-return]: https://github.com/facebook/flow/issues/1414


//   return clippingParents.filter(function (clippingParent) {
//     return (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isElement)(clippingParent) && (0,_contains_js__WEBPACK_IMPORTED_MODULE_11__["default"])(clippingParent, clipperElement) && (0,_getNodeName_js__WEBPACK_IMPORTED_MODULE_12__["default"])(clippingParent) !== 'body';
//   });
// } // Gets the maximum area that the element is visible in due to any number of
// // clipping parents


// function getClippingRect(element, boundary, rootBoundary, strategy) {
//   var mainClippingParents = boundary === 'clippingParents' ? getClippingParents(element) : [].concat(boundary);
//   var clippingParents = [].concat(mainClippingParents, [rootBoundary]);
//   var firstClippingParent = clippingParents[0];
//   var clippingRect = clippingParents.reduce(function (accRect, clippingParent) {
//     var rect = getClientRectFromMixedType(element, clippingParent, strategy);
//     accRect.top = (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_13__.max)(rect.top, accRect.top);
//     accRect.right = (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_13__.min)(rect.right, accRect.right);
//     accRect.bottom = (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_13__.min)(rect.bottom, accRect.bottom);
//     accRect.left = (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_13__.max)(rect.left, accRect.left);
//     return accRect;
//   }, getClientRectFromMixedType(element, firstClippingParent, strategy));
//   clippingRect.width = clippingRect.right - clippingRect.left;
//   clippingRect.height = clippingRect.bottom - clippingRect.top;
//   clippingRect.x = clippingRect.left;
//   clippingRect.y = clippingRect.top;
//   return clippingRect;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getCompositeRect.js":
// /*!***********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getCompositeRect.js ***!
//   \***********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getCompositeRect)
// /* harmony export */ });
// /* harmony import */ var _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getBoundingClientRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
// /* harmony import */ var _getNodeScroll_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./getNodeScroll.js */ "./node_modules/@popperjs/core/lib/dom-utils/getNodeScroll.js");
// /* harmony import */ var _getNodeName_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./getNodeName.js */ "./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
// /* harmony import */ var _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./getWindowScrollBarX.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js");
// /* harmony import */ var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./getDocumentElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
// /* harmony import */ var _isScrollParent_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./isScrollParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js");
// /* harmony import */ var _utils_math_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/math.js */ "./node_modules/@popperjs/core/lib/utils/math.js");









// function isElementScaled(element) {
//   var rect = element.getBoundingClientRect();
//   var scaleX = (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_0__.round)(rect.width) / element.offsetWidth || 1;
//   var scaleY = (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_0__.round)(rect.height) / element.offsetHeight || 1;
//   return scaleX !== 1 || scaleY !== 1;
// } // Returns the composite rect of an element relative to its offsetParent.
// // Composite means it takes into account transforms as well as layout.


// function getCompositeRect(elementOrVirtualElement, offsetParent, isFixed) {
//   if (isFixed === void 0) {
//     isFixed = false;
//   }

//   var isOffsetParentAnElement = (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(offsetParent);
//   var offsetParentIsScaled = (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(offsetParent) && isElementScaled(offsetParent);
//   var documentElement = (0,_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(offsetParent);
//   var rect = (0,_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_3__["default"])(elementOrVirtualElement, offsetParentIsScaled, isFixed);
//   var scroll = {
//     scrollLeft: 0,
//     scrollTop: 0
//   };
//   var offsets = {
//     x: 0,
//     y: 0
//   };

//   if (isOffsetParentAnElement || !isOffsetParentAnElement && !isFixed) {
//     if ((0,_getNodeName_js__WEBPACK_IMPORTED_MODULE_4__["default"])(offsetParent) !== 'body' || // https://github.com/popperjs/popper-core/issues/1078
//     (0,_isScrollParent_js__WEBPACK_IMPORTED_MODULE_5__["default"])(documentElement)) {
//       scroll = (0,_getNodeScroll_js__WEBPACK_IMPORTED_MODULE_6__["default"])(offsetParent);
//     }

//     if ((0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(offsetParent)) {
//       offsets = (0,_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_3__["default"])(offsetParent, true);
//       offsets.x += offsetParent.clientLeft;
//       offsets.y += offsetParent.clientTop;
//     } else if (documentElement) {
//       offsets.x = (0,_getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_7__["default"])(documentElement);
//     }
//   }

//   return {
//     x: rect.left + scroll.scrollLeft - offsets.x,
//     y: rect.top + scroll.scrollTop - offsets.y,
//     width: rect.width,
//     height: rect.height
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js":
// /*!***********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js ***!
//   \***********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getComputedStyle)
// /* harmony export */ });
// /* harmony import */ var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");

// function getComputedStyle(element) {
//   return (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element).getComputedStyle(element);
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js":
// /*!*************************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js ***!
//   \*************************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getDocumentElement)
// /* harmony export */ });
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");

// function getDocumentElement(element) {
//   // $FlowFixMe[incompatible-return]: assume body is always available
//   return (((0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isElement)(element) ? element.ownerDocument : // $FlowFixMe[prop-missing]
//   element.document) || window.document).documentElement;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentRect.js":
// /*!**********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getDocumentRect.js ***!
//   \**********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getDocumentRect)
// /* harmony export */ });
// /* harmony import */ var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getDocumentElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
// /* harmony import */ var _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./getComputedStyle.js */ "./node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
// /* harmony import */ var _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getWindowScrollBarX.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js");
// /* harmony import */ var _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getWindowScroll.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js");
// /* harmony import */ var _utils_math_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/math.js */ "./node_modules/@popperjs/core/lib/utils/math.js");




//  // Gets the entire size of the scrollable document area, even extending outside
// // of the `<html>` and `<body>` rect bounds if horizontally scrollable

// function getDocumentRect(element) {
//   var _element$ownerDocumen;

//   var html = (0,_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element);
//   var winScroll = (0,_getWindowScroll_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element);
//   var body = (_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body;
//   var width = (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_2__.max)(html.scrollWidth, html.clientWidth, body ? body.scrollWidth : 0, body ? body.clientWidth : 0);
//   var height = (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_2__.max)(html.scrollHeight, html.clientHeight, body ? body.scrollHeight : 0, body ? body.clientHeight : 0);
//   var x = -winScroll.scrollLeft + (0,_getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_3__["default"])(element);
//   var y = -winScroll.scrollTop;

//   if ((0,_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_4__["default"])(body || html).direction === 'rtl') {
//     x += (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_2__.max)(html.clientWidth, body ? body.clientWidth : 0) - width;
//   }

//   return {
//     width: width,
//     height: height,
//     x: x,
//     y: y
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getHTMLElementScroll.js":
// /*!***************************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getHTMLElementScroll.js ***!
//   \***************************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getHTMLElementScroll)
// /* harmony export */ });
// function getHTMLElementScroll(element) {
//   return {
//     scrollLeft: element.scrollLeft,
//     scrollTop: element.scrollTop
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js":
// /*!********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js ***!
//   \********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getLayoutRect)
// /* harmony export */ });
// /* harmony import */ var _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getBoundingClientRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
//  // Returns the layout rect of an element relative to its offsetParent. Layout
// // means it doesn't take into account transforms.

// function getLayoutRect(element) {
//   var clientRect = (0,_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element); // Use the clientRect sizes if it's not been transformed.
//   // Fixes https://github.com/popperjs/popper-core/issues/1223

//   var width = element.offsetWidth;
//   var height = element.offsetHeight;

//   if (Math.abs(clientRect.width - width) <= 1) {
//     width = clientRect.width;
//   }

//   if (Math.abs(clientRect.height - height) <= 1) {
//     height = clientRect.height;
//   }

//   return {
//     x: element.offsetLeft,
//     y: element.offsetTop,
//     width: width,
//     height: height
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js":
// /*!******************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js ***!
//   \******************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getNodeName)
// /* harmony export */ });
// function getNodeName(element) {
//   return element ? (element.nodeName || '').toLowerCase() : null;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getNodeScroll.js":
// /*!********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getNodeScroll.js ***!
//   \********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getNodeScroll)
// /* harmony export */ });
// /* harmony import */ var _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./getWindowScroll.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js");
// /* harmony import */ var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
// /* harmony import */ var _getHTMLElementScroll_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getHTMLElementScroll.js */ "./node_modules/@popperjs/core/lib/dom-utils/getHTMLElementScroll.js");




// function getNodeScroll(node) {
//   if (node === (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node) || !(0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(node)) {
//     return (0,_getWindowScroll_js__WEBPACK_IMPORTED_MODULE_2__["default"])(node);
//   } else {
//     return (0,_getHTMLElementScroll_js__WEBPACK_IMPORTED_MODULE_3__["default"])(node);
//   }
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js":
// /*!**********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js ***!
//   \**********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getOffsetParent)
// /* harmony export */ });
// /* harmony import */ var _getWindow_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
// /* harmony import */ var _getNodeName_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./getNodeName.js */ "./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
// /* harmony import */ var _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getComputedStyle.js */ "./node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
// /* harmony import */ var _isTableElement_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./isTableElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/isTableElement.js");
// /* harmony import */ var _getParentNode_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getParentNode.js */ "./node_modules/@popperjs/core/lib/dom-utils/getParentNode.js");
// /* harmony import */ var _utils_userAgent_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/userAgent.js */ "./node_modules/@popperjs/core/lib/utils/userAgent.js");








// function getTrueOffsetParent(element) {
//   if (!(0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element) || // https://github.com/popperjs/popper-core/issues/837
//   (0,_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element).position === 'fixed') {
//     return null;
//   }

//   return element.offsetParent;
// } // `.offsetParent` reports `null` for fixed elements, while absolute elements
// // return the containing block


// function getContainingBlock(element) {
//   var isFirefox = /firefox/i.test((0,_utils_userAgent_js__WEBPACK_IMPORTED_MODULE_2__["default"])());
//   var isIE = /Trident/i.test((0,_utils_userAgent_js__WEBPACK_IMPORTED_MODULE_2__["default"])());

//   if (isIE && (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element)) {
//     // In IE 9, 10 and 11 fixed elements containing block is always established by the viewport
//     var elementCss = (0,_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element);

//     if (elementCss.position === 'fixed') {
//       return null;
//     }
//   }

//   var currentNode = (0,_getParentNode_js__WEBPACK_IMPORTED_MODULE_3__["default"])(element);

//   if ((0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isShadowRoot)(currentNode)) {
//     currentNode = currentNode.host;
//   }

//   while ((0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(currentNode) && ['html', 'body'].indexOf((0,_getNodeName_js__WEBPACK_IMPORTED_MODULE_4__["default"])(currentNode)) < 0) {
//     var css = (0,_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(currentNode); // This is non-exhaustive but covers the most common CSS properties that
//     // create a containing block.
//     // https://developer.mozilla.org/en-US/docs/Web/CSS/Containing_block#identifying_the_containing_block

//     if (css.transform !== 'none' || css.perspective !== 'none' || css.contain === 'paint' || ['transform', 'perspective'].indexOf(css.willChange) !== -1 || isFirefox && css.willChange === 'filter' || isFirefox && css.filter && css.filter !== 'none') {
//       return currentNode;
//     } else {
//       currentNode = currentNode.parentNode;
//     }
//   }

//   return null;
// } // Gets the closest ancestor positioned element. Handles some edge cases,
// // such as table ancestors and cross browser bugs.


// function getOffsetParent(element) {
//   var window = (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_5__["default"])(element);
//   var offsetParent = getTrueOffsetParent(element);

//   while (offsetParent && (0,_isTableElement_js__WEBPACK_IMPORTED_MODULE_6__["default"])(offsetParent) && (0,_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(offsetParent).position === 'static') {
//     offsetParent = getTrueOffsetParent(offsetParent);
//   }

//   if (offsetParent && ((0,_getNodeName_js__WEBPACK_IMPORTED_MODULE_4__["default"])(offsetParent) === 'html' || (0,_getNodeName_js__WEBPACK_IMPORTED_MODULE_4__["default"])(offsetParent) === 'body' && (0,_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(offsetParent).position === 'static')) {
//     return window;
//   }

//   return offsetParent || getContainingBlock(element) || window;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getParentNode.js":
// /*!********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getParentNode.js ***!
//   \********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getParentNode)
// /* harmony export */ });
// /* harmony import */ var _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getNodeName.js */ "./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
// /* harmony import */ var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./getDocumentElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");



// function getParentNode(element) {
//   if ((0,_getNodeName_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element) === 'html') {
//     return element;
//   }

//   return (// this is a quicker (but less type safe) way to save quite some bytes from the bundle
//     // $FlowFixMe[incompatible-return]
//     // $FlowFixMe[prop-missing]
//     element.assignedSlot || // step into the shadow DOM of the parent of a slotted node
//     element.parentNode || ( // DOM Element detected
//     (0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isShadowRoot)(element) ? element.host : null) || // ShadowRoot detected
//     // $FlowFixMe[incompatible-call]: HTMLElement is a Node
//     (0,_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(element) // fallback

//   );
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getScrollParent.js":
// /*!**********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getScrollParent.js ***!
//   \**********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getScrollParent)
// /* harmony export */ });
// /* harmony import */ var _getParentNode_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getParentNode.js */ "./node_modules/@popperjs/core/lib/dom-utils/getParentNode.js");
// /* harmony import */ var _isScrollParent_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./isScrollParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js");
// /* harmony import */ var _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getNodeName.js */ "./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
// /* harmony import */ var _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");




// function getScrollParent(node) {
//   if (['html', 'body', '#document'].indexOf((0,_getNodeName_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node)) >= 0) {
//     // $FlowFixMe[incompatible-return]: assume body is always available
//     return node.ownerDocument.body;
//   }

//   if ((0,_instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(node) && (0,_isScrollParent_js__WEBPACK_IMPORTED_MODULE_2__["default"])(node)) {
//     return node;
//   }

//   return getScrollParent((0,_getParentNode_js__WEBPACK_IMPORTED_MODULE_3__["default"])(node));
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getViewportRect.js":
// /*!**********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getViewportRect.js ***!
//   \**********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getViewportRect)
// /* harmony export */ });
// /* harmony import */ var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
// /* harmony import */ var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getDocumentElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
// /* harmony import */ var _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getWindowScrollBarX.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js");
// /* harmony import */ var _isLayoutViewport_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./isLayoutViewport.js */ "./node_modules/@popperjs/core/lib/dom-utils/isLayoutViewport.js");




// function getViewportRect(element, strategy) {
//   var win = (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element);
//   var html = (0,_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element);
//   var visualViewport = win.visualViewport;
//   var width = html.clientWidth;
//   var height = html.clientHeight;
//   var x = 0;
//   var y = 0;

//   if (visualViewport) {
//     width = visualViewport.width;
//     height = visualViewport.height;
//     var layoutViewport = (0,_isLayoutViewport_js__WEBPACK_IMPORTED_MODULE_2__["default"])();

//     if (layoutViewport || !layoutViewport && strategy === 'fixed') {
//       x = visualViewport.offsetLeft;
//       y = visualViewport.offsetTop;
//     }
//   }

//   return {
//     width: width,
//     height: height,
//     x: x + (0,_getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_3__["default"])(element),
//     y: y
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js":
// /*!****************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getWindow.js ***!
//   \****************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getWindow)
// /* harmony export */ });
// function getWindow(node) {
//   if (node == null) {
//     return window;
//   }

//   if (node.toString() !== '[object Window]') {
//     var ownerDocument = node.ownerDocument;
//     return ownerDocument ? ownerDocument.defaultView || window : window;
//   }

//   return node;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js":
// /*!**********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js ***!
//   \**********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getWindowScroll)
// /* harmony export */ });
// /* harmony import */ var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");

// function getWindowScroll(node) {
//   var win = (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node);
//   var scrollLeft = win.pageXOffset;
//   var scrollTop = win.pageYOffset;
//   return {
//     scrollLeft: scrollLeft,
//     scrollTop: scrollTop
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js":
// /*!**************************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js ***!
//   \**************************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getWindowScrollBarX)
// /* harmony export */ });
// /* harmony import */ var _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getBoundingClientRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
// /* harmony import */ var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getDocumentElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
// /* harmony import */ var _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./getWindowScroll.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js");



// function getWindowScrollBarX(element) {
//   // If <html> has a CSS width greater than the viewport, then this will be
//   // incorrect for RTL.
//   // Popper 1 is broken in this case and never had a bug report so let's assume
//   // it's not an issue. I don't think anyone ever specifies width on <html>
//   // anyway.
//   // Browsers where the left scrollbar doesn't cause an issue report `0` for
//   // this (e.g. Edge 2019, IE11, Safari)
//   return (0,_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__["default"])((0,_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element)).left + (0,_getWindowScroll_js__WEBPACK_IMPORTED_MODULE_2__["default"])(element).scrollLeft;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js":
// /*!*****************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js ***!
//   \*****************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   isElement: () => (/* binding */ isElement),
// /* harmony export */   isHTMLElement: () => (/* binding */ isHTMLElement),
// /* harmony export */   isShadowRoot: () => (/* binding */ isShadowRoot)
// /* harmony export */ });
// /* harmony import */ var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");


// function isElement(node) {
//   var OwnElement = (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node).Element;
//   return node instanceof OwnElement || node instanceof Element;
// }

// function isHTMLElement(node) {
//   var OwnElement = (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node).HTMLElement;
//   return node instanceof OwnElement || node instanceof HTMLElement;
// }

// function isShadowRoot(node) {
//   // IE 11 has no ShadowRoot
//   if (typeof ShadowRoot === 'undefined') {
//     return false;
//   }

//   var OwnElement = (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node).ShadowRoot;
//   return node instanceof OwnElement || node instanceof ShadowRoot;
// }



// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/isLayoutViewport.js":
// /*!***********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/isLayoutViewport.js ***!
//   \***********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ isLayoutViewport)
// /* harmony export */ });
// /* harmony import */ var _utils_userAgent_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/userAgent.js */ "./node_modules/@popperjs/core/lib/utils/userAgent.js");

// function isLayoutViewport() {
//   return !/^((?!chrome|android).)*safari/i.test((0,_utils_userAgent_js__WEBPACK_IMPORTED_MODULE_0__["default"])());
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js":
// /*!*********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js ***!
//   \*********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ isScrollParent)
// /* harmony export */ });
// /* harmony import */ var _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getComputedStyle.js */ "./node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");

// function isScrollParent(element) {
//   // Firefox wants us to check `-x` and `-y` variations as well
//   var _getComputedStyle = (0,_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element),
//       overflow = _getComputedStyle.overflow,
//       overflowX = _getComputedStyle.overflowX,
//       overflowY = _getComputedStyle.overflowY;

//   return /auto|scroll|overlay|hidden/.test(overflow + overflowY + overflowX);
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/isTableElement.js":
// /*!*********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/isTableElement.js ***!
//   \*********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ isTableElement)
// /* harmony export */ });
// /* harmony import */ var _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getNodeName.js */ "./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");

// function isTableElement(element) {
//   return ['table', 'td', 'th'].indexOf((0,_getNodeName_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element)) >= 0;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js":
// /*!************************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js ***!
//   \************************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ listScrollParents)
// /* harmony export */ });
// /* harmony import */ var _getScrollParent_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getScrollParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/getScrollParent.js");
// /* harmony import */ var _getParentNode_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getParentNode.js */ "./node_modules/@popperjs/core/lib/dom-utils/getParentNode.js");
// /* harmony import */ var _getWindow_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
// /* harmony import */ var _isScrollParent_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./isScrollParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js");




// /*
// given a DOM element, return the list of all scroll parents, up the list of ancesors
// until we get to the top window object. This list is what we attach scroll listeners
// to, because if any of these parent elements scroll, we'll need to re-calculate the
// reference element's position.
// */

// function listScrollParents(element, list) {
//   var _element$ownerDocumen;

//   if (list === void 0) {
//     list = [];
//   }

//   var scrollParent = (0,_getScrollParent_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element);
//   var isBody = scrollParent === ((_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body);
//   var win = (0,_getWindow_js__WEBPACK_IMPORTED_MODULE_1__["default"])(scrollParent);
//   var target = isBody ? [win].concat(win.visualViewport || [], (0,_isScrollParent_js__WEBPACK_IMPORTED_MODULE_2__["default"])(scrollParent) ? scrollParent : []) : scrollParent;
//   var updatedList = list.concat(target);
//   return isBody ? updatedList : // $FlowFixMe[incompatible-call]: isBody tells us target will be an HTMLElement here
//   updatedList.concat(listScrollParents((0,_getParentNode_js__WEBPACK_IMPORTED_MODULE_3__["default"])(target)));
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/enums.js":
// /*!**************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/enums.js ***!
//   \**************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   afterMain: () => (/* binding */ afterMain),
// /* harmony export */   afterRead: () => (/* binding */ afterRead),
// /* harmony export */   afterWrite: () => (/* binding */ afterWrite),
// /* harmony export */   auto: () => (/* binding */ auto),
// /* harmony export */   basePlacements: () => (/* binding */ basePlacements),
// /* harmony export */   beforeMain: () => (/* binding */ beforeMain),
// /* harmony export */   beforeRead: () => (/* binding */ beforeRead),
// /* harmony export */   beforeWrite: () => (/* binding */ beforeWrite),
// /* harmony export */   bottom: () => (/* binding */ bottom),
// /* harmony export */   clippingParents: () => (/* binding */ clippingParents),
// /* harmony export */   end: () => (/* binding */ end),
// /* harmony export */   left: () => (/* binding */ left),
// /* harmony export */   main: () => (/* binding */ main),
// /* harmony export */   modifierPhases: () => (/* binding */ modifierPhases),
// /* harmony export */   placements: () => (/* binding */ placements),
// /* harmony export */   popper: () => (/* binding */ popper),
// /* harmony export */   read: () => (/* binding */ read),
// /* harmony export */   reference: () => (/* binding */ reference),
// /* harmony export */   right: () => (/* binding */ right),
// /* harmony export */   start: () => (/* binding */ start),
// /* harmony export */   top: () => (/* binding */ top),
// /* harmony export */   variationPlacements: () => (/* binding */ variationPlacements),
// /* harmony export */   viewport: () => (/* binding */ viewport),
// /* harmony export */   write: () => (/* binding */ write)
// /* harmony export */ });
// var top = 'top';
// var bottom = 'bottom';
// var right = 'right';
// var left = 'left';
// var auto = 'auto';
// var basePlacements = [top, bottom, right, left];
// var start = 'start';
// var end = 'end';
// var clippingParents = 'clippingParents';
// var viewport = 'viewport';
// var popper = 'popper';
// var reference = 'reference';
// var variationPlacements = /*#__PURE__*/basePlacements.reduce(function (acc, placement) {
//   return acc.concat([placement + "-" + start, placement + "-" + end]);
// }, []);
// var placements = /*#__PURE__*/[].concat(basePlacements, [auto]).reduce(function (acc, placement) {
//   return acc.concat([placement, placement + "-" + start, placement + "-" + end]);
// }, []); // modifiers that need to read the DOM

// var beforeRead = 'beforeRead';
// var read = 'read';
// var afterRead = 'afterRead'; // pure-logic modifiers

// var beforeMain = 'beforeMain';
// var main = 'main';
// var afterMain = 'afterMain'; // modifier with the purpose to write to the DOM (or write into a framework state)

// var beforeWrite = 'beforeWrite';
// var write = 'write';
// var afterWrite = 'afterWrite';
// var modifierPhases = [beforeRead, read, afterRead, beforeMain, main, afterMain, beforeWrite, write, afterWrite];

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/index.js":
// /*!**************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/index.js ***!
//   \**************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   afterMain: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.afterMain),
// /* harmony export */   afterRead: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.afterRead),
// /* harmony export */   afterWrite: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.afterWrite),
// /* harmony export */   applyStyles: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.applyStyles),
// /* harmony export */   arrow: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.arrow),
// /* harmony export */   auto: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.auto),
// /* harmony export */   basePlacements: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.basePlacements),
// /* harmony export */   beforeMain: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.beforeMain),
// /* harmony export */   beforeRead: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.beforeRead),
// /* harmony export */   beforeWrite: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.beforeWrite),
// /* harmony export */   bottom: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.bottom),
// /* harmony export */   clippingParents: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.clippingParents),
// /* harmony export */   computeStyles: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.computeStyles),
// /* harmony export */   createPopper: () => (/* reexport safe */ _popper_js__WEBPACK_IMPORTED_MODULE_4__.createPopper),
// /* harmony export */   createPopperBase: () => (/* reexport safe */ _createPopper_js__WEBPACK_IMPORTED_MODULE_2__.createPopper),
// /* harmony export */   createPopperLite: () => (/* reexport safe */ _popper_lite_js__WEBPACK_IMPORTED_MODULE_5__.createPopper),
// /* harmony export */   detectOverflow: () => (/* reexport safe */ _createPopper_js__WEBPACK_IMPORTED_MODULE_3__["default"]),
// /* harmony export */   end: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.end),
// /* harmony export */   eventListeners: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.eventListeners),
// /* harmony export */   flip: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.flip),
// /* harmony export */   hide: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.hide),
// /* harmony export */   left: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.left),
// /* harmony export */   main: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.main),
// /* harmony export */   modifierPhases: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.modifierPhases),
// /* harmony export */   offset: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.offset),
// /* harmony export */   placements: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.placements),
// /* harmony export */   popper: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper),
// /* harmony export */   popperGenerator: () => (/* reexport safe */ _createPopper_js__WEBPACK_IMPORTED_MODULE_2__.popperGenerator),
// /* harmony export */   popperOffsets: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.popperOffsets),
// /* harmony export */   preventOverflow: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.preventOverflow),
// /* harmony export */   read: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.read),
// /* harmony export */   reference: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.reference),
// /* harmony export */   right: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.right),
// /* harmony export */   start: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.start),
// /* harmony export */   top: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.top),
// /* harmony export */   variationPlacements: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.variationPlacements),
// /* harmony export */   viewport: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.viewport),
// /* harmony export */   write: () => (/* reexport safe */ _enums_js__WEBPACK_IMPORTED_MODULE_0__.write)
// /* harmony export */ });
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
// /* harmony import */ var _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modifiers/index.js */ "./node_modules/@popperjs/core/lib/modifiers/index.js");
// /* harmony import */ var _createPopper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./createPopper.js */ "./node_modules/@popperjs/core/lib/createPopper.js");
// /* harmony import */ var _createPopper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./createPopper.js */ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js");
// /* harmony import */ var _popper_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./popper.js */ "./node_modules/@popperjs/core/lib/popper.js");
// /* harmony import */ var _popper_lite_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./popper-lite.js */ "./node_modules/@popperjs/core/lib/popper-lite.js");

//  // eslint-disable-next-line import/no-unused-modules

//  // eslint-disable-next-line import/no-unused-modules

//  // eslint-disable-next-line import/no-unused-modules



// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/applyStyles.js":
// /*!******************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/applyStyles.js ***!
//   \******************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
// /* harmony export */ });
// /* harmony import */ var _dom_utils_getNodeName_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../dom-utils/getNodeName.js */ "./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
// /* harmony import */ var _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../dom-utils/instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");

//  // This modifier takes the styles prepared by the `computeStyles` modifier
// // and applies them to the HTMLElements such as popper and arrow

// function applyStyles(_ref) {
//   var state = _ref.state;
//   Object.keys(state.elements).forEach(function (name) {
//     var style = state.styles[name] || {};
//     var attributes = state.attributes[name] || {};
//     var element = state.elements[name]; // arrow is optional + virtual elements

//     if (!(0,_dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element) || !(0,_dom_utils_getNodeName_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element)) {
//       return;
//     } // Flow doesn't support to extend this property, but it's the most
//     // effective way to apply styles to an HTMLElement
//     // $FlowFixMe[cannot-write]


//     Object.assign(element.style, style);
//     Object.keys(attributes).forEach(function (name) {
//       var value = attributes[name];

//       if (value === false) {
//         element.removeAttribute(name);
//       } else {
//         element.setAttribute(name, value === true ? '' : value);
//       }
//     });
//   });
// }

// function effect(_ref2) {
//   var state = _ref2.state;
//   var initialStyles = {
//     popper: {
//       position: state.options.strategy,
//       left: '0',
//       top: '0',
//       margin: '0'
//     },
//     arrow: {
//       position: 'absolute'
//     },
//     reference: {}
//   };
//   Object.assign(state.elements.popper.style, initialStyles.popper);
//   state.styles = initialStyles;

//   if (state.elements.arrow) {
//     Object.assign(state.elements.arrow.style, initialStyles.arrow);
//   }

//   return function () {
//     Object.keys(state.elements).forEach(function (name) {
//       var element = state.elements[name];
//       var attributes = state.attributes[name] || {};
//       var styleProperties = Object.keys(state.styles.hasOwnProperty(name) ? state.styles[name] : initialStyles[name]); // Set all values to an empty string to unset them

//       var style = styleProperties.reduce(function (style, property) {
//         style[property] = '';
//         return style;
//       }, {}); // arrow is optional + virtual elements

//       if (!(0,_dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element) || !(0,_dom_utils_getNodeName_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element)) {
//         return;
//       }

//       Object.assign(element.style, style);
//       Object.keys(attributes).forEach(function (attribute) {
//         element.removeAttribute(attribute);
//       });
//     });
//   };
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'applyStyles',
//   enabled: true,
//   phase: 'write',
//   fn: applyStyles,
//   effect: effect,
//   requires: ['computeStyles']
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/arrow.js":
// /*!************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/arrow.js ***!
//   \************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
// /* harmony export */ });
// /* harmony import */ var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../utils/getBasePlacement.js */ "./node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
// /* harmony import */ var _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../dom-utils/getLayoutRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js");
// /* harmony import */ var _dom_utils_contains_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../dom-utils/contains.js */ "./node_modules/@popperjs/core/lib/dom-utils/contains.js");
// /* harmony import */ var _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../dom-utils/getOffsetParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
// /* harmony import */ var _utils_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../utils/getMainAxisFromPlacement.js */ "./node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js");
// /* harmony import */ var _utils_within_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../utils/within.js */ "./node_modules/@popperjs/core/lib/utils/within.js");
// /* harmony import */ var _utils_mergePaddingObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/mergePaddingObject.js */ "./node_modules/@popperjs/core/lib/utils/mergePaddingObject.js");
// /* harmony import */ var _utils_expandToHashMap_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/expandToHashMap.js */ "./node_modules/@popperjs/core/lib/utils/expandToHashMap.js");
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");








//  // eslint-disable-next-line import/no-unused-modules

// var toPaddingObject = function toPaddingObject(padding, state) {
//   padding = typeof padding === 'function' ? padding(Object.assign({}, state.rects, {
//     placement: state.placement
//   })) : padding;
//   return (0,_utils_mergePaddingObject_js__WEBPACK_IMPORTED_MODULE_0__["default"])(typeof padding !== 'number' ? padding : (0,_utils_expandToHashMap_js__WEBPACK_IMPORTED_MODULE_1__["default"])(padding, _enums_js__WEBPACK_IMPORTED_MODULE_2__.basePlacements));
// };

// function arrow(_ref) {
//   var _state$modifiersData$;

//   var state = _ref.state,
//       name = _ref.name,
//       options = _ref.options;
//   var arrowElement = state.elements.arrow;
//   var popperOffsets = state.modifiersData.popperOffsets;
//   var basePlacement = (0,_utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(state.placement);
//   var axis = (0,_utils_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_4__["default"])(basePlacement);
//   var isVertical = [_enums_js__WEBPACK_IMPORTED_MODULE_2__.left, _enums_js__WEBPACK_IMPORTED_MODULE_2__.right].indexOf(basePlacement) >= 0;
//   var len = isVertical ? 'height' : 'width';

//   if (!arrowElement || !popperOffsets) {
//     return;
//   }

//   var paddingObject = toPaddingObject(options.padding, state);
//   var arrowRect = (0,_dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_5__["default"])(arrowElement);
//   var minProp = axis === 'y' ? _enums_js__WEBPACK_IMPORTED_MODULE_2__.top : _enums_js__WEBPACK_IMPORTED_MODULE_2__.left;
//   var maxProp = axis === 'y' ? _enums_js__WEBPACK_IMPORTED_MODULE_2__.bottom : _enums_js__WEBPACK_IMPORTED_MODULE_2__.right;
//   var endDiff = state.rects.reference[len] + state.rects.reference[axis] - popperOffsets[axis] - state.rects.popper[len];
//   var startDiff = popperOffsets[axis] - state.rects.reference[axis];
//   var arrowOffsetParent = (0,_dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_6__["default"])(arrowElement);
//   var clientSize = arrowOffsetParent ? axis === 'y' ? arrowOffsetParent.clientHeight || 0 : arrowOffsetParent.clientWidth || 0 : 0;
//   var centerToReference = endDiff / 2 - startDiff / 2; // Make sure the arrow doesn't overflow the popper if the center point is
//   // outside of the popper bounds

//   var min = paddingObject[minProp];
//   var max = clientSize - arrowRect[len] - paddingObject[maxProp];
//   var center = clientSize / 2 - arrowRect[len] / 2 + centerToReference;
//   var offset = (0,_utils_within_js__WEBPACK_IMPORTED_MODULE_7__.within)(min, center, max); // Prevents breaking syntax highlighting...

//   var axisProp = axis;
//   state.modifiersData[name] = (_state$modifiersData$ = {}, _state$modifiersData$[axisProp] = offset, _state$modifiersData$.centerOffset = offset - center, _state$modifiersData$);
// }

// function effect(_ref2) {
//   var state = _ref2.state,
//       options = _ref2.options;
//   var _options$element = options.element,
//       arrowElement = _options$element === void 0 ? '[data-popper-arrow]' : _options$element;

//   if (arrowElement == null) {
//     return;
//   } // CSS selector


//   if (typeof arrowElement === 'string') {
//     arrowElement = state.elements.popper.querySelector(arrowElement);

//     if (!arrowElement) {
//       return;
//     }
//   }

//   if (!(0,_dom_utils_contains_js__WEBPACK_IMPORTED_MODULE_8__["default"])(state.elements.popper, arrowElement)) {
//     return;
//   }

//   state.elements.arrow = arrowElement;
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'arrow',
//   enabled: true,
//   phase: 'main',
//   fn: arrow,
//   effect: effect,
//   requires: ['popperOffsets'],
//   requiresIfExists: ['preventOverflow']
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/computeStyles.js":
// /*!********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/computeStyles.js ***!
//   \********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
// /* harmony export */   mapToStyles: () => (/* binding */ mapToStyles)
// /* harmony export */ });
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
// /* harmony import */ var _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../dom-utils/getOffsetParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
// /* harmony import */ var _dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../dom-utils/getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
// /* harmony import */ var _dom_utils_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../dom-utils/getDocumentElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
// /* harmony import */ var _dom_utils_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../dom-utils/getComputedStyle.js */ "./node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
// /* harmony import */ var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../utils/getBasePlacement.js */ "./node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
// /* harmony import */ var _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../utils/getVariation.js */ "./node_modules/@popperjs/core/lib/utils/getVariation.js");
// /* harmony import */ var _utils_math_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/math.js */ "./node_modules/@popperjs/core/lib/utils/math.js");







//  // eslint-disable-next-line import/no-unused-modules

// var unsetSides = {
//   top: 'auto',
//   right: 'auto',
//   bottom: 'auto',
//   left: 'auto'
// }; // Round the offsets to the nearest suitable subpixel based on the DPR.
// // Zooming can change the DPR, but it seems to report a value that will
// // cleanly divide the values into the appropriate subpixels.

// function roundOffsetsByDPR(_ref, win) {
//   var x = _ref.x,
//       y = _ref.y;
//   var dpr = win.devicePixelRatio || 1;
//   return {
//     x: (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_0__.round)(x * dpr) / dpr || 0,
//     y: (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_0__.round)(y * dpr) / dpr || 0
//   };
// }

// function mapToStyles(_ref2) {
//   var _Object$assign2;

//   var popper = _ref2.popper,
//       popperRect = _ref2.popperRect,
//       placement = _ref2.placement,
//       variation = _ref2.variation,
//       offsets = _ref2.offsets,
//       position = _ref2.position,
//       gpuAcceleration = _ref2.gpuAcceleration,
//       adaptive = _ref2.adaptive,
//       roundOffsets = _ref2.roundOffsets,
//       isFixed = _ref2.isFixed;
//   var _offsets$x = offsets.x,
//       x = _offsets$x === void 0 ? 0 : _offsets$x,
//       _offsets$y = offsets.y,
//       y = _offsets$y === void 0 ? 0 : _offsets$y;

//   var _ref3 = typeof roundOffsets === 'function' ? roundOffsets({
//     x: x,
//     y: y
//   }) : {
//     x: x,
//     y: y
//   };

//   x = _ref3.x;
//   y = _ref3.y;
//   var hasX = offsets.hasOwnProperty('x');
//   var hasY = offsets.hasOwnProperty('y');
//   var sideX = _enums_js__WEBPACK_IMPORTED_MODULE_1__.left;
//   var sideY = _enums_js__WEBPACK_IMPORTED_MODULE_1__.top;
//   var win = window;

//   if (adaptive) {
//     var offsetParent = (0,_dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_2__["default"])(popper);
//     var heightProp = 'clientHeight';
//     var widthProp = 'clientWidth';

//     if (offsetParent === (0,_dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_3__["default"])(popper)) {
//       offsetParent = (0,_dom_utils_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_4__["default"])(popper);

//       if ((0,_dom_utils_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_5__["default"])(offsetParent).position !== 'static' && position === 'absolute') {
//         heightProp = 'scrollHeight';
//         widthProp = 'scrollWidth';
//       }
//     } // $FlowFixMe[incompatible-cast]: force type refinement, we compare offsetParent with window above, but Flow doesn't detect it


//     offsetParent = offsetParent;

//     if (placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.top || (placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.left || placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.right) && variation === _enums_js__WEBPACK_IMPORTED_MODULE_1__.end) {
//       sideY = _enums_js__WEBPACK_IMPORTED_MODULE_1__.bottom;
//       var offsetY = isFixed && offsetParent === win && win.visualViewport ? win.visualViewport.height : // $FlowFixMe[prop-missing]
//       offsetParent[heightProp];
//       y -= offsetY - popperRect.height;
//       y *= gpuAcceleration ? 1 : -1;
//     }

//     if (placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.left || (placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.top || placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.bottom) && variation === _enums_js__WEBPACK_IMPORTED_MODULE_1__.end) {
//       sideX = _enums_js__WEBPACK_IMPORTED_MODULE_1__.right;
//       var offsetX = isFixed && offsetParent === win && win.visualViewport ? win.visualViewport.width : // $FlowFixMe[prop-missing]
//       offsetParent[widthProp];
//       x -= offsetX - popperRect.width;
//       x *= gpuAcceleration ? 1 : -1;
//     }
//   }

//   var commonStyles = Object.assign({
//     position: position
//   }, adaptive && unsetSides);

//   var _ref4 = roundOffsets === true ? roundOffsetsByDPR({
//     x: x,
//     y: y
//   }, (0,_dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_3__["default"])(popper)) : {
//     x: x,
//     y: y
//   };

//   x = _ref4.x;
//   y = _ref4.y;

//   if (gpuAcceleration) {
//     var _Object$assign;

//     return Object.assign({}, commonStyles, (_Object$assign = {}, _Object$assign[sideY] = hasY ? '0' : '', _Object$assign[sideX] = hasX ? '0' : '', _Object$assign.transform = (win.devicePixelRatio || 1) <= 1 ? "translate(" + x + "px, " + y + "px)" : "translate3d(" + x + "px, " + y + "px, 0)", _Object$assign));
//   }

//   return Object.assign({}, commonStyles, (_Object$assign2 = {}, _Object$assign2[sideY] = hasY ? y + "px" : '', _Object$assign2[sideX] = hasX ? x + "px" : '', _Object$assign2.transform = '', _Object$assign2));
// }

// function computeStyles(_ref5) {
//   var state = _ref5.state,
//       options = _ref5.options;
//   var _options$gpuAccelerat = options.gpuAcceleration,
//       gpuAcceleration = _options$gpuAccelerat === void 0 ? true : _options$gpuAccelerat,
//       _options$adaptive = options.adaptive,
//       adaptive = _options$adaptive === void 0 ? true : _options$adaptive,
//       _options$roundOffsets = options.roundOffsets,
//       roundOffsets = _options$roundOffsets === void 0 ? true : _options$roundOffsets;
//   var commonStyles = {
//     placement: (0,_utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_6__["default"])(state.placement),
//     variation: (0,_utils_getVariation_js__WEBPACK_IMPORTED_MODULE_7__["default"])(state.placement),
//     popper: state.elements.popper,
//     popperRect: state.rects.popper,
//     gpuAcceleration: gpuAcceleration,
//     isFixed: state.options.strategy === 'fixed'
//   };

//   if (state.modifiersData.popperOffsets != null) {
//     state.styles.popper = Object.assign({}, state.styles.popper, mapToStyles(Object.assign({}, commonStyles, {
//       offsets: state.modifiersData.popperOffsets,
//       position: state.options.strategy,
//       adaptive: adaptive,
//       roundOffsets: roundOffsets
//     })));
//   }

//   if (state.modifiersData.arrow != null) {
//     state.styles.arrow = Object.assign({}, state.styles.arrow, mapToStyles(Object.assign({}, commonStyles, {
//       offsets: state.modifiersData.arrow,
//       position: 'absolute',
//       adaptive: false,
//       roundOffsets: roundOffsets
//     })));
//   }

//   state.attributes.popper = Object.assign({}, state.attributes.popper, {
//     'data-popper-placement': state.placement
//   });
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'computeStyles',
//   enabled: true,
//   phase: 'beforeWrite',
//   fn: computeStyles,
//   data: {}
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/eventListeners.js":
// /*!*********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/eventListeners.js ***!
//   \*********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
// /* harmony export */ });
// /* harmony import */ var _dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../dom-utils/getWindow.js */ "./node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
//  // eslint-disable-next-line import/no-unused-modules

// var passive = {
//   passive: true
// };

// function effect(_ref) {
//   var state = _ref.state,
//       instance = _ref.instance,
//       options = _ref.options;
//   var _options$scroll = options.scroll,
//       scroll = _options$scroll === void 0 ? true : _options$scroll,
//       _options$resize = options.resize,
//       resize = _options$resize === void 0 ? true : _options$resize;
//   var window = (0,_dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(state.elements.popper);
//   var scrollParents = [].concat(state.scrollParents.reference, state.scrollParents.popper);

//   if (scroll) {
//     scrollParents.forEach(function (scrollParent) {
//       scrollParent.addEventListener('scroll', instance.update, passive);
//     });
//   }

//   if (resize) {
//     window.addEventListener('resize', instance.update, passive);
//   }

//   return function () {
//     if (scroll) {
//       scrollParents.forEach(function (scrollParent) {
//         scrollParent.removeEventListener('scroll', instance.update, passive);
//       });
//     }

//     if (resize) {
//       window.removeEventListener('resize', instance.update, passive);
//     }
//   };
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'eventListeners',
//   enabled: true,
//   phase: 'write',
//   fn: function fn() {},
//   effect: effect,
//   data: {}
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/flip.js":
// /*!***********************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/flip.js ***!
//   \***********************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
// /* harmony export */ });
// /* harmony import */ var _utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/getOppositePlacement.js */ "./node_modules/@popperjs/core/lib/utils/getOppositePlacement.js");
// /* harmony import */ var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/getBasePlacement.js */ "./node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
// /* harmony import */ var _utils_getOppositeVariationPlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../utils/getOppositeVariationPlacement.js */ "./node_modules/@popperjs/core/lib/utils/getOppositeVariationPlacement.js");
// /* harmony import */ var _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../utils/detectOverflow.js */ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js");
// /* harmony import */ var _utils_computeAutoPlacement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../utils/computeAutoPlacement.js */ "./node_modules/@popperjs/core/lib/utils/computeAutoPlacement.js");
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
// /* harmony import */ var _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../utils/getVariation.js */ "./node_modules/@popperjs/core/lib/utils/getVariation.js");






//  // eslint-disable-next-line import/no-unused-modules

// function getExpandedFallbackPlacements(placement) {
//   if ((0,_utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement) === _enums_js__WEBPACK_IMPORTED_MODULE_1__.auto) {
//     return [];
//   }

//   var oppositePlacement = (0,_utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(placement);
//   return [(0,_utils_getOppositeVariationPlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(placement), oppositePlacement, (0,_utils_getOppositeVariationPlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(oppositePlacement)];
// }

// function flip(_ref) {
//   var state = _ref.state,
//       options = _ref.options,
//       name = _ref.name;

//   if (state.modifiersData[name]._skip) {
//     return;
//   }

//   var _options$mainAxis = options.mainAxis,
//       checkMainAxis = _options$mainAxis === void 0 ? true : _options$mainAxis,
//       _options$altAxis = options.altAxis,
//       checkAltAxis = _options$altAxis === void 0 ? true : _options$altAxis,
//       specifiedFallbackPlacements = options.fallbackPlacements,
//       padding = options.padding,
//       boundary = options.boundary,
//       rootBoundary = options.rootBoundary,
//       altBoundary = options.altBoundary,
//       _options$flipVariatio = options.flipVariations,
//       flipVariations = _options$flipVariatio === void 0 ? true : _options$flipVariatio,
//       allowedAutoPlacements = options.allowedAutoPlacements;
//   var preferredPlacement = state.options.placement;
//   var basePlacement = (0,_utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(preferredPlacement);
//   var isBasePlacement = basePlacement === preferredPlacement;
//   var fallbackPlacements = specifiedFallbackPlacements || (isBasePlacement || !flipVariations ? [(0,_utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(preferredPlacement)] : getExpandedFallbackPlacements(preferredPlacement));
//   var placements = [preferredPlacement].concat(fallbackPlacements).reduce(function (acc, placement) {
//     return acc.concat((0,_utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement) === _enums_js__WEBPACK_IMPORTED_MODULE_1__.auto ? (0,_utils_computeAutoPlacement_js__WEBPACK_IMPORTED_MODULE_4__["default"])(state, {
//       placement: placement,
//       boundary: boundary,
//       rootBoundary: rootBoundary,
//       padding: padding,
//       flipVariations: flipVariations,
//       allowedAutoPlacements: allowedAutoPlacements
//     }) : placement);
//   }, []);
//   var referenceRect = state.rects.reference;
//   var popperRect = state.rects.popper;
//   var checksMap = new Map();
//   var makeFallbackChecks = true;
//   var firstFittingPlacement = placements[0];

//   for (var i = 0; i < placements.length; i++) {
//     var placement = placements[i];

//     var _basePlacement = (0,_utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement);

//     var isStartVariation = (0,_utils_getVariation_js__WEBPACK_IMPORTED_MODULE_5__["default"])(placement) === _enums_js__WEBPACK_IMPORTED_MODULE_1__.start;
//     var isVertical = [_enums_js__WEBPACK_IMPORTED_MODULE_1__.top, _enums_js__WEBPACK_IMPORTED_MODULE_1__.bottom].indexOf(_basePlacement) >= 0;
//     var len = isVertical ? 'width' : 'height';
//     var overflow = (0,_utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_6__["default"])(state, {
//       placement: placement,
//       boundary: boundary,
//       rootBoundary: rootBoundary,
//       altBoundary: altBoundary,
//       padding: padding
//     });
//     var mainVariationSide = isVertical ? isStartVariation ? _enums_js__WEBPACK_IMPORTED_MODULE_1__.right : _enums_js__WEBPACK_IMPORTED_MODULE_1__.left : isStartVariation ? _enums_js__WEBPACK_IMPORTED_MODULE_1__.bottom : _enums_js__WEBPACK_IMPORTED_MODULE_1__.top;

//     if (referenceRect[len] > popperRect[len]) {
//       mainVariationSide = (0,_utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(mainVariationSide);
//     }

//     var altVariationSide = (0,_utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(mainVariationSide);
//     var checks = [];

//     if (checkMainAxis) {
//       checks.push(overflow[_basePlacement] <= 0);
//     }

//     if (checkAltAxis) {
//       checks.push(overflow[mainVariationSide] <= 0, overflow[altVariationSide] <= 0);
//     }

//     if (checks.every(function (check) {
//       return check;
//     })) {
//       firstFittingPlacement = placement;
//       makeFallbackChecks = false;
//       break;
//     }

//     checksMap.set(placement, checks);
//   }

//   if (makeFallbackChecks) {
//     // `2` may be desired in some cases – research later
//     var numberOfChecks = flipVariations ? 3 : 1;

//     var _loop = function _loop(_i) {
//       var fittingPlacement = placements.find(function (placement) {
//         var checks = checksMap.get(placement);

//         if (checks) {
//           return checks.slice(0, _i).every(function (check) {
//             return check;
//           });
//         }
//       });

//       if (fittingPlacement) {
//         firstFittingPlacement = fittingPlacement;
//         return "break";
//       }
//     };

//     for (var _i = numberOfChecks; _i > 0; _i--) {
//       var _ret = _loop(_i);

//       if (_ret === "break") break;
//     }
//   }

//   if (state.placement !== firstFittingPlacement) {
//     state.modifiersData[name]._skip = true;
//     state.placement = firstFittingPlacement;
//     state.reset = true;
//   }
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'flip',
//   enabled: true,
//   phase: 'main',
//   fn: flip,
//   requiresIfExists: ['offset'],
//   data: {
//     _skip: false
//   }
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/hide.js":
// /*!***********************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/hide.js ***!
//   \***********************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
// /* harmony export */ });
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
// /* harmony import */ var _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/detectOverflow.js */ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js");



// function getSideOffsets(overflow, rect, preventedOffsets) {
//   if (preventedOffsets === void 0) {
//     preventedOffsets = {
//       x: 0,
//       y: 0
//     };
//   }

//   return {
//     top: overflow.top - rect.height - preventedOffsets.y,
//     right: overflow.right - rect.width + preventedOffsets.x,
//     bottom: overflow.bottom - rect.height + preventedOffsets.y,
//     left: overflow.left - rect.width - preventedOffsets.x
//   };
// }

// function isAnySideFullyClipped(overflow) {
//   return [_enums_js__WEBPACK_IMPORTED_MODULE_0__.top, _enums_js__WEBPACK_IMPORTED_MODULE_0__.right, _enums_js__WEBPACK_IMPORTED_MODULE_0__.bottom, _enums_js__WEBPACK_IMPORTED_MODULE_0__.left].some(function (side) {
//     return overflow[side] >= 0;
//   });
// }

// function hide(_ref) {
//   var state = _ref.state,
//       name = _ref.name;
//   var referenceRect = state.rects.reference;
//   var popperRect = state.rects.popper;
//   var preventedOffsets = state.modifiersData.preventOverflow;
//   var referenceOverflow = (0,_utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_1__["default"])(state, {
//     elementContext: 'reference'
//   });
//   var popperAltOverflow = (0,_utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_1__["default"])(state, {
//     altBoundary: true
//   });
//   var referenceClippingOffsets = getSideOffsets(referenceOverflow, referenceRect);
//   var popperEscapeOffsets = getSideOffsets(popperAltOverflow, popperRect, preventedOffsets);
//   var isReferenceHidden = isAnySideFullyClipped(referenceClippingOffsets);
//   var hasPopperEscaped = isAnySideFullyClipped(popperEscapeOffsets);
//   state.modifiersData[name] = {
//     referenceClippingOffsets: referenceClippingOffsets,
//     popperEscapeOffsets: popperEscapeOffsets,
//     isReferenceHidden: isReferenceHidden,
//     hasPopperEscaped: hasPopperEscaped
//   };
//   state.attributes.popper = Object.assign({}, state.attributes.popper, {
//     'data-popper-reference-hidden': isReferenceHidden,
//     'data-popper-escaped': hasPopperEscaped
//   });
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'hide',
//   enabled: true,
//   phase: 'main',
//   requiresIfExists: ['preventOverflow'],
//   fn: hide
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/index.js":
// /*!************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/index.js ***!
//   \************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   applyStyles: () => (/* reexport safe */ _applyStyles_js__WEBPACK_IMPORTED_MODULE_0__["default"]),
// /* harmony export */   arrow: () => (/* reexport safe */ _arrow_js__WEBPACK_IMPORTED_MODULE_1__["default"]),
// /* harmony export */   computeStyles: () => (/* reexport safe */ _computeStyles_js__WEBPACK_IMPORTED_MODULE_2__["default"]),
// /* harmony export */   eventListeners: () => (/* reexport safe */ _eventListeners_js__WEBPACK_IMPORTED_MODULE_3__["default"]),
// /* harmony export */   flip: () => (/* reexport safe */ _flip_js__WEBPACK_IMPORTED_MODULE_4__["default"]),
// /* harmony export */   hide: () => (/* reexport safe */ _hide_js__WEBPACK_IMPORTED_MODULE_5__["default"]),
// /* harmony export */   offset: () => (/* reexport safe */ _offset_js__WEBPACK_IMPORTED_MODULE_6__["default"]),
// /* harmony export */   popperOffsets: () => (/* reexport safe */ _popperOffsets_js__WEBPACK_IMPORTED_MODULE_7__["default"]),
// /* harmony export */   preventOverflow: () => (/* reexport safe */ _preventOverflow_js__WEBPACK_IMPORTED_MODULE_8__["default"])
// /* harmony export */ });
// /* harmony import */ var _applyStyles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./applyStyles.js */ "./node_modules/@popperjs/core/lib/modifiers/applyStyles.js");
// /* harmony import */ var _arrow_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./arrow.js */ "./node_modules/@popperjs/core/lib/modifiers/arrow.js");
// /* harmony import */ var _computeStyles_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./computeStyles.js */ "./node_modules/@popperjs/core/lib/modifiers/computeStyles.js");
// /* harmony import */ var _eventListeners_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./eventListeners.js */ "./node_modules/@popperjs/core/lib/modifiers/eventListeners.js");
// /* harmony import */ var _flip_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./flip.js */ "./node_modules/@popperjs/core/lib/modifiers/flip.js");
// /* harmony import */ var _hide_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./hide.js */ "./node_modules/@popperjs/core/lib/modifiers/hide.js");
// /* harmony import */ var _offset_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./offset.js */ "./node_modules/@popperjs/core/lib/modifiers/offset.js");
// /* harmony import */ var _popperOffsets_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./popperOffsets.js */ "./node_modules/@popperjs/core/lib/modifiers/popperOffsets.js");
// /* harmony import */ var _preventOverflow_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./preventOverflow.js */ "./node_modules/@popperjs/core/lib/modifiers/preventOverflow.js");










// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/offset.js":
// /*!*************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/offset.js ***!
//   \*************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
// /* harmony export */   distanceAndSkiddingToXY: () => (/* binding */ distanceAndSkiddingToXY)
// /* harmony export */ });
// /* harmony import */ var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/getBasePlacement.js */ "./node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");

//  // eslint-disable-next-line import/no-unused-modules

// function distanceAndSkiddingToXY(placement, rects, offset) {
//   var basePlacement = (0,_utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement);
//   var invertDistance = [_enums_js__WEBPACK_IMPORTED_MODULE_1__.left, _enums_js__WEBPACK_IMPORTED_MODULE_1__.top].indexOf(basePlacement) >= 0 ? -1 : 1;

//   var _ref = typeof offset === 'function' ? offset(Object.assign({}, rects, {
//     placement: placement
//   })) : offset,
//       skidding = _ref[0],
//       distance = _ref[1];

//   skidding = skidding || 0;
//   distance = (distance || 0) * invertDistance;
//   return [_enums_js__WEBPACK_IMPORTED_MODULE_1__.left, _enums_js__WEBPACK_IMPORTED_MODULE_1__.right].indexOf(basePlacement) >= 0 ? {
//     x: distance,
//     y: skidding
//   } : {
//     x: skidding,
//     y: distance
//   };
// }

// function offset(_ref2) {
//   var state = _ref2.state,
//       options = _ref2.options,
//       name = _ref2.name;
//   var _options$offset = options.offset,
//       offset = _options$offset === void 0 ? [0, 0] : _options$offset;
//   var data = _enums_js__WEBPACK_IMPORTED_MODULE_1__.placements.reduce(function (acc, placement) {
//     acc[placement] = distanceAndSkiddingToXY(placement, state.rects, offset);
//     return acc;
//   }, {});
//   var _data$state$placement = data[state.placement],
//       x = _data$state$placement.x,
//       y = _data$state$placement.y;

//   if (state.modifiersData.popperOffsets != null) {
//     state.modifiersData.popperOffsets.x += x;
//     state.modifiersData.popperOffsets.y += y;
//   }

//   state.modifiersData[name] = data;
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'offset',
//   enabled: true,
//   phase: 'main',
//   requires: ['popperOffsets'],
//   fn: offset
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/popperOffsets.js":
// /*!********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/popperOffsets.js ***!
//   \********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
// /* harmony export */ });
// /* harmony import */ var _utils_computeOffsets_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/computeOffsets.js */ "./node_modules/@popperjs/core/lib/utils/computeOffsets.js");


// function popperOffsets(_ref) {
//   var state = _ref.state,
//       name = _ref.name;
//   // Offsets are the actual position the popper needs to have to be
//   // properly positioned near its reference element
//   // This is the most basic placement, and will be adjusted by
//   // the modifiers in the next step
//   state.modifiersData[name] = (0,_utils_computeOffsets_js__WEBPACK_IMPORTED_MODULE_0__["default"])({
//     reference: state.rects.reference,
//     element: state.rects.popper,
//     strategy: 'absolute',
//     placement: state.placement
//   });
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'popperOffsets',
//   enabled: true,
//   phase: 'read',
//   fn: popperOffsets,
//   data: {}
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/modifiers/preventOverflow.js":
// /*!**********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/modifiers/preventOverflow.js ***!
//   \**********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
// /* harmony export */ });
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
// /* harmony import */ var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/getBasePlacement.js */ "./node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
// /* harmony import */ var _utils_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../utils/getMainAxisFromPlacement.js */ "./node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js");
// /* harmony import */ var _utils_getAltAxis_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../utils/getAltAxis.js */ "./node_modules/@popperjs/core/lib/utils/getAltAxis.js");
// /* harmony import */ var _utils_within_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../utils/within.js */ "./node_modules/@popperjs/core/lib/utils/within.js");
// /* harmony import */ var _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../dom-utils/getLayoutRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js");
// /* harmony import */ var _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../dom-utils/getOffsetParent.js */ "./node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
// /* harmony import */ var _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/detectOverflow.js */ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js");
// /* harmony import */ var _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/getVariation.js */ "./node_modules/@popperjs/core/lib/utils/getVariation.js");
// /* harmony import */ var _utils_getFreshSideObject_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../utils/getFreshSideObject.js */ "./node_modules/@popperjs/core/lib/utils/getFreshSideObject.js");
// /* harmony import */ var _utils_math_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../utils/math.js */ "./node_modules/@popperjs/core/lib/utils/math.js");












// function preventOverflow(_ref) {
//   var state = _ref.state,
//       options = _ref.options,
//       name = _ref.name;
//   var _options$mainAxis = options.mainAxis,
//       checkMainAxis = _options$mainAxis === void 0 ? true : _options$mainAxis,
//       _options$altAxis = options.altAxis,
//       checkAltAxis = _options$altAxis === void 0 ? false : _options$altAxis,
//       boundary = options.boundary,
//       rootBoundary = options.rootBoundary,
//       altBoundary = options.altBoundary,
//       padding = options.padding,
//       _options$tether = options.tether,
//       tether = _options$tether === void 0 ? true : _options$tether,
//       _options$tetherOffset = options.tetherOffset,
//       tetherOffset = _options$tetherOffset === void 0 ? 0 : _options$tetherOffset;
//   var overflow = (0,_utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(state, {
//     boundary: boundary,
//     rootBoundary: rootBoundary,
//     padding: padding,
//     altBoundary: altBoundary
//   });
//   var basePlacement = (0,_utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_1__["default"])(state.placement);
//   var variation = (0,_utils_getVariation_js__WEBPACK_IMPORTED_MODULE_2__["default"])(state.placement);
//   var isBasePlacement = !variation;
//   var mainAxis = (0,_utils_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(basePlacement);
//   var altAxis = (0,_utils_getAltAxis_js__WEBPACK_IMPORTED_MODULE_4__["default"])(mainAxis);
//   var popperOffsets = state.modifiersData.popperOffsets;
//   var referenceRect = state.rects.reference;
//   var popperRect = state.rects.popper;
//   var tetherOffsetValue = typeof tetherOffset === 'function' ? tetherOffset(Object.assign({}, state.rects, {
//     placement: state.placement
//   })) : tetherOffset;
//   var normalizedTetherOffsetValue = typeof tetherOffsetValue === 'number' ? {
//     mainAxis: tetherOffsetValue,
//     altAxis: tetherOffsetValue
//   } : Object.assign({
//     mainAxis: 0,
//     altAxis: 0
//   }, tetherOffsetValue);
//   var offsetModifierState = state.modifiersData.offset ? state.modifiersData.offset[state.placement] : null;
//   var data = {
//     x: 0,
//     y: 0
//   };

//   if (!popperOffsets) {
//     return;
//   }

//   if (checkMainAxis) {
//     var _offsetModifierState$;

//     var mainSide = mainAxis === 'y' ? _enums_js__WEBPACK_IMPORTED_MODULE_5__.top : _enums_js__WEBPACK_IMPORTED_MODULE_5__.left;
//     var altSide = mainAxis === 'y' ? _enums_js__WEBPACK_IMPORTED_MODULE_5__.bottom : _enums_js__WEBPACK_IMPORTED_MODULE_5__.right;
//     var len = mainAxis === 'y' ? 'height' : 'width';
//     var offset = popperOffsets[mainAxis];
//     var min = offset + overflow[mainSide];
//     var max = offset - overflow[altSide];
//     var additive = tether ? -popperRect[len] / 2 : 0;
//     var minLen = variation === _enums_js__WEBPACK_IMPORTED_MODULE_5__.start ? referenceRect[len] : popperRect[len];
//     var maxLen = variation === _enums_js__WEBPACK_IMPORTED_MODULE_5__.start ? -popperRect[len] : -referenceRect[len]; // We need to include the arrow in the calculation so the arrow doesn't go
//     // outside the reference bounds

//     var arrowElement = state.elements.arrow;
//     var arrowRect = tether && arrowElement ? (0,_dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_6__["default"])(arrowElement) : {
//       width: 0,
//       height: 0
//     };
//     var arrowPaddingObject = state.modifiersData['arrow#persistent'] ? state.modifiersData['arrow#persistent'].padding : (0,_utils_getFreshSideObject_js__WEBPACK_IMPORTED_MODULE_7__["default"])();
//     var arrowPaddingMin = arrowPaddingObject[mainSide];
//     var arrowPaddingMax = arrowPaddingObject[altSide]; // If the reference length is smaller than the arrow length, we don't want
//     // to include its full size in the calculation. If the reference is small
//     // and near the edge of a boundary, the popper can overflow even if the
//     // reference is not overflowing as well (e.g. virtual elements with no
//     // width or height)

//     var arrowLen = (0,_utils_within_js__WEBPACK_IMPORTED_MODULE_8__.within)(0, referenceRect[len], arrowRect[len]);
//     var minOffset = isBasePlacement ? referenceRect[len] / 2 - additive - arrowLen - arrowPaddingMin - normalizedTetherOffsetValue.mainAxis : minLen - arrowLen - arrowPaddingMin - normalizedTetherOffsetValue.mainAxis;
//     var maxOffset = isBasePlacement ? -referenceRect[len] / 2 + additive + arrowLen + arrowPaddingMax + normalizedTetherOffsetValue.mainAxis : maxLen + arrowLen + arrowPaddingMax + normalizedTetherOffsetValue.mainAxis;
//     var arrowOffsetParent = state.elements.arrow && (0,_dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_9__["default"])(state.elements.arrow);
//     var clientOffset = arrowOffsetParent ? mainAxis === 'y' ? arrowOffsetParent.clientTop || 0 : arrowOffsetParent.clientLeft || 0 : 0;
//     var offsetModifierValue = (_offsetModifierState$ = offsetModifierState == null ? void 0 : offsetModifierState[mainAxis]) != null ? _offsetModifierState$ : 0;
//     var tetherMin = offset + minOffset - offsetModifierValue - clientOffset;
//     var tetherMax = offset + maxOffset - offsetModifierValue;
//     var preventedOffset = (0,_utils_within_js__WEBPACK_IMPORTED_MODULE_8__.within)(tether ? (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_10__.min)(min, tetherMin) : min, offset, tether ? (0,_utils_math_js__WEBPACK_IMPORTED_MODULE_10__.max)(max, tetherMax) : max);
//     popperOffsets[mainAxis] = preventedOffset;
//     data[mainAxis] = preventedOffset - offset;
//   }

//   if (checkAltAxis) {
//     var _offsetModifierState$2;

//     var _mainSide = mainAxis === 'x' ? _enums_js__WEBPACK_IMPORTED_MODULE_5__.top : _enums_js__WEBPACK_IMPORTED_MODULE_5__.left;

//     var _altSide = mainAxis === 'x' ? _enums_js__WEBPACK_IMPORTED_MODULE_5__.bottom : _enums_js__WEBPACK_IMPORTED_MODULE_5__.right;

//     var _offset = popperOffsets[altAxis];

//     var _len = altAxis === 'y' ? 'height' : 'width';

//     var _min = _offset + overflow[_mainSide];

//     var _max = _offset - overflow[_altSide];

//     var isOriginSide = [_enums_js__WEBPACK_IMPORTED_MODULE_5__.top, _enums_js__WEBPACK_IMPORTED_MODULE_5__.left].indexOf(basePlacement) !== -1;

//     var _offsetModifierValue = (_offsetModifierState$2 = offsetModifierState == null ? void 0 : offsetModifierState[altAxis]) != null ? _offsetModifierState$2 : 0;

//     var _tetherMin = isOriginSide ? _min : _offset - referenceRect[_len] - popperRect[_len] - _offsetModifierValue + normalizedTetherOffsetValue.altAxis;

//     var _tetherMax = isOriginSide ? _offset + referenceRect[_len] + popperRect[_len] - _offsetModifierValue - normalizedTetherOffsetValue.altAxis : _max;

//     var _preventedOffset = tether && isOriginSide ? (0,_utils_within_js__WEBPACK_IMPORTED_MODULE_8__.withinMaxClamp)(_tetherMin, _offset, _tetherMax) : (0,_utils_within_js__WEBPACK_IMPORTED_MODULE_8__.within)(tether ? _tetherMin : _min, _offset, tether ? _tetherMax : _max);

//     popperOffsets[altAxis] = _preventedOffset;
//     data[altAxis] = _preventedOffset - _offset;
//   }

//   state.modifiersData[name] = data;
// } // eslint-disable-next-line import/no-unused-modules


// /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
//   name: 'preventOverflow',
//   enabled: true,
//   phase: 'main',
//   fn: preventOverflow,
//   requiresIfExists: ['offset']
// });

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/popper-lite.js":
// /*!********************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/popper-lite.js ***!
//   \********************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   createPopper: () => (/* binding */ createPopper),
// /* harmony export */   defaultModifiers: () => (/* binding */ defaultModifiers),
// /* harmony export */   detectOverflow: () => (/* reexport safe */ _createPopper_js__WEBPACK_IMPORTED_MODULE_5__["default"]),
// /* harmony export */   popperGenerator: () => (/* reexport safe */ _createPopper_js__WEBPACK_IMPORTED_MODULE_4__.popperGenerator)
// /* harmony export */ });
// /* harmony import */ var _createPopper_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./createPopper.js */ "./node_modules/@popperjs/core/lib/createPopper.js");
// /* harmony import */ var _createPopper_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./createPopper.js */ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js");
// /* harmony import */ var _modifiers_eventListeners_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modifiers/eventListeners.js */ "./node_modules/@popperjs/core/lib/modifiers/eventListeners.js");
// /* harmony import */ var _modifiers_popperOffsets_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modifiers/popperOffsets.js */ "./node_modules/@popperjs/core/lib/modifiers/popperOffsets.js");
// /* harmony import */ var _modifiers_computeStyles_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modifiers/computeStyles.js */ "./node_modules/@popperjs/core/lib/modifiers/computeStyles.js");
// /* harmony import */ var _modifiers_applyStyles_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modifiers/applyStyles.js */ "./node_modules/@popperjs/core/lib/modifiers/applyStyles.js");





// var defaultModifiers = [_modifiers_eventListeners_js__WEBPACK_IMPORTED_MODULE_0__["default"], _modifiers_popperOffsets_js__WEBPACK_IMPORTED_MODULE_1__["default"], _modifiers_computeStyles_js__WEBPACK_IMPORTED_MODULE_2__["default"], _modifiers_applyStyles_js__WEBPACK_IMPORTED_MODULE_3__["default"]];
// var createPopper = /*#__PURE__*/(0,_createPopper_js__WEBPACK_IMPORTED_MODULE_4__.popperGenerator)({
//   defaultModifiers: defaultModifiers
// }); // eslint-disable-next-line import/no-unused-modules



// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/popper.js":
// /*!***************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/popper.js ***!
//   \***************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   applyStyles: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.applyStyles),
// /* harmony export */   arrow: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.arrow),
// /* harmony export */   computeStyles: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.computeStyles),
// /* harmony export */   createPopper: () => (/* binding */ createPopper),
// /* harmony export */   createPopperLite: () => (/* reexport safe */ _popper_lite_js__WEBPACK_IMPORTED_MODULE_11__.createPopper),
// /* harmony export */   defaultModifiers: () => (/* binding */ defaultModifiers),
// /* harmony export */   detectOverflow: () => (/* reexport safe */ _createPopper_js__WEBPACK_IMPORTED_MODULE_10__["default"]),
// /* harmony export */   eventListeners: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.eventListeners),
// /* harmony export */   flip: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.flip),
// /* harmony export */   hide: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.hide),
// /* harmony export */   offset: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.offset),
// /* harmony export */   popperGenerator: () => (/* reexport safe */ _createPopper_js__WEBPACK_IMPORTED_MODULE_9__.popperGenerator),
// /* harmony export */   popperOffsets: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.popperOffsets),
// /* harmony export */   preventOverflow: () => (/* reexport safe */ _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.preventOverflow)
// /* harmony export */ });
// /* harmony import */ var _createPopper_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./createPopper.js */ "./node_modules/@popperjs/core/lib/createPopper.js");
// /* harmony import */ var _createPopper_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./createPopper.js */ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js");
// /* harmony import */ var _modifiers_eventListeners_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modifiers/eventListeners.js */ "./node_modules/@popperjs/core/lib/modifiers/eventListeners.js");
// /* harmony import */ var _modifiers_popperOffsets_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modifiers/popperOffsets.js */ "./node_modules/@popperjs/core/lib/modifiers/popperOffsets.js");
// /* harmony import */ var _modifiers_computeStyles_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modifiers/computeStyles.js */ "./node_modules/@popperjs/core/lib/modifiers/computeStyles.js");
// /* harmony import */ var _modifiers_applyStyles_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modifiers/applyStyles.js */ "./node_modules/@popperjs/core/lib/modifiers/applyStyles.js");
// /* harmony import */ var _modifiers_offset_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modifiers/offset.js */ "./node_modules/@popperjs/core/lib/modifiers/offset.js");
// /* harmony import */ var _modifiers_flip_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./modifiers/flip.js */ "./node_modules/@popperjs/core/lib/modifiers/flip.js");
// /* harmony import */ var _modifiers_preventOverflow_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./modifiers/preventOverflow.js */ "./node_modules/@popperjs/core/lib/modifiers/preventOverflow.js");
// /* harmony import */ var _modifiers_arrow_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./modifiers/arrow.js */ "./node_modules/@popperjs/core/lib/modifiers/arrow.js");
// /* harmony import */ var _modifiers_hide_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./modifiers/hide.js */ "./node_modules/@popperjs/core/lib/modifiers/hide.js");
// /* harmony import */ var _popper_lite_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./popper-lite.js */ "./node_modules/@popperjs/core/lib/popper-lite.js");
// /* harmony import */ var _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./modifiers/index.js */ "./node_modules/@popperjs/core/lib/modifiers/index.js");










// var defaultModifiers = [_modifiers_eventListeners_js__WEBPACK_IMPORTED_MODULE_0__["default"], _modifiers_popperOffsets_js__WEBPACK_IMPORTED_MODULE_1__["default"], _modifiers_computeStyles_js__WEBPACK_IMPORTED_MODULE_2__["default"], _modifiers_applyStyles_js__WEBPACK_IMPORTED_MODULE_3__["default"], _modifiers_offset_js__WEBPACK_IMPORTED_MODULE_4__["default"], _modifiers_flip_js__WEBPACK_IMPORTED_MODULE_5__["default"], _modifiers_preventOverflow_js__WEBPACK_IMPORTED_MODULE_6__["default"], _modifiers_arrow_js__WEBPACK_IMPORTED_MODULE_7__["default"], _modifiers_hide_js__WEBPACK_IMPORTED_MODULE_8__["default"]];
// var createPopper = /*#__PURE__*/(0,_createPopper_js__WEBPACK_IMPORTED_MODULE_9__.popperGenerator)({
//   defaultModifiers: defaultModifiers
// }); // eslint-disable-next-line import/no-unused-modules

//  // eslint-disable-next-line import/no-unused-modules

//  // eslint-disable-next-line import/no-unused-modules



// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/computeAutoPlacement.js":
// /*!***********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/computeAutoPlacement.js ***!
//   \***********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ computeAutoPlacement)
// /* harmony export */ });
// /* harmony import */ var _getVariation_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getVariation.js */ "./node_modules/@popperjs/core/lib/utils/getVariation.js");
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
// /* harmony import */ var _detectOverflow_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./detectOverflow.js */ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js");
// /* harmony import */ var _getBasePlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getBasePlacement.js */ "./node_modules/@popperjs/core/lib/utils/getBasePlacement.js");




// function computeAutoPlacement(state, options) {
//   if (options === void 0) {
//     options = {};
//   }

//   var _options = options,
//       placement = _options.placement,
//       boundary = _options.boundary,
//       rootBoundary = _options.rootBoundary,
//       padding = _options.padding,
//       flipVariations = _options.flipVariations,
//       _options$allowedAutoP = _options.allowedAutoPlacements,
//       allowedAutoPlacements = _options$allowedAutoP === void 0 ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.placements : _options$allowedAutoP;
//   var variation = (0,_getVariation_js__WEBPACK_IMPORTED_MODULE_1__["default"])(placement);
//   var placements = variation ? flipVariations ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.variationPlacements : _enums_js__WEBPACK_IMPORTED_MODULE_0__.variationPlacements.filter(function (placement) {
//     return (0,_getVariation_js__WEBPACK_IMPORTED_MODULE_1__["default"])(placement) === variation;
//   }) : _enums_js__WEBPACK_IMPORTED_MODULE_0__.basePlacements;
//   var allowedPlacements = placements.filter(function (placement) {
//     return allowedAutoPlacements.indexOf(placement) >= 0;
//   });

//   if (allowedPlacements.length === 0) {
//     allowedPlacements = placements;
//   } // $FlowFixMe[incompatible-type]: Flow seems to have problems with two array unions...


//   var overflows = allowedPlacements.reduce(function (acc, placement) {
//     acc[placement] = (0,_detectOverflow_js__WEBPACK_IMPORTED_MODULE_2__["default"])(state, {
//       placement: placement,
//       boundary: boundary,
//       rootBoundary: rootBoundary,
//       padding: padding
//     })[(0,_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(placement)];
//     return acc;
//   }, {});
//   return Object.keys(overflows).sort(function (a, b) {
//     return overflows[a] - overflows[b];
//   });
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/computeOffsets.js":
// /*!*****************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/computeOffsets.js ***!
//   \*****************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ computeOffsets)
// /* harmony export */ });
// /* harmony import */ var _getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getBasePlacement.js */ "./node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
// /* harmony import */ var _getVariation_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./getVariation.js */ "./node_modules/@popperjs/core/lib/utils/getVariation.js");
// /* harmony import */ var _getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./getMainAxisFromPlacement.js */ "./node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js");
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");




// function computeOffsets(_ref) {
//   var reference = _ref.reference,
//       element = _ref.element,
//       placement = _ref.placement;
//   var basePlacement = placement ? (0,_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement) : null;
//   var variation = placement ? (0,_getVariation_js__WEBPACK_IMPORTED_MODULE_1__["default"])(placement) : null;
//   var commonX = reference.x + reference.width / 2 - element.width / 2;
//   var commonY = reference.y + reference.height / 2 - element.height / 2;
//   var offsets;

//   switch (basePlacement) {
//     case _enums_js__WEBPACK_IMPORTED_MODULE_2__.top:
//       offsets = {
//         x: commonX,
//         y: reference.y - element.height
//       };
//       break;

//     case _enums_js__WEBPACK_IMPORTED_MODULE_2__.bottom:
//       offsets = {
//         x: commonX,
//         y: reference.y + reference.height
//       };
//       break;

//     case _enums_js__WEBPACK_IMPORTED_MODULE_2__.right:
//       offsets = {
//         x: reference.x + reference.width,
//         y: commonY
//       };
//       break;

//     case _enums_js__WEBPACK_IMPORTED_MODULE_2__.left:
//       offsets = {
//         x: reference.x - element.width,
//         y: commonY
//       };
//       break;

//     default:
//       offsets = {
//         x: reference.x,
//         y: reference.y
//       };
//   }

//   var mainAxis = basePlacement ? (0,_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(basePlacement) : null;

//   if (mainAxis != null) {
//     var len = mainAxis === 'y' ? 'height' : 'width';

//     switch (variation) {
//       case _enums_js__WEBPACK_IMPORTED_MODULE_2__.start:
//         offsets[mainAxis] = offsets[mainAxis] - (reference[len] / 2 - element[len] / 2);
//         break;

//       case _enums_js__WEBPACK_IMPORTED_MODULE_2__.end:
//         offsets[mainAxis] = offsets[mainAxis] + (reference[len] / 2 - element[len] / 2);
//         break;

//       default:
//     }
//   }

//   return offsets;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/debounce.js":
// /*!***********************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/debounce.js ***!
//   \***********************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ debounce)
// /* harmony export */ });
// function debounce(fn) {
//   var pending;
//   return function () {
//     if (!pending) {
//       pending = new Promise(function (resolve) {
//         Promise.resolve().then(function () {
//           pending = undefined;
//           resolve(fn());
//         });
//       });
//     }

//     return pending;
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/detectOverflow.js":
// /*!*****************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/detectOverflow.js ***!
//   \*****************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ detectOverflow)
// /* harmony export */ });
// /* harmony import */ var _dom_utils_getClippingRect_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../dom-utils/getClippingRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getClippingRect.js");
// /* harmony import */ var _dom_utils_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../dom-utils/getDocumentElement.js */ "./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
// /* harmony import */ var _dom_utils_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../dom-utils/getBoundingClientRect.js */ "./node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
// /* harmony import */ var _computeOffsets_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./computeOffsets.js */ "./node_modules/@popperjs/core/lib/utils/computeOffsets.js");
// /* harmony import */ var _rectToClientRect_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./rectToClientRect.js */ "./node_modules/@popperjs/core/lib/utils/rectToClientRect.js");
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
// /* harmony import */ var _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../dom-utils/instanceOf.js */ "./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
// /* harmony import */ var _mergePaddingObject_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./mergePaddingObject.js */ "./node_modules/@popperjs/core/lib/utils/mergePaddingObject.js");
// /* harmony import */ var _expandToHashMap_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./expandToHashMap.js */ "./node_modules/@popperjs/core/lib/utils/expandToHashMap.js");








//  // eslint-disable-next-line import/no-unused-modules

// function detectOverflow(state, options) {
//   if (options === void 0) {
//     options = {};
//   }

//   var _options = options,
//       _options$placement = _options.placement,
//       placement = _options$placement === void 0 ? state.placement : _options$placement,
//       _options$strategy = _options.strategy,
//       strategy = _options$strategy === void 0 ? state.strategy : _options$strategy,
//       _options$boundary = _options.boundary,
//       boundary = _options$boundary === void 0 ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.clippingParents : _options$boundary,
//       _options$rootBoundary = _options.rootBoundary,
//       rootBoundary = _options$rootBoundary === void 0 ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.viewport : _options$rootBoundary,
//       _options$elementConte = _options.elementContext,
//       elementContext = _options$elementConte === void 0 ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper : _options$elementConte,
//       _options$altBoundary = _options.altBoundary,
//       altBoundary = _options$altBoundary === void 0 ? false : _options$altBoundary,
//       _options$padding = _options.padding,
//       padding = _options$padding === void 0 ? 0 : _options$padding;
//   var paddingObject = (0,_mergePaddingObject_js__WEBPACK_IMPORTED_MODULE_1__["default"])(typeof padding !== 'number' ? padding : (0,_expandToHashMap_js__WEBPACK_IMPORTED_MODULE_2__["default"])(padding, _enums_js__WEBPACK_IMPORTED_MODULE_0__.basePlacements));
//   var altContext = elementContext === _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.reference : _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper;
//   var popperRect = state.rects.popper;
//   var element = state.elements[altBoundary ? altContext : elementContext];
//   var clippingClientRect = (0,_dom_utils_getClippingRect_js__WEBPACK_IMPORTED_MODULE_3__["default"])((0,_dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isElement)(element) ? element : element.contextElement || (0,_dom_utils_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_5__["default"])(state.elements.popper), boundary, rootBoundary, strategy);
//   var referenceClientRect = (0,_dom_utils_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_6__["default"])(state.elements.reference);
//   var popperOffsets = (0,_computeOffsets_js__WEBPACK_IMPORTED_MODULE_7__["default"])({
//     reference: referenceClientRect,
//     element: popperRect,
//     strategy: 'absolute',
//     placement: placement
//   });
//   var popperClientRect = (0,_rectToClientRect_js__WEBPACK_IMPORTED_MODULE_8__["default"])(Object.assign({}, popperRect, popperOffsets));
//   var elementClientRect = elementContext === _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper ? popperClientRect : referenceClientRect; // positive = overflowing the clipping rect
//   // 0 or negative = within the clipping rect

//   var overflowOffsets = {
//     top: clippingClientRect.top - elementClientRect.top + paddingObject.top,
//     bottom: elementClientRect.bottom - clippingClientRect.bottom + paddingObject.bottom,
//     left: clippingClientRect.left - elementClientRect.left + paddingObject.left,
//     right: elementClientRect.right - clippingClientRect.right + paddingObject.right
//   };
//   var offsetData = state.modifiersData.offset; // Offsets can be applied only to the popper element

//   if (elementContext === _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper && offsetData) {
//     var offset = offsetData[placement];
//     Object.keys(overflowOffsets).forEach(function (key) {
//       var multiply = [_enums_js__WEBPACK_IMPORTED_MODULE_0__.right, _enums_js__WEBPACK_IMPORTED_MODULE_0__.bottom].indexOf(key) >= 0 ? 1 : -1;
//       var axis = [_enums_js__WEBPACK_IMPORTED_MODULE_0__.top, _enums_js__WEBPACK_IMPORTED_MODULE_0__.bottom].indexOf(key) >= 0 ? 'y' : 'x';
//       overflowOffsets[key] += offset[axis] * multiply;
//     });
//   }

//   return overflowOffsets;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/expandToHashMap.js":
// /*!******************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/expandToHashMap.js ***!
//   \******************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ expandToHashMap)
// /* harmony export */ });
// function expandToHashMap(value, keys) {
//   return keys.reduce(function (hashMap, key) {
//     hashMap[key] = value;
//     return hashMap;
//   }, {});
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/getAltAxis.js":
// /*!*************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/getAltAxis.js ***!
//   \*************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getAltAxis)
// /* harmony export */ });
// function getAltAxis(axis) {
//   return axis === 'x' ? 'y' : 'x';
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/getBasePlacement.js":
// /*!*******************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/getBasePlacement.js ***!
//   \*******************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getBasePlacement)
// /* harmony export */ });

// function getBasePlacement(placement) {
//   return placement.split('-')[0];
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/getFreshSideObject.js":
// /*!*********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/getFreshSideObject.js ***!
//   \*********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getFreshSideObject)
// /* harmony export */ });
// function getFreshSideObject() {
//   return {
//     top: 0,
//     right: 0,
//     bottom: 0,
//     left: 0
//   };
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js":
// /*!***************************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js ***!
//   \***************************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getMainAxisFromPlacement)
// /* harmony export */ });
// function getMainAxisFromPlacement(placement) {
//   return ['top', 'bottom'].indexOf(placement) >= 0 ? 'x' : 'y';
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/getOppositePlacement.js":
// /*!***********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/getOppositePlacement.js ***!
//   \***********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getOppositePlacement)
// /* harmony export */ });
// var hash = {
//   left: 'right',
//   right: 'left',
//   bottom: 'top',
//   top: 'bottom'
// };
// function getOppositePlacement(placement) {
//   return placement.replace(/left|right|bottom|top/g, function (matched) {
//     return hash[matched];
//   });
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/getOppositeVariationPlacement.js":
// /*!********************************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/getOppositeVariationPlacement.js ***!
//   \********************************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getOppositeVariationPlacement)
// /* harmony export */ });
// var hash = {
//   start: 'end',
//   end: 'start'
// };
// function getOppositeVariationPlacement(placement) {
//   return placement.replace(/start|end/g, function (matched) {
//     return hash[matched];
//   });
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/getVariation.js":
// /*!***************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/getVariation.js ***!
//   \***************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getVariation)
// /* harmony export */ });
// function getVariation(placement) {
//   return placement.split('-')[1];
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/math.js":
// /*!*******************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/math.js ***!
//   \*******************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   max: () => (/* binding */ max),
// /* harmony export */   min: () => (/* binding */ min),
// /* harmony export */   round: () => (/* binding */ round)
// /* harmony export */ });
// var max = Math.max;
// var min = Math.min;
// var round = Math.round;

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/mergeByName.js":
// /*!**************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/mergeByName.js ***!
//   \**************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ mergeByName)
// /* harmony export */ });
// function mergeByName(modifiers) {
//   var merged = modifiers.reduce(function (merged, current) {
//     var existing = merged[current.name];
//     merged[current.name] = existing ? Object.assign({}, existing, current, {
//       options: Object.assign({}, existing.options, current.options),
//       data: Object.assign({}, existing.data, current.data)
//     }) : current;
//     return merged;
//   }, {}); // IE11 does not support Object.values

//   return Object.keys(merged).map(function (key) {
//     return merged[key];
//   });
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/mergePaddingObject.js":
// /*!*********************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/mergePaddingObject.js ***!
//   \*********************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ mergePaddingObject)
// /* harmony export */ });
// /* harmony import */ var _getFreshSideObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./getFreshSideObject.js */ "./node_modules/@popperjs/core/lib/utils/getFreshSideObject.js");

// function mergePaddingObject(paddingObject) {
//   return Object.assign({}, (0,_getFreshSideObject_js__WEBPACK_IMPORTED_MODULE_0__["default"])(), paddingObject);
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/orderModifiers.js":
// /*!*****************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/orderModifiers.js ***!
//   \*****************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ orderModifiers)
// /* harmony export */ });
// /* harmony import */ var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../enums.js */ "./node_modules/@popperjs/core/lib/enums.js");
//  // source: https://stackoverflow.com/questions/49875255

// function order(modifiers) {
//   var map = new Map();
//   var visited = new Set();
//   var result = [];
//   modifiers.forEach(function (modifier) {
//     map.set(modifier.name, modifier);
//   }); // On visiting object, check for its dependencies and visit them recursively

//   function sort(modifier) {
//     visited.add(modifier.name);
//     var requires = [].concat(modifier.requires || [], modifier.requiresIfExists || []);
//     requires.forEach(function (dep) {
//       if (!visited.has(dep)) {
//         var depModifier = map.get(dep);

//         if (depModifier) {
//           sort(depModifier);
//         }
//       }
//     });
//     result.push(modifier);
//   }

//   modifiers.forEach(function (modifier) {
//     if (!visited.has(modifier.name)) {
//       // check for visited object
//       sort(modifier);
//     }
//   });
//   return result;
// }

// function orderModifiers(modifiers) {
//   // order based on dependencies
//   var orderedModifiers = order(modifiers); // order based on phase

//   return _enums_js__WEBPACK_IMPORTED_MODULE_0__.modifierPhases.reduce(function (acc, phase) {
//     return acc.concat(orderedModifiers.filter(function (modifier) {
//       return modifier.phase === phase;
//     }));
//   }, []);
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/rectToClientRect.js":
// /*!*******************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/rectToClientRect.js ***!
//   \*******************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ rectToClientRect)
// /* harmony export */ });
// function rectToClientRect(rect) {
//   return Object.assign({}, rect, {
//     left: rect.x,
//     top: rect.y,
//     right: rect.x + rect.width,
//     bottom: rect.y + rect.height
//   });
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/userAgent.js":
// /*!************************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/userAgent.js ***!
//   \************************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   "default": () => (/* binding */ getUAString)
// /* harmony export */ });
// function getUAString() {
//   var uaData = navigator.userAgentData;

//   if (uaData != null && uaData.brands && Array.isArray(uaData.brands)) {
//     return uaData.brands.map(function (item) {
//       return item.brand + "/" + item.version;
//     }).join(' ');
//   }

//   return navigator.userAgent;
// }

// /***/ }),

// /***/ "./node_modules/@popperjs/core/lib/utils/within.js":
// /*!*********************************************************!*\
//   !*** ./node_modules/@popperjs/core/lib/utils/within.js ***!
//   \*********************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   within: () => (/* binding */ within),
// /* harmony export */   withinMaxClamp: () => (/* binding */ withinMaxClamp)
// /* harmony export */ });
// /* harmony import */ var _math_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./math.js */ "./node_modules/@popperjs/core/lib/utils/math.js");

// function within(min, value, max) {
//   return (0,_math_js__WEBPACK_IMPORTED_MODULE_0__.max)(min, (0,_math_js__WEBPACK_IMPORTED_MODULE_0__.min)(value, max));
// }
// function withinMaxClamp(min, value, max) {
//   var v = within(min, value, max);
//   return v > max ? max : v;
// }

// /***/ }),

// /***/ "./node_modules/axios/index.js":
// /*!*************************************!*\
//   !*** ./node_modules/axios/index.js ***!
//   \*************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// module.exports = __webpack_require__(/*! ./lib/axios */ "./node_modules/axios/lib/axios.js");

// /***/ }),

// /***/ "./node_modules/axios/lib/adapters/xhr.js":
// /*!************************************************!*\
//   !*** ./node_modules/axios/lib/adapters/xhr.js ***!
//   \************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
// var settle = __webpack_require__(/*! ./../core/settle */ "./node_modules/axios/lib/core/settle.js");
// var cookies = __webpack_require__(/*! ./../helpers/cookies */ "./node_modules/axios/lib/helpers/cookies.js");
// var buildURL = __webpack_require__(/*! ./../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
// var buildFullPath = __webpack_require__(/*! ../core/buildFullPath */ "./node_modules/axios/lib/core/buildFullPath.js");
// var parseHeaders = __webpack_require__(/*! ./../helpers/parseHeaders */ "./node_modules/axios/lib/helpers/parseHeaders.js");
// var isURLSameOrigin = __webpack_require__(/*! ./../helpers/isURLSameOrigin */ "./node_modules/axios/lib/helpers/isURLSameOrigin.js");
// var createError = __webpack_require__(/*! ../core/createError */ "./node_modules/axios/lib/core/createError.js");
// var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");
// var Cancel = __webpack_require__(/*! ../cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

// module.exports = function xhrAdapter(config) {
//   return new Promise(function dispatchXhrRequest(resolve, reject) {
//     var requestData = config.data;
//     var requestHeaders = config.headers;
//     var responseType = config.responseType;
//     var onCanceled;
//     function done() {
//       if (config.cancelToken) {
//         config.cancelToken.unsubscribe(onCanceled);
//       }

//       if (config.signal) {
//         config.signal.removeEventListener('abort', onCanceled);
//       }
//     }

//     if (utils.isFormData(requestData)) {
//       delete requestHeaders['Content-Type']; // Let the browser set it
//     }

//     var request = new XMLHttpRequest();

//     // HTTP basic authentication
//     if (config.auth) {
//       var username = config.auth.username || '';
//       var password = config.auth.password ? unescape(encodeURIComponent(config.auth.password)) : '';
//       requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
//     }

//     var fullPath = buildFullPath(config.baseURL, config.url);
//     request.open(config.method.toUpperCase(), buildURL(fullPath, config.params, config.paramsSerializer), true);

//     // Set the request timeout in MS
//     request.timeout = config.timeout;

//     function onloadend() {
//       if (!request) {
//         return;
//       }
//       // Prepare the response
//       var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
//       var responseData = !responseType || responseType === 'text' ||  responseType === 'json' ?
//         request.responseText : request.response;
//       var response = {
//         data: responseData,
//         status: request.status,
//         statusText: request.statusText,
//         headers: responseHeaders,
//         config: config,
//         request: request
//       };

//       settle(function _resolve(value) {
//         resolve(value);
//         done();
//       }, function _reject(err) {
//         reject(err);
//         done();
//       }, response);

//       // Clean up request
//       request = null;
//     }

//     if ('onloadend' in request) {
//       // Use onloadend if available
//       request.onloadend = onloadend;
//     } else {
//       // Listen for ready state to emulate onloadend
//       request.onreadystatechange = function handleLoad() {
//         if (!request || request.readyState !== 4) {
//           return;
//         }

//         // The request errored out and we didn't get a response, this will be
//         // handled by onerror instead
//         // With one exception: request that using file: protocol, most browsers
//         // will return status as 0 even though it's a successful request
//         if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
//           return;
//         }
//         // readystate handler is calling before onerror or ontimeout handlers,
//         // so we should call onloadend on the next 'tick'
//         setTimeout(onloadend);
//       };
//     }

//     // Handle browser request cancellation (as opposed to a manual cancellation)
//     request.onabort = function handleAbort() {
//       if (!request) {
//         return;
//       }

//       reject(createError('Request aborted', config, 'ECONNABORTED', request));

//       // Clean up request
//       request = null;
//     };

//     // Handle low level network errors
//     request.onerror = function handleError() {
//       // Real errors are hidden from us by the browser
//       // onerror should only fire if it's a network error
//       reject(createError('Network Error', config, null, request));

//       // Clean up request
//       request = null;
//     };

//     // Handle timeout
//     request.ontimeout = function handleTimeout() {
//       var timeoutErrorMessage = config.timeout ? 'timeout of ' + config.timeout + 'ms exceeded' : 'timeout exceeded';
//       var transitional = config.transitional || defaults.transitional;
//       if (config.timeoutErrorMessage) {
//         timeoutErrorMessage = config.timeoutErrorMessage;
//       }
//       reject(createError(
//         timeoutErrorMessage,
//         config,
//         transitional.clarifyTimeoutError ? 'ETIMEDOUT' : 'ECONNABORTED',
//         request));

//       // Clean up request
//       request = null;
//     };

//     // Add xsrf header
//     // This is only done if running in a standard browser environment.
//     // Specifically not if we're in a web worker, or react-native.
//     if (utils.isStandardBrowserEnv()) {
//       // Add xsrf header
//       var xsrfValue = (config.withCredentials || isURLSameOrigin(fullPath)) && config.xsrfCookieName ?
//         cookies.read(config.xsrfCookieName) :
//         undefined;

//       if (xsrfValue) {
//         requestHeaders[config.xsrfHeaderName] = xsrfValue;
//       }
//     }

//     // Add headers to the request
//     if ('setRequestHeader' in request) {
//       utils.forEach(requestHeaders, function setRequestHeader(val, key) {
//         if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
//           // Remove Content-Type if data is undefined
//           delete requestHeaders[key];
//         } else {
//           // Otherwise add header to the request
//           request.setRequestHeader(key, val);
//         }
//       });
//     }

//     // Add withCredentials to request if needed
//     if (!utils.isUndefined(config.withCredentials)) {
//       request.withCredentials = !!config.withCredentials;
//     }

//     // Add responseType to request if needed
//     if (responseType && responseType !== 'json') {
//       request.responseType = config.responseType;
//     }

//     // Handle progress if needed
//     if (typeof config.onDownloadProgress === 'function') {
//       request.addEventListener('progress', config.onDownloadProgress);
//     }

//     // Not all browsers support upload events
//     if (typeof config.onUploadProgress === 'function' && request.upload) {
//       request.upload.addEventListener('progress', config.onUploadProgress);
//     }

//     if (config.cancelToken || config.signal) {
//       // Handle cancellation
//       // eslint-disable-next-line func-names
//       onCanceled = function(cancel) {
//         if (!request) {
//           return;
//         }
//         reject(!cancel || (cancel && cancel.type) ? new Cancel('canceled') : cancel);
//         request.abort();
//         request = null;
//       };

//       config.cancelToken && config.cancelToken.subscribe(onCanceled);
//       if (config.signal) {
//         config.signal.aborted ? onCanceled() : config.signal.addEventListener('abort', onCanceled);
//       }
//     }

//     if (!requestData) {
//       requestData = null;
//     }

//     // Send the request
//     request.send(requestData);
//   });
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/axios.js":
// /*!*****************************************!*\
//   !*** ./node_modules/axios/lib/axios.js ***!
//   \*****************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
// var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");
// var Axios = __webpack_require__(/*! ./core/Axios */ "./node_modules/axios/lib/core/Axios.js");
// var mergeConfig = __webpack_require__(/*! ./core/mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
// var defaults = __webpack_require__(/*! ./defaults */ "./node_modules/axios/lib/defaults.js");

// /**
//  * Create an instance of Axios
//  *
//  * @param {Object} defaultConfig The default config for the instance
//  * @return {Axios} A new instance of Axios
//  */
// function createInstance(defaultConfig) {
//   var context = new Axios(defaultConfig);
//   var instance = bind(Axios.prototype.request, context);

//   // Copy axios.prototype to instance
//   utils.extend(instance, Axios.prototype, context);

//   // Copy context to instance
//   utils.extend(instance, context);

//   // Factory for creating new instances
//   instance.create = function create(instanceConfig) {
//     return createInstance(mergeConfig(defaultConfig, instanceConfig));
//   };

//   return instance;
// }

// // Create the default instance to be exported
// var axios = createInstance(defaults);

// // Expose Axios class to allow class inheritance
// axios.Axios = Axios;

// // Expose Cancel & CancelToken
// axios.Cancel = __webpack_require__(/*! ./cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");
// axios.CancelToken = __webpack_require__(/*! ./cancel/CancelToken */ "./node_modules/axios/lib/cancel/CancelToken.js");
// axios.isCancel = __webpack_require__(/*! ./cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
// axios.VERSION = (__webpack_require__(/*! ./env/data */ "./node_modules/axios/lib/env/data.js").version);

// // Expose all/spread
// axios.all = function all(promises) {
//   return Promise.all(promises);
// };
// axios.spread = __webpack_require__(/*! ./helpers/spread */ "./node_modules/axios/lib/helpers/spread.js");

// // Expose isAxiosError
// axios.isAxiosError = __webpack_require__(/*! ./helpers/isAxiosError */ "./node_modules/axios/lib/helpers/isAxiosError.js");

// module.exports = axios;

// // Allow use of default import syntax in TypeScript
// module.exports["default"] = axios;


// /***/ }),

// /***/ "./node_modules/axios/lib/cancel/Cancel.js":
// /*!*************************************************!*\
//   !*** ./node_modules/axios/lib/cancel/Cancel.js ***!
//   \*************************************************/
// /***/ ((module) => {

// "use strict";


// /**
//  * A `Cancel` is an object that is thrown when an operation is canceled.
//  *
//  * @class
//  * @param {string=} message The message.
//  */
// function Cancel(message) {
//   this.message = message;
// }

// Cancel.prototype.toString = function toString() {
//   return 'Cancel' + (this.message ? ': ' + this.message : '');
// };

// Cancel.prototype.__CANCEL__ = true;

// module.exports = Cancel;


// /***/ }),

// /***/ "./node_modules/axios/lib/cancel/CancelToken.js":
// /*!******************************************************!*\
//   !*** ./node_modules/axios/lib/cancel/CancelToken.js ***!
//   \******************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var Cancel = __webpack_require__(/*! ./Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

// /**
//  * A `CancelToken` is an object that can be used to request cancellation of an operation.
//  *
//  * @class
//  * @param {Function} executor The executor function.
//  */
// function CancelToken(executor) {
//   if (typeof executor !== 'function') {
//     throw new TypeError('executor must be a function.');
//   }

//   var resolvePromise;

//   this.promise = new Promise(function promiseExecutor(resolve) {
//     resolvePromise = resolve;
//   });

//   var token = this;

//   // eslint-disable-next-line func-names
//   this.promise.then(function(cancel) {
//     if (!token._listeners) return;

//     var i;
//     var l = token._listeners.length;

//     for (i = 0; i < l; i++) {
//       token._listeners[i](cancel);
//     }
//     token._listeners = null;
//   });

//   // eslint-disable-next-line func-names
//   this.promise.then = function(onfulfilled) {
//     var _resolve;
//     // eslint-disable-next-line func-names
//     var promise = new Promise(function(resolve) {
//       token.subscribe(resolve);
//       _resolve = resolve;
//     }).then(onfulfilled);

//     promise.cancel = function reject() {
//       token.unsubscribe(_resolve);
//     };

//     return promise;
//   };

//   executor(function cancel(message) {
//     if (token.reason) {
//       // Cancellation has already been requested
//       return;
//     }

//     token.reason = new Cancel(message);
//     resolvePromise(token.reason);
//   });
// }

// /**
//  * Throws a `Cancel` if cancellation has been requested.
//  */
// CancelToken.prototype.throwIfRequested = function throwIfRequested() {
//   if (this.reason) {
//     throw this.reason;
//   }
// };

// /**
//  * Subscribe to the cancel signal
//  */

// CancelToken.prototype.subscribe = function subscribe(listener) {
//   if (this.reason) {
//     listener(this.reason);
//     return;
//   }

//   if (this._listeners) {
//     this._listeners.push(listener);
//   } else {
//     this._listeners = [listener];
//   }
// };

// /**
//  * Unsubscribe from the cancel signal
//  */

// CancelToken.prototype.unsubscribe = function unsubscribe(listener) {
//   if (!this._listeners) {
//     return;
//   }
//   var index = this._listeners.indexOf(listener);
//   if (index !== -1) {
//     this._listeners.splice(index, 1);
//   }
// };

// /**
//  * Returns an object that contains a new `CancelToken` and a function that, when called,
//  * cancels the `CancelToken`.
//  */
// CancelToken.source = function source() {
//   var cancel;
//   var token = new CancelToken(function executor(c) {
//     cancel = c;
//   });
//   return {
//     token: token,
//     cancel: cancel
//   };
// };

// module.exports = CancelToken;


// /***/ }),

// /***/ "./node_modules/axios/lib/cancel/isCancel.js":
// /*!***************************************************!*\
//   !*** ./node_modules/axios/lib/cancel/isCancel.js ***!
//   \***************************************************/
// /***/ ((module) => {

// "use strict";


// module.exports = function isCancel(value) {
//   return !!(value && value.__CANCEL__);
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/core/Axios.js":
// /*!**********************************************!*\
//   !*** ./node_modules/axios/lib/core/Axios.js ***!
//   \**********************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
// var buildURL = __webpack_require__(/*! ../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
// var InterceptorManager = __webpack_require__(/*! ./InterceptorManager */ "./node_modules/axios/lib/core/InterceptorManager.js");
// var dispatchRequest = __webpack_require__(/*! ./dispatchRequest */ "./node_modules/axios/lib/core/dispatchRequest.js");
// var mergeConfig = __webpack_require__(/*! ./mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
// var validator = __webpack_require__(/*! ../helpers/validator */ "./node_modules/axios/lib/helpers/validator.js");

// var validators = validator.validators;
// /**
//  * Create a new instance of Axios
//  *
//  * @param {Object} instanceConfig The default config for the instance
//  */
// function Axios(instanceConfig) {
//   this.defaults = instanceConfig;
//   this.interceptors = {
//     request: new InterceptorManager(),
//     response: new InterceptorManager()
//   };
// }

// /**
//  * Dispatch a request
//  *
//  * @param {Object} config The config specific for this request (merged with this.defaults)
//  */
// Axios.prototype.request = function request(configOrUrl, config) {
//   /*eslint no-param-reassign:0*/
//   // Allow for axios('example/url'[, config]) a la fetch API
//   if (typeof configOrUrl === 'string') {
//     config = config || {};
//     config.url = configOrUrl;
//   } else {
//     config = configOrUrl || {};
//   }

//   if (!config.url) {
//     throw new Error('Provided config url is not valid');
//   }

//   config = mergeConfig(this.defaults, config);

//   // Set config.method
//   if (config.method) {
//     config.method = config.method.toLowerCase();
//   } else if (this.defaults.method) {
//     config.method = this.defaults.method.toLowerCase();
//   } else {
//     config.method = 'get';
//   }

//   var transitional = config.transitional;

//   if (transitional !== undefined) {
//     validator.assertOptions(transitional, {
//       silentJSONParsing: validators.transitional(validators.boolean),
//       forcedJSONParsing: validators.transitional(validators.boolean),
//       clarifyTimeoutError: validators.transitional(validators.boolean)
//     }, false);
//   }

//   // filter out skipped interceptors
//   var requestInterceptorChain = [];
//   var synchronousRequestInterceptors = true;
//   this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
//     if (typeof interceptor.runWhen === 'function' && interceptor.runWhen(config) === false) {
//       return;
//     }

//     synchronousRequestInterceptors = synchronousRequestInterceptors && interceptor.synchronous;

//     requestInterceptorChain.unshift(interceptor.fulfilled, interceptor.rejected);
//   });

//   var responseInterceptorChain = [];
//   this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
//     responseInterceptorChain.push(interceptor.fulfilled, interceptor.rejected);
//   });

//   var promise;

//   if (!synchronousRequestInterceptors) {
//     var chain = [dispatchRequest, undefined];

//     Array.prototype.unshift.apply(chain, requestInterceptorChain);
//     chain = chain.concat(responseInterceptorChain);

//     promise = Promise.resolve(config);
//     while (chain.length) {
//       promise = promise.then(chain.shift(), chain.shift());
//     }

//     return promise;
//   }


//   var newConfig = config;
//   while (requestInterceptorChain.length) {
//     var onFulfilled = requestInterceptorChain.shift();
//     var onRejected = requestInterceptorChain.shift();
//     try {
//       newConfig = onFulfilled(newConfig);
//     } catch (error) {
//       onRejected(error);
//       break;
//     }
//   }

//   try {
//     promise = dispatchRequest(newConfig);
//   } catch (error) {
//     return Promise.reject(error);
//   }

//   while (responseInterceptorChain.length) {
//     promise = promise.then(responseInterceptorChain.shift(), responseInterceptorChain.shift());
//   }

//   return promise;
// };

// Axios.prototype.getUri = function getUri(config) {
//   if (!config.url) {
//     throw new Error('Provided config url is not valid');
//   }
//   config = mergeConfig(this.defaults, config);
//   return buildURL(config.url, config.params, config.paramsSerializer).replace(/^\?/, '');
// };

// // Provide aliases for supported request methods
// utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
//   /*eslint func-names:0*/
//   Axios.prototype[method] = function(url, config) {
//     return this.request(mergeConfig(config || {}, {
//       method: method,
//       url: url,
//       data: (config || {}).data
//     }));
//   };
// });

// utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
//   /*eslint func-names:0*/
//   Axios.prototype[method] = function(url, data, config) {
//     return this.request(mergeConfig(config || {}, {
//       method: method,
//       url: url,
//       data: data
//     }));
//   };
// });

// module.exports = Axios;


// /***/ }),

// /***/ "./node_modules/axios/lib/core/InterceptorManager.js":
// /*!***********************************************************!*\
//   !*** ./node_modules/axios/lib/core/InterceptorManager.js ***!
//   \***********************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// function InterceptorManager() {
//   this.handlers = [];
// }

// /**
//  * Add a new interceptor to the stack
//  *
//  * @param {Function} fulfilled The function to handle `then` for a `Promise`
//  * @param {Function} rejected The function to handle `reject` for a `Promise`
//  *
//  * @return {Number} An ID used to remove interceptor later
//  */
// InterceptorManager.prototype.use = function use(fulfilled, rejected, options) {
//   this.handlers.push({
//     fulfilled: fulfilled,
//     rejected: rejected,
//     synchronous: options ? options.synchronous : false,
//     runWhen: options ? options.runWhen : null
//   });
//   return this.handlers.length - 1;
// };

// /**
//  * Remove an interceptor from the stack
//  *
//  * @param {Number} id The ID that was returned by `use`
//  */
// InterceptorManager.prototype.eject = function eject(id) {
//   if (this.handlers[id]) {
//     this.handlers[id] = null;
//   }
// };

// /**
//  * Iterate over all the registered interceptors
//  *
//  * This method is particularly useful for skipping over any
//  * interceptors that may have become `null` calling `eject`.
//  *
//  * @param {Function} fn The function to call for each interceptor
//  */
// InterceptorManager.prototype.forEach = function forEach(fn) {
//   utils.forEach(this.handlers, function forEachHandler(h) {
//     if (h !== null) {
//       fn(h);
//     }
//   });
// };

// module.exports = InterceptorManager;


// /***/ }),

// /***/ "./node_modules/axios/lib/core/buildFullPath.js":
// /*!******************************************************!*\
//   !*** ./node_modules/axios/lib/core/buildFullPath.js ***!
//   \******************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var isAbsoluteURL = __webpack_require__(/*! ../helpers/isAbsoluteURL */ "./node_modules/axios/lib/helpers/isAbsoluteURL.js");
// var combineURLs = __webpack_require__(/*! ../helpers/combineURLs */ "./node_modules/axios/lib/helpers/combineURLs.js");

// /**
//  * Creates a new URL by combining the baseURL with the requestedURL,
//  * only when the requestedURL is not already an absolute URL.
//  * If the requestURL is absolute, this function returns the requestedURL untouched.
//  *
//  * @param {string} baseURL The base URL
//  * @param {string} requestedURL Absolute or relative URL to combine
//  * @returns {string} The combined full path
//  */
// module.exports = function buildFullPath(baseURL, requestedURL) {
//   if (baseURL && !isAbsoluteURL(requestedURL)) {
//     return combineURLs(baseURL, requestedURL);
//   }
//   return requestedURL;
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/core/createError.js":
// /*!****************************************************!*\
//   !*** ./node_modules/axios/lib/core/createError.js ***!
//   \****************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var enhanceError = __webpack_require__(/*! ./enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

// /**
//  * Create an Error with the specified message, config, error code, request and response.
//  *
//  * @param {string} message The error message.
//  * @param {Object} config The config.
//  * @param {string} [code] The error code (for example, 'ECONNABORTED').
//  * @param {Object} [request] The request.
//  * @param {Object} [response] The response.
//  * @returns {Error} The created error.
//  */
// module.exports = function createError(message, config, code, request, response) {
//   var error = new Error(message);
//   return enhanceError(error, config, code, request, response);
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/core/dispatchRequest.js":
// /*!********************************************************!*\
//   !*** ./node_modules/axios/lib/core/dispatchRequest.js ***!
//   \********************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
// var transformData = __webpack_require__(/*! ./transformData */ "./node_modules/axios/lib/core/transformData.js");
// var isCancel = __webpack_require__(/*! ../cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
// var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");
// var Cancel = __webpack_require__(/*! ../cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

// /**
//  * Throws a `Cancel` if cancellation has been requested.
//  */
// function throwIfCancellationRequested(config) {
//   if (config.cancelToken) {
//     config.cancelToken.throwIfRequested();
//   }

//   if (config.signal && config.signal.aborted) {
//     throw new Cancel('canceled');
//   }
// }

// /**
//  * Dispatch a request to the server using the configured adapter.
//  *
//  * @param {object} config The config that is to be used for the request
//  * @returns {Promise} The Promise to be fulfilled
//  */
// module.exports = function dispatchRequest(config) {
//   throwIfCancellationRequested(config);

//   // Ensure headers exist
//   config.headers = config.headers || {};

//   // Transform request data
//   config.data = transformData.call(
//     config,
//     config.data,
//     config.headers,
//     config.transformRequest
//   );

//   // Flatten headers
//   config.headers = utils.merge(
//     config.headers.common || {},
//     config.headers[config.method] || {},
//     config.headers
//   );

//   utils.forEach(
//     ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
//     function cleanHeaderConfig(method) {
//       delete config.headers[method];
//     }
//   );

//   var adapter = config.adapter || defaults.adapter;

//   return adapter(config).then(function onAdapterResolution(response) {
//     throwIfCancellationRequested(config);

//     // Transform response data
//     response.data = transformData.call(
//       config,
//       response.data,
//       response.headers,
//       config.transformResponse
//     );

//     return response;
//   }, function onAdapterRejection(reason) {
//     if (!isCancel(reason)) {
//       throwIfCancellationRequested(config);

//       // Transform response data
//       if (reason && reason.response) {
//         reason.response.data = transformData.call(
//           config,
//           reason.response.data,
//           reason.response.headers,
//           config.transformResponse
//         );
//       }
//     }

//     return Promise.reject(reason);
//   });
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/core/enhanceError.js":
// /*!*****************************************************!*\
//   !*** ./node_modules/axios/lib/core/enhanceError.js ***!
//   \*****************************************************/
// /***/ ((module) => {

// "use strict";


// /**
//  * Update an Error with the specified config, error code, and response.
//  *
//  * @param {Error} error The error to update.
//  * @param {Object} config The config.
//  * @param {string} [code] The error code (for example, 'ECONNABORTED').
//  * @param {Object} [request] The request.
//  * @param {Object} [response] The response.
//  * @returns {Error} The error.
//  */
// module.exports = function enhanceError(error, config, code, request, response) {
//   error.config = config;
//   if (code) {
//     error.code = code;
//   }

//   error.request = request;
//   error.response = response;
//   error.isAxiosError = true;

//   error.toJSON = function toJSON() {
//     return {
//       // Standard
//       message: this.message,
//       name: this.name,
//       // Microsoft
//       description: this.description,
//       number: this.number,
//       // Mozilla
//       fileName: this.fileName,
//       lineNumber: this.lineNumber,
//       columnNumber: this.columnNumber,
//       stack: this.stack,
//       // Axios
//       config: this.config,
//       code: this.code,
//       status: this.response && this.response.status ? this.response.status : null
//     };
//   };
//   return error;
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/core/mergeConfig.js":
// /*!****************************************************!*\
//   !*** ./node_modules/axios/lib/core/mergeConfig.js ***!
//   \****************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

// /**
//  * Config-specific merge-function which creates a new config-object
//  * by merging two configuration objects together.
//  *
//  * @param {Object} config1
//  * @param {Object} config2
//  * @returns {Object} New object resulting from merging config2 to config1
//  */
// module.exports = function mergeConfig(config1, config2) {
//   // eslint-disable-next-line no-param-reassign
//   config2 = config2 || {};
//   var config = {};

//   function getMergedValue(target, source) {
//     if (utils.isPlainObject(target) && utils.isPlainObject(source)) {
//       return utils.merge(target, source);
//     } else if (utils.isPlainObject(source)) {
//       return utils.merge({}, source);
//     } else if (utils.isArray(source)) {
//       return source.slice();
//     }
//     return source;
//   }

//   // eslint-disable-next-line consistent-return
//   function mergeDeepProperties(prop) {
//     if (!utils.isUndefined(config2[prop])) {
//       return getMergedValue(config1[prop], config2[prop]);
//     } else if (!utils.isUndefined(config1[prop])) {
//       return getMergedValue(undefined, config1[prop]);
//     }
//   }

//   // eslint-disable-next-line consistent-return
//   function valueFromConfig2(prop) {
//     if (!utils.isUndefined(config2[prop])) {
//       return getMergedValue(undefined, config2[prop]);
//     }
//   }

//   // eslint-disable-next-line consistent-return
//   function defaultToConfig2(prop) {
//     if (!utils.isUndefined(config2[prop])) {
//       return getMergedValue(undefined, config2[prop]);
//     } else if (!utils.isUndefined(config1[prop])) {
//       return getMergedValue(undefined, config1[prop]);
//     }
//   }

//   // eslint-disable-next-line consistent-return
//   function mergeDirectKeys(prop) {
//     if (prop in config2) {
//       return getMergedValue(config1[prop], config2[prop]);
//     } else if (prop in config1) {
//       return getMergedValue(undefined, config1[prop]);
//     }
//   }

//   var mergeMap = {
//     'url': valueFromConfig2,
//     'method': valueFromConfig2,
//     'data': valueFromConfig2,
//     'baseURL': defaultToConfig2,
//     'transformRequest': defaultToConfig2,
//     'transformResponse': defaultToConfig2,
//     'paramsSerializer': defaultToConfig2,
//     'timeout': defaultToConfig2,
//     'timeoutMessage': defaultToConfig2,
//     'withCredentials': defaultToConfig2,
//     'adapter': defaultToConfig2,
//     'responseType': defaultToConfig2,
//     'xsrfCookieName': defaultToConfig2,
//     'xsrfHeaderName': defaultToConfig2,
//     'onUploadProgress': defaultToConfig2,
//     'onDownloadProgress': defaultToConfig2,
//     'decompress': defaultToConfig2,
//     'maxContentLength': defaultToConfig2,
//     'maxBodyLength': defaultToConfig2,
//     'transport': defaultToConfig2,
//     'httpAgent': defaultToConfig2,
//     'httpsAgent': defaultToConfig2,
//     'cancelToken': defaultToConfig2,
//     'socketPath': defaultToConfig2,
//     'responseEncoding': defaultToConfig2,
//     'validateStatus': mergeDirectKeys
//   };

//   utils.forEach(Object.keys(config1).concat(Object.keys(config2)), function computeConfigValue(prop) {
//     var merge = mergeMap[prop] || mergeDeepProperties;
//     var configValue = merge(prop);
//     (utils.isUndefined(configValue) && merge !== mergeDirectKeys) || (config[prop] = configValue);
//   });

//   return config;
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/core/settle.js":
// /*!***********************************************!*\
//   !*** ./node_modules/axios/lib/core/settle.js ***!
//   \***********************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var createError = __webpack_require__(/*! ./createError */ "./node_modules/axios/lib/core/createError.js");

// /**
//  * Resolve or reject a Promise based on response status.
//  *
//  * @param {Function} resolve A function that resolves the promise.
//  * @param {Function} reject A function that rejects the promise.
//  * @param {object} response The response.
//  */
// module.exports = function settle(resolve, reject, response) {
//   var validateStatus = response.config.validateStatus;
//   if (!response.status || !validateStatus || validateStatus(response.status)) {
//     resolve(response);
//   } else {
//     reject(createError(
//       'Request failed with status code ' + response.status,
//       response.config,
//       null,
//       response.request,
//       response
//     ));
//   }
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/core/transformData.js":
// /*!******************************************************!*\
//   !*** ./node_modules/axios/lib/core/transformData.js ***!
//   \******************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
// var defaults = __webpack_require__(/*! ./../defaults */ "./node_modules/axios/lib/defaults.js");

// /**
//  * Transform the data for a request or a response
//  *
//  * @param {Object|String} data The data to be transformed
//  * @param {Array} headers The headers for the request or response
//  * @param {Array|Function} fns A single function or Array of functions
//  * @returns {*} The resulting transformed data
//  */
// module.exports = function transformData(data, headers, fns) {
//   var context = this || defaults;
//   /*eslint no-param-reassign:0*/
//   utils.forEach(fns, function transform(fn) {
//     data = fn.call(context, data, headers);
//   });

//   return data;
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/defaults.js":
// /*!********************************************!*\
//   !*** ./node_modules/axios/lib/defaults.js ***!
//   \********************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";
// /* provided dependency */ var process = __webpack_require__(/*! process/browser.js */ "./node_modules/process/browser.js");


// var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
// var normalizeHeaderName = __webpack_require__(/*! ./helpers/normalizeHeaderName */ "./node_modules/axios/lib/helpers/normalizeHeaderName.js");
// var enhanceError = __webpack_require__(/*! ./core/enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

// var DEFAULT_CONTENT_TYPE = {
//   'Content-Type': 'application/x-www-form-urlencoded'
// };

// function setContentTypeIfUnset(headers, value) {
//   if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
//     headers['Content-Type'] = value;
//   }
// }

// function getDefaultAdapter() {
//   var adapter;
//   if (typeof XMLHttpRequest !== 'undefined') {
//     // For browsers use XHR adapter
//     adapter = __webpack_require__(/*! ./adapters/xhr */ "./node_modules/axios/lib/adapters/xhr.js");
//   } else if (typeof process !== 'undefined' && Object.prototype.toString.call(process) === '[object process]') {
//     // For node use HTTP adapter
//     adapter = __webpack_require__(/*! ./adapters/http */ "./node_modules/axios/lib/adapters/xhr.js");
//   }
//   return adapter;
// }

// function stringifySafely(rawValue, parser, encoder) {
//   if (utils.isString(rawValue)) {
//     try {
//       (parser || JSON.parse)(rawValue);
//       return utils.trim(rawValue);
//     } catch (e) {
//       if (e.name !== 'SyntaxError') {
//         throw e;
//       }
//     }
//   }

//   return (encoder || JSON.stringify)(rawValue);
// }

// var defaults = {

//   transitional: {
//     silentJSONParsing: true,
//     forcedJSONParsing: true,
//     clarifyTimeoutError: false
//   },

//   adapter: getDefaultAdapter(),

//   transformRequest: [function transformRequest(data, headers) {
//     normalizeHeaderName(headers, 'Accept');
//     normalizeHeaderName(headers, 'Content-Type');

//     if (utils.isFormData(data) ||
//       utils.isArrayBuffer(data) ||
//       utils.isBuffer(data) ||
//       utils.isStream(data) ||
//       utils.isFile(data) ||
//       utils.isBlob(data)
//     ) {
//       return data;
//     }
//     if (utils.isArrayBufferView(data)) {
//       return data.buffer;
//     }
//     if (utils.isURLSearchParams(data)) {
//       setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
//       return data.toString();
//     }
//     if (utils.isObject(data) || (headers && headers['Content-Type'] === 'application/json')) {
//       setContentTypeIfUnset(headers, 'application/json');
//       return stringifySafely(data);
//     }
//     return data;
//   }],

//   transformResponse: [function transformResponse(data) {
//     var transitional = this.transitional || defaults.transitional;
//     var silentJSONParsing = transitional && transitional.silentJSONParsing;
//     var forcedJSONParsing = transitional && transitional.forcedJSONParsing;
//     var strictJSONParsing = !silentJSONParsing && this.responseType === 'json';

//     if (strictJSONParsing || (forcedJSONParsing && utils.isString(data) && data.length)) {
//       try {
//         return JSON.parse(data);
//       } catch (e) {
//         if (strictJSONParsing) {
//           if (e.name === 'SyntaxError') {
//             throw enhanceError(e, this, 'E_JSON_PARSE');
//           }
//           throw e;
//         }
//       }
//     }

//     return data;
//   }],

//   /**
//    * A timeout in milliseconds to abort a request. If set to 0 (default) a
//    * timeout is not created.
//    */
//   timeout: 0,

//   xsrfCookieName: 'XSRF-TOKEN',
//   xsrfHeaderName: 'X-XSRF-TOKEN',

//   maxContentLength: -1,
//   maxBodyLength: -1,

//   validateStatus: function validateStatus(status) {
//     return status >= 200 && status < 300;
//   },

//   headers: {
//     common: {
//       'Accept': 'application/json, text/plain, */*'
//     }
//   }
// };

// utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
//   defaults.headers[method] = {};
// });

// utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
//   defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
// });

// module.exports = defaults;


// /***/ }),

// /***/ "./node_modules/axios/lib/env/data.js":
// /*!********************************************!*\
//   !*** ./node_modules/axios/lib/env/data.js ***!
//   \********************************************/
// /***/ ((module) => {

// module.exports = {
//   "version": "0.25.0"
// };

// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/bind.js":
// /*!************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/bind.js ***!
//   \************************************************/
// /***/ ((module) => {

// "use strict";


// module.exports = function bind(fn, thisArg) {
//   return function wrap() {
//     var args = new Array(arguments.length);
//     for (var i = 0; i < args.length; i++) {
//       args[i] = arguments[i];
//     }
//     return fn.apply(thisArg, args);
//   };
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/buildURL.js":
// /*!****************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/buildURL.js ***!
//   \****************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// function encode(val) {
//   return encodeURIComponent(val).
//     replace(/%3A/gi, ':').
//     replace(/%24/g, '$').
//     replace(/%2C/gi, ',').
//     replace(/%20/g, '+').
//     replace(/%5B/gi, '[').
//     replace(/%5D/gi, ']');
// }

// /**
//  * Build a URL by appending params to the end
//  *
//  * @param {string} url The base of the url (e.g., http://www.google.com)
//  * @param {object} [params] The params to be appended
//  * @returns {string} The formatted url
//  */
// module.exports = function buildURL(url, params, paramsSerializer) {
//   /*eslint no-param-reassign:0*/
//   if (!params) {
//     return url;
//   }

//   var serializedParams;
//   if (paramsSerializer) {
//     serializedParams = paramsSerializer(params);
//   } else if (utils.isURLSearchParams(params)) {
//     serializedParams = params.toString();
//   } else {
//     var parts = [];

//     utils.forEach(params, function serialize(val, key) {
//       if (val === null || typeof val === 'undefined') {
//         return;
//       }

//       if (utils.isArray(val)) {
//         key = key + '[]';
//       } else {
//         val = [val];
//       }

//       utils.forEach(val, function parseValue(v) {
//         if (utils.isDate(v)) {
//           v = v.toISOString();
//         } else if (utils.isObject(v)) {
//           v = JSON.stringify(v);
//         }
//         parts.push(encode(key) + '=' + encode(v));
//       });
//     });

//     serializedParams = parts.join('&');
//   }

//   if (serializedParams) {
//     var hashmarkIndex = url.indexOf('#');
//     if (hashmarkIndex !== -1) {
//       url = url.slice(0, hashmarkIndex);
//     }

//     url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
//   }

//   return url;
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/combineURLs.js":
// /*!*******************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/combineURLs.js ***!
//   \*******************************************************/
// /***/ ((module) => {

// "use strict";


// /**
//  * Creates a new URL by combining the specified URLs
//  *
//  * @param {string} baseURL The base URL
//  * @param {string} relativeURL The relative URL
//  * @returns {string} The combined URL
//  */
// module.exports = function combineURLs(baseURL, relativeURL) {
//   return relativeURL
//     ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
//     : baseURL;
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/cookies.js":
// /*!***************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/cookies.js ***!
//   \***************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// module.exports = (
//   utils.isStandardBrowserEnv() ?

//   // Standard browser envs support document.cookie
//     (function standardBrowserEnv() {
//       return {
//         write: function write(name, value, expires, path, domain, secure) {
//           var cookie = [];
//           cookie.push(name + '=' + encodeURIComponent(value));

//           if (utils.isNumber(expires)) {
//             cookie.push('expires=' + new Date(expires).toGMTString());
//           }

//           if (utils.isString(path)) {
//             cookie.push('path=' + path);
//           }

//           if (utils.isString(domain)) {
//             cookie.push('domain=' + domain);
//           }

//           if (secure === true) {
//             cookie.push('secure');
//           }

//           document.cookie = cookie.join('; ');
//         },

//         read: function read(name) {
//           var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
//           return (match ? decodeURIComponent(match[3]) : null);
//         },

//         remove: function remove(name) {
//           this.write(name, '', Date.now() - 86400000);
//         }
//       };
//     })() :

//   // Non standard browser env (web workers, react-native) lack needed support.
//     (function nonStandardBrowserEnv() {
//       return {
//         write: function write() {},
//         read: function read() { return null; },
//         remove: function remove() {}
//       };
//     })()
// );


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/isAbsoluteURL.js":
// /*!*********************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/isAbsoluteURL.js ***!
//   \*********************************************************/
// /***/ ((module) => {

// "use strict";


// /**
//  * Determines whether the specified URL is absolute
//  *
//  * @param {string} url The URL to test
//  * @returns {boolean} True if the specified URL is absolute, otherwise false
//  */
// module.exports = function isAbsoluteURL(url) {
//   // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
//   // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
//   // by any combination of letters, digits, plus, period, or hyphen.
//   return /^([a-z][a-z\d+\-.]*:)?\/\//i.test(url);
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/isAxiosError.js":
// /*!********************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/isAxiosError.js ***!
//   \********************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// /**
//  * Determines whether the payload is an error thrown by Axios
//  *
//  * @param {*} payload The value to test
//  * @returns {boolean} True if the payload is an error thrown by Axios, otherwise false
//  */
// module.exports = function isAxiosError(payload) {
//   return utils.isObject(payload) && (payload.isAxiosError === true);
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/isURLSameOrigin.js":
// /*!***********************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/isURLSameOrigin.js ***!
//   \***********************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// module.exports = (
//   utils.isStandardBrowserEnv() ?

//   // Standard browser envs have full support of the APIs needed to test
//   // whether the request URL is of the same origin as current location.
//     (function standardBrowserEnv() {
//       var msie = /(msie|trident)/i.test(navigator.userAgent);
//       var urlParsingNode = document.createElement('a');
//       var originURL;

//       /**
//     * Parse a URL to discover it's components
//     *
//     * @param {String} url The URL to be parsed
//     * @returns {Object}
//     */
//       function resolveURL(url) {
//         var href = url;

//         if (msie) {
//         // IE needs attribute set twice to normalize properties
//           urlParsingNode.setAttribute('href', href);
//           href = urlParsingNode.href;
//         }

//         urlParsingNode.setAttribute('href', href);

//         // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
//         return {
//           href: urlParsingNode.href,
//           protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
//           host: urlParsingNode.host,
//           search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
//           hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
//           hostname: urlParsingNode.hostname,
//           port: urlParsingNode.port,
//           pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
//             urlParsingNode.pathname :
//             '/' + urlParsingNode.pathname
//         };
//       }

//       originURL = resolveURL(window.location.href);

//       /**
//     * Determine if a URL shares the same origin as the current location
//     *
//     * @param {String} requestURL The URL to test
//     * @returns {boolean} True if URL shares the same origin, otherwise false
//     */
//       return function isURLSameOrigin(requestURL) {
//         var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
//         return (parsed.protocol === originURL.protocol &&
//             parsed.host === originURL.host);
//       };
//     })() :

//   // Non standard browser envs (web workers, react-native) lack needed support.
//     (function nonStandardBrowserEnv() {
//       return function isURLSameOrigin() {
//         return true;
//       };
//     })()
// );


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/normalizeHeaderName.js":
// /*!***************************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/normalizeHeaderName.js ***!
//   \***************************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

// module.exports = function normalizeHeaderName(headers, normalizedName) {
//   utils.forEach(headers, function processHeader(value, name) {
//     if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
//       headers[normalizedName] = value;
//       delete headers[name];
//     }
//   });
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/parseHeaders.js":
// /*!********************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/parseHeaders.js ***!
//   \********************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// // Headers whose duplicates are ignored by node
// // c.f. https://nodejs.org/api/http.html#http_message_headers
// var ignoreDuplicateOf = [
//   'age', 'authorization', 'content-length', 'content-type', 'etag',
//   'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
//   'last-modified', 'location', 'max-forwards', 'proxy-authorization',
//   'referer', 'retry-after', 'user-agent'
// ];

// /**
//  * Parse headers into an object
//  *
//  * ```
//  * Date: Wed, 27 Aug 2014 08:58:49 GMT
//  * Content-Type: application/json
//  * Connection: keep-alive
//  * Transfer-Encoding: chunked
//  * ```
//  *
//  * @param {String} headers Headers needing to be parsed
//  * @returns {Object} Headers parsed into an object
//  */
// module.exports = function parseHeaders(headers) {
//   var parsed = {};
//   var key;
//   var val;
//   var i;

//   if (!headers) { return parsed; }

//   utils.forEach(headers.split('\n'), function parser(line) {
//     i = line.indexOf(':');
//     key = utils.trim(line.substr(0, i)).toLowerCase();
//     val = utils.trim(line.substr(i + 1));

//     if (key) {
//       if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
//         return;
//       }
//       if (key === 'set-cookie') {
//         parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
//       } else {
//         parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
//       }
//     }
//   });

//   return parsed;
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/spread.js":
// /*!**************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/spread.js ***!
//   \**************************************************/
// /***/ ((module) => {

// "use strict";


// /**
//  * Syntactic sugar for invoking a function and expanding an array for arguments.
//  *
//  * Common use case would be to use `Function.prototype.apply`.
//  *
//  *  ```js
//  *  function f(x, y, z) {}
//  *  var args = [1, 2, 3];
//  *  f.apply(null, args);
//  *  ```
//  *
//  * With `spread` this example can be re-written.
//  *
//  *  ```js
//  *  spread(function(x, y, z) {})([1, 2, 3]);
//  *  ```
//  *
//  * @param {Function} callback
//  * @returns {Function}
//  */
// module.exports = function spread(callback) {
//   return function wrap(arr) {
//     return callback.apply(null, arr);
//   };
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/helpers/validator.js":
// /*!*****************************************************!*\
//   !*** ./node_modules/axios/lib/helpers/validator.js ***!
//   \*****************************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var VERSION = (__webpack_require__(/*! ../env/data */ "./node_modules/axios/lib/env/data.js").version);

// var validators = {};

// // eslint-disable-next-line func-names
// ['object', 'boolean', 'number', 'function', 'string', 'symbol'].forEach(function(type, i) {
//   validators[type] = function validator(thing) {
//     return typeof thing === type || 'a' + (i < 1 ? 'n ' : ' ') + type;
//   };
// });

// var deprecatedWarnings = {};

// /**
//  * Transitional option validator
//  * @param {function|boolean?} validator - set to false if the transitional option has been removed
//  * @param {string?} version - deprecated version / removed since version
//  * @param {string?} message - some message with additional info
//  * @returns {function}
//  */
// validators.transitional = function transitional(validator, version, message) {
//   function formatMessage(opt, desc) {
//     return '[Axios v' + VERSION + '] Transitional option \'' + opt + '\'' + desc + (message ? '. ' + message : '');
//   }

//   // eslint-disable-next-line func-names
//   return function(value, opt, opts) {
//     if (validator === false) {
//       throw new Error(formatMessage(opt, ' has been removed' + (version ? ' in ' + version : '')));
//     }

//     if (version && !deprecatedWarnings[opt]) {
//       deprecatedWarnings[opt] = true;
//       // eslint-disable-next-line no-console
//       console.warn(
//         formatMessage(
//           opt,
//           ' has been deprecated since v' + version + ' and will be removed in the near future'
//         )
//       );
//     }

//     return validator ? validator(value, opt, opts) : true;
//   };
// };

// /**
//  * Assert object's properties type
//  * @param {object} options
//  * @param {object} schema
//  * @param {boolean?} allowUnknown
//  */

// function assertOptions(options, schema, allowUnknown) {
//   if (typeof options !== 'object') {
//     throw new TypeError('options must be an object');
//   }
//   var keys = Object.keys(options);
//   var i = keys.length;
//   while (i-- > 0) {
//     var opt = keys[i];
//     var validator = schema[opt];
//     if (validator) {
//       var value = options[opt];
//       var result = value === undefined || validator(value, opt, options);
//       if (result !== true) {
//         throw new TypeError('option ' + opt + ' must be ' + result);
//       }
//       continue;
//     }
//     if (allowUnknown !== true) {
//       throw Error('Unknown option ' + opt);
//     }
//   }
// }

// module.exports = {
//   assertOptions: assertOptions,
//   validators: validators
// };


// /***/ }),

// /***/ "./node_modules/axios/lib/utils.js":
// /*!*****************************************!*\
//   !*** ./node_modules/axios/lib/utils.js ***!
//   \*****************************************/
// /***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// "use strict";


// var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");

// // utils is a library of generic helper functions non-specific to axios

// var toString = Object.prototype.toString;

// /**
//  * Determine if a value is an Array
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is an Array, otherwise false
//  */
// function isArray(val) {
//   return Array.isArray(val);
// }

// /**
//  * Determine if a value is undefined
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if the value is undefined, otherwise false
//  */
// function isUndefined(val) {
//   return typeof val === 'undefined';
// }

// /**
//  * Determine if a value is a Buffer
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a Buffer, otherwise false
//  */
// function isBuffer(val) {
//   return val !== null && !isUndefined(val) && val.constructor !== null && !isUndefined(val.constructor)
//     && typeof val.constructor.isBuffer === 'function' && val.constructor.isBuffer(val);
// }

// /**
//  * Determine if a value is an ArrayBuffer
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is an ArrayBuffer, otherwise false
//  */
// function isArrayBuffer(val) {
//   return toString.call(val) === '[object ArrayBuffer]';
// }

// /**
//  * Determine if a value is a FormData
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is an FormData, otherwise false
//  */
// function isFormData(val) {
//   return toString.call(val) === '[object FormData]';
// }

// /**
//  * Determine if a value is a view on an ArrayBuffer
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
//  */
// function isArrayBufferView(val) {
//   var result;
//   if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
//     result = ArrayBuffer.isView(val);
//   } else {
//     result = (val) && (val.buffer) && (isArrayBuffer(val.buffer));
//   }
//   return result;
// }

// /**
//  * Determine if a value is a String
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a String, otherwise false
//  */
// function isString(val) {
//   return typeof val === 'string';
// }

// /**
//  * Determine if a value is a Number
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a Number, otherwise false
//  */
// function isNumber(val) {
//   return typeof val === 'number';
// }

// /**
//  * Determine if a value is an Object
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is an Object, otherwise false
//  */
// function isObject(val) {
//   return val !== null && typeof val === 'object';
// }

// /**
//  * Determine if a value is a plain Object
//  *
//  * @param {Object} val The value to test
//  * @return {boolean} True if value is a plain Object, otherwise false
//  */
// function isPlainObject(val) {
//   if (toString.call(val) !== '[object Object]') {
//     return false;
//   }

//   var prototype = Object.getPrototypeOf(val);
//   return prototype === null || prototype === Object.prototype;
// }

// /**
//  * Determine if a value is a Date
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a Date, otherwise false
//  */
// function isDate(val) {
//   return toString.call(val) === '[object Date]';
// }

// /**
//  * Determine if a value is a File
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a File, otherwise false
//  */
// function isFile(val) {
//   return toString.call(val) === '[object File]';
// }

// /**
//  * Determine if a value is a Blob
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a Blob, otherwise false
//  */
// function isBlob(val) {
//   return toString.call(val) === '[object Blob]';
// }

// /**
//  * Determine if a value is a Function
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a Function, otherwise false
//  */
// function isFunction(val) {
//   return toString.call(val) === '[object Function]';
// }

// /**
//  * Determine if a value is a Stream
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a Stream, otherwise false
//  */
// function isStream(val) {
//   return isObject(val) && isFunction(val.pipe);
// }

// /**
//  * Determine if a value is a URLSearchParams object
//  *
//  * @param {Object} val The value to test
//  * @returns {boolean} True if value is a URLSearchParams object, otherwise false
//  */
// function isURLSearchParams(val) {
//   return toString.call(val) === '[object URLSearchParams]';
// }

// /**
//  * Trim excess whitespace off the beginning and end of a string
//  *
//  * @param {String} str The String to trim
//  * @returns {String} The String freed of excess whitespace
//  */
// function trim(str) {
//   return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g, '');
// }

// /**
//  * Determine if we're running in a standard browser environment
//  *
//  * This allows axios to run in a web worker, and react-native.
//  * Both environments support XMLHttpRequest, but not fully standard globals.
//  *
//  * web workers:
//  *  typeof window -> undefined
//  *  typeof document -> undefined
//  *
//  * react-native:
//  *  navigator.product -> 'ReactNative'
//  * nativescript
//  *  navigator.product -> 'NativeScript' or 'NS'
//  */
// function isStandardBrowserEnv() {
//   if (typeof navigator !== 'undefined' && (navigator.product === 'ReactNative' ||
//                                            navigator.product === 'NativeScript' ||
//                                            navigator.product === 'NS')) {
//     return false;
//   }
//   return (
//     typeof window !== 'undefined' &&
//     typeof document !== 'undefined'
//   );
// }

// /**
//  * Iterate over an Array or an Object invoking a function for each item.
//  *
//  * If `obj` is an Array callback will be called passing
//  * the value, index, and complete array for each item.
//  *
//  * If 'obj' is an Object callback will be called passing
//  * the value, key, and complete object for each property.
//  *
//  * @param {Object|Array} obj The object to iterate
//  * @param {Function} fn The callback to invoke for each item
//  */
// function forEach(obj, fn) {
//   // Don't bother if no value provided
//   if (obj === null || typeof obj === 'undefined') {
//     return;
//   }

//   // Force an array if not already something iterable
//   if (typeof obj !== 'object') {
//     /*eslint no-param-reassign:0*/
//     obj = [obj];
//   }

//   if (isArray(obj)) {
//     // Iterate over array values
//     for (var i = 0, l = obj.length; i < l; i++) {
//       fn.call(null, obj[i], i, obj);
//     }
//   } else {
//     // Iterate over object keys
//     for (var key in obj) {
//       if (Object.prototype.hasOwnProperty.call(obj, key)) {
//         fn.call(null, obj[key], key, obj);
//       }
//     }
//   }
// }

// /**
//  * Accepts varargs expecting each argument to be an object, then
//  * immutably merges the properties of each object and returns result.
//  *
//  * When multiple objects contain the same key the later object in
//  * the arguments list will take precedence.
//  *
//  * Example:
//  *
//  * ```js
//  * var result = merge({foo: 123}, {foo: 456});
//  * console.log(result.foo); // outputs 456
//  * ```
//  *
//  * @param {Object} obj1 Object to merge
//  * @returns {Object} Result of all merge properties
//  */
// function merge(/* obj1, obj2, obj3, ... */) {
//   var result = {};
//   function assignValue(val, key) {
//     if (isPlainObject(result[key]) && isPlainObject(val)) {
//       result[key] = merge(result[key], val);
//     } else if (isPlainObject(val)) {
//       result[key] = merge({}, val);
//     } else if (isArray(val)) {
//       result[key] = val.slice();
//     } else {
//       result[key] = val;
//     }
//   }

//   for (var i = 0, l = arguments.length; i < l; i++) {
//     forEach(arguments[i], assignValue);
//   }
//   return result;
// }

// /**
//  * Extends object a by mutably adding to it the properties of object b.
//  *
//  * @param {Object} a The object to be extended
//  * @param {Object} b The object to copy properties from
//  * @param {Object} thisArg The object to bind function to
//  * @return {Object} The resulting value of object a
//  */
// function extend(a, b, thisArg) {
//   forEach(b, function assignValue(val, key) {
//     if (thisArg && typeof val === 'function') {
//       a[key] = bind(val, thisArg);
//     } else {
//       a[key] = val;
//     }
//   });
//   return a;
// }

// /**
//  * Remove byte order marker. This catches EF BB BF (the UTF-8 BOM)
//  *
//  * @param {string} content with BOM
//  * @return {string} content value without BOM
//  */
// function stripBOM(content) {
//   if (content.charCodeAt(0) === 0xFEFF) {
//     content = content.slice(1);
//   }
//   return content;
// }

// module.exports = {
//   isArray: isArray,
//   isArrayBuffer: isArrayBuffer,
//   isBuffer: isBuffer,
//   isFormData: isFormData,
//   isArrayBufferView: isArrayBufferView,
//   isString: isString,
//   isNumber: isNumber,
//   isObject: isObject,
//   isPlainObject: isPlainObject,
//   isUndefined: isUndefined,
//   isDate: isDate,
//   isFile: isFile,
//   isBlob: isBlob,
//   isFunction: isFunction,
//   isStream: isStream,
//   isURLSearchParams: isURLSearchParams,
//   isStandardBrowserEnv: isStandardBrowserEnv,
//   forEach: forEach,
//   merge: merge,
//   extend: extend,
//   trim: trim,
//   stripBOM: stripBOM
// };


// /***/ }),

// /***/ "./resources/js/app.js":
// /*!*****************************!*\
//   !*** ./resources/js/app.js ***!
//   \*****************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony import */ var _bootstrap__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");
// Object(function webpackMissingModule() { var e = new Error("Cannot find module 'vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
// /* harmony import */ var _components_ExampleComponent_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/ExampleComponent.vue */ "./resources/js/components/ExampleComponent.vue");
// /* harmony import */ var _components_ExampleComponent_vue__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_components_ExampleComponent_vue__WEBPACK_IMPORTED_MODULE_2__);
// var _console;
// function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
// function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
// function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
// function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
// function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
// function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */




// /**
//  * Next, we will create a fresh Vue application instance. You may then begin
//  * registering components with the application instance so they are ready
//  * to use in your application's views. An example is included for you.
//  */
// /* eslint-disable */
// (_console = console).log.apply(_console, _toConsumableArray(oo_oo("1795723135_15_0_15_80_4", 'Conexión a Pusher:', window.Echo.connector.pusher.connection.state)));
// window.Echo.channel('notifications').listen('RealTimeNotification', function (event) {
//   var _console2, _console3;
//   /* eslint-disable */(_console2 = console).log.apply(_console2, _toConsumableArray(oo_oo("1795723135_19_8_19_60_4", 'Notificación recibida:', event.message)));
//   alert("Nueva notificaci\xF3n: ".concat(event.message));
//   /* eslint-disable */
//   (_console3 = console).log.apply(_console3, _toConsumableArray(oo_oo("1795723135_21_8_21_90_4", 'Conexión a Pusher 2:', window.Echo.connector.pusher.connection.state)));
// });
// var app = Object(function webpackMissingModule() { var e = new Error("Cannot find module 'vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())({});

// app.component('example-component', (_components_ExampleComponent_vue__WEBPACK_IMPORTED_MODULE_2___default()));

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// // Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
// //     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// // });

// /**
//  * Finally, we will attach the application instance to a HTML element with
//  * an "id" attribute of "app". This element is included with the "auth"
//  * scaffolding. Otherwise, you will need to add an element yourself.
//  */

// app.mount('#app');
// /* istanbul ignore next */ /* c8 ignore start */ /* eslint-disable */
// ;
// function oo_cm() {
//   try {
//     return (0, eval)("globalThis._console_ninja") || (0, eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x2160de=_0x21a3;function _0x3632(){var _0x56982f=['default','send','%c\\x20Console\\x20Ninja\\x20extension\\x20is\\x20connected\\x20to\\x20','_HTMLAllCollection','expressionsToEvaluate','host','','versions','perf_hooks','positiveInfinity','127.0.0.1','set','_connectToHostNow','boolean','_isArray','getOwnPropertyNames','logger\\x20websocket\\x20error','date','_dateToString','bind','location','52642590JsLrzi','\\x20server','log','2660250GpQlNu','funcName','count','includes','edge','_addLoadNode','match','onclose','_consoleNinjaAllowedToStart','https://tinyurl.com/37x8b79t','onmessage','rootExpression','node','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','_capIfString','_objectToString','concat','_p_name','next.js','onerror','undefined','negativeInfinity','toLowerCase','_setNodeExpressionPath','slice','message','astro','_connected','toUpperCase','catch','background:\\x20rgb(30,30,30);\\x20color:\\x20rgb(255,213,92)','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','_quotedRegExp','unknown','unshift','autoExpandPropertyCount','_type','2793RMykfg','stringify','current','hasOwnProperty','webpack','_getOwnPropertySymbols','isExpressionToEvaluate','then','_getOwnPropertyDescriptor','unref','_isSet','onopen','_hasMapOnItsPath','hits','_isUndefined','_hasSymbolPropertyOnItsPath','valueOf','pop','2570814XHvPai','autoExpandMaxDepth','null','_propertyName','[object\\x20Date]','process','totalStrLength','cappedElements','setter',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"Pedro\",\"192.168.18.66\",\"172.28.128.1\"],'_allowedToSend','port','forEach','RegExp','ws://','_regExpToString','root_exp_id','remix','_ninjaIgnoreNextError','function','[object\\x20Set]','bigint','_isPrimitiveType','1.0.0','_WebSocketClass','url','[object\\x20Map]','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','prototype','global','getWebSocketClass','_sortProps','[object\\x20Array]','elapsed','_treeNodePropertiesBeforeFullValue','object','String','_inNextEdge','_addProperty','sortProps','eventReceivedCallback','origin','push','stackTraceLimit','symbol','Set','_connectAttemptCount','name','toString','_addFunctionsNode','_isPrimitiveWrapperType','reduceLimits','_treeNodePropertiesAfterFullValue','_socket','warn','_hasSetOnItsPath','_sendErrorMessage','_numberRegExp','props','index','autoExpand','\\x20browser','_setNodeLabel','constructor','path','_setNodePermissions','indexOf','substr','split','args','_cleanNode','NEGATIVE_INFINITY','_addObjectProperty','value','disabledLog','noFunctions','reload','parent','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','_property','getter','_processTreeNodeResult','parse','elements','type','_setNodeQueryPath','depth','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','125320pkibkH','1731831767849','now','join','array','performance','call','dockerizedApp','fromCharCode','data','getOwnPropertyDescriptor','_additionalMetadata','number','_Symbol','Number','get','_reconnectTimeout','pathToFileURL','strLength','10AfgneC','cappedProps','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','string','__es'+'Module','length','Boolean','_isNegativeZero','_webSocketErrorDocsLink','...','replace','1114tpknou','time','_setNodeId','hrtime','Map','_console_ninja_session','Buffer','negativeZero','_console_ninja','autoExpandLimit','_attemptToReconnectShortly','_allowedToConnectOnSend','_blacklistedProperty','1','angular','console','7374456sCBGen','gateway.docker.internal','HTMLAllCollection','nan','','hostname','expId','create','capped','serialize','stack','_ws','_setNodeExpandableState','_p_','NEXT_RUNTIME','isArray','endsWith','_connecting','defineProperty','_undefined','autoExpandPreviousObjects','161kAIGOe',\"c:\\\\Users\\\\pedro\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.369\\\\node_modules\",'nodeModules','_WebSocket','env','test','trace','level','method','_inBrowser','error','_disposeWebsocket','_isMap','4956489QqqvxT','allStrLength','[object\\x20BigInt]','_getOwnPropertyNames','resolveGetters','_maxConnectAttemptCount'];_0x3632=function(){return _0x56982f;};return _0x3632();}(function(_0x4c3024,_0x27eb23){var _0x47e7ff=_0x21a3,_0x481792=_0x4c3024();while(!![]){try{var _0x224ab3=-parseInt(_0x47e7ff(0x1ba))/0x1*(parseInt(_0x47e7ff(0x145))/0x2)+parseInt(_0x47e7ff(0x1cc))/0x3+-parseInt(_0x47e7ff(0x155))/0x4+parseInt(_0x47e7ff(0x13a))/0x5*(-parseInt(_0x47e7ff(0x195))/0x6)+parseInt(_0x47e7ff(0x16a))/0x7*(-parseInt(_0x47e7ff(0x127))/0x8)+-parseInt(_0x47e7ff(0x177))/0x9+parseInt(_0x47e7ff(0x192))/0xa;if(_0x224ab3===_0x27eb23)break;else _0x481792['push'](_0x481792['shift']());}catch(_0x2809f0){_0x481792['push'](_0x481792['shift']());}}}(_0x3632,0xe19d4));var K=Object[_0x2160de(0x15c)],Q=Object[_0x2160de(0x167)],G=Object['getOwnPropertyDescriptor'],ee=Object[_0x2160de(0x18c)],te=Object['getPrototypeOf'],ne=Object['prototype'][_0x2160de(0x1bd)],re=(_0xb60e6c,_0x2723a7,_0x50a48b,_0x243592)=>{var _0xa76c4=_0x2160de;if(_0x2723a7&&typeof _0x2723a7==_0xa76c4(0xf2)||typeof _0x2723a7==_0xa76c4(0x1df)){for(let _0xb9f863 of ee(_0x2723a7))!ne[_0xa76c4(0x12d)](_0xb60e6c,_0xb9f863)&&_0xb9f863!==_0x50a48b&&Q(_0xb60e6c,_0xb9f863,{'get':()=>_0x2723a7[_0xb9f863],'enumerable':!(_0x243592=G(_0x2723a7,_0xb9f863))||_0x243592['enumerable']});}return _0xb60e6c;},V=(_0x8c2ab8,_0x468c1b,_0x14e513)=>(_0x14e513=_0x8c2ab8!=null?K(te(_0x8c2ab8)):{},re(_0x468c1b||!_0x8c2ab8||!_0x8c2ab8[_0x2160de(0x13e)]?Q(_0x14e513,_0x2160de(0x17d),{'value':_0x8c2ab8,'enumerable':!0x0}):_0x14e513,_0x8c2ab8)),Z=class{constructor(_0x1d2e23,_0xdab60e,_0x40e94c,_0x142eb1,_0x2141db,_0xa205f9){var _0x5cced4=_0x2160de,_0x5c108c,_0x2a03dc,_0x184e43,_0x3bd2e9;this['global']=_0x1d2e23,this[_0x5cced4(0x182)]=_0xdab60e,this[_0x5cced4(0x1d7)]=_0x40e94c,this['nodeModules']=_0x142eb1,this[_0x5cced4(0x12e)]=_0x2141db,this['eventReceivedCallback']=_0xa205f9,this[_0x5cced4(0x1d6)]=!0x0,this[_0x5cced4(0x150)]=!0x0,this[_0x5cced4(0x1b0)]=!0x1,this[_0x5cced4(0x166)]=!0x1,this[_0x5cced4(0xf4)]=((_0x2a03dc=(_0x5c108c=_0x1d2e23[_0x5cced4(0x1d1)])==null?void 0x0:_0x5c108c[_0x5cced4(0x16e)])==null?void 0x0:_0x2a03dc[_0x5cced4(0x163)])===_0x5cced4(0x199),this[_0x5cced4(0x173)]=!((_0x3bd2e9=(_0x184e43=this[_0x5cced4(0x1e9)][_0x5cced4(0x1d1)])==null?void 0x0:_0x184e43[_0x5cced4(0x184)])!=null&&_0x3bd2e9[_0x5cced4(0x1a1)])&&!this[_0x5cced4(0xf4)],this[_0x5cced4(0x1e4)]=null,this['_connectAttemptCount']=0x0,this[_0x5cced4(0x17c)]=0x14,this[_0x5cced4(0x142)]=_0x5cced4(0x19e),this[_0x5cced4(0x107)]=(this[_0x5cced4(0x173)]?_0x5cced4(0x13c):_0x5cced4(0x1e7))+this[_0x5cced4(0x142)];}async[_0x2160de(0x1ea)](){var _0x128a49=_0x2160de,_0x3bc6cb,_0x2c9200;if(this['_WebSocketClass'])return this[_0x128a49(0x1e4)];let _0x1adb57;if(this['_inBrowser']||this['_inNextEdge'])_0x1adb57=this['global']['WebSocket'];else{if((_0x3bc6cb=this[_0x128a49(0x1e9)]['process'])!=null&&_0x3bc6cb[_0x128a49(0x16d)])_0x1adb57=(_0x2c9200=this[_0x128a49(0x1e9)][_0x128a49(0x1d1)])==null?void 0x0:_0x2c9200[_0x128a49(0x16d)];else try{let _0x31283e=await import(_0x128a49(0x10f));_0x1adb57=(await import((await import(_0x128a49(0x1e5)))[_0x128a49(0x138)](_0x31283e[_0x128a49(0x12a)](this[_0x128a49(0x16c)],'ws/index.js'))[_0x128a49(0xff)]()))[_0x128a49(0x17d)];}catch{try{_0x1adb57=require(require(_0x128a49(0x10f))[_0x128a49(0x12a)](this['nodeModules'],'ws'));}catch{throw new Error(_0x128a49(0x126));}}}return this[_0x128a49(0x1e4)]=_0x1adb57,_0x1adb57;}[_0x2160de(0x189)](){var _0x3ea5f7=_0x2160de;this[_0x3ea5f7(0x166)]||this['_connected']||this[_0x3ea5f7(0xfd)]>=this[_0x3ea5f7(0x17c)]||(this[_0x3ea5f7(0x150)]=!0x1,this[_0x3ea5f7(0x166)]=!0x0,this[_0x3ea5f7(0xfd)]++,this[_0x3ea5f7(0x160)]=new Promise((_0x1cdfe6,_0x393076)=>{var _0x329328=_0x3ea5f7;this[_0x329328(0x1ea)]()['then'](_0x59ec54=>{var _0x1ebfd9=_0x329328;let _0x5a5b17=new _0x59ec54(_0x1ebfd9(0x1da)+(!this['_inBrowser']&&this[_0x1ebfd9(0x12e)]?_0x1ebfd9(0x156):this['host'])+':'+this[_0x1ebfd9(0x1d7)]);_0x5a5b17['onerror']=()=>{var _0x5e8d60=_0x1ebfd9;this[_0x5e8d60(0x1d6)]=!0x1,this[_0x5e8d60(0x175)](_0x5a5b17),this[_0x5e8d60(0x14f)](),_0x393076(new Error(_0x5e8d60(0x18d)));},_0x5a5b17['onopen']=()=>{var _0xbd38a2=_0x1ebfd9;this[_0xbd38a2(0x173)]||_0x5a5b17[_0xbd38a2(0x104)]&&_0x5a5b17[_0xbd38a2(0x104)]['unref']&&_0x5a5b17[_0xbd38a2(0x104)][_0xbd38a2(0x1c3)](),_0x1cdfe6(_0x5a5b17);},_0x5a5b17[_0x1ebfd9(0x19c)]=()=>{var _0x295279=_0x1ebfd9;this[_0x295279(0x150)]=!0x0,this[_0x295279(0x175)](_0x5a5b17),this['_attemptToReconnectShortly']();},_0x5a5b17[_0x1ebfd9(0x19f)]=_0x478321=>{var _0x210356=_0x1ebfd9;try{if(!(_0x478321!=null&&_0x478321['data'])||!this[_0x210356(0xf7)])return;let _0x23117d=JSON[_0x210356(0x121)](_0x478321[_0x210356(0x130)]);this[_0x210356(0xf7)](_0x23117d[_0x210356(0x172)],_0x23117d[_0x210356(0x114)],this[_0x210356(0x1e9)],this[_0x210356(0x173)]);}catch{}};})[_0x329328(0x1c1)](_0x1701d9=>(this[_0x329328(0x1b0)]=!0x0,this['_connecting']=!0x1,this['_allowedToConnectOnSend']=!0x1,this[_0x329328(0x1d6)]=!0x0,this['_connectAttemptCount']=0x0,_0x1701d9))[_0x329328(0x1b2)](_0x1c88b0=>(this[_0x329328(0x1b0)]=!0x1,this['_connecting']=!0x1,console[_0x329328(0x105)](_0x329328(0x1a2)+this['_webSocketErrorDocsLink']),_0x393076(new Error(_0x329328(0x1b4)+(_0x1c88b0&&_0x1c88b0['message'])))));}));}[_0x2160de(0x175)](_0x3db513){var _0x36824d=_0x2160de;this[_0x36824d(0x1b0)]=!0x1,this[_0x36824d(0x166)]=!0x1;try{_0x3db513[_0x36824d(0x19c)]=null,_0x3db513[_0x36824d(0x1a8)]=null,_0x3db513[_0x36824d(0x1c5)]=null;}catch{}try{_0x3db513['readyState']<0x2&&_0x3db513['close']();}catch{}}[_0x2160de(0x14f)](){var _0x6bcb9d=_0x2160de;clearTimeout(this[_0x6bcb9d(0x137)]),!(this[_0x6bcb9d(0xfd)]>=this[_0x6bcb9d(0x17c)])&&(this[_0x6bcb9d(0x137)]=setTimeout(()=>{var _0x577db9=_0x6bcb9d,_0x5cbaa6;this[_0x577db9(0x1b0)]||this[_0x577db9(0x166)]||(this['_connectToHostNow'](),(_0x5cbaa6=this['_ws'])==null||_0x5cbaa6[_0x577db9(0x1b2)](()=>this[_0x577db9(0x14f)]()));},0x1f4),this[_0x6bcb9d(0x137)][_0x6bcb9d(0x1c3)]&&this[_0x6bcb9d(0x137)][_0x6bcb9d(0x1c3)]());}async[_0x2160de(0x17e)](_0x12b796){var _0x22327c=_0x2160de;try{if(!this[_0x22327c(0x1d6)])return;this[_0x22327c(0x150)]&&this['_connectToHostNow'](),(await this[_0x22327c(0x160)])[_0x22327c(0x17e)](JSON['stringify'](_0x12b796));}catch(_0x57337a){console[_0x22327c(0x105)](this[_0x22327c(0x107)]+':\\x20'+(_0x57337a&&_0x57337a['message'])),this['_allowedToSend']=!0x1,this[_0x22327c(0x14f)]();}}};function q(_0x1f963b,_0x263322,_0x3f1b38,_0x43c8cd,_0xf6067d,_0xf3e79,_0x473826,_0x504ee4=ie){var _0x65040b=_0x2160de;let _0x5e33cb=_0x3f1b38[_0x65040b(0x113)](',')['map'](_0x577e64=>{var _0x5cfeab=_0x65040b,_0x1eeeb0,_0x5befcf,_0x2ed490,_0x451332;try{if(!_0x1f963b[_0x5cfeab(0x14a)]){let _0x213503=((_0x5befcf=(_0x1eeeb0=_0x1f963b['process'])==null?void 0x0:_0x1eeeb0[_0x5cfeab(0x184)])==null?void 0x0:_0x5befcf[_0x5cfeab(0x1a1)])||((_0x451332=(_0x2ed490=_0x1f963b[_0x5cfeab(0x1d1)])==null?void 0x0:_0x2ed490[_0x5cfeab(0x16e)])==null?void 0x0:_0x451332[_0x5cfeab(0x163)])===_0x5cfeab(0x199);(_0xf6067d===_0x5cfeab(0x1a7)||_0xf6067d===_0x5cfeab(0x1dd)||_0xf6067d===_0x5cfeab(0x1af)||_0xf6067d===_0x5cfeab(0x153))&&(_0xf6067d+=_0x213503?_0x5cfeab(0x193):_0x5cfeab(0x10c)),_0x1f963b[_0x5cfeab(0x14a)]={'id':+new Date(),'tool':_0xf6067d},_0x473826&&_0xf6067d&&!_0x213503&&console[_0x5cfeab(0x194)](_0x5cfeab(0x17f)+(_0xf6067d['charAt'](0x0)[_0x5cfeab(0x1b1)]()+_0xf6067d['substr'](0x1))+',',_0x5cfeab(0x1b3),'see\\x20https://tinyurl.com/2vt8jxzw\\x20for\\x20more\\x20info.');}let _0x80b835=new Z(_0x1f963b,_0x263322,_0x577e64,_0x43c8cd,_0xf3e79,_0x504ee4);return _0x80b835[_0x5cfeab(0x17e)][_0x5cfeab(0x190)](_0x80b835);}catch(_0x1cb024){return console[_0x5cfeab(0x105)](_0x5cfeab(0x11d),_0x1cb024&&_0x1cb024['message']),()=>{};}});return _0x183d11=>_0x5e33cb[_0x65040b(0x1d8)](_0x404b4f=>_0x404b4f(_0x183d11));}function ie(_0x5a5d6e,_0x3ab594,_0x3d399e,_0x309169){var _0x2b0214=_0x2160de;_0x309169&&_0x5a5d6e===_0x2b0214(0x11b)&&_0x3d399e[_0x2b0214(0x191)][_0x2b0214(0x11b)]();}function _0x21a3(_0x3c4fd7,_0x245abe){var _0x3632c8=_0x3632();return _0x21a3=function(_0x21a3d1,_0x24d2de){_0x21a3d1=_0x21a3d1-0xee;var _0x3406f5=_0x3632c8[_0x21a3d1];return _0x3406f5;},_0x21a3(_0x3c4fd7,_0x245abe);}function B(_0x479ade){var _0x55e4b6=_0x2160de,_0x1db6df,_0x2675fc;let _0x253e83=function(_0x461cb,_0x51aef7){return _0x51aef7-_0x461cb;},_0x24648b;if(_0x479ade[_0x55e4b6(0x12c)])_0x24648b=function(){var _0x28c428=_0x55e4b6;return _0x479ade[_0x28c428(0x12c)][_0x28c428(0x129)]();};else{if(_0x479ade[_0x55e4b6(0x1d1)]&&_0x479ade[_0x55e4b6(0x1d1)][_0x55e4b6(0x148)]&&((_0x2675fc=(_0x1db6df=_0x479ade['process'])==null?void 0x0:_0x1db6df[_0x55e4b6(0x16e)])==null?void 0x0:_0x2675fc[_0x55e4b6(0x163)])!==_0x55e4b6(0x199))_0x24648b=function(){var _0x44dcc4=_0x55e4b6;return _0x479ade[_0x44dcc4(0x1d1)][_0x44dcc4(0x148)]();},_0x253e83=function(_0x1e11c5,_0xa37d54){return 0x3e8*(_0xa37d54[0x0]-_0x1e11c5[0x0])+(_0xa37d54[0x1]-_0x1e11c5[0x1])/0xf4240;};else try{let {performance:_0x568fd6}=require(_0x55e4b6(0x185));_0x24648b=function(){var _0x5f57ed=_0x55e4b6;return _0x568fd6[_0x5f57ed(0x129)]();};}catch{_0x24648b=function(){return+new Date();};}}return{'elapsed':_0x253e83,'timeStamp':_0x24648b,'now':()=>Date['now']()};}function H(_0x10dccb,_0x1e80af,_0x352174){var _0x4997ac=_0x2160de,_0x5b1ba2,_0x11f9c0,_0x27ac93,_0x36b7af,_0x2b4871;if(_0x10dccb[_0x4997ac(0x19d)]!==void 0x0)return _0x10dccb['_consoleNinjaAllowedToStart'];let _0x392b63=((_0x11f9c0=(_0x5b1ba2=_0x10dccb[_0x4997ac(0x1d1)])==null?void 0x0:_0x5b1ba2[_0x4997ac(0x184)])==null?void 0x0:_0x11f9c0[_0x4997ac(0x1a1)])||((_0x36b7af=(_0x27ac93=_0x10dccb[_0x4997ac(0x1d1)])==null?void 0x0:_0x27ac93['env'])==null?void 0x0:_0x36b7af['NEXT_RUNTIME'])===_0x4997ac(0x199);function _0x2d8e02(_0x1544db){var _0x36dbda=_0x4997ac;if(_0x1544db['startsWith']('/')&&_0x1544db[_0x36dbda(0x165)]('/')){let _0x4974fb=new RegExp(_0x1544db[_0x36dbda(0x1ad)](0x1,-0x1));return _0x1401d3=>_0x4974fb[_0x36dbda(0x16f)](_0x1401d3);}else{if(_0x1544db[_0x36dbda(0x198)]('*')||_0x1544db[_0x36dbda(0x198)]('?')){let _0x2cb3b9=new RegExp('^'+_0x1544db[_0x36dbda(0x144)](/\\./g,String[_0x36dbda(0x12f)](0x5c)+'.')['replace'](/\\*/g,'.*')['replace'](/\\?/g,'.')+String['fromCharCode'](0x24));return _0x320b97=>_0x2cb3b9[_0x36dbda(0x16f)](_0x320b97);}else return _0x3d785b=>_0x3d785b===_0x1544db;}}let _0x2bda5a=_0x1e80af['map'](_0x2d8e02);return _0x10dccb['_consoleNinjaAllowedToStart']=_0x392b63||!_0x1e80af,!_0x10dccb[_0x4997ac(0x19d)]&&((_0x2b4871=_0x10dccb[_0x4997ac(0x191)])==null?void 0x0:_0x2b4871[_0x4997ac(0x15a)])&&(_0x10dccb[_0x4997ac(0x19d)]=_0x2bda5a['some'](_0x45fe63=>_0x45fe63(_0x10dccb[_0x4997ac(0x191)][_0x4997ac(0x15a)]))),_0x10dccb[_0x4997ac(0x19d)];}function X(_0x3e77c0,_0x368502,_0x3d2d4c,_0x391fb4){var _0x144a79=_0x2160de;_0x3e77c0=_0x3e77c0,_0x368502=_0x368502,_0x3d2d4c=_0x3d2d4c,_0x391fb4=_0x391fb4;let _0x83c743=B(_0x3e77c0),_0x47a395=_0x83c743[_0x144a79(0xf0)],_0x24d130=_0x83c743['timeStamp'];class _0x4e138c{constructor(){var _0x50df0f=_0x144a79;this['_keyStrRegExp']=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x50df0f(0x108)]=/^(0|[1-9][0-9]*)$/,this[_0x50df0f(0x1b5)]=/'([^\\\\']|\\\\')*'/,this[_0x50df0f(0x168)]=_0x3e77c0[_0x50df0f(0x1a9)],this[_0x50df0f(0x180)]=_0x3e77c0[_0x50df0f(0x157)],this[_0x50df0f(0x1c2)]=Object[_0x50df0f(0x131)],this[_0x50df0f(0x17a)]=Object[_0x50df0f(0x18c)],this[_0x50df0f(0x134)]=_0x3e77c0['Symbol'],this[_0x50df0f(0x1db)]=RegExp[_0x50df0f(0x1e8)]['toString'],this[_0x50df0f(0x18f)]=Date['prototype'][_0x50df0f(0xff)];}[_0x144a79(0x15e)](_0x5416d7,_0x116012,_0x4064e,_0x5d249a){var _0x276822=_0x144a79,_0x49e6d5=this,_0x57b7ae=_0x4064e[_0x276822(0x10b)];function _0x3b3f6a(_0x5d68a0,_0x790290,_0x5d67a7){var _0x395046=_0x276822;_0x790290[_0x395046(0x123)]=_0x395046(0x1b6),_0x790290[_0x395046(0x174)]=_0x5d68a0[_0x395046(0x1ae)],_0x3d70f8=_0x5d67a7['node'][_0x395046(0x1bc)],_0x5d67a7[_0x395046(0x1a1)][_0x395046(0x1bc)]=_0x790290,_0x49e6d5[_0x395046(0xf1)](_0x790290,_0x5d67a7);}try{_0x4064e[_0x276822(0x171)]++,_0x4064e[_0x276822(0x10b)]&&_0x4064e['autoExpandPreviousObjects'][_0x276822(0xf9)](_0x116012);var _0x409809,_0x4b11d6,_0x4c519c,_0x77116f,_0x22b5a1=[],_0x5988bd=[],_0x39ee3b,_0x21d3f8=this['_type'](_0x116012),_0x2d1504=_0x21d3f8===_0x276822(0x12b),_0xb381de=!0x1,_0x2aa0a9=_0x21d3f8==='function',_0x3fdc8a=this[_0x276822(0x1e2)](_0x21d3f8),_0x2795c6=this['_isPrimitiveWrapperType'](_0x21d3f8),_0x5995ba=_0x3fdc8a||_0x2795c6,_0x1134b4={},_0x3e617b=0x0,_0x34b838=!0x1,_0x3d70f8,_0x448392=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x4064e[_0x276822(0x125)]){if(_0x2d1504){if(_0x4b11d6=_0x116012['length'],_0x4b11d6>_0x4064e['elements']){for(_0x4c519c=0x0,_0x77116f=_0x4064e[_0x276822(0x122)],_0x409809=_0x4c519c;_0x409809<_0x77116f;_0x409809++)_0x5988bd['push'](_0x49e6d5[_0x276822(0xf5)](_0x22b5a1,_0x116012,_0x21d3f8,_0x409809,_0x4064e));_0x5416d7[_0x276822(0x1d3)]=!0x0;}else{for(_0x4c519c=0x0,_0x77116f=_0x4b11d6,_0x409809=_0x4c519c;_0x409809<_0x77116f;_0x409809++)_0x5988bd[_0x276822(0xf9)](_0x49e6d5[_0x276822(0xf5)](_0x22b5a1,_0x116012,_0x21d3f8,_0x409809,_0x4064e));}_0x4064e[_0x276822(0x1b8)]+=_0x5988bd[_0x276822(0x13f)];}if(!(_0x21d3f8===_0x276822(0x1ce)||_0x21d3f8==='undefined')&&!_0x3fdc8a&&_0x21d3f8!==_0x276822(0xf3)&&_0x21d3f8!==_0x276822(0x14b)&&_0x21d3f8!==_0x276822(0x1e1)){var _0x5bbc59=_0x5d249a[_0x276822(0x109)]||_0x4064e['props'];if(this['_isSet'](_0x116012)?(_0x409809=0x0,_0x116012[_0x276822(0x1d8)](function(_0x370926){var _0x37eb0d=_0x276822;if(_0x3e617b++,_0x4064e[_0x37eb0d(0x1b8)]++,_0x3e617b>_0x5bbc59){_0x34b838=!0x0;return;}if(!_0x4064e[_0x37eb0d(0x1c0)]&&_0x4064e[_0x37eb0d(0x10b)]&&_0x4064e['autoExpandPropertyCount']>_0x4064e[_0x37eb0d(0x14e)]){_0x34b838=!0x0;return;}_0x5988bd['push'](_0x49e6d5['_addProperty'](_0x22b5a1,_0x116012,_0x37eb0d(0xfc),_0x409809++,_0x4064e,function(_0x1b010a){return function(){return _0x1b010a;};}(_0x370926)));})):this[_0x276822(0x176)](_0x116012)&&_0x116012['forEach'](function(_0x3e9664,_0x283dc1){var _0x6b9f9b=_0x276822;if(_0x3e617b++,_0x4064e['autoExpandPropertyCount']++,_0x3e617b>_0x5bbc59){_0x34b838=!0x0;return;}if(!_0x4064e[_0x6b9f9b(0x1c0)]&&_0x4064e[_0x6b9f9b(0x10b)]&&_0x4064e[_0x6b9f9b(0x1b8)]>_0x4064e[_0x6b9f9b(0x14e)]){_0x34b838=!0x0;return;}var _0x42447e=_0x283dc1[_0x6b9f9b(0xff)]();_0x42447e[_0x6b9f9b(0x13f)]>0x64&&(_0x42447e=_0x42447e[_0x6b9f9b(0x1ad)](0x0,0x64)+_0x6b9f9b(0x143)),_0x5988bd['push'](_0x49e6d5['_addProperty'](_0x22b5a1,_0x116012,'Map',_0x42447e,_0x4064e,function(_0x490eaf){return function(){return _0x490eaf;};}(_0x3e9664)));}),!_0xb381de){try{for(_0x39ee3b in _0x116012)if(!(_0x2d1504&&_0x448392['test'](_0x39ee3b))&&!this[_0x276822(0x151)](_0x116012,_0x39ee3b,_0x4064e)){if(_0x3e617b++,_0x4064e[_0x276822(0x1b8)]++,_0x3e617b>_0x5bbc59){_0x34b838=!0x0;break;}if(!_0x4064e[_0x276822(0x1c0)]&&_0x4064e['autoExpand']&&_0x4064e[_0x276822(0x1b8)]>_0x4064e[_0x276822(0x14e)]){_0x34b838=!0x0;break;}_0x5988bd[_0x276822(0xf9)](_0x49e6d5[_0x276822(0x117)](_0x22b5a1,_0x1134b4,_0x116012,_0x21d3f8,_0x39ee3b,_0x4064e));}}catch{}if(_0x1134b4['_p_length']=!0x0,_0x2aa0a9&&(_0x1134b4[_0x276822(0x1a6)]=!0x0),!_0x34b838){var _0x46fabb=[][_0x276822(0x1a5)](this[_0x276822(0x17a)](_0x116012))[_0x276822(0x1a5)](this['_getOwnPropertySymbols'](_0x116012));for(_0x409809=0x0,_0x4b11d6=_0x46fabb['length'];_0x409809<_0x4b11d6;_0x409809++)if(_0x39ee3b=_0x46fabb[_0x409809],!(_0x2d1504&&_0x448392[_0x276822(0x16f)](_0x39ee3b[_0x276822(0xff)]()))&&!this[_0x276822(0x151)](_0x116012,_0x39ee3b,_0x4064e)&&!_0x1134b4[_0x276822(0x162)+_0x39ee3b[_0x276822(0xff)]()]){if(_0x3e617b++,_0x4064e['autoExpandPropertyCount']++,_0x3e617b>_0x5bbc59){_0x34b838=!0x0;break;}if(!_0x4064e['isExpressionToEvaluate']&&_0x4064e[_0x276822(0x10b)]&&_0x4064e['autoExpandPropertyCount']>_0x4064e[_0x276822(0x14e)]){_0x34b838=!0x0;break;}_0x5988bd[_0x276822(0xf9)](_0x49e6d5[_0x276822(0x117)](_0x22b5a1,_0x1134b4,_0x116012,_0x21d3f8,_0x39ee3b,_0x4064e));}}}}}if(_0x5416d7[_0x276822(0x123)]=_0x21d3f8,_0x5995ba?(_0x5416d7[_0x276822(0x118)]=_0x116012[_0x276822(0x1ca)](),this[_0x276822(0x1a3)](_0x21d3f8,_0x5416d7,_0x4064e,_0x5d249a)):_0x21d3f8===_0x276822(0x18e)?_0x5416d7[_0x276822(0x118)]=this[_0x276822(0x18f)]['call'](_0x116012):_0x21d3f8===_0x276822(0x1e1)?_0x5416d7[_0x276822(0x118)]=_0x116012[_0x276822(0xff)]():_0x21d3f8===_0x276822(0x1d9)?_0x5416d7[_0x276822(0x118)]=this[_0x276822(0x1db)][_0x276822(0x12d)](_0x116012):_0x21d3f8===_0x276822(0xfb)&&this['_Symbol']?_0x5416d7[_0x276822(0x118)]=this[_0x276822(0x134)]['prototype']['toString'][_0x276822(0x12d)](_0x116012):!_0x4064e[_0x276822(0x125)]&&!(_0x21d3f8===_0x276822(0x1ce)||_0x21d3f8===_0x276822(0x1a9))&&(delete _0x5416d7[_0x276822(0x118)],_0x5416d7[_0x276822(0x15d)]=!0x0),_0x34b838&&(_0x5416d7[_0x276822(0x13b)]=!0x0),_0x3d70f8=_0x4064e[_0x276822(0x1a1)][_0x276822(0x1bc)],_0x4064e[_0x276822(0x1a1)]['current']=_0x5416d7,this[_0x276822(0xf1)](_0x5416d7,_0x4064e),_0x5988bd[_0x276822(0x13f)]){for(_0x409809=0x0,_0x4b11d6=_0x5988bd[_0x276822(0x13f)];_0x409809<_0x4b11d6;_0x409809++)_0x5988bd[_0x409809](_0x409809);}_0x22b5a1[_0x276822(0x13f)]&&(_0x5416d7[_0x276822(0x109)]=_0x22b5a1);}catch(_0x545cfc){_0x3b3f6a(_0x545cfc,_0x5416d7,_0x4064e);}return this[_0x276822(0x132)](_0x116012,_0x5416d7),this[_0x276822(0x103)](_0x5416d7,_0x4064e),_0x4064e['node'][_0x276822(0x1bc)]=_0x3d70f8,_0x4064e[_0x276822(0x171)]--,_0x4064e[_0x276822(0x10b)]=_0x57b7ae,_0x4064e['autoExpand']&&_0x4064e[_0x276822(0x169)][_0x276822(0x1cb)](),_0x5416d7;}[_0x144a79(0x1bf)](_0x342ecf){return Object['getOwnPropertySymbols']?Object['getOwnPropertySymbols'](_0x342ecf):[];}[_0x144a79(0x1c4)](_0x5ba2ae){var _0x5a7687=_0x144a79;return!!(_0x5ba2ae&&_0x3e77c0[_0x5a7687(0xfc)]&&this['_objectToString'](_0x5ba2ae)===_0x5a7687(0x1e0)&&_0x5ba2ae[_0x5a7687(0x1d8)]);}[_0x144a79(0x151)](_0x1cb176,_0x21f6ff,_0x22cda5){var _0x223b84=_0x144a79;return _0x22cda5[_0x223b84(0x11a)]?typeof _0x1cb176[_0x21f6ff]==_0x223b84(0x1df):!0x1;}[_0x144a79(0x1b9)](_0x14fbf5){var _0x540dfe=_0x144a79,_0x21d37e='';return _0x21d37e=typeof _0x14fbf5,_0x21d37e===_0x540dfe(0xf2)?this['_objectToString'](_0x14fbf5)===_0x540dfe(0xef)?_0x21d37e=_0x540dfe(0x12b):this[_0x540dfe(0x1a4)](_0x14fbf5)===_0x540dfe(0x1d0)?_0x21d37e='date':this[_0x540dfe(0x1a4)](_0x14fbf5)===_0x540dfe(0x179)?_0x21d37e=_0x540dfe(0x1e1):_0x14fbf5===null?_0x21d37e=_0x540dfe(0x1ce):_0x14fbf5[_0x540dfe(0x10e)]&&(_0x21d37e=_0x14fbf5['constructor'][_0x540dfe(0xfe)]||_0x21d37e):_0x21d37e===_0x540dfe(0x1a9)&&this[_0x540dfe(0x180)]&&_0x14fbf5 instanceof this['_HTMLAllCollection']&&(_0x21d37e=_0x540dfe(0x157)),_0x21d37e;}[_0x144a79(0x1a4)](_0x8e2c33){var _0x252277=_0x144a79;return Object[_0x252277(0x1e8)]['toString'][_0x252277(0x12d)](_0x8e2c33);}[_0x144a79(0x1e2)](_0x575741){var _0x23d891=_0x144a79;return _0x575741===_0x23d891(0x18a)||_0x575741==='string'||_0x575741===_0x23d891(0x133);}[_0x144a79(0x101)](_0x4456b7){var _0x2de837=_0x144a79;return _0x4456b7===_0x2de837(0x140)||_0x4456b7==='String'||_0x4456b7===_0x2de837(0x135);}[_0x144a79(0xf5)](_0x4354f5,_0x2e6613,_0x5874b5,_0x561ca8,_0x22e9fa,_0xf7af1c){var _0x1cf564=this;return function(_0x384940){var _0x598128=_0x21a3,_0x1c7c0b=_0x22e9fa[_0x598128(0x1a1)][_0x598128(0x1bc)],_0x46c00c=_0x22e9fa[_0x598128(0x1a1)][_0x598128(0x10a)],_0x16be0b=_0x22e9fa[_0x598128(0x1a1)][_0x598128(0x11c)];_0x22e9fa[_0x598128(0x1a1)][_0x598128(0x11c)]=_0x1c7c0b,_0x22e9fa[_0x598128(0x1a1)][_0x598128(0x10a)]=typeof _0x561ca8=='number'?_0x561ca8:_0x384940,_0x4354f5[_0x598128(0xf9)](_0x1cf564['_property'](_0x2e6613,_0x5874b5,_0x561ca8,_0x22e9fa,_0xf7af1c)),_0x22e9fa[_0x598128(0x1a1)][_0x598128(0x11c)]=_0x16be0b,_0x22e9fa['node']['index']=_0x46c00c;};}[_0x144a79(0x117)](_0x58d056,_0x3f3d81,_0x423f15,_0x7eaa6e,_0xd8e80,_0x57780f,_0x4dffbc){var _0x32a146=_0x144a79,_0x41efa8=this;return _0x3f3d81[_0x32a146(0x162)+_0xd8e80['toString']()]=!0x0,function(_0x4d920b){var _0x49b5c2=_0x32a146,_0x5ac13c=_0x57780f[_0x49b5c2(0x1a1)][_0x49b5c2(0x1bc)],_0x3b2e7f=_0x57780f['node'][_0x49b5c2(0x10a)],_0x188cf3=_0x57780f[_0x49b5c2(0x1a1)]['parent'];_0x57780f[_0x49b5c2(0x1a1)][_0x49b5c2(0x11c)]=_0x5ac13c,_0x57780f['node'][_0x49b5c2(0x10a)]=_0x4d920b,_0x58d056[_0x49b5c2(0xf9)](_0x41efa8[_0x49b5c2(0x11e)](_0x423f15,_0x7eaa6e,_0xd8e80,_0x57780f,_0x4dffbc)),_0x57780f[_0x49b5c2(0x1a1)][_0x49b5c2(0x11c)]=_0x188cf3,_0x57780f[_0x49b5c2(0x1a1)][_0x49b5c2(0x10a)]=_0x3b2e7f;};}[_0x144a79(0x11e)](_0x30d594,_0x313c60,_0x116b3f,_0x110528,_0x4c9ac0){var _0x860bad=_0x144a79,_0x3c61c2=this;_0x4c9ac0||(_0x4c9ac0=function(_0x374fcf,_0x341fdd){return _0x374fcf[_0x341fdd];});var _0x5ebc8c=_0x116b3f[_0x860bad(0xff)](),_0x32f673=_0x110528[_0x860bad(0x181)]||{},_0x38968e=_0x110528['depth'],_0xd7277d=_0x110528[_0x860bad(0x1c0)];try{var _0x14b85f=this['_isMap'](_0x30d594),_0x316f78=_0x5ebc8c;_0x14b85f&&_0x316f78[0x0]==='\\x27'&&(_0x316f78=_0x316f78[_0x860bad(0x112)](0x1,_0x316f78['length']-0x2));var _0x4099d8=_0x110528[_0x860bad(0x181)]=_0x32f673['_p_'+_0x316f78];_0x4099d8&&(_0x110528[_0x860bad(0x125)]=_0x110528[_0x860bad(0x125)]+0x1),_0x110528[_0x860bad(0x1c0)]=!!_0x4099d8;var _0x28f7fd=typeof _0x116b3f==_0x860bad(0xfb),_0x33a0d0={'name':_0x28f7fd||_0x14b85f?_0x5ebc8c:this[_0x860bad(0x1cf)](_0x5ebc8c)};if(_0x28f7fd&&(_0x33a0d0[_0x860bad(0xfb)]=!0x0),!(_0x313c60===_0x860bad(0x12b)||_0x313c60==='Error')){var _0x1db4a5=this[_0x860bad(0x1c2)](_0x30d594,_0x116b3f);if(_0x1db4a5&&(_0x1db4a5[_0x860bad(0x188)]&&(_0x33a0d0[_0x860bad(0x1d4)]=!0x0),_0x1db4a5[_0x860bad(0x136)]&&!_0x4099d8&&!_0x110528[_0x860bad(0x17b)]))return _0x33a0d0[_0x860bad(0x11f)]=!0x0,this['_processTreeNodeResult'](_0x33a0d0,_0x110528),_0x33a0d0;}var _0x45eef2;try{_0x45eef2=_0x4c9ac0(_0x30d594,_0x116b3f);}catch(_0x349276){return _0x33a0d0={'name':_0x5ebc8c,'type':'unknown','error':_0x349276[_0x860bad(0x1ae)]},this[_0x860bad(0x120)](_0x33a0d0,_0x110528),_0x33a0d0;}var _0x539394=this[_0x860bad(0x1b9)](_0x45eef2),_0x490c82=this[_0x860bad(0x1e2)](_0x539394);if(_0x33a0d0[_0x860bad(0x123)]=_0x539394,_0x490c82)this[_0x860bad(0x120)](_0x33a0d0,_0x110528,_0x45eef2,function(){var _0x5a3749=_0x860bad;_0x33a0d0[_0x5a3749(0x118)]=_0x45eef2['valueOf'](),!_0x4099d8&&_0x3c61c2[_0x5a3749(0x1a3)](_0x539394,_0x33a0d0,_0x110528,{});});else{var _0x3ce9b1=_0x110528['autoExpand']&&_0x110528[_0x860bad(0x171)]<_0x110528[_0x860bad(0x1cd)]&&_0x110528[_0x860bad(0x169)][_0x860bad(0x111)](_0x45eef2)<0x0&&_0x539394!=='function'&&_0x110528['autoExpandPropertyCount']<_0x110528[_0x860bad(0x14e)];_0x3ce9b1||_0x110528[_0x860bad(0x171)]<_0x38968e||_0x4099d8?(this[_0x860bad(0x15e)](_0x33a0d0,_0x45eef2,_0x110528,_0x4099d8||{}),this[_0x860bad(0x132)](_0x45eef2,_0x33a0d0)):this[_0x860bad(0x120)](_0x33a0d0,_0x110528,_0x45eef2,function(){var _0x4e871a=_0x860bad;_0x539394===_0x4e871a(0x1ce)||_0x539394===_0x4e871a(0x1a9)||(delete _0x33a0d0[_0x4e871a(0x118)],_0x33a0d0['capped']=!0x0);});}return _0x33a0d0;}finally{_0x110528[_0x860bad(0x181)]=_0x32f673,_0x110528['depth']=_0x38968e,_0x110528[_0x860bad(0x1c0)]=_0xd7277d;}}[_0x144a79(0x1a3)](_0x48037b,_0x2f1dd0,_0x473c43,_0x2ec293){var _0x39eca7=_0x144a79,_0x3f171f=_0x2ec293[_0x39eca7(0x139)]||_0x473c43[_0x39eca7(0x139)];if((_0x48037b==='string'||_0x48037b===_0x39eca7(0xf3))&&_0x2f1dd0[_0x39eca7(0x118)]){let _0x2d465d=_0x2f1dd0[_0x39eca7(0x118)][_0x39eca7(0x13f)];_0x473c43[_0x39eca7(0x178)]+=_0x2d465d,_0x473c43[_0x39eca7(0x178)]>_0x473c43[_0x39eca7(0x1d2)]?(_0x2f1dd0[_0x39eca7(0x15d)]='',delete _0x2f1dd0['value']):_0x2d465d>_0x3f171f&&(_0x2f1dd0[_0x39eca7(0x15d)]=_0x2f1dd0[_0x39eca7(0x118)][_0x39eca7(0x112)](0x0,_0x3f171f),delete _0x2f1dd0[_0x39eca7(0x118)]);}}[_0x144a79(0x176)](_0x5e12a9){var _0x2e6805=_0x144a79;return!!(_0x5e12a9&&_0x3e77c0[_0x2e6805(0x149)]&&this[_0x2e6805(0x1a4)](_0x5e12a9)===_0x2e6805(0x1e6)&&_0x5e12a9[_0x2e6805(0x1d8)]);}[_0x144a79(0x1cf)](_0x45972a){var _0x58ae9d=_0x144a79;if(_0x45972a[_0x58ae9d(0x19b)](/^\\d+$/))return _0x45972a;var _0x319850;try{_0x319850=JSON[_0x58ae9d(0x1bb)](''+_0x45972a);}catch{_0x319850='\\x22'+this[_0x58ae9d(0x1a4)](_0x45972a)+'\\x22';}return _0x319850[_0x58ae9d(0x19b)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x319850=_0x319850[_0x58ae9d(0x112)](0x1,_0x319850['length']-0x2):_0x319850=_0x319850['replace'](/'/g,'\\x5c\\x27')[_0x58ae9d(0x144)](/\\\\\"/g,'\\x22')[_0x58ae9d(0x144)](/(^\"|\"$)/g,'\\x27'),_0x319850;}[_0x144a79(0x120)](_0x1bd8dc,_0x2ed4bd,_0x324def,_0x4e2bae){var _0x357ebc=_0x144a79;this[_0x357ebc(0xf1)](_0x1bd8dc,_0x2ed4bd),_0x4e2bae&&_0x4e2bae(),this[_0x357ebc(0x132)](_0x324def,_0x1bd8dc),this[_0x357ebc(0x103)](_0x1bd8dc,_0x2ed4bd);}['_treeNodePropertiesBeforeFullValue'](_0x107d65,_0x3ed7ca){var _0x219b16=_0x144a79;this['_setNodeId'](_0x107d65,_0x3ed7ca),this[_0x219b16(0x124)](_0x107d65,_0x3ed7ca),this[_0x219b16(0x1ac)](_0x107d65,_0x3ed7ca),this[_0x219b16(0x110)](_0x107d65,_0x3ed7ca);}[_0x144a79(0x147)](_0x56ce50,_0x58285a){}[_0x144a79(0x124)](_0x2fd389,_0x113b19){}[_0x144a79(0x10d)](_0x46fedc,_0x1fb3d1){}[_0x144a79(0x1c8)](_0x53d6a4){var _0x314f4b=_0x144a79;return _0x53d6a4===this[_0x314f4b(0x168)];}[_0x144a79(0x103)](_0x94f0d4,_0x1f78a2){var _0xc416c9=_0x144a79;this[_0xc416c9(0x10d)](_0x94f0d4,_0x1f78a2),this['_setNodeExpandableState'](_0x94f0d4),_0x1f78a2['sortProps']&&this[_0xc416c9(0xee)](_0x94f0d4),this[_0xc416c9(0x100)](_0x94f0d4,_0x1f78a2),this[_0xc416c9(0x19a)](_0x94f0d4,_0x1f78a2),this[_0xc416c9(0x115)](_0x94f0d4);}[_0x144a79(0x132)](_0x912632,_0x5f5544){var _0x20b522=_0x144a79;let _0x50f594;try{_0x3e77c0[_0x20b522(0x154)]&&(_0x50f594=_0x3e77c0[_0x20b522(0x154)][_0x20b522(0x174)],_0x3e77c0[_0x20b522(0x154)][_0x20b522(0x174)]=function(){}),_0x912632&&typeof _0x912632['length']==_0x20b522(0x133)&&(_0x5f5544['length']=_0x912632['length']);}catch{}finally{_0x50f594&&(_0x3e77c0[_0x20b522(0x154)]['error']=_0x50f594);}if(_0x5f5544[_0x20b522(0x123)]==='number'||_0x5f5544[_0x20b522(0x123)]===_0x20b522(0x135)){if(isNaN(_0x5f5544[_0x20b522(0x118)]))_0x5f5544[_0x20b522(0x158)]=!0x0,delete _0x5f5544['value'];else switch(_0x5f5544[_0x20b522(0x118)]){case Number['POSITIVE_INFINITY']:_0x5f5544[_0x20b522(0x186)]=!0x0,delete _0x5f5544[_0x20b522(0x118)];break;case Number[_0x20b522(0x116)]:_0x5f5544[_0x20b522(0x1aa)]=!0x0,delete _0x5f5544[_0x20b522(0x118)];break;case 0x0:this[_0x20b522(0x141)](_0x5f5544[_0x20b522(0x118)])&&(_0x5f5544[_0x20b522(0x14c)]=!0x0);break;}}else _0x5f5544[_0x20b522(0x123)]===_0x20b522(0x1df)&&typeof _0x912632['name']==_0x20b522(0x13d)&&_0x912632[_0x20b522(0xfe)]&&_0x5f5544[_0x20b522(0xfe)]&&_0x912632[_0x20b522(0xfe)]!==_0x5f5544['name']&&(_0x5f5544[_0x20b522(0x196)]=_0x912632['name']);}[_0x144a79(0x141)](_0x3d8de7){var _0x5bd0fa=_0x144a79;return 0x1/_0x3d8de7===Number[_0x5bd0fa(0x116)];}['_sortProps'](_0x4aa6dd){var _0x119666=_0x144a79;!_0x4aa6dd[_0x119666(0x109)]||!_0x4aa6dd[_0x119666(0x109)][_0x119666(0x13f)]||_0x4aa6dd[_0x119666(0x123)]===_0x119666(0x12b)||_0x4aa6dd[_0x119666(0x123)]===_0x119666(0x149)||_0x4aa6dd[_0x119666(0x123)]===_0x119666(0xfc)||_0x4aa6dd[_0x119666(0x109)]['sort'](function(_0x31ad1b,_0x1e1fbf){var _0x2d660e=_0x119666,_0x1d39c7=_0x31ad1b[_0x2d660e(0xfe)][_0x2d660e(0x1ab)](),_0x58bbc5=_0x1e1fbf['name'][_0x2d660e(0x1ab)]();return _0x1d39c7<_0x58bbc5?-0x1:_0x1d39c7>_0x58bbc5?0x1:0x0;});}[_0x144a79(0x100)](_0x256f87,_0x39cae1){var _0x3d0616=_0x144a79;if(!(_0x39cae1[_0x3d0616(0x11a)]||!_0x256f87['props']||!_0x256f87['props'][_0x3d0616(0x13f)])){for(var _0x12a78b=[],_0x11c382=[],_0x564eb4=0x0,_0x128043=_0x256f87['props'][_0x3d0616(0x13f)];_0x564eb4<_0x128043;_0x564eb4++){var _0x5b20c3=_0x256f87[_0x3d0616(0x109)][_0x564eb4];_0x5b20c3[_0x3d0616(0x123)]==='function'?_0x12a78b[_0x3d0616(0xf9)](_0x5b20c3):_0x11c382[_0x3d0616(0xf9)](_0x5b20c3);}if(!(!_0x11c382[_0x3d0616(0x13f)]||_0x12a78b['length']<=0x1)){_0x256f87[_0x3d0616(0x109)]=_0x11c382;var _0x32daf8={'functionsNode':!0x0,'props':_0x12a78b};this[_0x3d0616(0x147)](_0x32daf8,_0x39cae1),this[_0x3d0616(0x10d)](_0x32daf8,_0x39cae1),this['_setNodeExpandableState'](_0x32daf8),this[_0x3d0616(0x110)](_0x32daf8,_0x39cae1),_0x32daf8['id']+='\\x20f',_0x256f87[_0x3d0616(0x109)][_0x3d0616(0x1b7)](_0x32daf8);}}}[_0x144a79(0x19a)](_0x15acc0,_0x155efd){}[_0x144a79(0x161)](_0x2e282a){}[_0x144a79(0x18b)](_0x237103){var _0xfedee4=_0x144a79;return Array[_0xfedee4(0x164)](_0x237103)||typeof _0x237103==_0xfedee4(0xf2)&&this['_objectToString'](_0x237103)===_0xfedee4(0xef);}[_0x144a79(0x110)](_0x93d6b1,_0x555532){}[_0x144a79(0x115)](_0x2328ec){var _0x443c04=_0x144a79;delete _0x2328ec[_0x443c04(0x1c9)],delete _0x2328ec[_0x443c04(0x106)],delete _0x2328ec[_0x443c04(0x1c6)];}[_0x144a79(0x1ac)](_0x473e8a,_0x1f3de2){}}let _0x182186=new _0x4e138c(),_0x4c7196={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x3701fa={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x213e3e(_0x2ff700,_0x1028d3,_0x6237b8,_0x3512a1,_0xcb090,_0x3b6c4b){var _0x407e31=_0x144a79;let _0x212837,_0x4e347f;try{_0x4e347f=_0x24d130(),_0x212837=_0x3d2d4c[_0x1028d3],!_0x212837||_0x4e347f-_0x212837['ts']>0x1f4&&_0x212837[_0x407e31(0x197)]&&_0x212837[_0x407e31(0x146)]/_0x212837[_0x407e31(0x197)]<0x64?(_0x3d2d4c[_0x1028d3]=_0x212837={'count':0x0,'time':0x0,'ts':_0x4e347f},_0x3d2d4c[_0x407e31(0x1c7)]={}):_0x4e347f-_0x3d2d4c['hits']['ts']>0x32&&_0x3d2d4c[_0x407e31(0x1c7)][_0x407e31(0x197)]&&_0x3d2d4c['hits'][_0x407e31(0x146)]/_0x3d2d4c[_0x407e31(0x1c7)]['count']<0x64&&(_0x3d2d4c[_0x407e31(0x1c7)]={});let _0x36a3f2=[],_0x24554b=_0x212837[_0x407e31(0x102)]||_0x3d2d4c[_0x407e31(0x1c7)][_0x407e31(0x102)]?_0x3701fa:_0x4c7196,_0x347fd7=_0x261a7d=>{var _0x3edcb4=_0x407e31;let _0x3a2713={};return _0x3a2713['props']=_0x261a7d['props'],_0x3a2713[_0x3edcb4(0x122)]=_0x261a7d[_0x3edcb4(0x122)],_0x3a2713[_0x3edcb4(0x139)]=_0x261a7d[_0x3edcb4(0x139)],_0x3a2713[_0x3edcb4(0x1d2)]=_0x261a7d[_0x3edcb4(0x1d2)],_0x3a2713[_0x3edcb4(0x14e)]=_0x261a7d[_0x3edcb4(0x14e)],_0x3a2713[_0x3edcb4(0x1cd)]=_0x261a7d[_0x3edcb4(0x1cd)],_0x3a2713[_0x3edcb4(0xf6)]=!0x1,_0x3a2713[_0x3edcb4(0x11a)]=!_0x368502,_0x3a2713[_0x3edcb4(0x125)]=0x1,_0x3a2713[_0x3edcb4(0x171)]=0x0,_0x3a2713[_0x3edcb4(0x15b)]=_0x3edcb4(0x1dc),_0x3a2713[_0x3edcb4(0x1a0)]='root_exp',_0x3a2713[_0x3edcb4(0x10b)]=!0x0,_0x3a2713['autoExpandPreviousObjects']=[],_0x3a2713[_0x3edcb4(0x1b8)]=0x0,_0x3a2713[_0x3edcb4(0x17b)]=!0x0,_0x3a2713[_0x3edcb4(0x178)]=0x0,_0x3a2713[_0x3edcb4(0x1a1)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x3a2713;};for(var _0x25383a=0x0;_0x25383a<_0xcb090[_0x407e31(0x13f)];_0x25383a++)_0x36a3f2[_0x407e31(0xf9)](_0x182186['serialize']({'timeNode':_0x2ff700===_0x407e31(0x146)||void 0x0},_0xcb090[_0x25383a],_0x347fd7(_0x24554b),{}));if(_0x2ff700==='trace'||_0x2ff700===_0x407e31(0x174)){let _0x5a1a14=Error[_0x407e31(0xfa)];try{Error[_0x407e31(0xfa)]=0x1/0x0,_0x36a3f2[_0x407e31(0xf9)](_0x182186[_0x407e31(0x15e)]({'stackNode':!0x0},new Error()[_0x407e31(0x15f)],_0x347fd7(_0x24554b),{'strLength':0x1/0x0}));}finally{Error[_0x407e31(0xfa)]=_0x5a1a14;}}return{'method':_0x407e31(0x194),'version':_0x391fb4,'args':[{'ts':_0x6237b8,'session':_0x3512a1,'args':_0x36a3f2,'id':_0x1028d3,'context':_0x3b6c4b}]};}catch(_0x5db04b){return{'method':_0x407e31(0x194),'version':_0x391fb4,'args':[{'ts':_0x6237b8,'session':_0x3512a1,'args':[{'type':_0x407e31(0x1b6),'error':_0x5db04b&&_0x5db04b[_0x407e31(0x1ae)]}],'id':_0x1028d3,'context':_0x3b6c4b}]};}finally{try{if(_0x212837&&_0x4e347f){let _0x45e299=_0x24d130();_0x212837['count']++,_0x212837[_0x407e31(0x146)]+=_0x47a395(_0x4e347f,_0x45e299),_0x212837['ts']=_0x45e299,_0x3d2d4c[_0x407e31(0x1c7)][_0x407e31(0x197)]++,_0x3d2d4c[_0x407e31(0x1c7)][_0x407e31(0x146)]+=_0x47a395(_0x4e347f,_0x45e299),_0x3d2d4c[_0x407e31(0x1c7)]['ts']=_0x45e299,(_0x212837[_0x407e31(0x197)]>0x32||_0x212837[_0x407e31(0x146)]>0x64)&&(_0x212837['reduceLimits']=!0x0),(_0x3d2d4c[_0x407e31(0x1c7)][_0x407e31(0x197)]>0x3e8||_0x3d2d4c[_0x407e31(0x1c7)]['time']>0x12c)&&(_0x3d2d4c[_0x407e31(0x1c7)]['reduceLimits']=!0x0);}}catch{}}}return _0x213e3e;}((_0x5d65e9,_0x571af9,_0x37e1e4,_0x433d48,_0x1b02f6,_0x430083,_0x5432d8,_0x102dcb,_0x493a3c,_0x240da5,_0x2821b9)=>{var _0x556dd6=_0x2160de;if(_0x5d65e9[_0x556dd6(0x14d)])return _0x5d65e9[_0x556dd6(0x14d)];if(!H(_0x5d65e9,_0x102dcb,_0x1b02f6))return _0x5d65e9[_0x556dd6(0x14d)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x5d65e9['_console_ninja'];let _0x1d6340=B(_0x5d65e9),_0x397ff6=_0x1d6340['elapsed'],_0x1a91da=_0x1d6340['timeStamp'],_0xa22aa9=_0x1d6340[_0x556dd6(0x129)],_0x4dd46f={'hits':{},'ts':{}},_0x22fa43=X(_0x5d65e9,_0x493a3c,_0x4dd46f,_0x430083),_0x590e5e=_0x44c539=>{_0x4dd46f['ts'][_0x44c539]=_0x1a91da();},_0x1ecc6b=(_0x392121,_0x1d046a)=>{let _0x489bc2=_0x4dd46f['ts'][_0x1d046a];if(delete _0x4dd46f['ts'][_0x1d046a],_0x489bc2){let _0x346578=_0x397ff6(_0x489bc2,_0x1a91da());_0x37b780(_0x22fa43('time',_0x392121,_0xa22aa9(),_0x4ee1c5,[_0x346578],_0x1d046a));}},_0x11ac60=_0x3097ff=>{var _0x43212c=_0x556dd6,_0x5de73e;return _0x1b02f6===_0x43212c(0x1a7)&&_0x5d65e9[_0x43212c(0xf8)]&&((_0x5de73e=_0x3097ff==null?void 0x0:_0x3097ff['args'])==null?void 0x0:_0x5de73e['length'])&&(_0x3097ff[_0x43212c(0x114)][0x0]['origin']=_0x5d65e9[_0x43212c(0xf8)]),_0x3097ff;};_0x5d65e9[_0x556dd6(0x14d)]={'consoleLog':(_0x3df3db,_0x1bb5ab)=>{var _0x2864ec=_0x556dd6;_0x5d65e9[_0x2864ec(0x154)][_0x2864ec(0x194)][_0x2864ec(0xfe)]!==_0x2864ec(0x119)&&_0x37b780(_0x22fa43(_0x2864ec(0x194),_0x3df3db,_0xa22aa9(),_0x4ee1c5,_0x1bb5ab));},'consoleTrace':(_0x29da49,_0x3f8374)=>{var _0x280bf8=_0x556dd6,_0x2254c1,_0x1e4130;_0x5d65e9['console'][_0x280bf8(0x194)][_0x280bf8(0xfe)]!=='disabledTrace'&&((_0x1e4130=(_0x2254c1=_0x5d65e9[_0x280bf8(0x1d1)])==null?void 0x0:_0x2254c1['versions'])!=null&&_0x1e4130[_0x280bf8(0x1a1)]&&(_0x5d65e9[_0x280bf8(0x1de)]=!0x0),_0x37b780(_0x11ac60(_0x22fa43(_0x280bf8(0x170),_0x29da49,_0xa22aa9(),_0x4ee1c5,_0x3f8374))));},'consoleError':(_0x547f0a,_0x50dbc7)=>{var _0x3597a9=_0x556dd6;_0x5d65e9[_0x3597a9(0x1de)]=!0x0,_0x37b780(_0x11ac60(_0x22fa43('error',_0x547f0a,_0xa22aa9(),_0x4ee1c5,_0x50dbc7)));},'consoleTime':_0x123ffe=>{_0x590e5e(_0x123ffe);},'consoleTimeEnd':(_0x2171a0,_0x403bb8)=>{_0x1ecc6b(_0x403bb8,_0x2171a0);},'autoLog':(_0x4998d0,_0x1bac37)=>{var _0xd73d23=_0x556dd6;_0x37b780(_0x22fa43(_0xd73d23(0x194),_0x1bac37,_0xa22aa9(),_0x4ee1c5,[_0x4998d0]));},'autoLogMany':(_0x431d18,_0x36d175)=>{var _0x73d5fc=_0x556dd6;_0x37b780(_0x22fa43(_0x73d5fc(0x194),_0x431d18,_0xa22aa9(),_0x4ee1c5,_0x36d175));},'autoTrace':(_0x459c49,_0x27ff2b)=>{var _0x433b06=_0x556dd6;_0x37b780(_0x11ac60(_0x22fa43(_0x433b06(0x170),_0x27ff2b,_0xa22aa9(),_0x4ee1c5,[_0x459c49])));},'autoTraceMany':(_0x2ff4f7,_0x18ce27)=>{_0x37b780(_0x11ac60(_0x22fa43('trace',_0x2ff4f7,_0xa22aa9(),_0x4ee1c5,_0x18ce27)));},'autoTime':(_0x2e41bc,_0x5eb8ec,_0x1c38dd)=>{_0x590e5e(_0x1c38dd);},'autoTimeEnd':(_0x47c008,_0xad9b13,_0x4fc532)=>{_0x1ecc6b(_0xad9b13,_0x4fc532);},'coverage':_0x4de91b=>{_0x37b780({'method':'coverage','version':_0x430083,'args':[{'id':_0x4de91b}]});}};let _0x37b780=q(_0x5d65e9,_0x571af9,_0x37e1e4,_0x433d48,_0x1b02f6,_0x240da5,_0x2821b9),_0x4ee1c5=_0x5d65e9[_0x556dd6(0x14a)];return _0x5d65e9['_console_ninja'];})(globalThis,_0x2160de(0x187),'64953',_0x2160de(0x16b),_0x2160de(0x1be),_0x2160de(0x1e3),_0x2160de(0x128),_0x2160de(0x1d5),_0x2160de(0x159),_0x2160de(0x183),_0x2160de(0x152));");
//   } catch (e) {}
// }
// ; /* istanbul ignore next */
// function oo_oo(i) {
//   for (var _len = arguments.length, v = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
//     v[_key - 1] = arguments[_key];
//   }
//   try {
//     oo_cm().consoleLog(i, v);
//   } catch (e) {}
//   return v;
// }
// ; /* istanbul ignore next */
// function oo_tr(i) {
//   for (var _len2 = arguments.length, v = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
//     v[_key2 - 1] = arguments[_key2];
//   }
//   try {
//     oo_cm().consoleTrace(i, v);
//   } catch (e) {}
//   return v;
// }
// ; /* istanbul ignore next */
// function oo_tx(i) {
//   for (var _len3 = arguments.length, v = new Array(_len3 > 1 ? _len3 - 1 : 0), _key3 = 1; _key3 < _len3; _key3++) {
//     v[_key3 - 1] = arguments[_key3];
//   }
//   try {
//     oo_cm().consoleError(i, v);
//   } catch (e) {}
//   return v;
// }
// ; /* istanbul ignore next */
// function oo_ts(v) {
//   try {
//     oo_cm().consoleTime(v);
//   } catch (e) {}
//   return v;
// }
// ; /* istanbul ignore next */
// function oo_te(v, i) {
//   try {
//     oo_cm().consoleTimeEnd(v, i);
//   } catch (e) {}
//   return v;
// }
// ; /*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/

// /***/ }),

// /***/ "./resources/js/bootstrap.js":
// /*!***********************************!*\
//   !*** ./resources/js/bootstrap.js ***!
//   \***********************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.esm.js");
// /* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
// /* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
// /* harmony import */ var laravel_echo__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! laravel-echo */ "./node_modules/laravel-echo/dist/echo.js");
// /* harmony import */ var pusher_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! pusher-js */ "./node_modules/pusher-js/dist/web/pusher.js");
// /* harmony import */ var pusher_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(pusher_js__WEBPACK_IMPORTED_MODULE_3__);


// /**
//  * We'll load the axios HTTP library which allows us to easily issue requests
//  * to our Laravel back-end. This library automatically handles sending the
//  * CSRF token as a header based on the value of the "XSRF" token cookie.
//  */


// window.axios = (axios__WEBPACK_IMPORTED_MODULE_1___default());
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// /**
//  * Echo exposes an expressive API for subscribing to channels and listening
//  * for events that are broadcast by Laravel. Echo and event broadcasting
//  * allows your team to easily build robust real-time web applications.
//  */



// window.Pusher = (pusher_js__WEBPACK_IMPORTED_MODULE_3___default());
// window.Echo = new laravel_echo__WEBPACK_IMPORTED_MODULE_2__["default"]({
//   broadcaster: 'pusher',
//   key: "ddfeb8029c8fce193f9a",
//   // Cambiado a MIX_
//   cluster: "us2",
//   // Cambiado a MIX_
//   wsHost:  false || "ws-".concat("us2", ".pusher.com"),
//   wsPort: "443" || 0,
//   wssPort: "443" || 0,
//   forceTLS: ("https" || 0) === 'https',
//   enabledTransports: ['ws', 'wss']
// });

// /***/ }),

// /***/ "./node_modules/bootstrap/dist/js/bootstrap.esm.js":
// /*!*********************************************************!*\
//   !*** ./node_modules/bootstrap/dist/js/bootstrap.esm.js ***!
//   \*********************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   Alert: () => (/* binding */ Alert),
// /* harmony export */   Button: () => (/* binding */ Button),
// /* harmony export */   Carousel: () => (/* binding */ Carousel),
// /* harmony export */   Collapse: () => (/* binding */ Collapse),
// /* harmony export */   Dropdown: () => (/* binding */ Dropdown),
// /* harmony export */   Modal: () => (/* binding */ Modal),
// /* harmony export */   Offcanvas: () => (/* binding */ Offcanvas),
// /* harmony export */   Popover: () => (/* binding */ Popover),
// /* harmony export */   ScrollSpy: () => (/* binding */ ScrollSpy),
// /* harmony export */   Tab: () => (/* binding */ Tab),
// /* harmony export */   Toast: () => (/* binding */ Toast),
// /* harmony export */   Tooltip: () => (/* binding */ Tooltip)
// /* harmony export */ });
// /* harmony import */ var _popperjs_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @popperjs/core */ "./node_modules/@popperjs/core/lib/index.js");
// /* harmony import */ var _popperjs_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @popperjs/core */ "./node_modules/@popperjs/core/lib/popper.js");
// /*!
//   * Bootstrap v5.3.2 (https://getbootstrap.com/)
//   * Copyright 2011-2023 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
//   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//   */


// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap dom/data.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */

// /**
//  * Constants
//  */

// const elementMap = new Map();
// const Data = {
//   set(element, key, instance) {
//     if (!elementMap.has(element)) {
//       elementMap.set(element, new Map());
//     }
//     const instanceMap = elementMap.get(element);

//     // make it clear we only want one instance per element
//     // can be removed later when multiple key/instances are fine to be used
//     if (!instanceMap.has(key) && instanceMap.size !== 0) {
//       // eslint-disable-next-line no-console
//       console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(instanceMap.keys())[0]}.`);
//       return;
//     }
//     instanceMap.set(key, instance);
//   },
//   get(element, key) {
//     if (elementMap.has(element)) {
//       return elementMap.get(element).get(key) || null;
//     }
//     return null;
//   },
//   remove(element, key) {
//     if (!elementMap.has(element)) {
//       return;
//     }
//     const instanceMap = elementMap.get(element);
//     instanceMap.delete(key);

//     // free up element references if there are no instances left for an element
//     if (instanceMap.size === 0) {
//       elementMap.delete(element);
//     }
//   }
// };

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/index.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */

// const MAX_UID = 1000000;
// const MILLISECONDS_MULTIPLIER = 1000;
// const TRANSITION_END = 'transitionend';

// /**
//  * Properly escape IDs selectors to handle weird IDs
//  * @param {string} selector
//  * @returns {string}
//  */
// const parseSelector = selector => {
//   if (selector && window.CSS && window.CSS.escape) {
//     // document.querySelector needs escaping to handle IDs (html5+) containing for instance /
//     selector = selector.replace(/#([^\s"#']+)/g, (match, id) => `#${CSS.escape(id)}`);
//   }
//   return selector;
// };

// // Shout-out Angus Croll (https://goo.gl/pxwQGp)
// const toType = object => {
//   if (object === null || object === undefined) {
//     return `${object}`;
//   }
//   return Object.prototype.toString.call(object).match(/\s([a-z]+)/i)[1].toLowerCase();
// };

// /**
//  * Public Util API
//  */

// const getUID = prefix => {
//   do {
//     prefix += Math.floor(Math.random() * MAX_UID);
//   } while (document.getElementById(prefix));
//   return prefix;
// };
// const getTransitionDurationFromElement = element => {
//   if (!element) {
//     return 0;
//   }

//   // Get transition-duration of the element
//   let {
//     transitionDuration,
//     transitionDelay
//   } = window.getComputedStyle(element);
//   const floatTransitionDuration = Number.parseFloat(transitionDuration);
//   const floatTransitionDelay = Number.parseFloat(transitionDelay);

//   // Return 0 if element or transition duration is not found
//   if (!floatTransitionDuration && !floatTransitionDelay) {
//     return 0;
//   }

//   // If multiple durations are defined, take the first
//   transitionDuration = transitionDuration.split(',')[0];
//   transitionDelay = transitionDelay.split(',')[0];
//   return (Number.parseFloat(transitionDuration) + Number.parseFloat(transitionDelay)) * MILLISECONDS_MULTIPLIER;
// };
// const triggerTransitionEnd = element => {
//   element.dispatchEvent(new Event(TRANSITION_END));
// };
// const isElement = object => {
//   if (!object || typeof object !== 'object') {
//     return false;
//   }
//   if (typeof object.jquery !== 'undefined') {
//     object = object[0];
//   }
//   return typeof object.nodeType !== 'undefined';
// };
// const getElement = object => {
//   // it's a jQuery object or a node element
//   if (isElement(object)) {
//     return object.jquery ? object[0] : object;
//   }
//   if (typeof object === 'string' && object.length > 0) {
//     return document.querySelector(parseSelector(object));
//   }
//   return null;
// };
// const isVisible = element => {
//   if (!isElement(element) || element.getClientRects().length === 0) {
//     return false;
//   }
//   const elementIsVisible = getComputedStyle(element).getPropertyValue('visibility') === 'visible';
//   // Handle `details` element as its content may falsie appear visible when it is closed
//   const closedDetails = element.closest('details:not([open])');
//   if (!closedDetails) {
//     return elementIsVisible;
//   }
//   if (closedDetails !== element) {
//     const summary = element.closest('summary');
//     if (summary && summary.parentNode !== closedDetails) {
//       return false;
//     }
//     if (summary === null) {
//       return false;
//     }
//   }
//   return elementIsVisible;
// };
// const isDisabled = element => {
//   if (!element || element.nodeType !== Node.ELEMENT_NODE) {
//     return true;
//   }
//   if (element.classList.contains('disabled')) {
//     return true;
//   }
//   if (typeof element.disabled !== 'undefined') {
//     return element.disabled;
//   }
//   return element.hasAttribute('disabled') && element.getAttribute('disabled') !== 'false';
// };
// const findShadowRoot = element => {
//   if (!document.documentElement.attachShadow) {
//     return null;
//   }

//   // Can find the shadow root otherwise it'll return the document
//   if (typeof element.getRootNode === 'function') {
//     const root = element.getRootNode();
//     return root instanceof ShadowRoot ? root : null;
//   }
//   if (element instanceof ShadowRoot) {
//     return element;
//   }

//   // when we don't find a shadow root
//   if (!element.parentNode) {
//     return null;
//   }
//   return findShadowRoot(element.parentNode);
// };
// const noop = () => {};

// /**
//  * Trick to restart an element's animation
//  *
//  * @param {HTMLElement} element
//  * @return void
//  *
//  * @see https://www.charistheo.io/blog/2021/02/restart-a-css-animation-with-javascript/#restarting-a-css-animation
//  */
// const reflow = element => {
//   element.offsetHeight; // eslint-disable-line no-unused-expressions
// };

// const getjQuery = () => {
//   if (window.jQuery && !document.body.hasAttribute('data-bs-no-jquery')) {
//     return window.jQuery;
//   }
//   return null;
// };
// const DOMContentLoadedCallbacks = [];
// const onDOMContentLoaded = callback => {
//   if (document.readyState === 'loading') {
//     // add listener on the first call when the document is in loading state
//     if (!DOMContentLoadedCallbacks.length) {
//       document.addEventListener('DOMContentLoaded', () => {
//         for (const callback of DOMContentLoadedCallbacks) {
//           callback();
//         }
//       });
//     }
//     DOMContentLoadedCallbacks.push(callback);
//   } else {
//     callback();
//   }
// };
// const isRTL = () => document.documentElement.dir === 'rtl';
// const defineJQueryPlugin = plugin => {
//   onDOMContentLoaded(() => {
//     const $ = getjQuery();
//     /* istanbul ignore if */
//     if ($) {
//       const name = plugin.NAME;
//       const JQUERY_NO_CONFLICT = $.fn[name];
//       $.fn[name] = plugin.jQueryInterface;
//       $.fn[name].Constructor = plugin;
//       $.fn[name].noConflict = () => {
//         $.fn[name] = JQUERY_NO_CONFLICT;
//         return plugin.jQueryInterface;
//       };
//     }
//   });
// };
// const execute = (possibleCallback, args = [], defaultValue = possibleCallback) => {
//   return typeof possibleCallback === 'function' ? possibleCallback(...args) : defaultValue;
// };
// const executeAfterTransition = (callback, transitionElement, waitForTransition = true) => {
//   if (!waitForTransition) {
//     execute(callback);
//     return;
//   }
//   const durationPadding = 5;
//   const emulatedDuration = getTransitionDurationFromElement(transitionElement) + durationPadding;
//   let called = false;
//   const handler = ({
//     target
//   }) => {
//     if (target !== transitionElement) {
//       return;
//     }
//     called = true;
//     transitionElement.removeEventListener(TRANSITION_END, handler);
//     execute(callback);
//   };
//   transitionElement.addEventListener(TRANSITION_END, handler);
//   setTimeout(() => {
//     if (!called) {
//       triggerTransitionEnd(transitionElement);
//     }
//   }, emulatedDuration);
// };

// /**
//  * Return the previous/next element of a list.
//  *
//  * @param {array} list    The list of elements
//  * @param activeElement   The active element
//  * @param shouldGetNext   Choose to get next or previous element
//  * @param isCycleAllowed
//  * @return {Element|elem} The proper element
//  */
// const getNextActiveElement = (list, activeElement, shouldGetNext, isCycleAllowed) => {
//   const listLength = list.length;
//   let index = list.indexOf(activeElement);

//   // if the element does not exist in the list return an element
//   // depending on the direction and if cycle is allowed
//   if (index === -1) {
//     return !shouldGetNext && isCycleAllowed ? list[listLength - 1] : list[0];
//   }
//   index += shouldGetNext ? 1 : -1;
//   if (isCycleAllowed) {
//     index = (index + listLength) % listLength;
//   }
//   return list[Math.max(0, Math.min(index, listLength - 1))];
// };

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap dom/event-handler.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const namespaceRegex = /[^.]*(?=\..*)\.|.*/;
// const stripNameRegex = /\..*/;
// const stripUidRegex = /::\d+$/;
// const eventRegistry = {}; // Events storage
// let uidEvent = 1;
// const customEvents = {
//   mouseenter: 'mouseover',
//   mouseleave: 'mouseout'
// };
// const nativeEvents = new Set(['click', 'dblclick', 'mouseup', 'mousedown', 'contextmenu', 'mousewheel', 'DOMMouseScroll', 'mouseover', 'mouseout', 'mousemove', 'selectstart', 'selectend', 'keydown', 'keypress', 'keyup', 'orientationchange', 'touchstart', 'touchmove', 'touchend', 'touchcancel', 'pointerdown', 'pointermove', 'pointerup', 'pointerleave', 'pointercancel', 'gesturestart', 'gesturechange', 'gestureend', 'focus', 'blur', 'change', 'reset', 'select', 'submit', 'focusin', 'focusout', 'load', 'unload', 'beforeunload', 'resize', 'move', 'DOMContentLoaded', 'readystatechange', 'error', 'abort', 'scroll']);

// /**
//  * Private methods
//  */

// function makeEventUid(element, uid) {
//   return uid && `${uid}::${uidEvent++}` || element.uidEvent || uidEvent++;
// }
// function getElementEvents(element) {
//   const uid = makeEventUid(element);
//   element.uidEvent = uid;
//   eventRegistry[uid] = eventRegistry[uid] || {};
//   return eventRegistry[uid];
// }
// function bootstrapHandler(element, fn) {
//   return function handler(event) {
//     hydrateObj(event, {
//       delegateTarget: element
//     });
//     if (handler.oneOff) {
//       EventHandler.off(element, event.type, fn);
//     }
//     return fn.apply(element, [event]);
//   };
// }
// function bootstrapDelegationHandler(element, selector, fn) {
//   return function handler(event) {
//     const domElements = element.querySelectorAll(selector);
//     for (let {
//       target
//     } = event; target && target !== this; target = target.parentNode) {
//       for (const domElement of domElements) {
//         if (domElement !== target) {
//           continue;
//         }
//         hydrateObj(event, {
//           delegateTarget: target
//         });
//         if (handler.oneOff) {
//           EventHandler.off(element, event.type, selector, fn);
//         }
//         return fn.apply(target, [event]);
//       }
//     }
//   };
// }
// function findHandler(events, callable, delegationSelector = null) {
//   return Object.values(events).find(event => event.callable === callable && event.delegationSelector === delegationSelector);
// }
// function normalizeParameters(originalTypeEvent, handler, delegationFunction) {
//   const isDelegated = typeof handler === 'string';
//   // TODO: tooltip passes `false` instead of selector, so we need to check
//   const callable = isDelegated ? delegationFunction : handler || delegationFunction;
//   let typeEvent = getTypeEvent(originalTypeEvent);
//   if (!nativeEvents.has(typeEvent)) {
//     typeEvent = originalTypeEvent;
//   }
//   return [isDelegated, callable, typeEvent];
// }
// function addHandler(element, originalTypeEvent, handler, delegationFunction, oneOff) {
//   if (typeof originalTypeEvent !== 'string' || !element) {
//     return;
//   }
//   let [isDelegated, callable, typeEvent] = normalizeParameters(originalTypeEvent, handler, delegationFunction);

//   // in case of mouseenter or mouseleave wrap the handler within a function that checks for its DOM position
//   // this prevents the handler from being dispatched the same way as mouseover or mouseout does
//   if (originalTypeEvent in customEvents) {
//     const wrapFunction = fn => {
//       return function (event) {
//         if (!event.relatedTarget || event.relatedTarget !== event.delegateTarget && !event.delegateTarget.contains(event.relatedTarget)) {
//           return fn.call(this, event);
//         }
//       };
//     };
//     callable = wrapFunction(callable);
//   }
//   const events = getElementEvents(element);
//   const handlers = events[typeEvent] || (events[typeEvent] = {});
//   const previousFunction = findHandler(handlers, callable, isDelegated ? handler : null);
//   if (previousFunction) {
//     previousFunction.oneOff = previousFunction.oneOff && oneOff;
//     return;
//   }
//   const uid = makeEventUid(callable, originalTypeEvent.replace(namespaceRegex, ''));
//   const fn = isDelegated ? bootstrapDelegationHandler(element, handler, callable) : bootstrapHandler(element, callable);
//   fn.delegationSelector = isDelegated ? handler : null;
//   fn.callable = callable;
//   fn.oneOff = oneOff;
//   fn.uidEvent = uid;
//   handlers[uid] = fn;
//   element.addEventListener(typeEvent, fn, isDelegated);
// }
// function removeHandler(element, events, typeEvent, handler, delegationSelector) {
//   const fn = findHandler(events[typeEvent], handler, delegationSelector);
//   if (!fn) {
//     return;
//   }
//   element.removeEventListener(typeEvent, fn, Boolean(delegationSelector));
//   delete events[typeEvent][fn.uidEvent];
// }
// function removeNamespacedHandlers(element, events, typeEvent, namespace) {
//   const storeElementEvent = events[typeEvent] || {};
//   for (const [handlerKey, event] of Object.entries(storeElementEvent)) {
//     if (handlerKey.includes(namespace)) {
//       removeHandler(element, events, typeEvent, event.callable, event.delegationSelector);
//     }
//   }
// }
// function getTypeEvent(event) {
//   // allow to get the native events from namespaced events ('click.bs.button' --> 'click')
//   event = event.replace(stripNameRegex, '');
//   return customEvents[event] || event;
// }
// const EventHandler = {
//   on(element, event, handler, delegationFunction) {
//     addHandler(element, event, handler, delegationFunction, false);
//   },
//   one(element, event, handler, delegationFunction) {
//     addHandler(element, event, handler, delegationFunction, true);
//   },
//   off(element, originalTypeEvent, handler, delegationFunction) {
//     if (typeof originalTypeEvent !== 'string' || !element) {
//       return;
//     }
//     const [isDelegated, callable, typeEvent] = normalizeParameters(originalTypeEvent, handler, delegationFunction);
//     const inNamespace = typeEvent !== originalTypeEvent;
//     const events = getElementEvents(element);
//     const storeElementEvent = events[typeEvent] || {};
//     const isNamespace = originalTypeEvent.startsWith('.');
//     if (typeof callable !== 'undefined') {
//       // Simplest case: handler is passed, remove that listener ONLY.
//       if (!Object.keys(storeElementEvent).length) {
//         return;
//       }
//       removeHandler(element, events, typeEvent, callable, isDelegated ? handler : null);
//       return;
//     }
//     if (isNamespace) {
//       for (const elementEvent of Object.keys(events)) {
//         removeNamespacedHandlers(element, events, elementEvent, originalTypeEvent.slice(1));
//       }
//     }
//     for (const [keyHandlers, event] of Object.entries(storeElementEvent)) {
//       const handlerKey = keyHandlers.replace(stripUidRegex, '');
//       if (!inNamespace || originalTypeEvent.includes(handlerKey)) {
//         removeHandler(element, events, typeEvent, event.callable, event.delegationSelector);
//       }
//     }
//   },
//   trigger(element, event, args) {
//     if (typeof event !== 'string' || !element) {
//       return null;
//     }
//     const $ = getjQuery();
//     const typeEvent = getTypeEvent(event);
//     const inNamespace = event !== typeEvent;
//     let jQueryEvent = null;
//     let bubbles = true;
//     let nativeDispatch = true;
//     let defaultPrevented = false;
//     if (inNamespace && $) {
//       jQueryEvent = $.Event(event, args);
//       $(element).trigger(jQueryEvent);
//       bubbles = !jQueryEvent.isPropagationStopped();
//       nativeDispatch = !jQueryEvent.isImmediatePropagationStopped();
//       defaultPrevented = jQueryEvent.isDefaultPrevented();
//     }
//     const evt = hydrateObj(new Event(event, {
//       bubbles,
//       cancelable: true
//     }), args);
//     if (defaultPrevented) {
//       evt.preventDefault();
//     }
//     if (nativeDispatch) {
//       element.dispatchEvent(evt);
//     }
//     if (evt.defaultPrevented && jQueryEvent) {
//       jQueryEvent.preventDefault();
//     }
//     return evt;
//   }
// };
// function hydrateObj(obj, meta = {}) {
//   for (const [key, value] of Object.entries(meta)) {
//     try {
//       obj[key] = value;
//     } catch (_unused) {
//       Object.defineProperty(obj, key, {
//         configurable: true,
//         get() {
//           return value;
//         }
//       });
//     }
//   }
//   return obj;
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap dom/manipulator.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */

// function normalizeData(value) {
//   if (value === 'true') {
//     return true;
//   }
//   if (value === 'false') {
//     return false;
//   }
//   if (value === Number(value).toString()) {
//     return Number(value);
//   }
//   if (value === '' || value === 'null') {
//     return null;
//   }
//   if (typeof value !== 'string') {
//     return value;
//   }
//   try {
//     return JSON.parse(decodeURIComponent(value));
//   } catch (_unused) {
//     return value;
//   }
// }
// function normalizeDataKey(key) {
//   return key.replace(/[A-Z]/g, chr => `-${chr.toLowerCase()}`);
// }
// const Manipulator = {
//   setDataAttribute(element, key, value) {
//     element.setAttribute(`data-bs-${normalizeDataKey(key)}`, value);
//   },
//   removeDataAttribute(element, key) {
//     element.removeAttribute(`data-bs-${normalizeDataKey(key)}`);
//   },
//   getDataAttributes(element) {
//     if (!element) {
//       return {};
//     }
//     const attributes = {};
//     const bsKeys = Object.keys(element.dataset).filter(key => key.startsWith('bs') && !key.startsWith('bsConfig'));
//     for (const key of bsKeys) {
//       let pureKey = key.replace(/^bs/, '');
//       pureKey = pureKey.charAt(0).toLowerCase() + pureKey.slice(1, pureKey.length);
//       attributes[pureKey] = normalizeData(element.dataset[key]);
//     }
//     return attributes;
//   },
//   getDataAttribute(element, key) {
//     return normalizeData(element.getAttribute(`data-bs-${normalizeDataKey(key)}`));
//   }
// };

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/config.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Class definition
//  */

// class Config {
//   // Getters
//   static get Default() {
//     return {};
//   }
//   static get DefaultType() {
//     return {};
//   }
//   static get NAME() {
//     throw new Error('You have to implement the static method "NAME", for each component!');
//   }
//   _getConfig(config) {
//     config = this._mergeConfigObj(config);
//     config = this._configAfterMerge(config);
//     this._typeCheckConfig(config);
//     return config;
//   }
//   _configAfterMerge(config) {
//     return config;
//   }
//   _mergeConfigObj(config, element) {
//     const jsonConfig = isElement(element) ? Manipulator.getDataAttribute(element, 'config') : {}; // try to parse

//     return {
//       ...this.constructor.Default,
//       ...(typeof jsonConfig === 'object' ? jsonConfig : {}),
//       ...(isElement(element) ? Manipulator.getDataAttributes(element) : {}),
//       ...(typeof config === 'object' ? config : {})
//     };
//   }
//   _typeCheckConfig(config, configTypes = this.constructor.DefaultType) {
//     for (const [property, expectedTypes] of Object.entries(configTypes)) {
//       const value = config[property];
//       const valueType = isElement(value) ? 'element' : toType(value);
//       if (!new RegExp(expectedTypes).test(valueType)) {
//         throw new TypeError(`${this.constructor.NAME.toUpperCase()}: Option "${property}" provided type "${valueType}" but expected type "${expectedTypes}".`);
//       }
//     }
//   }
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap base-component.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const VERSION = '5.3.2';

// /**
//  * Class definition
//  */

// class BaseComponent extends Config {
//   constructor(element, config) {
//     super();
//     element = getElement(element);
//     if (!element) {
//       return;
//     }
//     this._element = element;
//     this._config = this._getConfig(config);
//     Data.set(this._element, this.constructor.DATA_KEY, this);
//   }

//   // Public
//   dispose() {
//     Data.remove(this._element, this.constructor.DATA_KEY);
//     EventHandler.off(this._element, this.constructor.EVENT_KEY);
//     for (const propertyName of Object.getOwnPropertyNames(this)) {
//       this[propertyName] = null;
//     }
//   }
//   _queueCallback(callback, element, isAnimated = true) {
//     executeAfterTransition(callback, element, isAnimated);
//   }
//   _getConfig(config) {
//     config = this._mergeConfigObj(config, this._element);
//     config = this._configAfterMerge(config);
//     this._typeCheckConfig(config);
//     return config;
//   }

//   // Static
//   static getInstance(element) {
//     return Data.get(getElement(element), this.DATA_KEY);
//   }
//   static getOrCreateInstance(element, config = {}) {
//     return this.getInstance(element) || new this(element, typeof config === 'object' ? config : null);
//   }
//   static get VERSION() {
//     return VERSION;
//   }
//   static get DATA_KEY() {
//     return `bs.${this.NAME}`;
//   }
//   static get EVENT_KEY() {
//     return `.${this.DATA_KEY}`;
//   }
//   static eventName(name) {
//     return `${name}${this.EVENT_KEY}`;
//   }
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap dom/selector-engine.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */

// const getSelector = element => {
//   let selector = element.getAttribute('data-bs-target');
//   if (!selector || selector === '#') {
//     let hrefAttribute = element.getAttribute('href');

//     // The only valid content that could double as a selector are IDs or classes,
//     // so everything starting with `#` or `.`. If a "real" URL is used as the selector,
//     // `document.querySelector` will rightfully complain it is invalid.
//     // See https://github.com/twbs/bootstrap/issues/32273
//     if (!hrefAttribute || !hrefAttribute.includes('#') && !hrefAttribute.startsWith('.')) {
//       return null;
//     }

//     // Just in case some CMS puts out a full URL with the anchor appended
//     if (hrefAttribute.includes('#') && !hrefAttribute.startsWith('#')) {
//       hrefAttribute = `#${hrefAttribute.split('#')[1]}`;
//     }
//     selector = hrefAttribute && hrefAttribute !== '#' ? parseSelector(hrefAttribute.trim()) : null;
//   }
//   return selector;
// };
// const SelectorEngine = {
//   find(selector, element = document.documentElement) {
//     return [].concat(...Element.prototype.querySelectorAll.call(element, selector));
//   },
//   findOne(selector, element = document.documentElement) {
//     return Element.prototype.querySelector.call(element, selector);
//   },
//   children(element, selector) {
//     return [].concat(...element.children).filter(child => child.matches(selector));
//   },
//   parents(element, selector) {
//     const parents = [];
//     let ancestor = element.parentNode.closest(selector);
//     while (ancestor) {
//       parents.push(ancestor);
//       ancestor = ancestor.parentNode.closest(selector);
//     }
//     return parents;
//   },
//   prev(element, selector) {
//     let previous = element.previousElementSibling;
//     while (previous) {
//       if (previous.matches(selector)) {
//         return [previous];
//       }
//       previous = previous.previousElementSibling;
//     }
//     return [];
//   },
//   // TODO: this is now unused; remove later along with prev()
//   next(element, selector) {
//     let next = element.nextElementSibling;
//     while (next) {
//       if (next.matches(selector)) {
//         return [next];
//       }
//       next = next.nextElementSibling;
//     }
//     return [];
//   },
//   focusableChildren(element) {
//     const focusables = ['a', 'button', 'input', 'textarea', 'select', 'details', '[tabindex]', '[contenteditable="true"]'].map(selector => `${selector}:not([tabindex^="-"])`).join(',');
//     return this.find(focusables, element).filter(el => !isDisabled(el) && isVisible(el));
//   },
//   getSelectorFromElement(element) {
//     const selector = getSelector(element);
//     if (selector) {
//       return SelectorEngine.findOne(selector) ? selector : null;
//     }
//     return null;
//   },
//   getElementFromSelector(element) {
//     const selector = getSelector(element);
//     return selector ? SelectorEngine.findOne(selector) : null;
//   },
//   getMultipleElementsFromSelector(element) {
//     const selector = getSelector(element);
//     return selector ? SelectorEngine.find(selector) : [];
//   }
// };

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/component-functions.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */

// const enableDismissTrigger = (component, method = 'hide') => {
//   const clickEvent = `click.dismiss${component.EVENT_KEY}`;
//   const name = component.NAME;
//   EventHandler.on(document, clickEvent, `[data-bs-dismiss="${name}"]`, function (event) {
//     if (['A', 'AREA'].includes(this.tagName)) {
//       event.preventDefault();
//     }
//     if (isDisabled(this)) {
//       return;
//     }
//     const target = SelectorEngine.getElementFromSelector(this) || this.closest(`.${name}`);
//     const instance = component.getOrCreateInstance(target);

//     // Method argument is left, for Alert and only, as it doesn't implement the 'hide' method
//     instance[method]();
//   });
// };

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap alert.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$f = 'alert';
// const DATA_KEY$a = 'bs.alert';
// const EVENT_KEY$b = `.${DATA_KEY$a}`;
// const EVENT_CLOSE = `close${EVENT_KEY$b}`;
// const EVENT_CLOSED = `closed${EVENT_KEY$b}`;
// const CLASS_NAME_FADE$5 = 'fade';
// const CLASS_NAME_SHOW$8 = 'show';

// /**
//  * Class definition
//  */

// class Alert extends BaseComponent {
//   // Getters
//   static get NAME() {
//     return NAME$f;
//   }

//   // Public
//   close() {
//     const closeEvent = EventHandler.trigger(this._element, EVENT_CLOSE);
//     if (closeEvent.defaultPrevented) {
//       return;
//     }
//     this._element.classList.remove(CLASS_NAME_SHOW$8);
//     const isAnimated = this._element.classList.contains(CLASS_NAME_FADE$5);
//     this._queueCallback(() => this._destroyElement(), this._element, isAnimated);
//   }

//   // Private
//   _destroyElement() {
//     this._element.remove();
//     EventHandler.trigger(this._element, EVENT_CLOSED);
//     this.dispose();
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Alert.getOrCreateInstance(this);
//       if (typeof config !== 'string') {
//         return;
//       }
//       if (data[config] === undefined || config.startsWith('_') || config === 'constructor') {
//         throw new TypeError(`No method named "${config}"`);
//       }
//       data[config](this);
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// enableDismissTrigger(Alert, 'close');

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Alert);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap button.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$e = 'button';
// const DATA_KEY$9 = 'bs.button';
// const EVENT_KEY$a = `.${DATA_KEY$9}`;
// const DATA_API_KEY$6 = '.data-api';
// const CLASS_NAME_ACTIVE$3 = 'active';
// const SELECTOR_DATA_TOGGLE$5 = '[data-bs-toggle="button"]';
// const EVENT_CLICK_DATA_API$6 = `click${EVENT_KEY$a}${DATA_API_KEY$6}`;

// /**
//  * Class definition
//  */

// class Button extends BaseComponent {
//   // Getters
//   static get NAME() {
//     return NAME$e;
//   }

//   // Public
//   toggle() {
//     // Toggle class and sync the `aria-pressed` attribute with the return value of the `.toggle()` method
//     this._element.setAttribute('aria-pressed', this._element.classList.toggle(CLASS_NAME_ACTIVE$3));
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Button.getOrCreateInstance(this);
//       if (config === 'toggle') {
//         data[config]();
//       }
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// EventHandler.on(document, EVENT_CLICK_DATA_API$6, SELECTOR_DATA_TOGGLE$5, event => {
//   event.preventDefault();
//   const button = event.target.closest(SELECTOR_DATA_TOGGLE$5);
//   const data = Button.getOrCreateInstance(button);
//   data.toggle();
// });

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Button);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/swipe.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$d = 'swipe';
// const EVENT_KEY$9 = '.bs.swipe';
// const EVENT_TOUCHSTART = `touchstart${EVENT_KEY$9}`;
// const EVENT_TOUCHMOVE = `touchmove${EVENT_KEY$9}`;
// const EVENT_TOUCHEND = `touchend${EVENT_KEY$9}`;
// const EVENT_POINTERDOWN = `pointerdown${EVENT_KEY$9}`;
// const EVENT_POINTERUP = `pointerup${EVENT_KEY$9}`;
// const POINTER_TYPE_TOUCH = 'touch';
// const POINTER_TYPE_PEN = 'pen';
// const CLASS_NAME_POINTER_EVENT = 'pointer-event';
// const SWIPE_THRESHOLD = 40;
// const Default$c = {
//   endCallback: null,
//   leftCallback: null,
//   rightCallback: null
// };
// const DefaultType$c = {
//   endCallback: '(function|null)',
//   leftCallback: '(function|null)',
//   rightCallback: '(function|null)'
// };

// /**
//  * Class definition
//  */

// class Swipe extends Config {
//   constructor(element, config) {
//     super();
//     this._element = element;
//     if (!element || !Swipe.isSupported()) {
//       return;
//     }
//     this._config = this._getConfig(config);
//     this._deltaX = 0;
//     this._supportPointerEvents = Boolean(window.PointerEvent);
//     this._initEvents();
//   }

//   // Getters
//   static get Default() {
//     return Default$c;
//   }
//   static get DefaultType() {
//     return DefaultType$c;
//   }
//   static get NAME() {
//     return NAME$d;
//   }

//   // Public
//   dispose() {
//     EventHandler.off(this._element, EVENT_KEY$9);
//   }

//   // Private
//   _start(event) {
//     if (!this._supportPointerEvents) {
//       this._deltaX = event.touches[0].clientX;
//       return;
//     }
//     if (this._eventIsPointerPenTouch(event)) {
//       this._deltaX = event.clientX;
//     }
//   }
//   _end(event) {
//     if (this._eventIsPointerPenTouch(event)) {
//       this._deltaX = event.clientX - this._deltaX;
//     }
//     this._handleSwipe();
//     execute(this._config.endCallback);
//   }
//   _move(event) {
//     this._deltaX = event.touches && event.touches.length > 1 ? 0 : event.touches[0].clientX - this._deltaX;
//   }
//   _handleSwipe() {
//     const absDeltaX = Math.abs(this._deltaX);
//     if (absDeltaX <= SWIPE_THRESHOLD) {
//       return;
//     }
//     const direction = absDeltaX / this._deltaX;
//     this._deltaX = 0;
//     if (!direction) {
//       return;
//     }
//     execute(direction > 0 ? this._config.rightCallback : this._config.leftCallback);
//   }
//   _initEvents() {
//     if (this._supportPointerEvents) {
//       EventHandler.on(this._element, EVENT_POINTERDOWN, event => this._start(event));
//       EventHandler.on(this._element, EVENT_POINTERUP, event => this._end(event));
//       this._element.classList.add(CLASS_NAME_POINTER_EVENT);
//     } else {
//       EventHandler.on(this._element, EVENT_TOUCHSTART, event => this._start(event));
//       EventHandler.on(this._element, EVENT_TOUCHMOVE, event => this._move(event));
//       EventHandler.on(this._element, EVENT_TOUCHEND, event => this._end(event));
//     }
//   }
//   _eventIsPointerPenTouch(event) {
//     return this._supportPointerEvents && (event.pointerType === POINTER_TYPE_PEN || event.pointerType === POINTER_TYPE_TOUCH);
//   }

//   // Static
//   static isSupported() {
//     return 'ontouchstart' in document.documentElement || navigator.maxTouchPoints > 0;
//   }
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap carousel.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$c = 'carousel';
// const DATA_KEY$8 = 'bs.carousel';
// const EVENT_KEY$8 = `.${DATA_KEY$8}`;
// const DATA_API_KEY$5 = '.data-api';
// const ARROW_LEFT_KEY$1 = 'ArrowLeft';
// const ARROW_RIGHT_KEY$1 = 'ArrowRight';
// const TOUCHEVENT_COMPAT_WAIT = 500; // Time for mouse compat events to fire after touch

// const ORDER_NEXT = 'next';
// const ORDER_PREV = 'prev';
// const DIRECTION_LEFT = 'left';
// const DIRECTION_RIGHT = 'right';
// const EVENT_SLIDE = `slide${EVENT_KEY$8}`;
// const EVENT_SLID = `slid${EVENT_KEY$8}`;
// const EVENT_KEYDOWN$1 = `keydown${EVENT_KEY$8}`;
// const EVENT_MOUSEENTER$1 = `mouseenter${EVENT_KEY$8}`;
// const EVENT_MOUSELEAVE$1 = `mouseleave${EVENT_KEY$8}`;
// const EVENT_DRAG_START = `dragstart${EVENT_KEY$8}`;
// const EVENT_LOAD_DATA_API$3 = `load${EVENT_KEY$8}${DATA_API_KEY$5}`;
// const EVENT_CLICK_DATA_API$5 = `click${EVENT_KEY$8}${DATA_API_KEY$5}`;
// const CLASS_NAME_CAROUSEL = 'carousel';
// const CLASS_NAME_ACTIVE$2 = 'active';
// const CLASS_NAME_SLIDE = 'slide';
// const CLASS_NAME_END = 'carousel-item-end';
// const CLASS_NAME_START = 'carousel-item-start';
// const CLASS_NAME_NEXT = 'carousel-item-next';
// const CLASS_NAME_PREV = 'carousel-item-prev';
// const SELECTOR_ACTIVE = '.active';
// const SELECTOR_ITEM = '.carousel-item';
// const SELECTOR_ACTIVE_ITEM = SELECTOR_ACTIVE + SELECTOR_ITEM;
// const SELECTOR_ITEM_IMG = '.carousel-item img';
// const SELECTOR_INDICATORS = '.carousel-indicators';
// const SELECTOR_DATA_SLIDE = '[data-bs-slide], [data-bs-slide-to]';
// const SELECTOR_DATA_RIDE = '[data-bs-ride="carousel"]';
// const KEY_TO_DIRECTION = {
//   [ARROW_LEFT_KEY$1]: DIRECTION_RIGHT,
//   [ARROW_RIGHT_KEY$1]: DIRECTION_LEFT
// };
// const Default$b = {
//   interval: 5000,
//   keyboard: true,
//   pause: 'hover',
//   ride: false,
//   touch: true,
//   wrap: true
// };
// const DefaultType$b = {
//   interval: '(number|boolean)',
//   // TODO:v6 remove boolean support
//   keyboard: 'boolean',
//   pause: '(string|boolean)',
//   ride: '(boolean|string)',
//   touch: 'boolean',
//   wrap: 'boolean'
// };

// /**
//  * Class definition
//  */

// class Carousel extends BaseComponent {
//   constructor(element, config) {
//     super(element, config);
//     this._interval = null;
//     this._activeElement = null;
//     this._isSliding = false;
//     this.touchTimeout = null;
//     this._swipeHelper = null;
//     this._indicatorsElement = SelectorEngine.findOne(SELECTOR_INDICATORS, this._element);
//     this._addEventListeners();
//     if (this._config.ride === CLASS_NAME_CAROUSEL) {
//       this.cycle();
//     }
//   }

//   // Getters
//   static get Default() {
//     return Default$b;
//   }
//   static get DefaultType() {
//     return DefaultType$b;
//   }
//   static get NAME() {
//     return NAME$c;
//   }

//   // Public
//   next() {
//     this._slide(ORDER_NEXT);
//   }
//   nextWhenVisible() {
//     // FIXME TODO use `document.visibilityState`
//     // Don't call next when the page isn't visible
//     // or the carousel or its parent isn't visible
//     if (!document.hidden && isVisible(this._element)) {
//       this.next();
//     }
//   }
//   prev() {
//     this._slide(ORDER_PREV);
//   }
//   pause() {
//     if (this._isSliding) {
//       triggerTransitionEnd(this._element);
//     }
//     this._clearInterval();
//   }
//   cycle() {
//     this._clearInterval();
//     this._updateInterval();
//     this._interval = setInterval(() => this.nextWhenVisible(), this._config.interval);
//   }
//   _maybeEnableCycle() {
//     if (!this._config.ride) {
//       return;
//     }
//     if (this._isSliding) {
//       EventHandler.one(this._element, EVENT_SLID, () => this.cycle());
//       return;
//     }
//     this.cycle();
//   }
//   to(index) {
//     const items = this._getItems();
//     if (index > items.length - 1 || index < 0) {
//       return;
//     }
//     if (this._isSliding) {
//       EventHandler.one(this._element, EVENT_SLID, () => this.to(index));
//       return;
//     }
//     const activeIndex = this._getItemIndex(this._getActive());
//     if (activeIndex === index) {
//       return;
//     }
//     const order = index > activeIndex ? ORDER_NEXT : ORDER_PREV;
//     this._slide(order, items[index]);
//   }
//   dispose() {
//     if (this._swipeHelper) {
//       this._swipeHelper.dispose();
//     }
//     super.dispose();
//   }

//   // Private
//   _configAfterMerge(config) {
//     config.defaultInterval = config.interval;
//     return config;
//   }
//   _addEventListeners() {
//     if (this._config.keyboard) {
//       EventHandler.on(this._element, EVENT_KEYDOWN$1, event => this._keydown(event));
//     }
//     if (this._config.pause === 'hover') {
//       EventHandler.on(this._element, EVENT_MOUSEENTER$1, () => this.pause());
//       EventHandler.on(this._element, EVENT_MOUSELEAVE$1, () => this._maybeEnableCycle());
//     }
//     if (this._config.touch && Swipe.isSupported()) {
//       this._addTouchEventListeners();
//     }
//   }
//   _addTouchEventListeners() {
//     for (const img of SelectorEngine.find(SELECTOR_ITEM_IMG, this._element)) {
//       EventHandler.on(img, EVENT_DRAG_START, event => event.preventDefault());
//     }
//     const endCallBack = () => {
//       if (this._config.pause !== 'hover') {
//         return;
//       }

//       // If it's a touch-enabled device, mouseenter/leave are fired as
//       // part of the mouse compatibility events on first tap - the carousel
//       // would stop cycling until user tapped out of it;
//       // here, we listen for touchend, explicitly pause the carousel
//       // (as if it's the second time we tap on it, mouseenter compat event
//       // is NOT fired) and after a timeout (to allow for mouse compatibility
//       // events to fire) we explicitly restart cycling

//       this.pause();
//       if (this.touchTimeout) {
//         clearTimeout(this.touchTimeout);
//       }
//       this.touchTimeout = setTimeout(() => this._maybeEnableCycle(), TOUCHEVENT_COMPAT_WAIT + this._config.interval);
//     };
//     const swipeConfig = {
//       leftCallback: () => this._slide(this._directionToOrder(DIRECTION_LEFT)),
//       rightCallback: () => this._slide(this._directionToOrder(DIRECTION_RIGHT)),
//       endCallback: endCallBack
//     };
//     this._swipeHelper = new Swipe(this._element, swipeConfig);
//   }
//   _keydown(event) {
//     if (/input|textarea/i.test(event.target.tagName)) {
//       return;
//     }
//     const direction = KEY_TO_DIRECTION[event.key];
//     if (direction) {
//       event.preventDefault();
//       this._slide(this._directionToOrder(direction));
//     }
//   }
//   _getItemIndex(element) {
//     return this._getItems().indexOf(element);
//   }
//   _setActiveIndicatorElement(index) {
//     if (!this._indicatorsElement) {
//       return;
//     }
//     const activeIndicator = SelectorEngine.findOne(SELECTOR_ACTIVE, this._indicatorsElement);
//     activeIndicator.classList.remove(CLASS_NAME_ACTIVE$2);
//     activeIndicator.removeAttribute('aria-current');
//     const newActiveIndicator = SelectorEngine.findOne(`[data-bs-slide-to="${index}"]`, this._indicatorsElement);
//     if (newActiveIndicator) {
//       newActiveIndicator.classList.add(CLASS_NAME_ACTIVE$2);
//       newActiveIndicator.setAttribute('aria-current', 'true');
//     }
//   }
//   _updateInterval() {
//     const element = this._activeElement || this._getActive();
//     if (!element) {
//       return;
//     }
//     const elementInterval = Number.parseInt(element.getAttribute('data-bs-interval'), 10);
//     this._config.interval = elementInterval || this._config.defaultInterval;
//   }
//   _slide(order, element = null) {
//     if (this._isSliding) {
//       return;
//     }
//     const activeElement = this._getActive();
//     const isNext = order === ORDER_NEXT;
//     const nextElement = element || getNextActiveElement(this._getItems(), activeElement, isNext, this._config.wrap);
//     if (nextElement === activeElement) {
//       return;
//     }
//     const nextElementIndex = this._getItemIndex(nextElement);
//     const triggerEvent = eventName => {
//       return EventHandler.trigger(this._element, eventName, {
//         relatedTarget: nextElement,
//         direction: this._orderToDirection(order),
//         from: this._getItemIndex(activeElement),
//         to: nextElementIndex
//       });
//     };
//     const slideEvent = triggerEvent(EVENT_SLIDE);
//     if (slideEvent.defaultPrevented) {
//       return;
//     }
//     if (!activeElement || !nextElement) {
//       // Some weirdness is happening, so we bail
//       // TODO: change tests that use empty divs to avoid this check
//       return;
//     }
//     const isCycling = Boolean(this._interval);
//     this.pause();
//     this._isSliding = true;
//     this._setActiveIndicatorElement(nextElementIndex);
//     this._activeElement = nextElement;
//     const directionalClassName = isNext ? CLASS_NAME_START : CLASS_NAME_END;
//     const orderClassName = isNext ? CLASS_NAME_NEXT : CLASS_NAME_PREV;
//     nextElement.classList.add(orderClassName);
//     reflow(nextElement);
//     activeElement.classList.add(directionalClassName);
//     nextElement.classList.add(directionalClassName);
//     const completeCallBack = () => {
//       nextElement.classList.remove(directionalClassName, orderClassName);
//       nextElement.classList.add(CLASS_NAME_ACTIVE$2);
//       activeElement.classList.remove(CLASS_NAME_ACTIVE$2, orderClassName, directionalClassName);
//       this._isSliding = false;
//       triggerEvent(EVENT_SLID);
//     };
//     this._queueCallback(completeCallBack, activeElement, this._isAnimated());
//     if (isCycling) {
//       this.cycle();
//     }
//   }
//   _isAnimated() {
//     return this._element.classList.contains(CLASS_NAME_SLIDE);
//   }
//   _getActive() {
//     return SelectorEngine.findOne(SELECTOR_ACTIVE_ITEM, this._element);
//   }
//   _getItems() {
//     return SelectorEngine.find(SELECTOR_ITEM, this._element);
//   }
//   _clearInterval() {
//     if (this._interval) {
//       clearInterval(this._interval);
//       this._interval = null;
//     }
//   }
//   _directionToOrder(direction) {
//     if (isRTL()) {
//       return direction === DIRECTION_LEFT ? ORDER_PREV : ORDER_NEXT;
//     }
//     return direction === DIRECTION_LEFT ? ORDER_NEXT : ORDER_PREV;
//   }
//   _orderToDirection(order) {
//     if (isRTL()) {
//       return order === ORDER_PREV ? DIRECTION_LEFT : DIRECTION_RIGHT;
//     }
//     return order === ORDER_PREV ? DIRECTION_RIGHT : DIRECTION_LEFT;
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Carousel.getOrCreateInstance(this, config);
//       if (typeof config === 'number') {
//         data.to(config);
//         return;
//       }
//       if (typeof config === 'string') {
//         if (data[config] === undefined || config.startsWith('_') || config === 'constructor') {
//           throw new TypeError(`No method named "${config}"`);
//         }
//         data[config]();
//       }
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// EventHandler.on(document, EVENT_CLICK_DATA_API$5, SELECTOR_DATA_SLIDE, function (event) {
//   const target = SelectorEngine.getElementFromSelector(this);
//   if (!target || !target.classList.contains(CLASS_NAME_CAROUSEL)) {
//     return;
//   }
//   event.preventDefault();
//   const carousel = Carousel.getOrCreateInstance(target);
//   const slideIndex = this.getAttribute('data-bs-slide-to');
//   if (slideIndex) {
//     carousel.to(slideIndex);
//     carousel._maybeEnableCycle();
//     return;
//   }
//   if (Manipulator.getDataAttribute(this, 'slide') === 'next') {
//     carousel.next();
//     carousel._maybeEnableCycle();
//     return;
//   }
//   carousel.prev();
//   carousel._maybeEnableCycle();
// });
// EventHandler.on(window, EVENT_LOAD_DATA_API$3, () => {
//   const carousels = SelectorEngine.find(SELECTOR_DATA_RIDE);
//   for (const carousel of carousels) {
//     Carousel.getOrCreateInstance(carousel);
//   }
// });

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Carousel);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap collapse.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$b = 'collapse';
// const DATA_KEY$7 = 'bs.collapse';
// const EVENT_KEY$7 = `.${DATA_KEY$7}`;
// const DATA_API_KEY$4 = '.data-api';
// const EVENT_SHOW$6 = `show${EVENT_KEY$7}`;
// const EVENT_SHOWN$6 = `shown${EVENT_KEY$7}`;
// const EVENT_HIDE$6 = `hide${EVENT_KEY$7}`;
// const EVENT_HIDDEN$6 = `hidden${EVENT_KEY$7}`;
// const EVENT_CLICK_DATA_API$4 = `click${EVENT_KEY$7}${DATA_API_KEY$4}`;
// const CLASS_NAME_SHOW$7 = 'show';
// const CLASS_NAME_COLLAPSE = 'collapse';
// const CLASS_NAME_COLLAPSING = 'collapsing';
// const CLASS_NAME_COLLAPSED = 'collapsed';
// const CLASS_NAME_DEEPER_CHILDREN = `:scope .${CLASS_NAME_COLLAPSE} .${CLASS_NAME_COLLAPSE}`;
// const CLASS_NAME_HORIZONTAL = 'collapse-horizontal';
// const WIDTH = 'width';
// const HEIGHT = 'height';
// const SELECTOR_ACTIVES = '.collapse.show, .collapse.collapsing';
// const SELECTOR_DATA_TOGGLE$4 = '[data-bs-toggle="collapse"]';
// const Default$a = {
//   parent: null,
//   toggle: true
// };
// const DefaultType$a = {
//   parent: '(null|element)',
//   toggle: 'boolean'
// };

// /**
//  * Class definition
//  */

// class Collapse extends BaseComponent {
//   constructor(element, config) {
//     super(element, config);
//     this._isTransitioning = false;
//     this._triggerArray = [];
//     const toggleList = SelectorEngine.find(SELECTOR_DATA_TOGGLE$4);
//     for (const elem of toggleList) {
//       const selector = SelectorEngine.getSelectorFromElement(elem);
//       const filterElement = SelectorEngine.find(selector).filter(foundElement => foundElement === this._element);
//       if (selector !== null && filterElement.length) {
//         this._triggerArray.push(elem);
//       }
//     }
//     this._initializeChildren();
//     if (!this._config.parent) {
//       this._addAriaAndCollapsedClass(this._triggerArray, this._isShown());
//     }
//     if (this._config.toggle) {
//       this.toggle();
//     }
//   }

//   // Getters
//   static get Default() {
//     return Default$a;
//   }
//   static get DefaultType() {
//     return DefaultType$a;
//   }
//   static get NAME() {
//     return NAME$b;
//   }

//   // Public
//   toggle() {
//     if (this._isShown()) {
//       this.hide();
//     } else {
//       this.show();
//     }
//   }
//   show() {
//     if (this._isTransitioning || this._isShown()) {
//       return;
//     }
//     let activeChildren = [];

//     // find active children
//     if (this._config.parent) {
//       activeChildren = this._getFirstLevelChildren(SELECTOR_ACTIVES).filter(element => element !== this._element).map(element => Collapse.getOrCreateInstance(element, {
//         toggle: false
//       }));
//     }
//     if (activeChildren.length && activeChildren[0]._isTransitioning) {
//       return;
//     }
//     const startEvent = EventHandler.trigger(this._element, EVENT_SHOW$6);
//     if (startEvent.defaultPrevented) {
//       return;
//     }
//     for (const activeInstance of activeChildren) {
//       activeInstance.hide();
//     }
//     const dimension = this._getDimension();
//     this._element.classList.remove(CLASS_NAME_COLLAPSE);
//     this._element.classList.add(CLASS_NAME_COLLAPSING);
//     this._element.style[dimension] = 0;
//     this._addAriaAndCollapsedClass(this._triggerArray, true);
//     this._isTransitioning = true;
//     const complete = () => {
//       this._isTransitioning = false;
//       this._element.classList.remove(CLASS_NAME_COLLAPSING);
//       this._element.classList.add(CLASS_NAME_COLLAPSE, CLASS_NAME_SHOW$7);
//       this._element.style[dimension] = '';
//       EventHandler.trigger(this._element, EVENT_SHOWN$6);
//     };
//     const capitalizedDimension = dimension[0].toUpperCase() + dimension.slice(1);
//     const scrollSize = `scroll${capitalizedDimension}`;
//     this._queueCallback(complete, this._element, true);
//     this._element.style[dimension] = `${this._element[scrollSize]}px`;
//   }
//   hide() {
//     if (this._isTransitioning || !this._isShown()) {
//       return;
//     }
//     const startEvent = EventHandler.trigger(this._element, EVENT_HIDE$6);
//     if (startEvent.defaultPrevented) {
//       return;
//     }
//     const dimension = this._getDimension();
//     this._element.style[dimension] = `${this._element.getBoundingClientRect()[dimension]}px`;
//     reflow(this._element);
//     this._element.classList.add(CLASS_NAME_COLLAPSING);
//     this._element.classList.remove(CLASS_NAME_COLLAPSE, CLASS_NAME_SHOW$7);
//     for (const trigger of this._triggerArray) {
//       const element = SelectorEngine.getElementFromSelector(trigger);
//       if (element && !this._isShown(element)) {
//         this._addAriaAndCollapsedClass([trigger], false);
//       }
//     }
//     this._isTransitioning = true;
//     const complete = () => {
//       this._isTransitioning = false;
//       this._element.classList.remove(CLASS_NAME_COLLAPSING);
//       this._element.classList.add(CLASS_NAME_COLLAPSE);
//       EventHandler.trigger(this._element, EVENT_HIDDEN$6);
//     };
//     this._element.style[dimension] = '';
//     this._queueCallback(complete, this._element, true);
//   }
//   _isShown(element = this._element) {
//     return element.classList.contains(CLASS_NAME_SHOW$7);
//   }

//   // Private
//   _configAfterMerge(config) {
//     config.toggle = Boolean(config.toggle); // Coerce string values
//     config.parent = getElement(config.parent);
//     return config;
//   }
//   _getDimension() {
//     return this._element.classList.contains(CLASS_NAME_HORIZONTAL) ? WIDTH : HEIGHT;
//   }
//   _initializeChildren() {
//     if (!this._config.parent) {
//       return;
//     }
//     const children = this._getFirstLevelChildren(SELECTOR_DATA_TOGGLE$4);
//     for (const element of children) {
//       const selected = SelectorEngine.getElementFromSelector(element);
//       if (selected) {
//         this._addAriaAndCollapsedClass([element], this._isShown(selected));
//       }
//     }
//   }
//   _getFirstLevelChildren(selector) {
//     const children = SelectorEngine.find(CLASS_NAME_DEEPER_CHILDREN, this._config.parent);
//     // remove children if greater depth
//     return SelectorEngine.find(selector, this._config.parent).filter(element => !children.includes(element));
//   }
//   _addAriaAndCollapsedClass(triggerArray, isOpen) {
//     if (!triggerArray.length) {
//       return;
//     }
//     for (const element of triggerArray) {
//       element.classList.toggle(CLASS_NAME_COLLAPSED, !isOpen);
//       element.setAttribute('aria-expanded', isOpen);
//     }
//   }

//   // Static
//   static jQueryInterface(config) {
//     const _config = {};
//     if (typeof config === 'string' && /show|hide/.test(config)) {
//       _config.toggle = false;
//     }
//     return this.each(function () {
//       const data = Collapse.getOrCreateInstance(this, _config);
//       if (typeof config === 'string') {
//         if (typeof data[config] === 'undefined') {
//           throw new TypeError(`No method named "${config}"`);
//         }
//         data[config]();
//       }
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// EventHandler.on(document, EVENT_CLICK_DATA_API$4, SELECTOR_DATA_TOGGLE$4, function (event) {
//   // preventDefault only for <a> elements (which change the URL) not inside the collapsible element
//   if (event.target.tagName === 'A' || event.delegateTarget && event.delegateTarget.tagName === 'A') {
//     event.preventDefault();
//   }
//   for (const element of SelectorEngine.getMultipleElementsFromSelector(this)) {
//     Collapse.getOrCreateInstance(element, {
//       toggle: false
//     }).toggle();
//   }
// });

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Collapse);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap dropdown.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$a = 'dropdown';
// const DATA_KEY$6 = 'bs.dropdown';
// const EVENT_KEY$6 = `.${DATA_KEY$6}`;
// const DATA_API_KEY$3 = '.data-api';
// const ESCAPE_KEY$2 = 'Escape';
// const TAB_KEY$1 = 'Tab';
// const ARROW_UP_KEY$1 = 'ArrowUp';
// const ARROW_DOWN_KEY$1 = 'ArrowDown';
// const RIGHT_MOUSE_BUTTON = 2; // MouseEvent.button value for the secondary button, usually the right button

// const EVENT_HIDE$5 = `hide${EVENT_KEY$6}`;
// const EVENT_HIDDEN$5 = `hidden${EVENT_KEY$6}`;
// const EVENT_SHOW$5 = `show${EVENT_KEY$6}`;
// const EVENT_SHOWN$5 = `shown${EVENT_KEY$6}`;
// const EVENT_CLICK_DATA_API$3 = `click${EVENT_KEY$6}${DATA_API_KEY$3}`;
// const EVENT_KEYDOWN_DATA_API = `keydown${EVENT_KEY$6}${DATA_API_KEY$3}`;
// const EVENT_KEYUP_DATA_API = `keyup${EVENT_KEY$6}${DATA_API_KEY$3}`;
// const CLASS_NAME_SHOW$6 = 'show';
// const CLASS_NAME_DROPUP = 'dropup';
// const CLASS_NAME_DROPEND = 'dropend';
// const CLASS_NAME_DROPSTART = 'dropstart';
// const CLASS_NAME_DROPUP_CENTER = 'dropup-center';
// const CLASS_NAME_DROPDOWN_CENTER = 'dropdown-center';
// const SELECTOR_DATA_TOGGLE$3 = '[data-bs-toggle="dropdown"]:not(.disabled):not(:disabled)';
// const SELECTOR_DATA_TOGGLE_SHOWN = `${SELECTOR_DATA_TOGGLE$3}.${CLASS_NAME_SHOW$6}`;
// const SELECTOR_MENU = '.dropdown-menu';
// const SELECTOR_NAVBAR = '.navbar';
// const SELECTOR_NAVBAR_NAV = '.navbar-nav';
// const SELECTOR_VISIBLE_ITEMS = '.dropdown-menu .dropdown-item:not(.disabled):not(:disabled)';
// const PLACEMENT_TOP = isRTL() ? 'top-end' : 'top-start';
// const PLACEMENT_TOPEND = isRTL() ? 'top-start' : 'top-end';
// const PLACEMENT_BOTTOM = isRTL() ? 'bottom-end' : 'bottom-start';
// const PLACEMENT_BOTTOMEND = isRTL() ? 'bottom-start' : 'bottom-end';
// const PLACEMENT_RIGHT = isRTL() ? 'left-start' : 'right-start';
// const PLACEMENT_LEFT = isRTL() ? 'right-start' : 'left-start';
// const PLACEMENT_TOPCENTER = 'top';
// const PLACEMENT_BOTTOMCENTER = 'bottom';
// const Default$9 = {
//   autoClose: true,
//   boundary: 'clippingParents',
//   display: 'dynamic',
//   offset: [0, 2],
//   popperConfig: null,
//   reference: 'toggle'
// };
// const DefaultType$9 = {
//   autoClose: '(boolean|string)',
//   boundary: '(string|element)',
//   display: 'string',
//   offset: '(array|string|function)',
//   popperConfig: '(null|object|function)',
//   reference: '(string|element|object)'
// };

// /**
//  * Class definition
//  */

// class Dropdown extends BaseComponent {
//   constructor(element, config) {
//     super(element, config);
//     this._popper = null;
//     this._parent = this._element.parentNode; // dropdown wrapper
//     // TODO: v6 revert #37011 & change markup https://getbootstrap.com/docs/5.3/forms/input-group/
//     this._menu = SelectorEngine.next(this._element, SELECTOR_MENU)[0] || SelectorEngine.prev(this._element, SELECTOR_MENU)[0] || SelectorEngine.findOne(SELECTOR_MENU, this._parent);
//     this._inNavbar = this._detectNavbar();
//   }

//   // Getters
//   static get Default() {
//     return Default$9;
//   }
//   static get DefaultType() {
//     return DefaultType$9;
//   }
//   static get NAME() {
//     return NAME$a;
//   }

//   // Public
//   toggle() {
//     return this._isShown() ? this.hide() : this.show();
//   }
//   show() {
//     if (isDisabled(this._element) || this._isShown()) {
//       return;
//     }
//     const relatedTarget = {
//       relatedTarget: this._element
//     };
//     const showEvent = EventHandler.trigger(this._element, EVENT_SHOW$5, relatedTarget);
//     if (showEvent.defaultPrevented) {
//       return;
//     }
//     this._createPopper();

//     // If this is a touch-enabled device we add extra
//     // empty mouseover listeners to the body's immediate children;
//     // only needed because of broken event delegation on iOS
//     // https://www.quirksmode.org/blog/archives/2014/02/mouse_event_bub.html
//     if ('ontouchstart' in document.documentElement && !this._parent.closest(SELECTOR_NAVBAR_NAV)) {
//       for (const element of [].concat(...document.body.children)) {
//         EventHandler.on(element, 'mouseover', noop);
//       }
//     }
//     this._element.focus();
//     this._element.setAttribute('aria-expanded', true);
//     this._menu.classList.add(CLASS_NAME_SHOW$6);
//     this._element.classList.add(CLASS_NAME_SHOW$6);
//     EventHandler.trigger(this._element, EVENT_SHOWN$5, relatedTarget);
//   }
//   hide() {
//     if (isDisabled(this._element) || !this._isShown()) {
//       return;
//     }
//     const relatedTarget = {
//       relatedTarget: this._element
//     };
//     this._completeHide(relatedTarget);
//   }
//   dispose() {
//     if (this._popper) {
//       this._popper.destroy();
//     }
//     super.dispose();
//   }
//   update() {
//     this._inNavbar = this._detectNavbar();
//     if (this._popper) {
//       this._popper.update();
//     }
//   }

//   // Private
//   _completeHide(relatedTarget) {
//     const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE$5, relatedTarget);
//     if (hideEvent.defaultPrevented) {
//       return;
//     }

//     // If this is a touch-enabled device we remove the extra
//     // empty mouseover listeners we added for iOS support
//     if ('ontouchstart' in document.documentElement) {
//       for (const element of [].concat(...document.body.children)) {
//         EventHandler.off(element, 'mouseover', noop);
//       }
//     }
//     if (this._popper) {
//       this._popper.destroy();
//     }
//     this._menu.classList.remove(CLASS_NAME_SHOW$6);
//     this._element.classList.remove(CLASS_NAME_SHOW$6);
//     this._element.setAttribute('aria-expanded', 'false');
//     Manipulator.removeDataAttribute(this._menu, 'popper');
//     EventHandler.trigger(this._element, EVENT_HIDDEN$5, relatedTarget);
//   }
//   _getConfig(config) {
//     config = super._getConfig(config);
//     if (typeof config.reference === 'object' && !isElement(config.reference) && typeof config.reference.getBoundingClientRect !== 'function') {
//       // Popper virtual elements require a getBoundingClientRect method
//       throw new TypeError(`${NAME$a.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`);
//     }
//     return config;
//   }
//   _createPopper() {
//     if (typeof _popperjs_core__WEBPACK_IMPORTED_MODULE_0__ === 'undefined') {
//       throw new TypeError('Bootstrap\'s dropdowns require Popper (https://popper.js.org)');
//     }
//     let referenceElement = this._element;
//     if (this._config.reference === 'parent') {
//       referenceElement = this._parent;
//     } else if (isElement(this._config.reference)) {
//       referenceElement = getElement(this._config.reference);
//     } else if (typeof this._config.reference === 'object') {
//       referenceElement = this._config.reference;
//     }
//     const popperConfig = this._getPopperConfig();
//     this._popper = _popperjs_core__WEBPACK_IMPORTED_MODULE_1__.createPopper(referenceElement, this._menu, popperConfig);
//   }
//   _isShown() {
//     return this._menu.classList.contains(CLASS_NAME_SHOW$6);
//   }
//   _getPlacement() {
//     const parentDropdown = this._parent;
//     if (parentDropdown.classList.contains(CLASS_NAME_DROPEND)) {
//       return PLACEMENT_RIGHT;
//     }
//     if (parentDropdown.classList.contains(CLASS_NAME_DROPSTART)) {
//       return PLACEMENT_LEFT;
//     }
//     if (parentDropdown.classList.contains(CLASS_NAME_DROPUP_CENTER)) {
//       return PLACEMENT_TOPCENTER;
//     }
//     if (parentDropdown.classList.contains(CLASS_NAME_DROPDOWN_CENTER)) {
//       return PLACEMENT_BOTTOMCENTER;
//     }

//     // We need to trim the value because custom properties can also include spaces
//     const isEnd = getComputedStyle(this._menu).getPropertyValue('--bs-position').trim() === 'end';
//     if (parentDropdown.classList.contains(CLASS_NAME_DROPUP)) {
//       return isEnd ? PLACEMENT_TOPEND : PLACEMENT_TOP;
//     }
//     return isEnd ? PLACEMENT_BOTTOMEND : PLACEMENT_BOTTOM;
//   }
//   _detectNavbar() {
//     return this._element.closest(SELECTOR_NAVBAR) !== null;
//   }
//   _getOffset() {
//     const {
//       offset
//     } = this._config;
//     if (typeof offset === 'string') {
//       return offset.split(',').map(value => Number.parseInt(value, 10));
//     }
//     if (typeof offset === 'function') {
//       return popperData => offset(popperData, this._element);
//     }
//     return offset;
//   }
//   _getPopperConfig() {
//     const defaultBsPopperConfig = {
//       placement: this._getPlacement(),
//       modifiers: [{
//         name: 'preventOverflow',
//         options: {
//           boundary: this._config.boundary
//         }
//       }, {
//         name: 'offset',
//         options: {
//           offset: this._getOffset()
//         }
//       }]
//     };

//     // Disable Popper if we have a static display or Dropdown is in Navbar
//     if (this._inNavbar || this._config.display === 'static') {
//       Manipulator.setDataAttribute(this._menu, 'popper', 'static'); // TODO: v6 remove
//       defaultBsPopperConfig.modifiers = [{
//         name: 'applyStyles',
//         enabled: false
//       }];
//     }
//     return {
//       ...defaultBsPopperConfig,
//       ...execute(this._config.popperConfig, [defaultBsPopperConfig])
//     };
//   }
//   _selectMenuItem({
//     key,
//     target
//   }) {
//     const items = SelectorEngine.find(SELECTOR_VISIBLE_ITEMS, this._menu).filter(element => isVisible(element));
//     if (!items.length) {
//       return;
//     }

//     // if target isn't included in items (e.g. when expanding the dropdown)
//     // allow cycling to get the last item in case key equals ARROW_UP_KEY
//     getNextActiveElement(items, target, key === ARROW_DOWN_KEY$1, !items.includes(target)).focus();
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Dropdown.getOrCreateInstance(this, config);
//       if (typeof config !== 'string') {
//         return;
//       }
//       if (typeof data[config] === 'undefined') {
//         throw new TypeError(`No method named "${config}"`);
//       }
//       data[config]();
//     });
//   }
//   static clearMenus(event) {
//     if (event.button === RIGHT_MOUSE_BUTTON || event.type === 'keyup' && event.key !== TAB_KEY$1) {
//       return;
//     }
//     const openToggles = SelectorEngine.find(SELECTOR_DATA_TOGGLE_SHOWN);
//     for (const toggle of openToggles) {
//       const context = Dropdown.getInstance(toggle);
//       if (!context || context._config.autoClose === false) {
//         continue;
//       }
//       const composedPath = event.composedPath();
//       const isMenuTarget = composedPath.includes(context._menu);
//       if (composedPath.includes(context._element) || context._config.autoClose === 'inside' && !isMenuTarget || context._config.autoClose === 'outside' && isMenuTarget) {
//         continue;
//       }

//       // Tab navigation through the dropdown menu or events from contained inputs shouldn't close the menu
//       if (context._menu.contains(event.target) && (event.type === 'keyup' && event.key === TAB_KEY$1 || /input|select|option|textarea|form/i.test(event.target.tagName))) {
//         continue;
//       }
//       const relatedTarget = {
//         relatedTarget: context._element
//       };
//       if (event.type === 'click') {
//         relatedTarget.clickEvent = event;
//       }
//       context._completeHide(relatedTarget);
//     }
//   }
//   static dataApiKeydownHandler(event) {
//     // If not an UP | DOWN | ESCAPE key => not a dropdown command
//     // If input/textarea && if key is other than ESCAPE => not a dropdown command

//     const isInput = /input|textarea/i.test(event.target.tagName);
//     const isEscapeEvent = event.key === ESCAPE_KEY$2;
//     const isUpOrDownEvent = [ARROW_UP_KEY$1, ARROW_DOWN_KEY$1].includes(event.key);
//     if (!isUpOrDownEvent && !isEscapeEvent) {
//       return;
//     }
//     if (isInput && !isEscapeEvent) {
//       return;
//     }
//     event.preventDefault();

//     // TODO: v6 revert #37011 & change markup https://getbootstrap.com/docs/5.3/forms/input-group/
//     const getToggleButton = this.matches(SELECTOR_DATA_TOGGLE$3) ? this : SelectorEngine.prev(this, SELECTOR_DATA_TOGGLE$3)[0] || SelectorEngine.next(this, SELECTOR_DATA_TOGGLE$3)[0] || SelectorEngine.findOne(SELECTOR_DATA_TOGGLE$3, event.delegateTarget.parentNode);
//     const instance = Dropdown.getOrCreateInstance(getToggleButton);
//     if (isUpOrDownEvent) {
//       event.stopPropagation();
//       instance.show();
//       instance._selectMenuItem(event);
//       return;
//     }
//     if (instance._isShown()) {
//       // else is escape and we check if it is shown
//       event.stopPropagation();
//       instance.hide();
//       getToggleButton.focus();
//     }
//   }
// }

// /**
//  * Data API implementation
//  */

// EventHandler.on(document, EVENT_KEYDOWN_DATA_API, SELECTOR_DATA_TOGGLE$3, Dropdown.dataApiKeydownHandler);
// EventHandler.on(document, EVENT_KEYDOWN_DATA_API, SELECTOR_MENU, Dropdown.dataApiKeydownHandler);
// EventHandler.on(document, EVENT_CLICK_DATA_API$3, Dropdown.clearMenus);
// EventHandler.on(document, EVENT_KEYUP_DATA_API, Dropdown.clearMenus);
// EventHandler.on(document, EVENT_CLICK_DATA_API$3, SELECTOR_DATA_TOGGLE$3, function (event) {
//   event.preventDefault();
//   Dropdown.getOrCreateInstance(this).toggle();
// });

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Dropdown);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/backdrop.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$9 = 'backdrop';
// const CLASS_NAME_FADE$4 = 'fade';
// const CLASS_NAME_SHOW$5 = 'show';
// const EVENT_MOUSEDOWN = `mousedown.bs.${NAME$9}`;
// const Default$8 = {
//   className: 'modal-backdrop',
//   clickCallback: null,
//   isAnimated: false,
//   isVisible: true,
//   // if false, we use the backdrop helper without adding any element to the dom
//   rootElement: 'body' // give the choice to place backdrop under different elements
// };

// const DefaultType$8 = {
//   className: 'string',
//   clickCallback: '(function|null)',
//   isAnimated: 'boolean',
//   isVisible: 'boolean',
//   rootElement: '(element|string)'
// };

// /**
//  * Class definition
//  */

// class Backdrop extends Config {
//   constructor(config) {
//     super();
//     this._config = this._getConfig(config);
//     this._isAppended = false;
//     this._element = null;
//   }

//   // Getters
//   static get Default() {
//     return Default$8;
//   }
//   static get DefaultType() {
//     return DefaultType$8;
//   }
//   static get NAME() {
//     return NAME$9;
//   }

//   // Public
//   show(callback) {
//     if (!this._config.isVisible) {
//       execute(callback);
//       return;
//     }
//     this._append();
//     const element = this._getElement();
//     if (this._config.isAnimated) {
//       reflow(element);
//     }
//     element.classList.add(CLASS_NAME_SHOW$5);
//     this._emulateAnimation(() => {
//       execute(callback);
//     });
//   }
//   hide(callback) {
//     if (!this._config.isVisible) {
//       execute(callback);
//       return;
//     }
//     this._getElement().classList.remove(CLASS_NAME_SHOW$5);
//     this._emulateAnimation(() => {
//       this.dispose();
//       execute(callback);
//     });
//   }
//   dispose() {
//     if (!this._isAppended) {
//       return;
//     }
//     EventHandler.off(this._element, EVENT_MOUSEDOWN);
//     this._element.remove();
//     this._isAppended = false;
//   }

//   // Private
//   _getElement() {
//     if (!this._element) {
//       const backdrop = document.createElement('div');
//       backdrop.className = this._config.className;
//       if (this._config.isAnimated) {
//         backdrop.classList.add(CLASS_NAME_FADE$4);
//       }
//       this._element = backdrop;
//     }
//     return this._element;
//   }
//   _configAfterMerge(config) {
//     // use getElement() with the default "body" to get a fresh Element on each instantiation
//     config.rootElement = getElement(config.rootElement);
//     return config;
//   }
//   _append() {
//     if (this._isAppended) {
//       return;
//     }
//     const element = this._getElement();
//     this._config.rootElement.append(element);
//     EventHandler.on(element, EVENT_MOUSEDOWN, () => {
//       execute(this._config.clickCallback);
//     });
//     this._isAppended = true;
//   }
//   _emulateAnimation(callback) {
//     executeAfterTransition(callback, this._getElement(), this._config.isAnimated);
//   }
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/focustrap.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$8 = 'focustrap';
// const DATA_KEY$5 = 'bs.focustrap';
// const EVENT_KEY$5 = `.${DATA_KEY$5}`;
// const EVENT_FOCUSIN$2 = `focusin${EVENT_KEY$5}`;
// const EVENT_KEYDOWN_TAB = `keydown.tab${EVENT_KEY$5}`;
// const TAB_KEY = 'Tab';
// const TAB_NAV_FORWARD = 'forward';
// const TAB_NAV_BACKWARD = 'backward';
// const Default$7 = {
//   autofocus: true,
//   trapElement: null // The element to trap focus inside of
// };

// const DefaultType$7 = {
//   autofocus: 'boolean',
//   trapElement: 'element'
// };

// /**
//  * Class definition
//  */

// class FocusTrap extends Config {
//   constructor(config) {
//     super();
//     this._config = this._getConfig(config);
//     this._isActive = false;
//     this._lastTabNavDirection = null;
//   }

//   // Getters
//   static get Default() {
//     return Default$7;
//   }
//   static get DefaultType() {
//     return DefaultType$7;
//   }
//   static get NAME() {
//     return NAME$8;
//   }

//   // Public
//   activate() {
//     if (this._isActive) {
//       return;
//     }
//     if (this._config.autofocus) {
//       this._config.trapElement.focus();
//     }
//     EventHandler.off(document, EVENT_KEY$5); // guard against infinite focus loop
//     EventHandler.on(document, EVENT_FOCUSIN$2, event => this._handleFocusin(event));
//     EventHandler.on(document, EVENT_KEYDOWN_TAB, event => this._handleKeydown(event));
//     this._isActive = true;
//   }
//   deactivate() {
//     if (!this._isActive) {
//       return;
//     }
//     this._isActive = false;
//     EventHandler.off(document, EVENT_KEY$5);
//   }

//   // Private
//   _handleFocusin(event) {
//     const {
//       trapElement
//     } = this._config;
//     if (event.target === document || event.target === trapElement || trapElement.contains(event.target)) {
//       return;
//     }
//     const elements = SelectorEngine.focusableChildren(trapElement);
//     if (elements.length === 0) {
//       trapElement.focus();
//     } else if (this._lastTabNavDirection === TAB_NAV_BACKWARD) {
//       elements[elements.length - 1].focus();
//     } else {
//       elements[0].focus();
//     }
//   }
//   _handleKeydown(event) {
//     if (event.key !== TAB_KEY) {
//       return;
//     }
//     this._lastTabNavDirection = event.shiftKey ? TAB_NAV_BACKWARD : TAB_NAV_FORWARD;
//   }
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/scrollBar.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const SELECTOR_FIXED_CONTENT = '.fixed-top, .fixed-bottom, .is-fixed, .sticky-top';
// const SELECTOR_STICKY_CONTENT = '.sticky-top';
// const PROPERTY_PADDING = 'padding-right';
// const PROPERTY_MARGIN = 'margin-right';

// /**
//  * Class definition
//  */

// class ScrollBarHelper {
//   constructor() {
//     this._element = document.body;
//   }

//   // Public
//   getWidth() {
//     // https://developer.mozilla.org/en-US/docs/Web/API/Window/innerWidth#usage_notes
//     const documentWidth = document.documentElement.clientWidth;
//     return Math.abs(window.innerWidth - documentWidth);
//   }
//   hide() {
//     const width = this.getWidth();
//     this._disableOverFlow();
//     // give padding to element to balance the hidden scrollbar width
//     this._setElementAttributes(this._element, PROPERTY_PADDING, calculatedValue => calculatedValue + width);
//     // trick: We adjust positive paddingRight and negative marginRight to sticky-top elements to keep showing fullwidth
//     this._setElementAttributes(SELECTOR_FIXED_CONTENT, PROPERTY_PADDING, calculatedValue => calculatedValue + width);
//     this._setElementAttributes(SELECTOR_STICKY_CONTENT, PROPERTY_MARGIN, calculatedValue => calculatedValue - width);
//   }
//   reset() {
//     this._resetElementAttributes(this._element, 'overflow');
//     this._resetElementAttributes(this._element, PROPERTY_PADDING);
//     this._resetElementAttributes(SELECTOR_FIXED_CONTENT, PROPERTY_PADDING);
//     this._resetElementAttributes(SELECTOR_STICKY_CONTENT, PROPERTY_MARGIN);
//   }
//   isOverflowing() {
//     return this.getWidth() > 0;
//   }

//   // Private
//   _disableOverFlow() {
//     this._saveInitialAttribute(this._element, 'overflow');
//     this._element.style.overflow = 'hidden';
//   }
//   _setElementAttributes(selector, styleProperty, callback) {
//     const scrollbarWidth = this.getWidth();
//     const manipulationCallBack = element => {
//       if (element !== this._element && window.innerWidth > element.clientWidth + scrollbarWidth) {
//         return;
//       }
//       this._saveInitialAttribute(element, styleProperty);
//       const calculatedValue = window.getComputedStyle(element).getPropertyValue(styleProperty);
//       element.style.setProperty(styleProperty, `${callback(Number.parseFloat(calculatedValue))}px`);
//     };
//     this._applyManipulationCallback(selector, manipulationCallBack);
//   }
//   _saveInitialAttribute(element, styleProperty) {
//     const actualValue = element.style.getPropertyValue(styleProperty);
//     if (actualValue) {
//       Manipulator.setDataAttribute(element, styleProperty, actualValue);
//     }
//   }
//   _resetElementAttributes(selector, styleProperty) {
//     const manipulationCallBack = element => {
//       const value = Manipulator.getDataAttribute(element, styleProperty);
//       // We only want to remove the property if the value is `null`; the value can also be zero
//       if (value === null) {
//         element.style.removeProperty(styleProperty);
//         return;
//       }
//       Manipulator.removeDataAttribute(element, styleProperty);
//       element.style.setProperty(styleProperty, value);
//     };
//     this._applyManipulationCallback(selector, manipulationCallBack);
//   }
//   _applyManipulationCallback(selector, callBack) {
//     if (isElement(selector)) {
//       callBack(selector);
//       return;
//     }
//     for (const sel of SelectorEngine.find(selector, this._element)) {
//       callBack(sel);
//     }
//   }
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap modal.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$7 = 'modal';
// const DATA_KEY$4 = 'bs.modal';
// const EVENT_KEY$4 = `.${DATA_KEY$4}`;
// const DATA_API_KEY$2 = '.data-api';
// const ESCAPE_KEY$1 = 'Escape';
// const EVENT_HIDE$4 = `hide${EVENT_KEY$4}`;
// const EVENT_HIDE_PREVENTED$1 = `hidePrevented${EVENT_KEY$4}`;
// const EVENT_HIDDEN$4 = `hidden${EVENT_KEY$4}`;
// const EVENT_SHOW$4 = `show${EVENT_KEY$4}`;
// const EVENT_SHOWN$4 = `shown${EVENT_KEY$4}`;
// const EVENT_RESIZE$1 = `resize${EVENT_KEY$4}`;
// const EVENT_CLICK_DISMISS = `click.dismiss${EVENT_KEY$4}`;
// const EVENT_MOUSEDOWN_DISMISS = `mousedown.dismiss${EVENT_KEY$4}`;
// const EVENT_KEYDOWN_DISMISS$1 = `keydown.dismiss${EVENT_KEY$4}`;
// const EVENT_CLICK_DATA_API$2 = `click${EVENT_KEY$4}${DATA_API_KEY$2}`;
// const CLASS_NAME_OPEN = 'modal-open';
// const CLASS_NAME_FADE$3 = 'fade';
// const CLASS_NAME_SHOW$4 = 'show';
// const CLASS_NAME_STATIC = 'modal-static';
// const OPEN_SELECTOR$1 = '.modal.show';
// const SELECTOR_DIALOG = '.modal-dialog';
// const SELECTOR_MODAL_BODY = '.modal-body';
// const SELECTOR_DATA_TOGGLE$2 = '[data-bs-toggle="modal"]';
// const Default$6 = {
//   backdrop: true,
//   focus: true,
//   keyboard: true
// };
// const DefaultType$6 = {
//   backdrop: '(boolean|string)',
//   focus: 'boolean',
//   keyboard: 'boolean'
// };

// /**
//  * Class definition
//  */

// class Modal extends BaseComponent {
//   constructor(element, config) {
//     super(element, config);
//     this._dialog = SelectorEngine.findOne(SELECTOR_DIALOG, this._element);
//     this._backdrop = this._initializeBackDrop();
//     this._focustrap = this._initializeFocusTrap();
//     this._isShown = false;
//     this._isTransitioning = false;
//     this._scrollBar = new ScrollBarHelper();
//     this._addEventListeners();
//   }

//   // Getters
//   static get Default() {
//     return Default$6;
//   }
//   static get DefaultType() {
//     return DefaultType$6;
//   }
//   static get NAME() {
//     return NAME$7;
//   }

//   // Public
//   toggle(relatedTarget) {
//     return this._isShown ? this.hide() : this.show(relatedTarget);
//   }
//   show(relatedTarget) {
//     if (this._isShown || this._isTransitioning) {
//       return;
//     }
//     const showEvent = EventHandler.trigger(this._element, EVENT_SHOW$4, {
//       relatedTarget
//     });
//     if (showEvent.defaultPrevented) {
//       return;
//     }
//     this._isShown = true;
//     this._isTransitioning = true;
//     this._scrollBar.hide();
//     document.body.classList.add(CLASS_NAME_OPEN);
//     this._adjustDialog();
//     this._backdrop.show(() => this._showElement(relatedTarget));
//   }
//   hide() {
//     if (!this._isShown || this._isTransitioning) {
//       return;
//     }
//     const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE$4);
//     if (hideEvent.defaultPrevented) {
//       return;
//     }
//     this._isShown = false;
//     this._isTransitioning = true;
//     this._focustrap.deactivate();
//     this._element.classList.remove(CLASS_NAME_SHOW$4);
//     this._queueCallback(() => this._hideModal(), this._element, this._isAnimated());
//   }
//   dispose() {
//     EventHandler.off(window, EVENT_KEY$4);
//     EventHandler.off(this._dialog, EVENT_KEY$4);
//     this._backdrop.dispose();
//     this._focustrap.deactivate();
//     super.dispose();
//   }
//   handleUpdate() {
//     this._adjustDialog();
//   }

//   // Private
//   _initializeBackDrop() {
//     return new Backdrop({
//       isVisible: Boolean(this._config.backdrop),
//       // 'static' option will be translated to true, and booleans will keep their value,
//       isAnimated: this._isAnimated()
//     });
//   }
//   _initializeFocusTrap() {
//     return new FocusTrap({
//       trapElement: this._element
//     });
//   }
//   _showElement(relatedTarget) {
//     // try to append dynamic modal
//     if (!document.body.contains(this._element)) {
//       document.body.append(this._element);
//     }
//     this._element.style.display = 'block';
//     this._element.removeAttribute('aria-hidden');
//     this._element.setAttribute('aria-modal', true);
//     this._element.setAttribute('role', 'dialog');
//     this._element.scrollTop = 0;
//     const modalBody = SelectorEngine.findOne(SELECTOR_MODAL_BODY, this._dialog);
//     if (modalBody) {
//       modalBody.scrollTop = 0;
//     }
//     reflow(this._element);
//     this._element.classList.add(CLASS_NAME_SHOW$4);
//     const transitionComplete = () => {
//       if (this._config.focus) {
//         this._focustrap.activate();
//       }
//       this._isTransitioning = false;
//       EventHandler.trigger(this._element, EVENT_SHOWN$4, {
//         relatedTarget
//       });
//     };
//     this._queueCallback(transitionComplete, this._dialog, this._isAnimated());
//   }
//   _addEventListeners() {
//     EventHandler.on(this._element, EVENT_KEYDOWN_DISMISS$1, event => {
//       if (event.key !== ESCAPE_KEY$1) {
//         return;
//       }
//       if (this._config.keyboard) {
//         this.hide();
//         return;
//       }
//       this._triggerBackdropTransition();
//     });
//     EventHandler.on(window, EVENT_RESIZE$1, () => {
//       if (this._isShown && !this._isTransitioning) {
//         this._adjustDialog();
//       }
//     });
//     EventHandler.on(this._element, EVENT_MOUSEDOWN_DISMISS, event => {
//       // a bad trick to segregate clicks that may start inside dialog but end outside, and avoid listen to scrollbar clicks
//       EventHandler.one(this._element, EVENT_CLICK_DISMISS, event2 => {
//         if (this._element !== event.target || this._element !== event2.target) {
//           return;
//         }
//         if (this._config.backdrop === 'static') {
//           this._triggerBackdropTransition();
//           return;
//         }
//         if (this._config.backdrop) {
//           this.hide();
//         }
//       });
//     });
//   }
//   _hideModal() {
//     this._element.style.display = 'none';
//     this._element.setAttribute('aria-hidden', true);
//     this._element.removeAttribute('aria-modal');
//     this._element.removeAttribute('role');
//     this._isTransitioning = false;
//     this._backdrop.hide(() => {
//       document.body.classList.remove(CLASS_NAME_OPEN);
//       this._resetAdjustments();
//       this._scrollBar.reset();
//       EventHandler.trigger(this._element, EVENT_HIDDEN$4);
//     });
//   }
//   _isAnimated() {
//     return this._element.classList.contains(CLASS_NAME_FADE$3);
//   }
//   _triggerBackdropTransition() {
//     const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE_PREVENTED$1);
//     if (hideEvent.defaultPrevented) {
//       return;
//     }
//     const isModalOverflowing = this._element.scrollHeight > document.documentElement.clientHeight;
//     const initialOverflowY = this._element.style.overflowY;
//     // return if the following background transition hasn't yet completed
//     if (initialOverflowY === 'hidden' || this._element.classList.contains(CLASS_NAME_STATIC)) {
//       return;
//     }
//     if (!isModalOverflowing) {
//       this._element.style.overflowY = 'hidden';
//     }
//     this._element.classList.add(CLASS_NAME_STATIC);
//     this._queueCallback(() => {
//       this._element.classList.remove(CLASS_NAME_STATIC);
//       this._queueCallback(() => {
//         this._element.style.overflowY = initialOverflowY;
//       }, this._dialog);
//     }, this._dialog);
//     this._element.focus();
//   }

//   /**
//    * The following methods are used to handle overflowing modals
//    */

//   _adjustDialog() {
//     const isModalOverflowing = this._element.scrollHeight > document.documentElement.clientHeight;
//     const scrollbarWidth = this._scrollBar.getWidth();
//     const isBodyOverflowing = scrollbarWidth > 0;
//     if (isBodyOverflowing && !isModalOverflowing) {
//       const property = isRTL() ? 'paddingLeft' : 'paddingRight';
//       this._element.style[property] = `${scrollbarWidth}px`;
//     }
//     if (!isBodyOverflowing && isModalOverflowing) {
//       const property = isRTL() ? 'paddingRight' : 'paddingLeft';
//       this._element.style[property] = `${scrollbarWidth}px`;
//     }
//   }
//   _resetAdjustments() {
//     this._element.style.paddingLeft = '';
//     this._element.style.paddingRight = '';
//   }

//   // Static
//   static jQueryInterface(config, relatedTarget) {
//     return this.each(function () {
//       const data = Modal.getOrCreateInstance(this, config);
//       if (typeof config !== 'string') {
//         return;
//       }
//       if (typeof data[config] === 'undefined') {
//         throw new TypeError(`No method named "${config}"`);
//       }
//       data[config](relatedTarget);
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// EventHandler.on(document, EVENT_CLICK_DATA_API$2, SELECTOR_DATA_TOGGLE$2, function (event) {
//   const target = SelectorEngine.getElementFromSelector(this);
//   if (['A', 'AREA'].includes(this.tagName)) {
//     event.preventDefault();
//   }
//   EventHandler.one(target, EVENT_SHOW$4, showEvent => {
//     if (showEvent.defaultPrevented) {
//       // only register focus restorer if modal will actually get shown
//       return;
//     }
//     EventHandler.one(target, EVENT_HIDDEN$4, () => {
//       if (isVisible(this)) {
//         this.focus();
//       }
//     });
//   });

//   // avoid conflict when clicking modal toggler while another one is open
//   const alreadyOpen = SelectorEngine.findOne(OPEN_SELECTOR$1);
//   if (alreadyOpen) {
//     Modal.getInstance(alreadyOpen).hide();
//   }
//   const data = Modal.getOrCreateInstance(target);
//   data.toggle(this);
// });
// enableDismissTrigger(Modal);

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Modal);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap offcanvas.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$6 = 'offcanvas';
// const DATA_KEY$3 = 'bs.offcanvas';
// const EVENT_KEY$3 = `.${DATA_KEY$3}`;
// const DATA_API_KEY$1 = '.data-api';
// const EVENT_LOAD_DATA_API$2 = `load${EVENT_KEY$3}${DATA_API_KEY$1}`;
// const ESCAPE_KEY = 'Escape';
// const CLASS_NAME_SHOW$3 = 'show';
// const CLASS_NAME_SHOWING$1 = 'showing';
// const CLASS_NAME_HIDING = 'hiding';
// const CLASS_NAME_BACKDROP = 'offcanvas-backdrop';
// const OPEN_SELECTOR = '.offcanvas.show';
// const EVENT_SHOW$3 = `show${EVENT_KEY$3}`;
// const EVENT_SHOWN$3 = `shown${EVENT_KEY$3}`;
// const EVENT_HIDE$3 = `hide${EVENT_KEY$3}`;
// const EVENT_HIDE_PREVENTED = `hidePrevented${EVENT_KEY$3}`;
// const EVENT_HIDDEN$3 = `hidden${EVENT_KEY$3}`;
// const EVENT_RESIZE = `resize${EVENT_KEY$3}`;
// const EVENT_CLICK_DATA_API$1 = `click${EVENT_KEY$3}${DATA_API_KEY$1}`;
// const EVENT_KEYDOWN_DISMISS = `keydown.dismiss${EVENT_KEY$3}`;
// const SELECTOR_DATA_TOGGLE$1 = '[data-bs-toggle="offcanvas"]';
// const Default$5 = {
//   backdrop: true,
//   keyboard: true,
//   scroll: false
// };
// const DefaultType$5 = {
//   backdrop: '(boolean|string)',
//   keyboard: 'boolean',
//   scroll: 'boolean'
// };

// /**
//  * Class definition
//  */

// class Offcanvas extends BaseComponent {
//   constructor(element, config) {
//     super(element, config);
//     this._isShown = false;
//     this._backdrop = this._initializeBackDrop();
//     this._focustrap = this._initializeFocusTrap();
//     this._addEventListeners();
//   }

//   // Getters
//   static get Default() {
//     return Default$5;
//   }
//   static get DefaultType() {
//     return DefaultType$5;
//   }
//   static get NAME() {
//     return NAME$6;
//   }

//   // Public
//   toggle(relatedTarget) {
//     return this._isShown ? this.hide() : this.show(relatedTarget);
//   }
//   show(relatedTarget) {
//     if (this._isShown) {
//       return;
//     }
//     const showEvent = EventHandler.trigger(this._element, EVENT_SHOW$3, {
//       relatedTarget
//     });
//     if (showEvent.defaultPrevented) {
//       return;
//     }
//     this._isShown = true;
//     this._backdrop.show();
//     if (!this._config.scroll) {
//       new ScrollBarHelper().hide();
//     }
//     this._element.setAttribute('aria-modal', true);
//     this._element.setAttribute('role', 'dialog');
//     this._element.classList.add(CLASS_NAME_SHOWING$1);
//     const completeCallBack = () => {
//       if (!this._config.scroll || this._config.backdrop) {
//         this._focustrap.activate();
//       }
//       this._element.classList.add(CLASS_NAME_SHOW$3);
//       this._element.classList.remove(CLASS_NAME_SHOWING$1);
//       EventHandler.trigger(this._element, EVENT_SHOWN$3, {
//         relatedTarget
//       });
//     };
//     this._queueCallback(completeCallBack, this._element, true);
//   }
//   hide() {
//     if (!this._isShown) {
//       return;
//     }
//     const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE$3);
//     if (hideEvent.defaultPrevented) {
//       return;
//     }
//     this._focustrap.deactivate();
//     this._element.blur();
//     this._isShown = false;
//     this._element.classList.add(CLASS_NAME_HIDING);
//     this._backdrop.hide();
//     const completeCallback = () => {
//       this._element.classList.remove(CLASS_NAME_SHOW$3, CLASS_NAME_HIDING);
//       this._element.removeAttribute('aria-modal');
//       this._element.removeAttribute('role');
//       if (!this._config.scroll) {
//         new ScrollBarHelper().reset();
//       }
//       EventHandler.trigger(this._element, EVENT_HIDDEN$3);
//     };
//     this._queueCallback(completeCallback, this._element, true);
//   }
//   dispose() {
//     this._backdrop.dispose();
//     this._focustrap.deactivate();
//     super.dispose();
//   }

//   // Private
//   _initializeBackDrop() {
//     const clickCallback = () => {
//       if (this._config.backdrop === 'static') {
//         EventHandler.trigger(this._element, EVENT_HIDE_PREVENTED);
//         return;
//       }
//       this.hide();
//     };

//     // 'static' option will be translated to true, and booleans will keep their value
//     const isVisible = Boolean(this._config.backdrop);
//     return new Backdrop({
//       className: CLASS_NAME_BACKDROP,
//       isVisible,
//       isAnimated: true,
//       rootElement: this._element.parentNode,
//       clickCallback: isVisible ? clickCallback : null
//     });
//   }
//   _initializeFocusTrap() {
//     return new FocusTrap({
//       trapElement: this._element
//     });
//   }
//   _addEventListeners() {
//     EventHandler.on(this._element, EVENT_KEYDOWN_DISMISS, event => {
//       if (event.key !== ESCAPE_KEY) {
//         return;
//       }
//       if (this._config.keyboard) {
//         this.hide();
//         return;
//       }
//       EventHandler.trigger(this._element, EVENT_HIDE_PREVENTED);
//     });
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Offcanvas.getOrCreateInstance(this, config);
//       if (typeof config !== 'string') {
//         return;
//       }
//       if (data[config] === undefined || config.startsWith('_') || config === 'constructor') {
//         throw new TypeError(`No method named "${config}"`);
//       }
//       data[config](this);
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// EventHandler.on(document, EVENT_CLICK_DATA_API$1, SELECTOR_DATA_TOGGLE$1, function (event) {
//   const target = SelectorEngine.getElementFromSelector(this);
//   if (['A', 'AREA'].includes(this.tagName)) {
//     event.preventDefault();
//   }
//   if (isDisabled(this)) {
//     return;
//   }
//   EventHandler.one(target, EVENT_HIDDEN$3, () => {
//     // focus on trigger when it is closed
//     if (isVisible(this)) {
//       this.focus();
//     }
//   });

//   // avoid conflict when clicking a toggler of an offcanvas, while another is open
//   const alreadyOpen = SelectorEngine.findOne(OPEN_SELECTOR);
//   if (alreadyOpen && alreadyOpen !== target) {
//     Offcanvas.getInstance(alreadyOpen).hide();
//   }
//   const data = Offcanvas.getOrCreateInstance(target);
//   data.toggle(this);
// });
// EventHandler.on(window, EVENT_LOAD_DATA_API$2, () => {
//   for (const selector of SelectorEngine.find(OPEN_SELECTOR)) {
//     Offcanvas.getOrCreateInstance(selector).show();
//   }
// });
// EventHandler.on(window, EVENT_RESIZE, () => {
//   for (const element of SelectorEngine.find('[aria-modal][class*=show][class*=offcanvas-]')) {
//     if (getComputedStyle(element).position !== 'fixed') {
//       Offcanvas.getOrCreateInstance(element).hide();
//     }
//   }
// });
// enableDismissTrigger(Offcanvas);

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Offcanvas);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/sanitizer.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */

// // js-docs-start allow-list
// const ARIA_ATTRIBUTE_PATTERN = /^aria-[\w-]*$/i;
// const DefaultAllowlist = {
//   // Global attributes allowed on any supplied element below.
//   '*': ['class', 'dir', 'id', 'lang', 'role', ARIA_ATTRIBUTE_PATTERN],
//   a: ['target', 'href', 'title', 'rel'],
//   area: [],
//   b: [],
//   br: [],
//   col: [],
//   code: [],
//   div: [],
//   em: [],
//   hr: [],
//   h1: [],
//   h2: [],
//   h3: [],
//   h4: [],
//   h5: [],
//   h6: [],
//   i: [],
//   img: ['src', 'srcset', 'alt', 'title', 'width', 'height'],
//   li: [],
//   ol: [],
//   p: [],
//   pre: [],
//   s: [],
//   small: [],
//   span: [],
//   sub: [],
//   sup: [],
//   strong: [],
//   u: [],
//   ul: []
// };
// // js-docs-end allow-list

// const uriAttributes = new Set(['background', 'cite', 'href', 'itemtype', 'longdesc', 'poster', 'src', 'xlink:href']);

// /**
//  * A pattern that recognizes URLs that are safe wrt. XSS in URL navigation
//  * contexts.
//  *
//  * Shout-out to Angular https://github.com/angular/angular/blob/15.2.8/packages/core/src/sanitization/url_sanitizer.ts#L38
//  */
// // eslint-disable-next-line unicorn/better-regex
// const SAFE_URL_PATTERN = /^(?!javascript:)(?:[a-z0-9+.-]+:|[^&:/?#]*(?:[/?#]|$))/i;
// const allowedAttribute = (attribute, allowedAttributeList) => {
//   const attributeName = attribute.nodeName.toLowerCase();
//   if (allowedAttributeList.includes(attributeName)) {
//     if (uriAttributes.has(attributeName)) {
//       return Boolean(SAFE_URL_PATTERN.test(attribute.nodeValue));
//     }
//     return true;
//   }

//   // Check if a regular expression validates the attribute.
//   return allowedAttributeList.filter(attributeRegex => attributeRegex instanceof RegExp).some(regex => regex.test(attributeName));
// };
// function sanitizeHtml(unsafeHtml, allowList, sanitizeFunction) {
//   if (!unsafeHtml.length) {
//     return unsafeHtml;
//   }
//   if (sanitizeFunction && typeof sanitizeFunction === 'function') {
//     return sanitizeFunction(unsafeHtml);
//   }
//   const domParser = new window.DOMParser();
//   const createdDocument = domParser.parseFromString(unsafeHtml, 'text/html');
//   const elements = [].concat(...createdDocument.body.querySelectorAll('*'));
//   for (const element of elements) {
//     const elementName = element.nodeName.toLowerCase();
//     if (!Object.keys(allowList).includes(elementName)) {
//       element.remove();
//       continue;
//     }
//     const attributeList = [].concat(...element.attributes);
//     const allowedAttributes = [].concat(allowList['*'] || [], allowList[elementName] || []);
//     for (const attribute of attributeList) {
//       if (!allowedAttribute(attribute, allowedAttributes)) {
//         element.removeAttribute(attribute.nodeName);
//       }
//     }
//   }
//   return createdDocument.body.innerHTML;
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap util/template-factory.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$5 = 'TemplateFactory';
// const Default$4 = {
//   allowList: DefaultAllowlist,
//   content: {},
//   // { selector : text ,  selector2 : text2 , }
//   extraClass: '',
//   html: false,
//   sanitize: true,
//   sanitizeFn: null,
//   template: '<div></div>'
// };
// const DefaultType$4 = {
//   allowList: 'object',
//   content: 'object',
//   extraClass: '(string|function)',
//   html: 'boolean',
//   sanitize: 'boolean',
//   sanitizeFn: '(null|function)',
//   template: 'string'
// };
// const DefaultContentType = {
//   entry: '(string|element|function|null)',
//   selector: '(string|element)'
// };

// /**
//  * Class definition
//  */

// class TemplateFactory extends Config {
//   constructor(config) {
//     super();
//     this._config = this._getConfig(config);
//   }

//   // Getters
//   static get Default() {
//     return Default$4;
//   }
//   static get DefaultType() {
//     return DefaultType$4;
//   }
//   static get NAME() {
//     return NAME$5;
//   }

//   // Public
//   getContent() {
//     return Object.values(this._config.content).map(config => this._resolvePossibleFunction(config)).filter(Boolean);
//   }
//   hasContent() {
//     return this.getContent().length > 0;
//   }
//   changeContent(content) {
//     this._checkContent(content);
//     this._config.content = {
//       ...this._config.content,
//       ...content
//     };
//     return this;
//   }
//   toHtml() {
//     const templateWrapper = document.createElement('div');
//     templateWrapper.innerHTML = this._maybeSanitize(this._config.template);
//     for (const [selector, text] of Object.entries(this._config.content)) {
//       this._setContent(templateWrapper, text, selector);
//     }
//     const template = templateWrapper.children[0];
//     const extraClass = this._resolvePossibleFunction(this._config.extraClass);
//     if (extraClass) {
//       template.classList.add(...extraClass.split(' '));
//     }
//     return template;
//   }

//   // Private
//   _typeCheckConfig(config) {
//     super._typeCheckConfig(config);
//     this._checkContent(config.content);
//   }
//   _checkContent(arg) {
//     for (const [selector, content] of Object.entries(arg)) {
//       super._typeCheckConfig({
//         selector,
//         entry: content
//       }, DefaultContentType);
//     }
//   }
//   _setContent(template, content, selector) {
//     const templateElement = SelectorEngine.findOne(selector, template);
//     if (!templateElement) {
//       return;
//     }
//     content = this._resolvePossibleFunction(content);
//     if (!content) {
//       templateElement.remove();
//       return;
//     }
//     if (isElement(content)) {
//       this._putElementInTemplate(getElement(content), templateElement);
//       return;
//     }
//     if (this._config.html) {
//       templateElement.innerHTML = this._maybeSanitize(content);
//       return;
//     }
//     templateElement.textContent = content;
//   }
//   _maybeSanitize(arg) {
//     return this._config.sanitize ? sanitizeHtml(arg, this._config.allowList, this._config.sanitizeFn) : arg;
//   }
//   _resolvePossibleFunction(arg) {
//     return execute(arg, [this]);
//   }
//   _putElementInTemplate(element, templateElement) {
//     if (this._config.html) {
//       templateElement.innerHTML = '';
//       templateElement.append(element);
//       return;
//     }
//     templateElement.textContent = element.textContent;
//   }
// }

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap tooltip.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$4 = 'tooltip';
// const DISALLOWED_ATTRIBUTES = new Set(['sanitize', 'allowList', 'sanitizeFn']);
// const CLASS_NAME_FADE$2 = 'fade';
// const CLASS_NAME_MODAL = 'modal';
// const CLASS_NAME_SHOW$2 = 'show';
// const SELECTOR_TOOLTIP_INNER = '.tooltip-inner';
// const SELECTOR_MODAL = `.${CLASS_NAME_MODAL}`;
// const EVENT_MODAL_HIDE = 'hide.bs.modal';
// const TRIGGER_HOVER = 'hover';
// const TRIGGER_FOCUS = 'focus';
// const TRIGGER_CLICK = 'click';
// const TRIGGER_MANUAL = 'manual';
// const EVENT_HIDE$2 = 'hide';
// const EVENT_HIDDEN$2 = 'hidden';
// const EVENT_SHOW$2 = 'show';
// const EVENT_SHOWN$2 = 'shown';
// const EVENT_INSERTED = 'inserted';
// const EVENT_CLICK$1 = 'click';
// const EVENT_FOCUSIN$1 = 'focusin';
// const EVENT_FOCUSOUT$1 = 'focusout';
// const EVENT_MOUSEENTER = 'mouseenter';
// const EVENT_MOUSELEAVE = 'mouseleave';
// const AttachmentMap = {
//   AUTO: 'auto',
//   TOP: 'top',
//   RIGHT: isRTL() ? 'left' : 'right',
//   BOTTOM: 'bottom',
//   LEFT: isRTL() ? 'right' : 'left'
// };
// const Default$3 = {
//   allowList: DefaultAllowlist,
//   animation: true,
//   boundary: 'clippingParents',
//   container: false,
//   customClass: '',
//   delay: 0,
//   fallbackPlacements: ['top', 'right', 'bottom', 'left'],
//   html: false,
//   offset: [0, 6],
//   placement: 'top',
//   popperConfig: null,
//   sanitize: true,
//   sanitizeFn: null,
//   selector: false,
//   template: '<div class="tooltip" role="tooltip">' + '<div class="tooltip-arrow"></div>' + '<div class="tooltip-inner"></div>' + '</div>',
//   title: '',
//   trigger: 'hover focus'
// };
// const DefaultType$3 = {
//   allowList: 'object',
//   animation: 'boolean',
//   boundary: '(string|element)',
//   container: '(string|element|boolean)',
//   customClass: '(string|function)',
//   delay: '(number|object)',
//   fallbackPlacements: 'array',
//   html: 'boolean',
//   offset: '(array|string|function)',
//   placement: '(string|function)',
//   popperConfig: '(null|object|function)',
//   sanitize: 'boolean',
//   sanitizeFn: '(null|function)',
//   selector: '(string|boolean)',
//   template: 'string',
//   title: '(string|element|function)',
//   trigger: 'string'
// };

// /**
//  * Class definition
//  */

// class Tooltip extends BaseComponent {
//   constructor(element, config) {
//     if (typeof _popperjs_core__WEBPACK_IMPORTED_MODULE_0__ === 'undefined') {
//       throw new TypeError('Bootstrap\'s tooltips require Popper (https://popper.js.org)');
//     }
//     super(element, config);

//     // Private
//     this._isEnabled = true;
//     this._timeout = 0;
//     this._isHovered = null;
//     this._activeTrigger = {};
//     this._popper = null;
//     this._templateFactory = null;
//     this._newContent = null;

//     // Protected
//     this.tip = null;
//     this._setListeners();
//     if (!this._config.selector) {
//       this._fixTitle();
//     }
//   }

//   // Getters
//   static get Default() {
//     return Default$3;
//   }
//   static get DefaultType() {
//     return DefaultType$3;
//   }
//   static get NAME() {
//     return NAME$4;
//   }

//   // Public
//   enable() {
//     this._isEnabled = true;
//   }
//   disable() {
//     this._isEnabled = false;
//   }
//   toggleEnabled() {
//     this._isEnabled = !this._isEnabled;
//   }
//   toggle() {
//     if (!this._isEnabled) {
//       return;
//     }
//     this._activeTrigger.click = !this._activeTrigger.click;
//     if (this._isShown()) {
//       this._leave();
//       return;
//     }
//     this._enter();
//   }
//   dispose() {
//     clearTimeout(this._timeout);
//     EventHandler.off(this._element.closest(SELECTOR_MODAL), EVENT_MODAL_HIDE, this._hideModalHandler);
//     if (this._element.getAttribute('data-bs-original-title')) {
//       this._element.setAttribute('title', this._element.getAttribute('data-bs-original-title'));
//     }
//     this._disposePopper();
//     super.dispose();
//   }
//   show() {
//     if (this._element.style.display === 'none') {
//       throw new Error('Please use show on visible elements');
//     }
//     if (!(this._isWithContent() && this._isEnabled)) {
//       return;
//     }
//     const showEvent = EventHandler.trigger(this._element, this.constructor.eventName(EVENT_SHOW$2));
//     const shadowRoot = findShadowRoot(this._element);
//     const isInTheDom = (shadowRoot || this._element.ownerDocument.documentElement).contains(this._element);
//     if (showEvent.defaultPrevented || !isInTheDom) {
//       return;
//     }

//     // TODO: v6 remove this or make it optional
//     this._disposePopper();
//     const tip = this._getTipElement();
//     this._element.setAttribute('aria-describedby', tip.getAttribute('id'));
//     const {
//       container
//     } = this._config;
//     if (!this._element.ownerDocument.documentElement.contains(this.tip)) {
//       container.append(tip);
//       EventHandler.trigger(this._element, this.constructor.eventName(EVENT_INSERTED));
//     }
//     this._popper = this._createPopper(tip);
//     tip.classList.add(CLASS_NAME_SHOW$2);

//     // If this is a touch-enabled device we add extra
//     // empty mouseover listeners to the body's immediate children;
//     // only needed because of broken event delegation on iOS
//     // https://www.quirksmode.org/blog/archives/2014/02/mouse_event_bub.html
//     if ('ontouchstart' in document.documentElement) {
//       for (const element of [].concat(...document.body.children)) {
//         EventHandler.on(element, 'mouseover', noop);
//       }
//     }
//     const complete = () => {
//       EventHandler.trigger(this._element, this.constructor.eventName(EVENT_SHOWN$2));
//       if (this._isHovered === false) {
//         this._leave();
//       }
//       this._isHovered = false;
//     };
//     this._queueCallback(complete, this.tip, this._isAnimated());
//   }
//   hide() {
//     if (!this._isShown()) {
//       return;
//     }
//     const hideEvent = EventHandler.trigger(this._element, this.constructor.eventName(EVENT_HIDE$2));
//     if (hideEvent.defaultPrevented) {
//       return;
//     }
//     const tip = this._getTipElement();
//     tip.classList.remove(CLASS_NAME_SHOW$2);

//     // If this is a touch-enabled device we remove the extra
//     // empty mouseover listeners we added for iOS support
//     if ('ontouchstart' in document.documentElement) {
//       for (const element of [].concat(...document.body.children)) {
//         EventHandler.off(element, 'mouseover', noop);
//       }
//     }
//     this._activeTrigger[TRIGGER_CLICK] = false;
//     this._activeTrigger[TRIGGER_FOCUS] = false;
//     this._activeTrigger[TRIGGER_HOVER] = false;
//     this._isHovered = null; // it is a trick to support manual triggering

//     const complete = () => {
//       if (this._isWithActiveTrigger()) {
//         return;
//       }
//       if (!this._isHovered) {
//         this._disposePopper();
//       }
//       this._element.removeAttribute('aria-describedby');
//       EventHandler.trigger(this._element, this.constructor.eventName(EVENT_HIDDEN$2));
//     };
//     this._queueCallback(complete, this.tip, this._isAnimated());
//   }
//   update() {
//     if (this._popper) {
//       this._popper.update();
//     }
//   }

//   // Protected
//   _isWithContent() {
//     return Boolean(this._getTitle());
//   }
//   _getTipElement() {
//     if (!this.tip) {
//       this.tip = this._createTipElement(this._newContent || this._getContentForTemplate());
//     }
//     return this.tip;
//   }
//   _createTipElement(content) {
//     const tip = this._getTemplateFactory(content).toHtml();

//     // TODO: remove this check in v6
//     if (!tip) {
//       return null;
//     }
//     tip.classList.remove(CLASS_NAME_FADE$2, CLASS_NAME_SHOW$2);
//     // TODO: v6 the following can be achieved with CSS only
//     tip.classList.add(`bs-${this.constructor.NAME}-auto`);
//     const tipId = getUID(this.constructor.NAME).toString();
//     tip.setAttribute('id', tipId);
//     if (this._isAnimated()) {
//       tip.classList.add(CLASS_NAME_FADE$2);
//     }
//     return tip;
//   }
//   setContent(content) {
//     this._newContent = content;
//     if (this._isShown()) {
//       this._disposePopper();
//       this.show();
//     }
//   }
//   _getTemplateFactory(content) {
//     if (this._templateFactory) {
//       this._templateFactory.changeContent(content);
//     } else {
//       this._templateFactory = new TemplateFactory({
//         ...this._config,
//         // the `content` var has to be after `this._config`
//         // to override config.content in case of popover
//         content,
//         extraClass: this._resolvePossibleFunction(this._config.customClass)
//       });
//     }
//     return this._templateFactory;
//   }
//   _getContentForTemplate() {
//     return {
//       [SELECTOR_TOOLTIP_INNER]: this._getTitle()
//     };
//   }
//   _getTitle() {
//     return this._resolvePossibleFunction(this._config.title) || this._element.getAttribute('data-bs-original-title');
//   }

//   // Private
//   _initializeOnDelegatedTarget(event) {
//     return this.constructor.getOrCreateInstance(event.delegateTarget, this._getDelegateConfig());
//   }
//   _isAnimated() {
//     return this._config.animation || this.tip && this.tip.classList.contains(CLASS_NAME_FADE$2);
//   }
//   _isShown() {
//     return this.tip && this.tip.classList.contains(CLASS_NAME_SHOW$2);
//   }
//   _createPopper(tip) {
//     const placement = execute(this._config.placement, [this, tip, this._element]);
//     const attachment = AttachmentMap[placement.toUpperCase()];
//     return _popperjs_core__WEBPACK_IMPORTED_MODULE_1__.createPopper(this._element, tip, this._getPopperConfig(attachment));
//   }
//   _getOffset() {
//     const {
//       offset
//     } = this._config;
//     if (typeof offset === 'string') {
//       return offset.split(',').map(value => Number.parseInt(value, 10));
//     }
//     if (typeof offset === 'function') {
//       return popperData => offset(popperData, this._element);
//     }
//     return offset;
//   }
//   _resolvePossibleFunction(arg) {
//     return execute(arg, [this._element]);
//   }
//   _getPopperConfig(attachment) {
//     const defaultBsPopperConfig = {
//       placement: attachment,
//       modifiers: [{
//         name: 'flip',
//         options: {
//           fallbackPlacements: this._config.fallbackPlacements
//         }
//       }, {
//         name: 'offset',
//         options: {
//           offset: this._getOffset()
//         }
//       }, {
//         name: 'preventOverflow',
//         options: {
//           boundary: this._config.boundary
//         }
//       }, {
//         name: 'arrow',
//         options: {
//           element: `.${this.constructor.NAME}-arrow`
//         }
//       }, {
//         name: 'preSetPlacement',
//         enabled: true,
//         phase: 'beforeMain',
//         fn: data => {
//           // Pre-set Popper's placement attribute in order to read the arrow sizes properly.
//           // Otherwise, Popper mixes up the width and height dimensions since the initial arrow style is for top placement
//           this._getTipElement().setAttribute('data-popper-placement', data.state.placement);
//         }
//       }]
//     };
//     return {
//       ...defaultBsPopperConfig,
//       ...execute(this._config.popperConfig, [defaultBsPopperConfig])
//     };
//   }
//   _setListeners() {
//     const triggers = this._config.trigger.split(' ');
//     for (const trigger of triggers) {
//       if (trigger === 'click') {
//         EventHandler.on(this._element, this.constructor.eventName(EVENT_CLICK$1), this._config.selector, event => {
//           const context = this._initializeOnDelegatedTarget(event);
//           context.toggle();
//         });
//       } else if (trigger !== TRIGGER_MANUAL) {
//         const eventIn = trigger === TRIGGER_HOVER ? this.constructor.eventName(EVENT_MOUSEENTER) : this.constructor.eventName(EVENT_FOCUSIN$1);
//         const eventOut = trigger === TRIGGER_HOVER ? this.constructor.eventName(EVENT_MOUSELEAVE) : this.constructor.eventName(EVENT_FOCUSOUT$1);
//         EventHandler.on(this._element, eventIn, this._config.selector, event => {
//           const context = this._initializeOnDelegatedTarget(event);
//           context._activeTrigger[event.type === 'focusin' ? TRIGGER_FOCUS : TRIGGER_HOVER] = true;
//           context._enter();
//         });
//         EventHandler.on(this._element, eventOut, this._config.selector, event => {
//           const context = this._initializeOnDelegatedTarget(event);
//           context._activeTrigger[event.type === 'focusout' ? TRIGGER_FOCUS : TRIGGER_HOVER] = context._element.contains(event.relatedTarget);
//           context._leave();
//         });
//       }
//     }
//     this._hideModalHandler = () => {
//       if (this._element) {
//         this.hide();
//       }
//     };
//     EventHandler.on(this._element.closest(SELECTOR_MODAL), EVENT_MODAL_HIDE, this._hideModalHandler);
//   }
//   _fixTitle() {
//     const title = this._element.getAttribute('title');
//     if (!title) {
//       return;
//     }
//     if (!this._element.getAttribute('aria-label') && !this._element.textContent.trim()) {
//       this._element.setAttribute('aria-label', title);
//     }
//     this._element.setAttribute('data-bs-original-title', title); // DO NOT USE IT. Is only for backwards compatibility
//     this._element.removeAttribute('title');
//   }
//   _enter() {
//     if (this._isShown() || this._isHovered) {
//       this._isHovered = true;
//       return;
//     }
//     this._isHovered = true;
//     this._setTimeout(() => {
//       if (this._isHovered) {
//         this.show();
//       }
//     }, this._config.delay.show);
//   }
//   _leave() {
//     if (this._isWithActiveTrigger()) {
//       return;
//     }
//     this._isHovered = false;
//     this._setTimeout(() => {
//       if (!this._isHovered) {
//         this.hide();
//       }
//     }, this._config.delay.hide);
//   }
//   _setTimeout(handler, timeout) {
//     clearTimeout(this._timeout);
//     this._timeout = setTimeout(handler, timeout);
//   }
//   _isWithActiveTrigger() {
//     return Object.values(this._activeTrigger).includes(true);
//   }
//   _getConfig(config) {
//     const dataAttributes = Manipulator.getDataAttributes(this._element);
//     for (const dataAttribute of Object.keys(dataAttributes)) {
//       if (DISALLOWED_ATTRIBUTES.has(dataAttribute)) {
//         delete dataAttributes[dataAttribute];
//       }
//     }
//     config = {
//       ...dataAttributes,
//       ...(typeof config === 'object' && config ? config : {})
//     };
//     config = this._mergeConfigObj(config);
//     config = this._configAfterMerge(config);
//     this._typeCheckConfig(config);
//     return config;
//   }
//   _configAfterMerge(config) {
//     config.container = config.container === false ? document.body : getElement(config.container);
//     if (typeof config.delay === 'number') {
//       config.delay = {
//         show: config.delay,
//         hide: config.delay
//       };
//     }
//     if (typeof config.title === 'number') {
//       config.title = config.title.toString();
//     }
//     if (typeof config.content === 'number') {
//       config.content = config.content.toString();
//     }
//     return config;
//   }
//   _getDelegateConfig() {
//     const config = {};
//     for (const [key, value] of Object.entries(this._config)) {
//       if (this.constructor.Default[key] !== value) {
//         config[key] = value;
//       }
//     }
//     config.selector = false;
//     config.trigger = 'manual';

//     // In the future can be replaced with:
//     // const keysWithDifferentValues = Object.entries(this._config).filter(entry => this.constructor.Default[entry[0]] !== this._config[entry[0]])
//     // `Object.fromEntries(keysWithDifferentValues)`
//     return config;
//   }
//   _disposePopper() {
//     if (this._popper) {
//       this._popper.destroy();
//       this._popper = null;
//     }
//     if (this.tip) {
//       this.tip.remove();
//       this.tip = null;
//     }
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Tooltip.getOrCreateInstance(this, config);
//       if (typeof config !== 'string') {
//         return;
//       }
//       if (typeof data[config] === 'undefined') {
//         throw new TypeError(`No method named "${config}"`);
//       }
//       data[config]();
//     });
//   }
// }

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Tooltip);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap popover.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$3 = 'popover';
// const SELECTOR_TITLE = '.popover-header';
// const SELECTOR_CONTENT = '.popover-body';
// const Default$2 = {
//   ...Tooltip.Default,
//   content: '',
//   offset: [0, 8],
//   placement: 'right',
//   template: '<div class="popover" role="tooltip">' + '<div class="popover-arrow"></div>' + '<h3 class="popover-header"></h3>' + '<div class="popover-body"></div>' + '</div>',
//   trigger: 'click'
// };
// const DefaultType$2 = {
//   ...Tooltip.DefaultType,
//   content: '(null|string|element|function)'
// };

// /**
//  * Class definition
//  */

// class Popover extends Tooltip {
//   // Getters
//   static get Default() {
//     return Default$2;
//   }
//   static get DefaultType() {
//     return DefaultType$2;
//   }
//   static get NAME() {
//     return NAME$3;
//   }

//   // Overrides
//   _isWithContent() {
//     return this._getTitle() || this._getContent();
//   }

//   // Private
//   _getContentForTemplate() {
//     return {
//       [SELECTOR_TITLE]: this._getTitle(),
//       [SELECTOR_CONTENT]: this._getContent()
//     };
//   }
//   _getContent() {
//     return this._resolvePossibleFunction(this._config.content);
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Popover.getOrCreateInstance(this, config);
//       if (typeof config !== 'string') {
//         return;
//       }
//       if (typeof data[config] === 'undefined') {
//         throw new TypeError(`No method named "${config}"`);
//       }
//       data[config]();
//     });
//   }
// }

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Popover);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap scrollspy.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$2 = 'scrollspy';
// const DATA_KEY$2 = 'bs.scrollspy';
// const EVENT_KEY$2 = `.${DATA_KEY$2}`;
// const DATA_API_KEY = '.data-api';
// const EVENT_ACTIVATE = `activate${EVENT_KEY$2}`;
// const EVENT_CLICK = `click${EVENT_KEY$2}`;
// const EVENT_LOAD_DATA_API$1 = `load${EVENT_KEY$2}${DATA_API_KEY}`;
// const CLASS_NAME_DROPDOWN_ITEM = 'dropdown-item';
// const CLASS_NAME_ACTIVE$1 = 'active';
// const SELECTOR_DATA_SPY = '[data-bs-spy="scroll"]';
// const SELECTOR_TARGET_LINKS = '[href]';
// const SELECTOR_NAV_LIST_GROUP = '.nav, .list-group';
// const SELECTOR_NAV_LINKS = '.nav-link';
// const SELECTOR_NAV_ITEMS = '.nav-item';
// const SELECTOR_LIST_ITEMS = '.list-group-item';
// const SELECTOR_LINK_ITEMS = `${SELECTOR_NAV_LINKS}, ${SELECTOR_NAV_ITEMS} > ${SELECTOR_NAV_LINKS}, ${SELECTOR_LIST_ITEMS}`;
// const SELECTOR_DROPDOWN = '.dropdown';
// const SELECTOR_DROPDOWN_TOGGLE$1 = '.dropdown-toggle';
// const Default$1 = {
//   offset: null,
//   // TODO: v6 @deprecated, keep it for backwards compatibility reasons
//   rootMargin: '0px 0px -25%',
//   smoothScroll: false,
//   target: null,
//   threshold: [0.1, 0.5, 1]
// };
// const DefaultType$1 = {
//   offset: '(number|null)',
//   // TODO v6 @deprecated, keep it for backwards compatibility reasons
//   rootMargin: 'string',
//   smoothScroll: 'boolean',
//   target: 'element',
//   threshold: 'array'
// };

// /**
//  * Class definition
//  */

// class ScrollSpy extends BaseComponent {
//   constructor(element, config) {
//     super(element, config);

//     // this._element is the observablesContainer and config.target the menu links wrapper
//     this._targetLinks = new Map();
//     this._observableSections = new Map();
//     this._rootElement = getComputedStyle(this._element).overflowY === 'visible' ? null : this._element;
//     this._activeTarget = null;
//     this._observer = null;
//     this._previousScrollData = {
//       visibleEntryTop: 0,
//       parentScrollTop: 0
//     };
//     this.refresh(); // initialize
//   }

//   // Getters
//   static get Default() {
//     return Default$1;
//   }
//   static get DefaultType() {
//     return DefaultType$1;
//   }
//   static get NAME() {
//     return NAME$2;
//   }

//   // Public
//   refresh() {
//     this._initializeTargetsAndObservables();
//     this._maybeEnableSmoothScroll();
//     if (this._observer) {
//       this._observer.disconnect();
//     } else {
//       this._observer = this._getNewObserver();
//     }
//     for (const section of this._observableSections.values()) {
//       this._observer.observe(section);
//     }
//   }
//   dispose() {
//     this._observer.disconnect();
//     super.dispose();
//   }

//   // Private
//   _configAfterMerge(config) {
//     // TODO: on v6 target should be given explicitly & remove the {target: 'ss-target'} case
//     config.target = getElement(config.target) || document.body;

//     // TODO: v6 Only for backwards compatibility reasons. Use rootMargin only
//     config.rootMargin = config.offset ? `${config.offset}px 0px -30%` : config.rootMargin;
//     if (typeof config.threshold === 'string') {
//       config.threshold = config.threshold.split(',').map(value => Number.parseFloat(value));
//     }
//     return config;
//   }
//   _maybeEnableSmoothScroll() {
//     if (!this._config.smoothScroll) {
//       return;
//     }

//     // unregister any previous listeners
//     EventHandler.off(this._config.target, EVENT_CLICK);
//     EventHandler.on(this._config.target, EVENT_CLICK, SELECTOR_TARGET_LINKS, event => {
//       const observableSection = this._observableSections.get(event.target.hash);
//       if (observableSection) {
//         event.preventDefault();
//         const root = this._rootElement || window;
//         const height = observableSection.offsetTop - this._element.offsetTop;
//         if (root.scrollTo) {
//           root.scrollTo({
//             top: height,
//             behavior: 'smooth'
//           });
//           return;
//         }

//         // Chrome 60 doesn't support `scrollTo`
//         root.scrollTop = height;
//       }
//     });
//   }
//   _getNewObserver() {
//     const options = {
//       root: this._rootElement,
//       threshold: this._config.threshold,
//       rootMargin: this._config.rootMargin
//     };
//     return new IntersectionObserver(entries => this._observerCallback(entries), options);
//   }

//   // The logic of selection
//   _observerCallback(entries) {
//     const targetElement = entry => this._targetLinks.get(`#${entry.target.id}`);
//     const activate = entry => {
//       this._previousScrollData.visibleEntryTop = entry.target.offsetTop;
//       this._process(targetElement(entry));
//     };
//     const parentScrollTop = (this._rootElement || document.documentElement).scrollTop;
//     const userScrollsDown = parentScrollTop >= this._previousScrollData.parentScrollTop;
//     this._previousScrollData.parentScrollTop = parentScrollTop;
//     for (const entry of entries) {
//       if (!entry.isIntersecting) {
//         this._activeTarget = null;
//         this._clearActiveClass(targetElement(entry));
//         continue;
//       }
//       const entryIsLowerThanPrevious = entry.target.offsetTop >= this._previousScrollData.visibleEntryTop;
//       // if we are scrolling down, pick the bigger offsetTop
//       if (userScrollsDown && entryIsLowerThanPrevious) {
//         activate(entry);
//         // if parent isn't scrolled, let's keep the first visible item, breaking the iteration
//         if (!parentScrollTop) {
//           return;
//         }
//         continue;
//       }

//       // if we are scrolling up, pick the smallest offsetTop
//       if (!userScrollsDown && !entryIsLowerThanPrevious) {
//         activate(entry);
//       }
//     }
//   }
//   _initializeTargetsAndObservables() {
//     this._targetLinks = new Map();
//     this._observableSections = new Map();
//     const targetLinks = SelectorEngine.find(SELECTOR_TARGET_LINKS, this._config.target);
//     for (const anchor of targetLinks) {
//       // ensure that the anchor has an id and is not disabled
//       if (!anchor.hash || isDisabled(anchor)) {
//         continue;
//       }
//       const observableSection = SelectorEngine.findOne(decodeURI(anchor.hash), this._element);

//       // ensure that the observableSection exists & is visible
//       if (isVisible(observableSection)) {
//         this._targetLinks.set(decodeURI(anchor.hash), anchor);
//         this._observableSections.set(anchor.hash, observableSection);
//       }
//     }
//   }
//   _process(target) {
//     if (this._activeTarget === target) {
//       return;
//     }
//     this._clearActiveClass(this._config.target);
//     this._activeTarget = target;
//     target.classList.add(CLASS_NAME_ACTIVE$1);
//     this._activateParents(target);
//     EventHandler.trigger(this._element, EVENT_ACTIVATE, {
//       relatedTarget: target
//     });
//   }
//   _activateParents(target) {
//     // Activate dropdown parents
//     if (target.classList.contains(CLASS_NAME_DROPDOWN_ITEM)) {
//       SelectorEngine.findOne(SELECTOR_DROPDOWN_TOGGLE$1, target.closest(SELECTOR_DROPDOWN)).classList.add(CLASS_NAME_ACTIVE$1);
//       return;
//     }
//     for (const listGroup of SelectorEngine.parents(target, SELECTOR_NAV_LIST_GROUP)) {
//       // Set triggered links parents as active
//       // With both <ul> and <nav> markup a parent is the previous sibling of any nav ancestor
//       for (const item of SelectorEngine.prev(listGroup, SELECTOR_LINK_ITEMS)) {
//         item.classList.add(CLASS_NAME_ACTIVE$1);
//       }
//     }
//   }
//   _clearActiveClass(parent) {
//     parent.classList.remove(CLASS_NAME_ACTIVE$1);
//     const activeNodes = SelectorEngine.find(`${SELECTOR_TARGET_LINKS}.${CLASS_NAME_ACTIVE$1}`, parent);
//     for (const node of activeNodes) {
//       node.classList.remove(CLASS_NAME_ACTIVE$1);
//     }
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = ScrollSpy.getOrCreateInstance(this, config);
//       if (typeof config !== 'string') {
//         return;
//       }
//       if (data[config] === undefined || config.startsWith('_') || config === 'constructor') {
//         throw new TypeError(`No method named "${config}"`);
//       }
//       data[config]();
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// EventHandler.on(window, EVENT_LOAD_DATA_API$1, () => {
//   for (const spy of SelectorEngine.find(SELECTOR_DATA_SPY)) {
//     ScrollSpy.getOrCreateInstance(spy);
//   }
// });

// /**
//  * jQuery
//  */

// defineJQueryPlugin(ScrollSpy);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap tab.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME$1 = 'tab';
// const DATA_KEY$1 = 'bs.tab';
// const EVENT_KEY$1 = `.${DATA_KEY$1}`;
// const EVENT_HIDE$1 = `hide${EVENT_KEY$1}`;
// const EVENT_HIDDEN$1 = `hidden${EVENT_KEY$1}`;
// const EVENT_SHOW$1 = `show${EVENT_KEY$1}`;
// const EVENT_SHOWN$1 = `shown${EVENT_KEY$1}`;
// const EVENT_CLICK_DATA_API = `click${EVENT_KEY$1}`;
// const EVENT_KEYDOWN = `keydown${EVENT_KEY$1}`;
// const EVENT_LOAD_DATA_API = `load${EVENT_KEY$1}`;
// const ARROW_LEFT_KEY = 'ArrowLeft';
// const ARROW_RIGHT_KEY = 'ArrowRight';
// const ARROW_UP_KEY = 'ArrowUp';
// const ARROW_DOWN_KEY = 'ArrowDown';
// const HOME_KEY = 'Home';
// const END_KEY = 'End';
// const CLASS_NAME_ACTIVE = 'active';
// const CLASS_NAME_FADE$1 = 'fade';
// const CLASS_NAME_SHOW$1 = 'show';
// const CLASS_DROPDOWN = 'dropdown';
// const SELECTOR_DROPDOWN_TOGGLE = '.dropdown-toggle';
// const SELECTOR_DROPDOWN_MENU = '.dropdown-menu';
// const NOT_SELECTOR_DROPDOWN_TOGGLE = `:not(${SELECTOR_DROPDOWN_TOGGLE})`;
// const SELECTOR_TAB_PANEL = '.list-group, .nav, [role="tablist"]';
// const SELECTOR_OUTER = '.nav-item, .list-group-item';
// const SELECTOR_INNER = `.nav-link${NOT_SELECTOR_DROPDOWN_TOGGLE}, .list-group-item${NOT_SELECTOR_DROPDOWN_TOGGLE}, [role="tab"]${NOT_SELECTOR_DROPDOWN_TOGGLE}`;
// const SELECTOR_DATA_TOGGLE = '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]'; // TODO: could only be `tab` in v6
// const SELECTOR_INNER_ELEM = `${SELECTOR_INNER}, ${SELECTOR_DATA_TOGGLE}`;
// const SELECTOR_DATA_TOGGLE_ACTIVE = `.${CLASS_NAME_ACTIVE}[data-bs-toggle="tab"], .${CLASS_NAME_ACTIVE}[data-bs-toggle="pill"], .${CLASS_NAME_ACTIVE}[data-bs-toggle="list"]`;

// /**
//  * Class definition
//  */

// class Tab extends BaseComponent {
//   constructor(element) {
//     super(element);
//     this._parent = this._element.closest(SELECTOR_TAB_PANEL);
//     if (!this._parent) {
//       return;
//       // TODO: should throw exception in v6
//       // throw new TypeError(`${element.outerHTML} has not a valid parent ${SELECTOR_INNER_ELEM}`)
//     }

//     // Set up initial aria attributes
//     this._setInitialAttributes(this._parent, this._getChildren());
//     EventHandler.on(this._element, EVENT_KEYDOWN, event => this._keydown(event));
//   }

//   // Getters
//   static get NAME() {
//     return NAME$1;
//   }

//   // Public
//   show() {
//     // Shows this elem and deactivate the active sibling if exists
//     const innerElem = this._element;
//     if (this._elemIsActive(innerElem)) {
//       return;
//     }

//     // Search for active tab on same parent to deactivate it
//     const active = this._getActiveElem();
//     const hideEvent = active ? EventHandler.trigger(active, EVENT_HIDE$1, {
//       relatedTarget: innerElem
//     }) : null;
//     const showEvent = EventHandler.trigger(innerElem, EVENT_SHOW$1, {
//       relatedTarget: active
//     });
//     if (showEvent.defaultPrevented || hideEvent && hideEvent.defaultPrevented) {
//       return;
//     }
//     this._deactivate(active, innerElem);
//     this._activate(innerElem, active);
//   }

//   // Private
//   _activate(element, relatedElem) {
//     if (!element) {
//       return;
//     }
//     element.classList.add(CLASS_NAME_ACTIVE);
//     this._activate(SelectorEngine.getElementFromSelector(element)); // Search and activate/show the proper section

//     const complete = () => {
//       if (element.getAttribute('role') !== 'tab') {
//         element.classList.add(CLASS_NAME_SHOW$1);
//         return;
//       }
//       element.removeAttribute('tabindex');
//       element.setAttribute('aria-selected', true);
//       this._toggleDropDown(element, true);
//       EventHandler.trigger(element, EVENT_SHOWN$1, {
//         relatedTarget: relatedElem
//       });
//     };
//     this._queueCallback(complete, element, element.classList.contains(CLASS_NAME_FADE$1));
//   }
//   _deactivate(element, relatedElem) {
//     if (!element) {
//       return;
//     }
//     element.classList.remove(CLASS_NAME_ACTIVE);
//     element.blur();
//     this._deactivate(SelectorEngine.getElementFromSelector(element)); // Search and deactivate the shown section too

//     const complete = () => {
//       if (element.getAttribute('role') !== 'tab') {
//         element.classList.remove(CLASS_NAME_SHOW$1);
//         return;
//       }
//       element.setAttribute('aria-selected', false);
//       element.setAttribute('tabindex', '-1');
//       this._toggleDropDown(element, false);
//       EventHandler.trigger(element, EVENT_HIDDEN$1, {
//         relatedTarget: relatedElem
//       });
//     };
//     this._queueCallback(complete, element, element.classList.contains(CLASS_NAME_FADE$1));
//   }
//   _keydown(event) {
//     if (![ARROW_LEFT_KEY, ARROW_RIGHT_KEY, ARROW_UP_KEY, ARROW_DOWN_KEY, HOME_KEY, END_KEY].includes(event.key)) {
//       return;
//     }
//     event.stopPropagation(); // stopPropagation/preventDefault both added to support up/down keys without scrolling the page
//     event.preventDefault();
//     const children = this._getChildren().filter(element => !isDisabled(element));
//     let nextActiveElement;
//     if ([HOME_KEY, END_KEY].includes(event.key)) {
//       nextActiveElement = children[event.key === HOME_KEY ? 0 : children.length - 1];
//     } else {
//       const isNext = [ARROW_RIGHT_KEY, ARROW_DOWN_KEY].includes(event.key);
//       nextActiveElement = getNextActiveElement(children, event.target, isNext, true);
//     }
//     if (nextActiveElement) {
//       nextActiveElement.focus({
//         preventScroll: true
//       });
//       Tab.getOrCreateInstance(nextActiveElement).show();
//     }
//   }
//   _getChildren() {
//     // collection of inner elements
//     return SelectorEngine.find(SELECTOR_INNER_ELEM, this._parent);
//   }
//   _getActiveElem() {
//     return this._getChildren().find(child => this._elemIsActive(child)) || null;
//   }
//   _setInitialAttributes(parent, children) {
//     this._setAttributeIfNotExists(parent, 'role', 'tablist');
//     for (const child of children) {
//       this._setInitialAttributesOnChild(child);
//     }
//   }
//   _setInitialAttributesOnChild(child) {
//     child = this._getInnerElement(child);
//     const isActive = this._elemIsActive(child);
//     const outerElem = this._getOuterElement(child);
//     child.setAttribute('aria-selected', isActive);
//     if (outerElem !== child) {
//       this._setAttributeIfNotExists(outerElem, 'role', 'presentation');
//     }
//     if (!isActive) {
//       child.setAttribute('tabindex', '-1');
//     }
//     this._setAttributeIfNotExists(child, 'role', 'tab');

//     // set attributes to the related panel too
//     this._setInitialAttributesOnTargetPanel(child);
//   }
//   _setInitialAttributesOnTargetPanel(child) {
//     const target = SelectorEngine.getElementFromSelector(child);
//     if (!target) {
//       return;
//     }
//     this._setAttributeIfNotExists(target, 'role', 'tabpanel');
//     if (child.id) {
//       this._setAttributeIfNotExists(target, 'aria-labelledby', `${child.id}`);
//     }
//   }
//   _toggleDropDown(element, open) {
//     const outerElem = this._getOuterElement(element);
//     if (!outerElem.classList.contains(CLASS_DROPDOWN)) {
//       return;
//     }
//     const toggle = (selector, className) => {
//       const element = SelectorEngine.findOne(selector, outerElem);
//       if (element) {
//         element.classList.toggle(className, open);
//       }
//     };
//     toggle(SELECTOR_DROPDOWN_TOGGLE, CLASS_NAME_ACTIVE);
//     toggle(SELECTOR_DROPDOWN_MENU, CLASS_NAME_SHOW$1);
//     outerElem.setAttribute('aria-expanded', open);
//   }
//   _setAttributeIfNotExists(element, attribute, value) {
//     if (!element.hasAttribute(attribute)) {
//       element.setAttribute(attribute, value);
//     }
//   }
//   _elemIsActive(elem) {
//     return elem.classList.contains(CLASS_NAME_ACTIVE);
//   }

//   // Try to get the inner element (usually the .nav-link)
//   _getInnerElement(elem) {
//     return elem.matches(SELECTOR_INNER_ELEM) ? elem : SelectorEngine.findOne(SELECTOR_INNER_ELEM, elem);
//   }

//   // Try to get the outer element (usually the .nav-item)
//   _getOuterElement(elem) {
//     return elem.closest(SELECTOR_OUTER) || elem;
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Tab.getOrCreateInstance(this);
//       if (typeof config !== 'string') {
//         return;
//       }
//       if (data[config] === undefined || config.startsWith('_') || config === 'constructor') {
//         throw new TypeError(`No method named "${config}"`);
//       }
//       data[config]();
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// EventHandler.on(document, EVENT_CLICK_DATA_API, SELECTOR_DATA_TOGGLE, function (event) {
//   if (['A', 'AREA'].includes(this.tagName)) {
//     event.preventDefault();
//   }
//   if (isDisabled(this)) {
//     return;
//   }
//   Tab.getOrCreateInstance(this).show();
// });

// /**
//  * Initialize on focus
//  */
// EventHandler.on(window, EVENT_LOAD_DATA_API, () => {
//   for (const element of SelectorEngine.find(SELECTOR_DATA_TOGGLE_ACTIVE)) {
//     Tab.getOrCreateInstance(element);
//   }
// });
// /**
//  * jQuery
//  */

// defineJQueryPlugin(Tab);

// /**
//  * --------------------------------------------------------------------------
//  * Bootstrap toast.js
//  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
//  * --------------------------------------------------------------------------
//  */


// /**
//  * Constants
//  */

// const NAME = 'toast';
// const DATA_KEY = 'bs.toast';
// const EVENT_KEY = `.${DATA_KEY}`;
// const EVENT_MOUSEOVER = `mouseover${EVENT_KEY}`;
// const EVENT_MOUSEOUT = `mouseout${EVENT_KEY}`;
// const EVENT_FOCUSIN = `focusin${EVENT_KEY}`;
// const EVENT_FOCUSOUT = `focusout${EVENT_KEY}`;
// const EVENT_HIDE = `hide${EVENT_KEY}`;
// const EVENT_HIDDEN = `hidden${EVENT_KEY}`;
// const EVENT_SHOW = `show${EVENT_KEY}`;
// const EVENT_SHOWN = `shown${EVENT_KEY}`;
// const CLASS_NAME_FADE = 'fade';
// const CLASS_NAME_HIDE = 'hide'; // @deprecated - kept here only for backwards compatibility
// const CLASS_NAME_SHOW = 'show';
// const CLASS_NAME_SHOWING = 'showing';
// const DefaultType = {
//   animation: 'boolean',
//   autohide: 'boolean',
//   delay: 'number'
// };
// const Default = {
//   animation: true,
//   autohide: true,
//   delay: 5000
// };

// /**
//  * Class definition
//  */

// class Toast extends BaseComponent {
//   constructor(element, config) {
//     super(element, config);
//     this._timeout = null;
//     this._hasMouseInteraction = false;
//     this._hasKeyboardInteraction = false;
//     this._setListeners();
//   }

//   // Getters
//   static get Default() {
//     return Default;
//   }
//   static get DefaultType() {
//     return DefaultType;
//   }
//   static get NAME() {
//     return NAME;
//   }

//   // Public
//   show() {
//     const showEvent = EventHandler.trigger(this._element, EVENT_SHOW);
//     if (showEvent.defaultPrevented) {
//       return;
//     }
//     this._clearTimeout();
//     if (this._config.animation) {
//       this._element.classList.add(CLASS_NAME_FADE);
//     }
//     const complete = () => {
//       this._element.classList.remove(CLASS_NAME_SHOWING);
//       EventHandler.trigger(this._element, EVENT_SHOWN);
//       this._maybeScheduleHide();
//     };
//     this._element.classList.remove(CLASS_NAME_HIDE); // @deprecated
//     reflow(this._element);
//     this._element.classList.add(CLASS_NAME_SHOW, CLASS_NAME_SHOWING);
//     this._queueCallback(complete, this._element, this._config.animation);
//   }
//   hide() {
//     if (!this.isShown()) {
//       return;
//     }
//     const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE);
//     if (hideEvent.defaultPrevented) {
//       return;
//     }
//     const complete = () => {
//       this._element.classList.add(CLASS_NAME_HIDE); // @deprecated
//       this._element.classList.remove(CLASS_NAME_SHOWING, CLASS_NAME_SHOW);
//       EventHandler.trigger(this._element, EVENT_HIDDEN);
//     };
//     this._element.classList.add(CLASS_NAME_SHOWING);
//     this._queueCallback(complete, this._element, this._config.animation);
//   }
//   dispose() {
//     this._clearTimeout();
//     if (this.isShown()) {
//       this._element.classList.remove(CLASS_NAME_SHOW);
//     }
//     super.dispose();
//   }
//   isShown() {
//     return this._element.classList.contains(CLASS_NAME_SHOW);
//   }

//   // Private

//   _maybeScheduleHide() {
//     if (!this._config.autohide) {
//       return;
//     }
//     if (this._hasMouseInteraction || this._hasKeyboardInteraction) {
//       return;
//     }
//     this._timeout = setTimeout(() => {
//       this.hide();
//     }, this._config.delay);
//   }
//   _onInteraction(event, isInteracting) {
//     switch (event.type) {
//       case 'mouseover':
//       case 'mouseout':
//         {
//           this._hasMouseInteraction = isInteracting;
//           break;
//         }
//       case 'focusin':
//       case 'focusout':
//         {
//           this._hasKeyboardInteraction = isInteracting;
//           break;
//         }
//     }
//     if (isInteracting) {
//       this._clearTimeout();
//       return;
//     }
//     const nextElement = event.relatedTarget;
//     if (this._element === nextElement || this._element.contains(nextElement)) {
//       return;
//     }
//     this._maybeScheduleHide();
//   }
//   _setListeners() {
//     EventHandler.on(this._element, EVENT_MOUSEOVER, event => this._onInteraction(event, true));
//     EventHandler.on(this._element, EVENT_MOUSEOUT, event => this._onInteraction(event, false));
//     EventHandler.on(this._element, EVENT_FOCUSIN, event => this._onInteraction(event, true));
//     EventHandler.on(this._element, EVENT_FOCUSOUT, event => this._onInteraction(event, false));
//   }
//   _clearTimeout() {
//     clearTimeout(this._timeout);
//     this._timeout = null;
//   }

//   // Static
//   static jQueryInterface(config) {
//     return this.each(function () {
//       const data = Toast.getOrCreateInstance(this, config);
//       if (typeof config === 'string') {
//         if (typeof data[config] === 'undefined') {
//           throw new TypeError(`No method named "${config}"`);
//         }
//         data[config](this);
//       }
//     });
//   }
// }

// /**
//  * Data API implementation
//  */

// enableDismissTrigger(Toast);

// /**
//  * jQuery
//  */

// defineJQueryPlugin(Toast);


// //# sourceMappingURL=bootstrap.esm.js.map


// /***/ }),

// /***/ "./node_modules/laravel-echo/dist/echo.js":
// /*!************************************************!*\
//   !*** ./node_modules/laravel-echo/dist/echo.js ***!
//   \************************************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// /* harmony export */ __webpack_require__.d(__webpack_exports__, {
// /* harmony export */   Channel: () => (/* binding */ Channel),
// /* harmony export */   Connector: () => (/* binding */ Connector),
// /* harmony export */   EventFormatter: () => (/* binding */ EventFormatter),
// /* harmony export */   "default": () => (/* binding */ Echo)
// /* harmony export */ });
// function _typeof(obj) {
//   "@babel/helpers - typeof";

//   return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
//     return typeof obj;
//   } : function (obj) {
//     return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
//   }, _typeof(obj);
// }

// function _classCallCheck(instance, Constructor) {
//   if (!(instance instanceof Constructor)) {
//     throw new TypeError("Cannot call a class as a function");
//   }
// }

// function _defineProperties(target, props) {
//   for (var i = 0; i < props.length; i++) {
//     var descriptor = props[i];
//     descriptor.enumerable = descriptor.enumerable || false;
//     descriptor.configurable = true;
//     if ("value" in descriptor) descriptor.writable = true;
//     Object.defineProperty(target, descriptor.key, descriptor);
//   }
// }

// function _createClass(Constructor, protoProps, staticProps) {
//   if (protoProps) _defineProperties(Constructor.prototype, protoProps);
//   if (staticProps) _defineProperties(Constructor, staticProps);
//   Object.defineProperty(Constructor, "prototype", {
//     writable: false
//   });
//   return Constructor;
// }

// function _extends() {
//   _extends = Object.assign || function (target) {
//     for (var i = 1; i < arguments.length; i++) {
//       var source = arguments[i];

//       for (var key in source) {
//         if (Object.prototype.hasOwnProperty.call(source, key)) {
//           target[key] = source[key];
//         }
//       }
//     }

//     return target;
//   };

//   return _extends.apply(this, arguments);
// }

// function _inherits(subClass, superClass) {
//   if (typeof superClass !== "function" && superClass !== null) {
//     throw new TypeError("Super expression must either be null or a function");
//   }

//   subClass.prototype = Object.create(superClass && superClass.prototype, {
//     constructor: {
//       value: subClass,
//       writable: true,
//       configurable: true
//     }
//   });
//   Object.defineProperty(subClass, "prototype", {
//     writable: false
//   });
//   if (superClass) _setPrototypeOf(subClass, superClass);
// }

// function _getPrototypeOf(o) {
//   _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
//     return o.__proto__ || Object.getPrototypeOf(o);
//   };
//   return _getPrototypeOf(o);
// }

// function _setPrototypeOf(o, p) {
//   _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
//     o.__proto__ = p;
//     return o;
//   };

//   return _setPrototypeOf(o, p);
// }

// function _isNativeReflectConstruct() {
//   if (typeof Reflect === "undefined" || !Reflect.construct) return false;
//   if (Reflect.construct.sham) return false;
//   if (typeof Proxy === "function") return true;

//   try {
//     Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {}));
//     return true;
//   } catch (e) {
//     return false;
//   }
// }

// function _assertThisInitialized(self) {
//   if (self === void 0) {
//     throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
//   }

//   return self;
// }

// function _possibleConstructorReturn(self, call) {
//   if (call && (typeof call === "object" || typeof call === "function")) {
//     return call;
//   } else if (call !== void 0) {
//     throw new TypeError("Derived constructors may only return object or undefined");
//   }

//   return _assertThisInitialized(self);
// }

// function _createSuper(Derived) {
//   var hasNativeReflectConstruct = _isNativeReflectConstruct();

//   return function _createSuperInternal() {
//     var Super = _getPrototypeOf(Derived),
//         result;

//     if (hasNativeReflectConstruct) {
//       var NewTarget = _getPrototypeOf(this).constructor;

//       result = Reflect.construct(Super, arguments, NewTarget);
//     } else {
//       result = Super.apply(this, arguments);
//     }

//     return _possibleConstructorReturn(this, result);
//   };
// }

// /**
//  * This class represents a basic channel.
//  */
// var Channel = /*#__PURE__*/function () {
//   function Channel() {
//     _classCallCheck(this, Channel);
//   }

//   _createClass(Channel, [{
//     key: "listenForWhisper",
//     value:
//     /**
//      * Listen for a whisper event on the channel instance.
//      */
//     function listenForWhisper(event, callback) {
//       return this.listen('.client-' + event, callback);
//     }
//     /**
//      * Listen for an event on the channel instance.
//      */

//   }, {
//     key: "notification",
//     value: function notification(callback) {
//       return this.listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', callback);
//     }
//     /**
//      * Stop listening for a whisper event on the channel instance.
//      */

//   }, {
//     key: "stopListeningForWhisper",
//     value: function stopListeningForWhisper(event, callback) {
//       return this.stopListening('.client-' + event, callback);
//     }
//   }]);

//   return Channel;
// }();

// /**
//  * Event name formatter
//  */
// var EventFormatter = /*#__PURE__*/function () {
//   /**
//    * Create a new class instance.
//    */
//   function EventFormatter(namespace) {
//     _classCallCheck(this, EventFormatter);

//     this.namespace = namespace; //
//   }
//   /**
//    * Format the given event name.
//    */


//   _createClass(EventFormatter, [{
//     key: "format",
//     value: function format(event) {
//       if (['.', '\\'].includes(event.charAt(0))) {
//         return event.substring(1);
//       } else if (this.namespace) {
//         event = this.namespace + '.' + event;
//       }

//       return event.replace(/\./g, '\\');
//     }
//     /**
//      * Set the event namespace.
//      */

//   }, {
//     key: "setNamespace",
//     value: function setNamespace(value) {
//       this.namespace = value;
//     }
//   }]);

//   return EventFormatter;
// }();

// /**
//  * This class represents a Pusher channel.
//  */

// var PusherChannel = /*#__PURE__*/function (_Channel) {
//   _inherits(PusherChannel, _Channel);

//   var _super = _createSuper(PusherChannel);

//   /**
//    * Create a new class instance.
//    */
//   function PusherChannel(pusher, name, options) {
//     var _this;

//     _classCallCheck(this, PusherChannel);

//     _this = _super.call(this);
//     _this.name = name;
//     _this.pusher = pusher;
//     _this.options = options;
//     _this.eventFormatter = new EventFormatter(_this.options.namespace);

//     _this.subscribe();

//     return _this;
//   }
//   /**
//    * Subscribe to a Pusher channel.
//    */


//   _createClass(PusherChannel, [{
//     key: "subscribe",
//     value: function subscribe() {
//       this.subscription = this.pusher.subscribe(this.name);
//     }
//     /**
//      * Unsubscribe from a Pusher channel.
//      */

//   }, {
//     key: "unsubscribe",
//     value: function unsubscribe() {
//       this.pusher.unsubscribe(this.name);
//     }
//     /**
//      * Listen for an event on the channel instance.
//      */

//   }, {
//     key: "listen",
//     value: function listen(event, callback) {
//       this.on(this.eventFormatter.format(event), callback);
//       return this;
//     }
//     /**
//      * Listen for all events on the channel instance.
//      */

//   }, {
//     key: "listenToAll",
//     value: function listenToAll(callback) {
//       var _this2 = this;

//       this.subscription.bind_global(function (event, data) {
//         if (event.startsWith('pusher:')) {
//           return;
//         }

//         var namespace = _this2.options.namespace.replace(/\./g, '\\');

//         var formattedEvent = event.startsWith(namespace) ? event.substring(namespace.length + 1) : '.' + event;
//         callback(formattedEvent, data);
//       });
//       return this;
//     }
//     /**
//      * Stop listening for an event on the channel instance.
//      */

//   }, {
//     key: "stopListening",
//     value: function stopListening(event, callback) {
//       if (callback) {
//         this.subscription.unbind(this.eventFormatter.format(event), callback);
//       } else {
//         this.subscription.unbind(this.eventFormatter.format(event));
//       }

//       return this;
//     }
//     /**
//      * Stop listening for all events on the channel instance.
//      */

//   }, {
//     key: "stopListeningToAll",
//     value: function stopListeningToAll(callback) {
//       if (callback) {
//         this.subscription.unbind_global(callback);
//       } else {
//         this.subscription.unbind_global();
//       }

//       return this;
//     }
//     /**
//      * Register a callback to be called anytime a subscription succeeds.
//      */

//   }, {
//     key: "subscribed",
//     value: function subscribed(callback) {
//       this.on('pusher:subscription_succeeded', function () {
//         callback();
//       });
//       return this;
//     }
//     /**
//      * Register a callback to be called anytime a subscription error occurs.
//      */

//   }, {
//     key: "error",
//     value: function error(callback) {
//       this.on('pusher:subscription_error', function (status) {
//         callback(status);
//       });
//       return this;
//     }
//     /**
//      * Bind a channel to an event.
//      */

//   }, {
//     key: "on",
//     value: function on(event, callback) {
//       this.subscription.bind(event, callback);
//       return this;
//     }
//   }]);

//   return PusherChannel;
// }(Channel);

// /**
//  * This class represents a Pusher private channel.
//  */

// var PusherPrivateChannel = /*#__PURE__*/function (_PusherChannel) {
//   _inherits(PusherPrivateChannel, _PusherChannel);

//   var _super = _createSuper(PusherPrivateChannel);

//   function PusherPrivateChannel() {
//     _classCallCheck(this, PusherPrivateChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(PusherPrivateChannel, [{
//     key: "whisper",
//     value:
//     /**
//      * Send a whisper event to other clients in the channel.
//      */
//     function whisper(eventName, data) {
//       this.pusher.channels.channels[this.name].trigger("client-".concat(eventName), data);
//       return this;
//     }
//   }]);

//   return PusherPrivateChannel;
// }(PusherChannel);

// /**
//  * This class represents a Pusher private channel.
//  */

// var PusherEncryptedPrivateChannel = /*#__PURE__*/function (_PusherChannel) {
//   _inherits(PusherEncryptedPrivateChannel, _PusherChannel);

//   var _super = _createSuper(PusherEncryptedPrivateChannel);

//   function PusherEncryptedPrivateChannel() {
//     _classCallCheck(this, PusherEncryptedPrivateChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(PusherEncryptedPrivateChannel, [{
//     key: "whisper",
//     value:
//     /**
//      * Send a whisper event to other clients in the channel.
//      */
//     function whisper(eventName, data) {
//       this.pusher.channels.channels[this.name].trigger("client-".concat(eventName), data);
//       return this;
//     }
//   }]);

//   return PusherEncryptedPrivateChannel;
// }(PusherChannel);

// /**
//  * This class represents a Pusher presence channel.
//  */

// var PusherPresenceChannel = /*#__PURE__*/function (_PusherPrivateChannel) {
//   _inherits(PusherPresenceChannel, _PusherPrivateChannel);

//   var _super = _createSuper(PusherPresenceChannel);

//   function PusherPresenceChannel() {
//     _classCallCheck(this, PusherPresenceChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(PusherPresenceChannel, [{
//     key: "here",
//     value:
//     /**
//      * Register a callback to be called anytime the member list changes.
//      */
//     function here(callback) {
//       this.on('pusher:subscription_succeeded', function (data) {
//         callback(Object.keys(data.members).map(function (k) {
//           return data.members[k];
//         }));
//       });
//       return this;
//     }
//     /**
//      * Listen for someone joining the channel.
//      */

//   }, {
//     key: "joining",
//     value: function joining(callback) {
//       this.on('pusher:member_added', function (member) {
//         callback(member.info);
//       });
//       return this;
//     }
//     /**
//      * Send a whisper event to other clients in the channel.
//      */

//   }, {
//     key: "whisper",
//     value: function whisper(eventName, data) {
//       this.pusher.channels.channels[this.name].trigger("client-".concat(eventName), data);
//       return this;
//     }
//     /**
//      * Listen for someone leaving the channel.
//      */

//   }, {
//     key: "leaving",
//     value: function leaving(callback) {
//       this.on('pusher:member_removed', function (member) {
//         callback(member.info);
//       });
//       return this;
//     }
//   }]);

//   return PusherPresenceChannel;
// }(PusherPrivateChannel);

// /**
//  * This class represents a Socket.io channel.
//  */

// var SocketIoChannel = /*#__PURE__*/function (_Channel) {
//   _inherits(SocketIoChannel, _Channel);

//   var _super = _createSuper(SocketIoChannel);

//   /**
//    * Create a new class instance.
//    */
//   function SocketIoChannel(socket, name, options) {
//     var _this;

//     _classCallCheck(this, SocketIoChannel);

//     _this = _super.call(this);
//     /**
//      * The event callbacks applied to the socket.
//      */

//     _this.events = {};
//     /**
//      * User supplied callbacks for events on this channel.
//      */

//     _this.listeners = {};
//     _this.name = name;
//     _this.socket = socket;
//     _this.options = options;
//     _this.eventFormatter = new EventFormatter(_this.options.namespace);

//     _this.subscribe();

//     return _this;
//   }
//   /**
//    * Subscribe to a Socket.io channel.
//    */


//   _createClass(SocketIoChannel, [{
//     key: "subscribe",
//     value: function subscribe() {
//       this.socket.emit('subscribe', {
//         channel: this.name,
//         auth: this.options.auth || {}
//       });
//     }
//     /**
//      * Unsubscribe from channel and ubind event callbacks.
//      */

//   }, {
//     key: "unsubscribe",
//     value: function unsubscribe() {
//       this.unbind();
//       this.socket.emit('unsubscribe', {
//         channel: this.name,
//         auth: this.options.auth || {}
//       });
//     }
//     /**
//      * Listen for an event on the channel instance.
//      */

//   }, {
//     key: "listen",
//     value: function listen(event, callback) {
//       this.on(this.eventFormatter.format(event), callback);
//       return this;
//     }
//     /**
//      * Stop listening for an event on the channel instance.
//      */

//   }, {
//     key: "stopListening",
//     value: function stopListening(event, callback) {
//       this.unbindEvent(this.eventFormatter.format(event), callback);
//       return this;
//     }
//     /**
//      * Register a callback to be called anytime a subscription succeeds.
//      */

//   }, {
//     key: "subscribed",
//     value: function subscribed(callback) {
//       this.on('connect', function (socket) {
//         callback(socket);
//       });
//       return this;
//     }
//     /**
//      * Register a callback to be called anytime an error occurs.
//      */

//   }, {
//     key: "error",
//     value: function error(callback) {
//       return this;
//     }
//     /**
//      * Bind the channel's socket to an event and store the callback.
//      */

//   }, {
//     key: "on",
//     value: function on(event, callback) {
//       var _this2 = this;

//       this.listeners[event] = this.listeners[event] || [];

//       if (!this.events[event]) {
//         this.events[event] = function (channel, data) {
//           if (_this2.name === channel && _this2.listeners[event]) {
//             _this2.listeners[event].forEach(function (cb) {
//               return cb(data);
//             });
//           }
//         };

//         this.socket.on(event, this.events[event]);
//       }

//       this.listeners[event].push(callback);
//       return this;
//     }
//     /**
//      * Unbind the channel's socket from all stored event callbacks.
//      */

//   }, {
//     key: "unbind",
//     value: function unbind() {
//       var _this3 = this;

//       Object.keys(this.events).forEach(function (event) {
//         _this3.unbindEvent(event);
//       });
//     }
//     /**
//      * Unbind the listeners for the given event.
//      */

//   }, {
//     key: "unbindEvent",
//     value: function unbindEvent(event, callback) {
//       this.listeners[event] = this.listeners[event] || [];

//       if (callback) {
//         this.listeners[event] = this.listeners[event].filter(function (cb) {
//           return cb !== callback;
//         });
//       }

//       if (!callback || this.listeners[event].length === 0) {
//         if (this.events[event]) {
//           this.socket.removeListener(event, this.events[event]);
//           delete this.events[event];
//         }

//         delete this.listeners[event];
//       }
//     }
//   }]);

//   return SocketIoChannel;
// }(Channel);

// /**
//  * This class represents a Socket.io private channel.
//  */

// var SocketIoPrivateChannel = /*#__PURE__*/function (_SocketIoChannel) {
//   _inherits(SocketIoPrivateChannel, _SocketIoChannel);

//   var _super = _createSuper(SocketIoPrivateChannel);

//   function SocketIoPrivateChannel() {
//     _classCallCheck(this, SocketIoPrivateChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(SocketIoPrivateChannel, [{
//     key: "whisper",
//     value:
//     /**
//      * Send a whisper event to other clients in the channel.
//      */
//     function whisper(eventName, data) {
//       this.socket.emit('client event', {
//         channel: this.name,
//         event: "client-".concat(eventName),
//         data: data
//       });
//       return this;
//     }
//   }]);

//   return SocketIoPrivateChannel;
// }(SocketIoChannel);

// /**
//  * This class represents a Socket.io presence channel.
//  */

// var SocketIoPresenceChannel = /*#__PURE__*/function (_SocketIoPrivateChann) {
//   _inherits(SocketIoPresenceChannel, _SocketIoPrivateChann);

//   var _super = _createSuper(SocketIoPresenceChannel);

//   function SocketIoPresenceChannel() {
//     _classCallCheck(this, SocketIoPresenceChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(SocketIoPresenceChannel, [{
//     key: "here",
//     value:
//     /**
//      * Register a callback to be called anytime the member list changes.
//      */
//     function here(callback) {
//       this.on('presence:subscribed', function (members) {
//         callback(members.map(function (m) {
//           return m.user_info;
//         }));
//       });
//       return this;
//     }
//     /**
//      * Listen for someone joining the channel.
//      */

//   }, {
//     key: "joining",
//     value: function joining(callback) {
//       this.on('presence:joining', function (member) {
//         return callback(member.user_info);
//       });
//       return this;
//     }
//     /**
//      * Send a whisper event to other clients in the channel.
//      */

//   }, {
//     key: "whisper",
//     value: function whisper(eventName, data) {
//       this.socket.emit('client event', {
//         channel: this.name,
//         event: "client-".concat(eventName),
//         data: data
//       });
//       return this;
//     }
//     /**
//      * Listen for someone leaving the channel.
//      */

//   }, {
//     key: "leaving",
//     value: function leaving(callback) {
//       this.on('presence:leaving', function (member) {
//         return callback(member.user_info);
//       });
//       return this;
//     }
//   }]);

//   return SocketIoPresenceChannel;
// }(SocketIoPrivateChannel);

// /**
//  * This class represents a null channel.
//  */

// var NullChannel = /*#__PURE__*/function (_Channel) {
//   _inherits(NullChannel, _Channel);

//   var _super = _createSuper(NullChannel);

//   function NullChannel() {
//     _classCallCheck(this, NullChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(NullChannel, [{
//     key: "subscribe",
//     value:
//     /**
//      * Subscribe to a channel.
//      */
//     function subscribe() {//
//     }
//     /**
//      * Unsubscribe from a channel.
//      */

//   }, {
//     key: "unsubscribe",
//     value: function unsubscribe() {//
//     }
//     /**
//      * Listen for an event on the channel instance.
//      */

//   }, {
//     key: "listen",
//     value: function listen(event, callback) {
//       return this;
//     }
//     /**
//      * Listen for all events on the channel instance.
//      */

//   }, {
//     key: "listenToAll",
//     value: function listenToAll(callback) {
//       return this;
//     }
//     /**
//      * Stop listening for an event on the channel instance.
//      */

//   }, {
//     key: "stopListening",
//     value: function stopListening(event, callback) {
//       return this;
//     }
//     /**
//      * Register a callback to be called anytime a subscription succeeds.
//      */

//   }, {
//     key: "subscribed",
//     value: function subscribed(callback) {
//       return this;
//     }
//     /**
//      * Register a callback to be called anytime an error occurs.
//      */

//   }, {
//     key: "error",
//     value: function error(callback) {
//       return this;
//     }
//     /**
//      * Bind a channel to an event.
//      */

//   }, {
//     key: "on",
//     value: function on(event, callback) {
//       return this;
//     }
//   }]);

//   return NullChannel;
// }(Channel);

// /**
//  * This class represents a null private channel.
//  */

// var NullPrivateChannel = /*#__PURE__*/function (_NullChannel) {
//   _inherits(NullPrivateChannel, _NullChannel);

//   var _super = _createSuper(NullPrivateChannel);

//   function NullPrivateChannel() {
//     _classCallCheck(this, NullPrivateChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(NullPrivateChannel, [{
//     key: "whisper",
//     value:
//     /**
//      * Send a whisper event to other clients in the channel.
//      */
//     function whisper(eventName, data) {
//       return this;
//     }
//   }]);

//   return NullPrivateChannel;
// }(NullChannel);

// /**
//  * This class represents a null private channel.
//  */

// var NullEncryptedPrivateChannel = /*#__PURE__*/function (_NullChannel) {
//   _inherits(NullEncryptedPrivateChannel, _NullChannel);

//   var _super = _createSuper(NullEncryptedPrivateChannel);

//   function NullEncryptedPrivateChannel() {
//     _classCallCheck(this, NullEncryptedPrivateChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(NullEncryptedPrivateChannel, [{
//     key: "whisper",
//     value:
//     /**
//      * Send a whisper event to other clients in the channel.
//      */
//     function whisper(eventName, data) {
//       return this;
//     }
//   }]);

//   return NullEncryptedPrivateChannel;
// }(NullChannel);

// /**
//  * This class represents a null presence channel.
//  */

// var NullPresenceChannel = /*#__PURE__*/function (_NullPrivateChannel) {
//   _inherits(NullPresenceChannel, _NullPrivateChannel);

//   var _super = _createSuper(NullPresenceChannel);

//   function NullPresenceChannel() {
//     _classCallCheck(this, NullPresenceChannel);

//     return _super.apply(this, arguments);
//   }

//   _createClass(NullPresenceChannel, [{
//     key: "here",
//     value:
//     /**
//      * Register a callback to be called anytime the member list changes.
//      */
//     function here(callback) {
//       return this;
//     }
//     /**
//      * Listen for someone joining the channel.
//      */

//   }, {
//     key: "joining",
//     value: function joining(callback) {
//       return this;
//     }
//     /**
//      * Send a whisper event to other clients in the channel.
//      */

//   }, {
//     key: "whisper",
//     value: function whisper(eventName, data) {
//       return this;
//     }
//     /**
//      * Listen for someone leaving the channel.
//      */

//   }, {
//     key: "leaving",
//     value: function leaving(callback) {
//       return this;
//     }
//   }]);

//   return NullPresenceChannel;
// }(NullPrivateChannel);

// var Connector = /*#__PURE__*/function () {
//   /**
//    * Create a new class instance.
//    */
//   function Connector(options) {
//     _classCallCheck(this, Connector);

//     /**
//      * Default connector options.
//      */
//     this._defaultOptions = {
//       auth: {
//         headers: {}
//       },
//       authEndpoint: '/broadcasting/auth',
//       userAuthentication: {
//         endpoint: '/broadcasting/user-auth',
//         headers: {}
//       },
//       broadcaster: 'pusher',
//       csrfToken: null,
//       bearerToken: null,
//       host: null,
//       key: null,
//       namespace: 'App.Events'
//     };
//     this.setOptions(options);
//     this.connect();
//   }
//   /**
//    * Merge the custom options with the defaults.
//    */


//   _createClass(Connector, [{
//     key: "setOptions",
//     value: function setOptions(options) {
//       this.options = _extends(this._defaultOptions, options);
//       var token = this.csrfToken();

//       if (token) {
//         this.options.auth.headers['X-CSRF-TOKEN'] = token;
//         this.options.userAuthentication.headers['X-CSRF-TOKEN'] = token;
//       }

//       token = this.options.bearerToken;

//       if (token) {
//         this.options.auth.headers['Authorization'] = 'Bearer ' + token;
//         this.options.userAuthentication.headers['Authorization'] = 'Bearer ' + token;
//       }

//       return options;
//     }
//     /**
//      * Extract the CSRF token from the page.
//      */

//   }, {
//     key: "csrfToken",
//     value: function csrfToken() {
//       var selector;

//       if (typeof window !== 'undefined' && window['Laravel'] && window['Laravel'].csrfToken) {
//         return window['Laravel'].csrfToken;
//       } else if (this.options.csrfToken) {
//         return this.options.csrfToken;
//       } else if (typeof document !== 'undefined' && typeof document.querySelector === 'function' && (selector = document.querySelector('meta[name="csrf-token"]'))) {
//         return selector.getAttribute('content');
//       }

//       return null;
//     }
//   }]);

//   return Connector;
// }();

// /**
//  * This class creates a connector to Pusher.
//  */

// var PusherConnector = /*#__PURE__*/function (_Connector) {
//   _inherits(PusherConnector, _Connector);

//   var _super = _createSuper(PusherConnector);

//   function PusherConnector() {
//     var _this;

//     _classCallCheck(this, PusherConnector);

//     _this = _super.apply(this, arguments);
//     /**
//      * All of the subscribed channel names.
//      */

//     _this.channels = {};
//     return _this;
//   }
//   /**
//    * Create a fresh Pusher connection.
//    */


//   _createClass(PusherConnector, [{
//     key: "connect",
//     value: function connect() {
//       if (typeof this.options.client !== 'undefined') {
//         this.pusher = this.options.client;
//       } else if (this.options.Pusher) {
//         this.pusher = new this.options.Pusher(this.options.key, this.options);
//       } else {
//         this.pusher = new Pusher(this.options.key, this.options);
//       }
//     }
//     /**
//      * Sign in the user via Pusher user authentication (https://pusher.com/docs/channels/using_channels/user-authentication/).
//      */

//   }, {
//     key: "signin",
//     value: function signin() {
//       this.pusher.signin();
//     }
//     /**
//      * Listen for an event on a channel instance.
//      */

//   }, {
//     key: "listen",
//     value: function listen(name, event, callback) {
//       return this.channel(name).listen(event, callback);
//     }
//     /**
//      * Get a channel instance by name.
//      */

//   }, {
//     key: "channel",
//     value: function channel(name) {
//       if (!this.channels[name]) {
//         this.channels[name] = new PusherChannel(this.pusher, name, this.options);
//       }

//       return this.channels[name];
//     }
//     /**
//      * Get a private channel instance by name.
//      */

//   }, {
//     key: "privateChannel",
//     value: function privateChannel(name) {
//       if (!this.channels['private-' + name]) {
//         this.channels['private-' + name] = new PusherPrivateChannel(this.pusher, 'private-' + name, this.options);
//       }

//       return this.channels['private-' + name];
//     }
//     /**
//      * Get a private encrypted channel instance by name.
//      */

//   }, {
//     key: "encryptedPrivateChannel",
//     value: function encryptedPrivateChannel(name) {
//       if (!this.channels['private-encrypted-' + name]) {
//         this.channels['private-encrypted-' + name] = new PusherEncryptedPrivateChannel(this.pusher, 'private-encrypted-' + name, this.options);
//       }

//       return this.channels['private-encrypted-' + name];
//     }
//     /**
//      * Get a presence channel instance by name.
//      */

//   }, {
//     key: "presenceChannel",
//     value: function presenceChannel(name) {
//       if (!this.channels['presence-' + name]) {
//         this.channels['presence-' + name] = new PusherPresenceChannel(this.pusher, 'presence-' + name, this.options);
//       }

//       return this.channels['presence-' + name];
//     }
//     /**
//      * Leave the given channel, as well as its private and presence variants.
//      */

//   }, {
//     key: "leave",
//     value: function leave(name) {
//       var _this2 = this;

//       var channels = [name, 'private-' + name, 'private-encrypted-' + name, 'presence-' + name];
//       channels.forEach(function (name, index) {
//         _this2.leaveChannel(name);
//       });
//     }
//     /**
//      * Leave the given channel.
//      */

//   }, {
//     key: "leaveChannel",
//     value: function leaveChannel(name) {
//       if (this.channels[name]) {
//         this.channels[name].unsubscribe();
//         delete this.channels[name];
//       }
//     }
//     /**
//      * Get the socket ID for the connection.
//      */

//   }, {
//     key: "socketId",
//     value: function socketId() {
//       return this.pusher.connection.socket_id;
//     }
//     /**
//      * Disconnect Pusher connection.
//      */

//   }, {
//     key: "disconnect",
//     value: function disconnect() {
//       this.pusher.disconnect();
//     }
//   }]);

//   return PusherConnector;
// }(Connector);

// /**
//  * This class creates a connnector to a Socket.io server.
//  */

// var SocketIoConnector = /*#__PURE__*/function (_Connector) {
//   _inherits(SocketIoConnector, _Connector);

//   var _super = _createSuper(SocketIoConnector);

//   function SocketIoConnector() {
//     var _this;

//     _classCallCheck(this, SocketIoConnector);

//     _this = _super.apply(this, arguments);
//     /**
//      * All of the subscribed channel names.
//      */

//     _this.channels = {};
//     return _this;
//   }
//   /**
//    * Create a fresh Socket.io connection.
//    */


//   _createClass(SocketIoConnector, [{
//     key: "connect",
//     value: function connect() {
//       var _this2 = this;

//       var io = this.getSocketIO();
//       this.socket = io(this.options.host, this.options);
//       this.socket.on('reconnect', function () {
//         Object.values(_this2.channels).forEach(function (channel) {
//           channel.subscribe();
//         });
//       });
//       return this.socket;
//     }
//     /**
//      * Get socket.io module from global scope or options.
//      */

//   }, {
//     key: "getSocketIO",
//     value: function getSocketIO() {
//       if (typeof this.options.client !== 'undefined') {
//         return this.options.client;
//       }

//       if (typeof io !== 'undefined') {
//         return io;
//       }

//       throw new Error('Socket.io client not found. Should be globally available or passed via options.client');
//     }
//     /**
//      * Listen for an event on a channel instance.
//      */

//   }, {
//     key: "listen",
//     value: function listen(name, event, callback) {
//       return this.channel(name).listen(event, callback);
//     }
//     /**
//      * Get a channel instance by name.
//      */

//   }, {
//     key: "channel",
//     value: function channel(name) {
//       if (!this.channels[name]) {
//         this.channels[name] = new SocketIoChannel(this.socket, name, this.options);
//       }

//       return this.channels[name];
//     }
//     /**
//      * Get a private channel instance by name.
//      */

//   }, {
//     key: "privateChannel",
//     value: function privateChannel(name) {
//       if (!this.channels['private-' + name]) {
//         this.channels['private-' + name] = new SocketIoPrivateChannel(this.socket, 'private-' + name, this.options);
//       }

//       return this.channels['private-' + name];
//     }
//     /**
//      * Get a presence channel instance by name.
//      */

//   }, {
//     key: "presenceChannel",
//     value: function presenceChannel(name) {
//       if (!this.channels['presence-' + name]) {
//         this.channels['presence-' + name] = new SocketIoPresenceChannel(this.socket, 'presence-' + name, this.options);
//       }

//       return this.channels['presence-' + name];
//     }
//     /**
//      * Leave the given channel, as well as its private and presence variants.
//      */

//   }, {
//     key: "leave",
//     value: function leave(name) {
//       var _this3 = this;

//       var channels = [name, 'private-' + name, 'presence-' + name];
//       channels.forEach(function (name) {
//         _this3.leaveChannel(name);
//       });
//     }
//     /**
//      * Leave the given channel.
//      */

//   }, {
//     key: "leaveChannel",
//     value: function leaveChannel(name) {
//       if (this.channels[name]) {
//         this.channels[name].unsubscribe();
//         delete this.channels[name];
//       }
//     }
//     /**
//      * Get the socket ID for the connection.
//      */

//   }, {
//     key: "socketId",
//     value: function socketId() {
//       return this.socket.id;
//     }
//     /**
//      * Disconnect Socketio connection.
//      */

//   }, {
//     key: "disconnect",
//     value: function disconnect() {
//       this.socket.disconnect();
//     }
//   }]);

//   return SocketIoConnector;
// }(Connector);

// /**
//  * This class creates a null connector.
//  */

// var NullConnector = /*#__PURE__*/function (_Connector) {
//   _inherits(NullConnector, _Connector);

//   var _super = _createSuper(NullConnector);

//   function NullConnector() {
//     var _this;

//     _classCallCheck(this, NullConnector);

//     _this = _super.apply(this, arguments);
//     /**
//      * All of the subscribed channel names.
//      */

//     _this.channels = {};
//     return _this;
//   }
//   /**
//    * Create a fresh connection.
//    */


//   _createClass(NullConnector, [{
//     key: "connect",
//     value: function connect() {//
//     }
//     /**
//      * Listen for an event on a channel instance.
//      */

//   }, {
//     key: "listen",
//     value: function listen(name, event, callback) {
//       return new NullChannel();
//     }
//     /**
//      * Get a channel instance by name.
//      */

//   }, {
//     key: "channel",
//     value: function channel(name) {
//       return new NullChannel();
//     }
//     /**
//      * Get a private channel instance by name.
//      */

//   }, {
//     key: "privateChannel",
//     value: function privateChannel(name) {
//       return new NullPrivateChannel();
//     }
//     /**
//      * Get a private encrypted channel instance by name.
//      */

//   }, {
//     key: "encryptedPrivateChannel",
//     value: function encryptedPrivateChannel(name) {
//       return new NullEncryptedPrivateChannel();
//     }
//     /**
//      * Get a presence channel instance by name.
//      */

//   }, {
//     key: "presenceChannel",
//     value: function presenceChannel(name) {
//       return new NullPresenceChannel();
//     }
//     /**
//      * Leave the given channel, as well as its private and presence variants.
//      */

//   }, {
//     key: "leave",
//     value: function leave(name) {//
//     }
//     /**
//      * Leave the given channel.
//      */

//   }, {
//     key: "leaveChannel",
//     value: function leaveChannel(name) {//
//     }
//     /**
//      * Get the socket ID for the connection.
//      */

//   }, {
//     key: "socketId",
//     value: function socketId() {
//       return 'fake-socket-id';
//     }
//     /**
//      * Disconnect the connection.
//      */

//   }, {
//     key: "disconnect",
//     value: function disconnect() {//
//     }
//   }]);

//   return NullConnector;
// }(Connector);

// /**
//  * This class is the primary API for interacting with broadcasting.
//  */

// var Echo = /*#__PURE__*/function () {
//   /**
//    * Create a new class instance.
//    */
//   function Echo(options) {
//     _classCallCheck(this, Echo);

//     this.options = options;
//     this.connect();

//     if (!this.options.withoutInterceptors) {
//       this.registerInterceptors();
//     }
//   }
//   /**
//    * Get a channel instance by name.
//    */


//   _createClass(Echo, [{
//     key: "channel",
//     value: function channel(_channel) {
//       return this.connector.channel(_channel);
//     }
//     /**
//      * Create a new connection.
//      */

//   }, {
//     key: "connect",
//     value: function connect() {
//       if (this.options.broadcaster == 'reverb') {
//         this.connector = new PusherConnector(_extends(_extends({}, this.options), {
//           cluster: ''
//         }));
//       } else if (this.options.broadcaster == 'pusher') {
//         this.connector = new PusherConnector(this.options);
//       } else if (this.options.broadcaster == 'socket.io') {
//         this.connector = new SocketIoConnector(this.options);
//       } else if (this.options.broadcaster == 'null') {
//         this.connector = new NullConnector(this.options);
//       } else if (typeof this.options.broadcaster == 'function') {
//         this.connector = this.options.broadcaster(this.options);
//       } else {
//         throw new Error("Broadcaster ".concat(_typeof(this.options.broadcaster), " ").concat(this.options.broadcaster, " is not supported."));
//       }
//     }
//     /**
//      * Disconnect from the Echo server.
//      */

//   }, {
//     key: "disconnect",
//     value: function disconnect() {
//       this.connector.disconnect();
//     }
//     /**
//      * Get a presence channel instance by name.
//      */

//   }, {
//     key: "join",
//     value: function join(channel) {
//       return this.connector.presenceChannel(channel);
//     }
//     /**
//      * Leave the given channel, as well as its private and presence variants.
//      */

//   }, {
//     key: "leave",
//     value: function leave(channel) {
//       this.connector.leave(channel);
//     }
//     /**
//      * Leave the given channel.
//      */

//   }, {
//     key: "leaveChannel",
//     value: function leaveChannel(channel) {
//       this.connector.leaveChannel(channel);
//     }
//     /**
//      * Leave all channels.
//      */

//   }, {
//     key: "leaveAllChannels",
//     value: function leaveAllChannels() {
//       for (var channel in this.connector.channels) {
//         this.leaveChannel(channel);
//       }
//     }
//     /**
//      * Listen for an event on a channel instance.
//      */

//   }, {
//     key: "listen",
//     value: function listen(channel, event, callback) {
//       return this.connector.listen(channel, event, callback);
//     }
//     /**
//      * Get a private channel instance by name.
//      */

//   }, {
//     key: "private",
//     value: function _private(channel) {
//       return this.connector.privateChannel(channel);
//     }
//     /**
//      * Get a private encrypted channel instance by name.
//      */

//   }, {
//     key: "encryptedPrivate",
//     value: function encryptedPrivate(channel) {
//       if (this.connector instanceof SocketIoConnector) {
//         throw new Error("Broadcaster ".concat(_typeof(this.options.broadcaster), " ").concat(this.options.broadcaster, " does not support encrypted private channels."));
//       }

//       return this.connector.encryptedPrivateChannel(channel);
//     }
//     /**
//      * Get the Socket ID for the connection.
//      */

//   }, {
//     key: "socketId",
//     value: function socketId() {
//       return this.connector.socketId();
//     }
//     /**
//      * Register 3rd party request interceptiors. These are used to automatically
//      * send a connections socket id to a Laravel app with a X-Socket-Id header.
//      */

//   }, {
//     key: "registerInterceptors",
//     value: function registerInterceptors() {
//       if (typeof Vue === 'function' && Vue.http) {
//         this.registerVueRequestInterceptor();
//       }

//       if (typeof axios === 'function') {
//         this.registerAxiosRequestInterceptor();
//       }

//       if (typeof jQuery === 'function') {
//         this.registerjQueryAjaxSetup();
//       }

//       if ((typeof Turbo === "undefined" ? "undefined" : _typeof(Turbo)) === 'object') {
//         this.registerTurboRequestInterceptor();
//       }
//     }
//     /**
//      * Register a Vue HTTP interceptor to add the X-Socket-ID header.
//      */

//   }, {
//     key: "registerVueRequestInterceptor",
//     value: function registerVueRequestInterceptor() {
//       var _this = this;

//       Vue.http.interceptors.push(function (request, next) {
//         if (_this.socketId()) {
//           request.headers.set('X-Socket-ID', _this.socketId());
//         }

//         next();
//       });
//     }
//     /**
//      * Register an Axios HTTP interceptor to add the X-Socket-ID header.
//      */

//   }, {
//     key: "registerAxiosRequestInterceptor",
//     value: function registerAxiosRequestInterceptor() {
//       var _this2 = this;

//       axios.interceptors.request.use(function (config) {
//         if (_this2.socketId()) {
//           config.headers['X-Socket-Id'] = _this2.socketId();
//         }

//         return config;
//       });
//     }
//     /**
//      * Register jQuery AjaxPrefilter to add the X-Socket-ID header.
//      */

//   }, {
//     key: "registerjQueryAjaxSetup",
//     value: function registerjQueryAjaxSetup() {
//       var _this3 = this;

//       if (typeof jQuery.ajax != 'undefined') {
//         jQuery.ajaxPrefilter(function (options, originalOptions, xhr) {
//           if (_this3.socketId()) {
//             xhr.setRequestHeader('X-Socket-Id', _this3.socketId());
//           }
//         });
//       }
//     }
//     /**
//      * Register the Turbo Request interceptor to add the X-Socket-ID header.
//      */

//   }, {
//     key: "registerTurboRequestInterceptor",
//     value: function registerTurboRequestInterceptor() {
//       var _this4 = this;

//       document.addEventListener('turbo:before-fetch-request', function (event) {
//         event.detail.fetchOptions.headers['X-Socket-Id'] = _this4.socketId();
//       });
//     }
//   }]);

//   return Echo;
// }();




// /***/ }),

// /***/ "./resources/css/app.css":
// /*!*******************************!*\
//   !*** ./resources/css/app.css ***!
//   \*******************************/
// /***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

// "use strict";
// __webpack_require__.r(__webpack_exports__);
// // extracted by mini-css-extract-plugin


// /***/ }),

// /***/ "./node_modules/process/browser.js":
// /*!*****************************************!*\
//   !*** ./node_modules/process/browser.js ***!
//   \*****************************************/
// /***/ ((module) => {

// // shim for using process in browser
// var process = module.exports = {};

// // cached from whatever global is present so that test runners that stub it
// // don't break things.  But we need to wrap it in a try catch in case it is
// // wrapped in strict mode code which doesn't define any globals.  It's inside a
// // function because try/catches deoptimize in certain engines.

// var cachedSetTimeout;
// var cachedClearTimeout;

// function defaultSetTimout() {
//     throw new Error('setTimeout has not been defined');
// }
// function defaultClearTimeout () {
//     throw new Error('clearTimeout has not been defined');
// }
// (function () {
//     try {
//         if (typeof setTimeout === 'function') {
//             cachedSetTimeout = setTimeout;
//         } else {
//             cachedSetTimeout = defaultSetTimout;
//         }
//     } catch (e) {
//         cachedSetTimeout = defaultSetTimout;
//     }
//     try {
//         if (typeof clearTimeout === 'function') {
//             cachedClearTimeout = clearTimeout;
//         } else {
//             cachedClearTimeout = defaultClearTimeout;
//         }
//     } catch (e) {
//         cachedClearTimeout = defaultClearTimeout;
//     }
// } ())
// function runTimeout(fun) {
//     if (cachedSetTimeout === setTimeout) {
//         //normal enviroments in sane situations
//         return setTimeout(fun, 0);
//     }
//     // if setTimeout wasn't available but was latter defined
//     if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
//         cachedSetTimeout = setTimeout;
//         return setTimeout(fun, 0);
//     }
//     try {
//         // when when somebody has screwed with setTimeout but no I.E. maddness
//         return cachedSetTimeout(fun, 0);
//     } catch(e){
//         try {
//             // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
//             return cachedSetTimeout.call(null, fun, 0);
//         } catch(e){
//             // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
//             return cachedSetTimeout.call(this, fun, 0);
//         }
//     }


// }
// function runClearTimeout(marker) {
//     if (cachedClearTimeout === clearTimeout) {
//         //normal enviroments in sane situations
//         return clearTimeout(marker);
//     }
//     // if clearTimeout wasn't available but was latter defined
//     if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
//         cachedClearTimeout = clearTimeout;
//         return clearTimeout(marker);
//     }
//     try {
//         // when when somebody has screwed with setTimeout but no I.E. maddness
//         return cachedClearTimeout(marker);
//     } catch (e){
//         try {
//             // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
//             return cachedClearTimeout.call(null, marker);
//         } catch (e){
//             // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
//             // Some versions of I.E. have different rules for clearTimeout vs setTimeout
//             return cachedClearTimeout.call(this, marker);
//         }
//     }



// }
// var queue = [];
// var draining = false;
// var currentQueue;
// var queueIndex = -1;

// function cleanUpNextTick() {
//     if (!draining || !currentQueue) {
//         return;
//     }
//     draining = false;
//     if (currentQueue.length) {
//         queue = currentQueue.concat(queue);
//     } else {
//         queueIndex = -1;
//     }
//     if (queue.length) {
//         drainQueue();
//     }
// }

// function drainQueue() {
//     if (draining) {
//         return;
//     }
//     var timeout = runTimeout(cleanUpNextTick);
//     draining = true;

//     var len = queue.length;
//     while(len) {
//         currentQueue = queue;
//         queue = [];
//         while (++queueIndex < len) {
//             if (currentQueue) {
//                 currentQueue[queueIndex].run();
//             }
//         }
//         queueIndex = -1;
//         len = queue.length;
//     }
//     currentQueue = null;
//     draining = false;
//     runClearTimeout(timeout);
// }

// process.nextTick = function (fun) {
//     var args = new Array(arguments.length - 1);
//     if (arguments.length > 1) {
//         for (var i = 1; i < arguments.length; i++) {
//             args[i - 1] = arguments[i];
//         }
//     }
//     queue.push(new Item(fun, args));
//     if (queue.length === 1 && !draining) {
//         runTimeout(drainQueue);
//     }
// };

// // v8 likes predictible objects
// function Item(fun, array) {
//     this.fun = fun;
//     this.array = array;
// }
// Item.prototype.run = function () {
//     this.fun.apply(null, this.array);
// };
// process.title = 'browser';
// process.browser = true;
// process.env = {};
// process.argv = [];
// process.version = ''; // empty string to avoid regexp issues
// process.versions = {};

// function noop() {}

// process.on = noop;
// process.addListener = noop;
// process.once = noop;
// process.off = noop;
// process.removeListener = noop;
// process.removeAllListeners = noop;
// process.emit = noop;
// process.prependListener = noop;
// process.prependOnceListener = noop;

// process.listeners = function (name) { return [] }

// process.binding = function (name) {
//     throw new Error('process.binding is not supported');
// };

// process.cwd = function () { return '/' };
// process.chdir = function (dir) {
//     throw new Error('process.chdir is not supported');
// };
// process.umask = function() { return 0; };


// /***/ }),

// /***/ "./node_modules/pusher-js/dist/web/pusher.js":
// /*!***************************************************!*\
//   !*** ./node_modules/pusher-js/dist/web/pusher.js ***!
//   \***************************************************/
// /***/ ((module) => {

// /*!
//  * Pusher JavaScript Library v8.4.0-rc2
//  * https://pusher.com/
//  *
//  * Copyright 2020, Pusher
//  * Released under the MIT licence.
//  */

// (function webpackUniversalModuleDefinition(root, factory) {
// 	if(true)
// 		module.exports = factory();
// 	else {}
// })(window, function() {
// return /******/ (function(modules) { // webpackBootstrap
// /******/ 	// The module cache
// /******/ 	var installedModules = {};
// /******/
// /******/ 	// The require function
// /******/ 	function __nested_webpack_require_673__(moduleId) {
// /******/
// /******/ 		// Check if module is in cache
// /******/ 		if(installedModules[moduleId]) {
// /******/ 			return installedModules[moduleId].exports;
// /******/ 		}
// /******/ 		// Create a new module (and put it into the cache)
// /******/ 		var module = installedModules[moduleId] = {
// /******/ 			i: moduleId,
// /******/ 			l: false,
// /******/ 			exports: {}
// /******/ 		};
// /******/
// /******/ 		// Execute the module function
// /******/ 		modules[moduleId].call(module.exports, module, module.exports, __nested_webpack_require_673__);
// /******/
// /******/ 		// Flag the module as loaded
// /******/ 		module.l = true;
// /******/
// /******/ 		// Return the exports of the module
// /******/ 		return module.exports;
// /******/ 	}
// /******/
// /******/
// /******/ 	// expose the modules object (__webpack_modules__)
// /******/ 	__nested_webpack_require_673__.m = modules;
// /******/
// /******/ 	// expose the module cache
// /******/ 	__nested_webpack_require_673__.c = installedModules;
// /******/
// /******/ 	// define getter function for harmony exports
// /******/ 	__nested_webpack_require_673__.d = function(exports, name, getter) {
// /******/ 		if(!__nested_webpack_require_673__.o(exports, name)) {
// /******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
// /******/ 		}
// /******/ 	};
// /******/
// /******/ 	// define __esModule on exports
// /******/ 	__nested_webpack_require_673__.r = function(exports) {
// /******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
// /******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
// /******/ 		}
// /******/ 		Object.defineProperty(exports, '__esModule', { value: true });
// /******/ 	};
// /******/
// /******/ 	// create a fake namespace object
// /******/ 	// mode & 1: value is a module id, require it
// /******/ 	// mode & 2: merge all properties of value into the ns
// /******/ 	// mode & 4: return value when already ns object
// /******/ 	// mode & 8|1: behave like require
// /******/ 	__nested_webpack_require_673__.t = function(value, mode) {
// /******/ 		if(mode & 1) value = __nested_webpack_require_673__(value);
// /******/ 		if(mode & 8) return value;
// /******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
// /******/ 		var ns = Object.create(null);
// /******/ 		__nested_webpack_require_673__.r(ns);
// /******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
// /******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __nested_webpack_require_673__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
// /******/ 		return ns;
// /******/ 	};
// /******/
// /******/ 	// getDefaultExport function for compatibility with non-harmony modules
// /******/ 	__nested_webpack_require_673__.n = function(module) {
// /******/ 		var getter = module && module.__esModule ?
// /******/ 			function getDefault() { return module['default']; } :
// /******/ 			function getModuleExports() { return module; };
// /******/ 		__nested_webpack_require_673__.d(getter, 'a', getter);
// /******/ 		return getter;
// /******/ 	};
// /******/
// /******/ 	// Object.prototype.hasOwnProperty.call
// /******/ 	__nested_webpack_require_673__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
// /******/
// /******/ 	// __webpack_public_path__
// /******/ 	__nested_webpack_require_673__.p = "";
// /******/
// /******/
// /******/ 	// Load entry module and return exports
// /******/ 	return __nested_webpack_require_673__(__nested_webpack_require_673__.s = 2);
// /******/ })
// /************************************************************************/
// /******/ ([
// /* 0 */
// /***/ (function(module, exports, __webpack_require__) {

// "use strict";

// // Copyright (C) 2016 Dmitry Chestnykh
// // MIT License. See LICENSE file for details.
// var __extends = (this && this.__extends) || (function () {
//     var extendStatics = function (d, b) {
//         extendStatics = Object.setPrototypeOf ||
//             ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
//             function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
//         return extendStatics(d, b);
//     };
//     return function (d, b) {
//         extendStatics(d, b);
//         function __() { this.constructor = d; }
//         d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
//     };
// })();
// Object.defineProperty(exports, "__esModule", { value: true });
// /**
//  * Package base64 implements Base64 encoding and decoding.
//  */
// // Invalid character used in decoding to indicate
// // that the character to decode is out of range of
// // alphabet and cannot be decoded.
// var INVALID_BYTE = 256;
// /**
//  * Implements standard Base64 encoding.
//  *
//  * Operates in constant time.
//  */
// var Coder = /** @class */ (function () {
//     // TODO(dchest): methods to encode chunk-by-chunk.
//     function Coder(_paddingCharacter) {
//         if (_paddingCharacter === void 0) { _paddingCharacter = "="; }
//         this._paddingCharacter = _paddingCharacter;
//     }
//     Coder.prototype.encodedLength = function (length) {
//         if (!this._paddingCharacter) {
//             return (length * 8 + 5) / 6 | 0;
//         }
//         return (length + 2) / 3 * 4 | 0;
//     };
//     Coder.prototype.encode = function (data) {
//         var out = "";
//         var i = 0;
//         for (; i < data.length - 2; i += 3) {
//             var c = (data[i] << 16) | (data[i + 1] << 8) | (data[i + 2]);
//             out += this._encodeByte((c >>> 3 * 6) & 63);
//             out += this._encodeByte((c >>> 2 * 6) & 63);
//             out += this._encodeByte((c >>> 1 * 6) & 63);
//             out += this._encodeByte((c >>> 0 * 6) & 63);
//         }
//         var left = data.length - i;
//         if (left > 0) {
//             var c = (data[i] << 16) | (left === 2 ? data[i + 1] << 8 : 0);
//             out += this._encodeByte((c >>> 3 * 6) & 63);
//             out += this._encodeByte((c >>> 2 * 6) & 63);
//             if (left === 2) {
//                 out += this._encodeByte((c >>> 1 * 6) & 63);
//             }
//             else {
//                 out += this._paddingCharacter || "";
//             }
//             out += this._paddingCharacter || "";
//         }
//         return out;
//     };
//     Coder.prototype.maxDecodedLength = function (length) {
//         if (!this._paddingCharacter) {
//             return (length * 6 + 7) / 8 | 0;
//         }
//         return length / 4 * 3 | 0;
//     };
//     Coder.prototype.decodedLength = function (s) {
//         return this.maxDecodedLength(s.length - this._getPaddingLength(s));
//     };
//     Coder.prototype.decode = function (s) {
//         if (s.length === 0) {
//             return new Uint8Array(0);
//         }
//         var paddingLength = this._getPaddingLength(s);
//         var length = s.length - paddingLength;
//         var out = new Uint8Array(this.maxDecodedLength(length));
//         var op = 0;
//         var i = 0;
//         var haveBad = 0;
//         var v0 = 0, v1 = 0, v2 = 0, v3 = 0;
//         for (; i < length - 4; i += 4) {
//             v0 = this._decodeChar(s.charCodeAt(i + 0));
//             v1 = this._decodeChar(s.charCodeAt(i + 1));
//             v2 = this._decodeChar(s.charCodeAt(i + 2));
//             v3 = this._decodeChar(s.charCodeAt(i + 3));
//             out[op++] = (v0 << 2) | (v1 >>> 4);
//             out[op++] = (v1 << 4) | (v2 >>> 2);
//             out[op++] = (v2 << 6) | v3;
//             haveBad |= v0 & INVALID_BYTE;
//             haveBad |= v1 & INVALID_BYTE;
//             haveBad |= v2 & INVALID_BYTE;
//             haveBad |= v3 & INVALID_BYTE;
//         }
//         if (i < length - 1) {
//             v0 = this._decodeChar(s.charCodeAt(i));
//             v1 = this._decodeChar(s.charCodeAt(i + 1));
//             out[op++] = (v0 << 2) | (v1 >>> 4);
//             haveBad |= v0 & INVALID_BYTE;
//             haveBad |= v1 & INVALID_BYTE;
//         }
//         if (i < length - 2) {
//             v2 = this._decodeChar(s.charCodeAt(i + 2));
//             out[op++] = (v1 << 4) | (v2 >>> 2);
//             haveBad |= v2 & INVALID_BYTE;
//         }
//         if (i < length - 3) {
//             v3 = this._decodeChar(s.charCodeAt(i + 3));
//             out[op++] = (v2 << 6) | v3;
//             haveBad |= v3 & INVALID_BYTE;
//         }
//         if (haveBad !== 0) {
//             throw new Error("Base64Coder: incorrect characters for decoding");
//         }
//         return out;
//     };
//     // Standard encoding have the following encoded/decoded ranges,
//     // which we need to convert between.
//     //
//     // ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz 0123456789  +   /
//     // Index:   0 - 25                    26 - 51              52 - 61   62  63
//     // ASCII:  65 - 90                    97 - 122             48 - 57   43  47
//     //
//     // Encode 6 bits in b into a new character.
//     Coder.prototype._encodeByte = function (b) {
//         // Encoding uses constant time operations as follows:
//         //
//         // 1. Define comparison of A with B using (A - B) >>> 8:
//         //          if A > B, then result is positive integer
//         //          if A <= B, then result is 0
//         //
//         // 2. Define selection of C or 0 using bitwise AND: X & C:
//         //          if X == 0, then result is 0
//         //          if X != 0, then result is C
//         //
//         // 3. Start with the smallest comparison (b >= 0), which is always
//         //    true, so set the result to the starting ASCII value (65).
//         //
//         // 4. Continue comparing b to higher ASCII values, and selecting
//         //    zero if comparison isn't true, otherwise selecting a value
//         //    to add to result, which:
//         //
//         //          a) undoes the previous addition
//         //          b) provides new value to add
//         //
//         var result = b;
//         // b >= 0
//         result += 65;
//         // b > 25
//         result += ((25 - b) >>> 8) & ((0 - 65) - 26 + 97);
//         // b > 51
//         result += ((51 - b) >>> 8) & ((26 - 97) - 52 + 48);
//         // b > 61
//         result += ((61 - b) >>> 8) & ((52 - 48) - 62 + 43);
//         // b > 62
//         result += ((62 - b) >>> 8) & ((62 - 43) - 63 + 47);
//         return String.fromCharCode(result);
//     };
//     // Decode a character code into a byte.
//     // Must return 256 if character is out of alphabet range.
//     Coder.prototype._decodeChar = function (c) {
//         // Decoding works similar to encoding: using the same comparison
//         // function, but now it works on ranges: result is always incremented
//         // by value, but this value becomes zero if the range is not
//         // satisfied.
//         //
//         // Decoding starts with invalid value, 256, which is then
//         // subtracted when the range is satisfied. If none of the ranges
//         // apply, the function returns 256, which is then checked by
//         // the caller to throw error.
//         var result = INVALID_BYTE; // start with invalid character
//         // c == 43 (c > 42 and c < 44)
//         result += (((42 - c) & (c - 44)) >>> 8) & (-INVALID_BYTE + c - 43 + 62);
//         // c == 47 (c > 46 and c < 48)
//         result += (((46 - c) & (c - 48)) >>> 8) & (-INVALID_BYTE + c - 47 + 63);
//         // c > 47 and c < 58
//         result += (((47 - c) & (c - 58)) >>> 8) & (-INVALID_BYTE + c - 48 + 52);
//         // c > 64 and c < 91
//         result += (((64 - c) & (c - 91)) >>> 8) & (-INVALID_BYTE + c - 65 + 0);
//         // c > 96 and c < 123
//         result += (((96 - c) & (c - 123)) >>> 8) & (-INVALID_BYTE + c - 97 + 26);
//         return result;
//     };
//     Coder.prototype._getPaddingLength = function (s) {
//         var paddingLength = 0;
//         if (this._paddingCharacter) {
//             for (var i = s.length - 1; i >= 0; i--) {
//                 if (s[i] !== this._paddingCharacter) {
//                     break;
//                 }
//                 paddingLength++;
//             }
//             if (s.length < 4 || paddingLength > 2) {
//                 throw new Error("Base64Coder: incorrect padding");
//             }
//         }
//         return paddingLength;
//     };
//     return Coder;
// }());
// exports.Coder = Coder;
// var stdCoder = new Coder();
// function encode(data) {
//     return stdCoder.encode(data);
// }
// exports.encode = encode;
// function decode(s) {
//     return stdCoder.decode(s);
// }
// exports.decode = decode;
// /**
//  * Implements URL-safe Base64 encoding.
//  * (Same as Base64, but '+' is replaced with '-', and '/' with '_').
//  *
//  * Operates in constant time.
//  */
// var URLSafeCoder = /** @class */ (function (_super) {
//     __extends(URLSafeCoder, _super);
//     function URLSafeCoder() {
//         return _super !== null && _super.apply(this, arguments) || this;
//     }
//     // URL-safe encoding have the following encoded/decoded ranges:
//     //
//     // ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz 0123456789  -   _
//     // Index:   0 - 25                    26 - 51              52 - 61   62  63
//     // ASCII:  65 - 90                    97 - 122             48 - 57   45  95
//     //
//     URLSafeCoder.prototype._encodeByte = function (b) {
//         var result = b;
//         // b >= 0
//         result += 65;
//         // b > 25
//         result += ((25 - b) >>> 8) & ((0 - 65) - 26 + 97);
//         // b > 51
//         result += ((51 - b) >>> 8) & ((26 - 97) - 52 + 48);
//         // b > 61
//         result += ((61 - b) >>> 8) & ((52 - 48) - 62 + 45);
//         // b > 62
//         result += ((62 - b) >>> 8) & ((62 - 45) - 63 + 95);
//         return String.fromCharCode(result);
//     };
//     URLSafeCoder.prototype._decodeChar = function (c) {
//         var result = INVALID_BYTE;
//         // c == 45 (c > 44 and c < 46)
//         result += (((44 - c) & (c - 46)) >>> 8) & (-INVALID_BYTE + c - 45 + 62);
//         // c == 95 (c > 94 and c < 96)
//         result += (((94 - c) & (c - 96)) >>> 8) & (-INVALID_BYTE + c - 95 + 63);
//         // c > 47 and c < 58
//         result += (((47 - c) & (c - 58)) >>> 8) & (-INVALID_BYTE + c - 48 + 52);
//         // c > 64 and c < 91
//         result += (((64 - c) & (c - 91)) >>> 8) & (-INVALID_BYTE + c - 65 + 0);
//         // c > 96 and c < 123
//         result += (((96 - c) & (c - 123)) >>> 8) & (-INVALID_BYTE + c - 97 + 26);
//         return result;
//     };
//     return URLSafeCoder;
// }(Coder));
// exports.URLSafeCoder = URLSafeCoder;
// var urlSafeCoder = new URLSafeCoder();
// function encodeURLSafe(data) {
//     return urlSafeCoder.encode(data);
// }
// exports.encodeURLSafe = encodeURLSafe;
// function decodeURLSafe(s) {
//     return urlSafeCoder.decode(s);
// }
// exports.decodeURLSafe = decodeURLSafe;
// exports.encodedLength = function (length) {
//     return stdCoder.encodedLength(length);
// };
// exports.maxDecodedLength = function (length) {
//     return stdCoder.maxDecodedLength(length);
// };
// exports.decodedLength = function (s) {
//     return stdCoder.decodedLength(s);
// };


// /***/ }),
// /* 1 */
// /***/ (function(module, exports, __webpack_require__) {

// "use strict";

// // Copyright (C) 2016 Dmitry Chestnykh
// // MIT License. See LICENSE file for details.
// Object.defineProperty(exports, "__esModule", { value: true });
// /**
//  * Package utf8 implements UTF-8 encoding and decoding.
//  */
// var INVALID_UTF16 = "utf8: invalid string";
// var INVALID_UTF8 = "utf8: invalid source encoding";
// /**
//  * Encodes the given string into UTF-8 byte array.
//  * Throws if the source string has invalid UTF-16 encoding.
//  */
// function encode(s) {
//     // Calculate result length and allocate output array.
//     // encodedLength() also validates string and throws errors,
//     // so we don't need repeat validation here.
//     var arr = new Uint8Array(encodedLength(s));
//     var pos = 0;
//     for (var i = 0; i < s.length; i++) {
//         var c = s.charCodeAt(i);
//         if (c < 0x80) {
//             arr[pos++] = c;
//         }
//         else if (c < 0x800) {
//             arr[pos++] = 0xc0 | c >> 6;
//             arr[pos++] = 0x80 | c & 0x3f;
//         }
//         else if (c < 0xd800) {
//             arr[pos++] = 0xe0 | c >> 12;
//             arr[pos++] = 0x80 | (c >> 6) & 0x3f;
//             arr[pos++] = 0x80 | c & 0x3f;
//         }
//         else {
//             i++; // get one more character
//             c = (c & 0x3ff) << 10;
//             c |= s.charCodeAt(i) & 0x3ff;
//             c += 0x10000;
//             arr[pos++] = 0xf0 | c >> 18;
//             arr[pos++] = 0x80 | (c >> 12) & 0x3f;
//             arr[pos++] = 0x80 | (c >> 6) & 0x3f;
//             arr[pos++] = 0x80 | c & 0x3f;
//         }
//     }
//     return arr;
// }
// exports.encode = encode;
// /**
//  * Returns the number of bytes required to encode the given string into UTF-8.
//  * Throws if the source string has invalid UTF-16 encoding.
//  */
// function encodedLength(s) {
//     var result = 0;
//     for (var i = 0; i < s.length; i++) {
//         var c = s.charCodeAt(i);
//         if (c < 0x80) {
//             result += 1;
//         }
//         else if (c < 0x800) {
//             result += 2;
//         }
//         else if (c < 0xd800) {
//             result += 3;
//         }
//         else if (c <= 0xdfff) {
//             if (i >= s.length - 1) {
//                 throw new Error(INVALID_UTF16);
//             }
//             i++; // "eat" next character
//             result += 4;
//         }
//         else {
//             throw new Error(INVALID_UTF16);
//         }
//     }
//     return result;
// }
// exports.encodedLength = encodedLength;
// /**
//  * Decodes the given byte array from UTF-8 into a string.
//  * Throws if encoding is invalid.
//  */
// function decode(arr) {
//     var chars = [];
//     for (var i = 0; i < arr.length; i++) {
//         var b = arr[i];
//         if (b & 0x80) {
//             var min = void 0;
//             if (b < 0xe0) {
//                 // Need 1 more byte.
//                 if (i >= arr.length) {
//                     throw new Error(INVALID_UTF8);
//                 }
//                 var n1 = arr[++i];
//                 if ((n1 & 0xc0) !== 0x80) {
//                     throw new Error(INVALID_UTF8);
//                 }
//                 b = (b & 0x1f) << 6 | (n1 & 0x3f);
//                 min = 0x80;
//             }
//             else if (b < 0xf0) {
//                 // Need 2 more bytes.
//                 if (i >= arr.length - 1) {
//                     throw new Error(INVALID_UTF8);
//                 }
//                 var n1 = arr[++i];
//                 var n2 = arr[++i];
//                 if ((n1 & 0xc0) !== 0x80 || (n2 & 0xc0) !== 0x80) {
//                     throw new Error(INVALID_UTF8);
//                 }
//                 b = (b & 0x0f) << 12 | (n1 & 0x3f) << 6 | (n2 & 0x3f);
//                 min = 0x800;
//             }
//             else if (b < 0xf8) {
//                 // Need 3 more bytes.
//                 if (i >= arr.length - 2) {
//                     throw new Error(INVALID_UTF8);
//                 }
//                 var n1 = arr[++i];
//                 var n2 = arr[++i];
//                 var n3 = arr[++i];
//                 if ((n1 & 0xc0) !== 0x80 || (n2 & 0xc0) !== 0x80 || (n3 & 0xc0) !== 0x80) {
//                     throw new Error(INVALID_UTF8);
//                 }
//                 b = (b & 0x0f) << 18 | (n1 & 0x3f) << 12 | (n2 & 0x3f) << 6 | (n3 & 0x3f);
//                 min = 0x10000;
//             }
//             else {
//                 throw new Error(INVALID_UTF8);
//             }
//             if (b < min || (b >= 0xd800 && b <= 0xdfff)) {
//                 throw new Error(INVALID_UTF8);
//             }
//             if (b >= 0x10000) {
//                 // Surrogate pair.
//                 if (b > 0x10ffff) {
//                     throw new Error(INVALID_UTF8);
//                 }
//                 b -= 0x10000;
//                 chars.push(String.fromCharCode(0xd800 | (b >> 10)));
//                 b = 0xdc00 | (b & 0x3ff);
//             }
//         }
//         chars.push(String.fromCharCode(b));
//     }
//     return chars.join("");
// }
// exports.decode = decode;


// /***/ }),
// /* 2 */
// /***/ (function(module, exports, __nested_webpack_require_19905__) {

// // required so we don't have to do require('pusher').default etc.
// module.exports = __nested_webpack_require_19905__(3).default;


// /***/ }),
// /* 3 */
// /***/ (function(module, __nested_webpack_exports__, __nested_webpack_require_20109__) {

// "use strict";
// // ESM COMPAT FLAG
// __nested_webpack_require_20109__.r(__nested_webpack_exports__);

// // CONCATENATED MODULE: ./src/runtimes/web/dom/script_receiver_factory.ts
// class ScriptReceiverFactory {
//     constructor(prefix, name) {
//         this.lastId = 0;
//         this.prefix = prefix;
//         this.name = name;
//     }
//     create(callback) {
//         this.lastId++;
//         var number = this.lastId;
//         var id = this.prefix + number;
//         var name = this.name + '[' + number + ']';
//         var called = false;
//         var callbackWrapper = function () {
//             if (!called) {
//                 callback.apply(null, arguments);
//                 called = true;
//             }
//         };
//         this[number] = callbackWrapper;
//         return { number: number, id: id, name: name, callback: callbackWrapper };
//     }
//     remove(receiver) {
//         delete this[receiver.number];
//     }
// }
// var ScriptReceivers = new ScriptReceiverFactory('_pusher_script_', 'Pusher.ScriptReceivers');

// // CONCATENATED MODULE: ./src/core/defaults.ts
// var Defaults = {
//     VERSION: "8.4.0-rc2",
//     PROTOCOL: 7,
//     wsPort: 80,
//     wssPort: 443,
//     wsPath: '',
//     httpHost: 'sockjs.pusher.com',
//     httpPort: 80,
//     httpsPort: 443,
//     httpPath: '/pusher',
//     stats_host: 'stats.pusher.com',
//     authEndpoint: '/pusher/auth',
//     authTransport: 'ajax',
//     activityTimeout: 120000,
//     pongTimeout: 30000,
//     unavailableTimeout: 10000,
//     userAuthentication: {
//         endpoint: '/pusher/user-auth',
//         transport: 'ajax'
//     },
//     channelAuthorization: {
//         endpoint: '/pusher/auth',
//         transport: 'ajax'
//     },
//     cdn_http: "http://js.pusher.com",
//     cdn_https: "https://js.pusher.com",
//     dependency_suffix: ""
// };
// /* harmony default export */ var defaults = (Defaults);

// // CONCATENATED MODULE: ./src/runtimes/web/dom/dependency_loader.ts


// class dependency_loader_DependencyLoader {
//     constructor(options) {
//         this.options = options;
//         this.receivers = options.receivers || ScriptReceivers;
//         this.loading = {};
//     }
//     load(name, options, callback) {
//         var self = this;
//         if (self.loading[name] && self.loading[name].length > 0) {
//             self.loading[name].push(callback);
//         }
//         else {
//             self.loading[name] = [callback];
//             var request = runtime.createScriptRequest(self.getPath(name, options));
//             var receiver = self.receivers.create(function (error) {
//                 self.receivers.remove(receiver);
//                 if (self.loading[name]) {
//                     var callbacks = self.loading[name];
//                     delete self.loading[name];
//                     var successCallback = function (wasSuccessful) {
//                         if (!wasSuccessful) {
//                             request.cleanup();
//                         }
//                     };
//                     for (var i = 0; i < callbacks.length; i++) {
//                         callbacks[i](error, successCallback);
//                     }
//                 }
//             });
//             request.send(receiver);
//         }
//     }
//     getRoot(options) {
//         var cdn;
//         var protocol = runtime.getDocument().location.protocol;
//         if ((options && options.useTLS) || protocol === 'https:') {
//             cdn = this.options.cdn_https;
//         }
//         else {
//             cdn = this.options.cdn_http;
//         }
//         return cdn.replace(/\/*$/, '') + '/' + this.options.version;
//     }
//     getPath(name, options) {
//         return this.getRoot(options) + '/' + name + this.options.suffix + '.js';
//     }
// }

// // CONCATENATED MODULE: ./src/runtimes/web/dom/dependencies.ts



// var DependenciesReceivers = new ScriptReceiverFactory('_pusher_dependencies', 'Pusher.DependenciesReceivers');
// var Dependencies = new dependency_loader_DependencyLoader({
//     cdn_http: defaults.cdn_http,
//     cdn_https: defaults.cdn_https,
//     version: defaults.VERSION,
//     suffix: defaults.dependency_suffix,
//     receivers: DependenciesReceivers
// });

// // CONCATENATED MODULE: ./src/core/utils/url_store.ts
// const urlStore = {
//     baseUrl: 'https://pusher.com',
//     urls: {
//         authenticationEndpoint: {
//             path: '/docs/channels/server_api/authenticating_users'
//         },
//         authorizationEndpoint: {
//             path: '/docs/channels/server_api/authorizing-users/'
//         },
//         javascriptQuickStart: {
//             path: '/docs/javascript_quick_start'
//         },
//         triggeringClientEvents: {
//             path: '/docs/client_api_guide/client_events#trigger-events'
//         },
//         encryptedChannelSupport: {
//             fullUrl: 'https://github.com/pusher/pusher-js/tree/cc491015371a4bde5743d1c87a0fbac0feb53195#encrypted-channel-support'
//         }
//     }
// };
// const buildLogSuffix = function (key) {
//     const urlPrefix = 'See:';
//     const urlObj = urlStore.urls[key];
//     if (!urlObj)
//         return '';
//     let url;
//     if (urlObj.fullUrl) {
//         url = urlObj.fullUrl;
//     }
//     else if (urlObj.path) {
//         url = urlStore.baseUrl + urlObj.path;
//     }
//     if (!url)
//         return '';
//     return `${urlPrefix} ${url}`;
// };
// /* harmony default export */ var url_store = ({ buildLogSuffix });

// // CONCATENATED MODULE: ./src/core/auth/options.ts
// var AuthRequestType;
// (function (AuthRequestType) {
//     AuthRequestType["UserAuthentication"] = "user-authentication";
//     AuthRequestType["ChannelAuthorization"] = "channel-authorization";
// })(AuthRequestType || (AuthRequestType = {}));

// // CONCATENATED MODULE: ./src/core/errors.ts
// class BadEventName extends Error {
//     constructor(msg) {
//         super(msg);
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }
// class BadChannelName extends Error {
//     constructor(msg) {
//         super(msg);
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }
// class RequestTimedOut extends Error {
//     constructor(msg) {
//         super(msg);
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }
// class TransportPriorityTooLow extends Error {
//     constructor(msg) {
//         super(msg);
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }
// class TransportClosed extends Error {
//     constructor(msg) {
//         super(msg);
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }
// class UnsupportedFeature extends Error {
//     constructor(msg) {
//         super(msg);
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }
// class UnsupportedTransport extends Error {
//     constructor(msg) {
//         super(msg);
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }
// class UnsupportedStrategy extends Error {
//     constructor(msg) {
//         super(msg);
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }
// class HTTPAuthError extends Error {
//     constructor(status, msg) {
//         super(msg);
//         this.status = status;
//         Object.setPrototypeOf(this, new.target.prototype);
//     }
// }

// // CONCATENATED MODULE: ./src/runtimes/isomorphic/auth/xhr_auth.ts




// const ajax = function (context, query, authOptions, authRequestType, callback) {
//     const xhr = runtime.createXHR();
//     xhr.open('POST', authOptions.endpoint, true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     for (var headerName in authOptions.headers) {
//         xhr.setRequestHeader(headerName, authOptions.headers[headerName]);
//     }
//     if (authOptions.headersProvider != null) {
//         let dynamicHeaders = authOptions.headersProvider();
//         for (var headerName in dynamicHeaders) {
//             xhr.setRequestHeader(headerName, dynamicHeaders[headerName]);
//         }
//     }
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4) {
//             if (xhr.status === 200) {
//                 let data;
//                 let parsed = false;
//                 try {
//                     data = JSON.parse(xhr.responseText);
//                     parsed = true;
//                 }
//                 catch (e) {
//                     callback(new HTTPAuthError(200, `JSON returned from ${authRequestType.toString()} endpoint was invalid, yet status code was 200. Data was: ${xhr.responseText}`), null);
//                 }
//                 if (parsed) {
//                     callback(null, data);
//                 }
//             }
//             else {
//                 let suffix = '';
//                 switch (authRequestType) {
//                     case AuthRequestType.UserAuthentication:
//                         suffix = url_store.buildLogSuffix('authenticationEndpoint');
//                         break;
//                     case AuthRequestType.ChannelAuthorization:
//                         suffix = `Clients must be authorized to join private or presence channels. ${url_store.buildLogSuffix('authorizationEndpoint')}`;
//                         break;
//                 }
//                 callback(new HTTPAuthError(xhr.status, `Unable to retrieve auth string from ${authRequestType.toString()} endpoint - ` +
//                     `received status: ${xhr.status} from ${authOptions.endpoint}. ${suffix}`), null);
//             }
//         }
//     };
//     xhr.send(query);
//     return xhr;
// };
// /* harmony default export */ var xhr_auth = (ajax);

// // CONCATENATED MODULE: ./src/core/base64.ts
// function encode(s) {
//     return btoa(utob(s));
// }
// var fromCharCode = String.fromCharCode;
// var b64chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
// var b64tab = {};
// for (var base64_i = 0, l = b64chars.length; base64_i < l; base64_i++) {
//     b64tab[b64chars.charAt(base64_i)] = base64_i;
// }
// var cb_utob = function (c) {
//     var cc = c.charCodeAt(0);
//     return cc < 0x80
//         ? c
//         : cc < 0x800
//             ? fromCharCode(0xc0 | (cc >>> 6)) + fromCharCode(0x80 | (cc & 0x3f))
//             : fromCharCode(0xe0 | ((cc >>> 12) & 0x0f)) +
//                 fromCharCode(0x80 | ((cc >>> 6) & 0x3f)) +
//                 fromCharCode(0x80 | (cc & 0x3f));
// };
// var utob = function (u) {
//     return u.replace(/[^\x00-\x7F]/g, cb_utob);
// };
// var cb_encode = function (ccc) {
//     var padlen = [0, 2, 1][ccc.length % 3];
//     var ord = (ccc.charCodeAt(0) << 16) |
//         ((ccc.length > 1 ? ccc.charCodeAt(1) : 0) << 8) |
//         (ccc.length > 2 ? ccc.charCodeAt(2) : 0);
//     var chars = [
//         b64chars.charAt(ord >>> 18),
//         b64chars.charAt((ord >>> 12) & 63),
//         padlen >= 2 ? '=' : b64chars.charAt((ord >>> 6) & 63),
//         padlen >= 1 ? '=' : b64chars.charAt(ord & 63)
//     ];
//     return chars.join('');
// };
// var btoa = window.btoa ||
//     function (b) {
//         return b.replace(/[\s\S]{1,3}/g, cb_encode);
//     };

// // CONCATENATED MODULE: ./src/core/utils/timers/abstract_timer.ts
// class Timer {
//     constructor(set, clear, delay, callback) {
//         this.clear = clear;
//         this.timer = set(() => {
//             if (this.timer) {
//                 this.timer = callback(this.timer);
//             }
//         }, delay);
//     }
//     isRunning() {
//         return this.timer !== null;
//     }
//     ensureAborted() {
//         if (this.timer) {
//             this.clear(this.timer);
//             this.timer = null;
//         }
//     }
// }
// /* harmony default export */ var abstract_timer = (Timer);

// // CONCATENATED MODULE: ./src/core/utils/timers/index.ts

// function timers_clearTimeout(timer) {
//     window.clearTimeout(timer);
// }
// function timers_clearInterval(timer) {
//     window.clearInterval(timer);
// }
// class timers_OneOffTimer extends abstract_timer {
//     constructor(delay, callback) {
//         super(setTimeout, timers_clearTimeout, delay, function (timer) {
//             callback();
//             return null;
//         });
//     }
// }
// class timers_PeriodicTimer extends abstract_timer {
//     constructor(delay, callback) {
//         super(setInterval, timers_clearInterval, delay, function (timer) {
//             callback();
//             return timer;
//         });
//     }
// }

// // CONCATENATED MODULE: ./src/core/util.ts

// var Util = {
//     now() {
//         if (Date.now) {
//             return Date.now();
//         }
//         else {
//             return new Date().valueOf();
//         }
//     },
//     defer(callback) {
//         return new timers_OneOffTimer(0, callback);
//     },
//     method(name, ...args) {
//         var boundArguments = Array.prototype.slice.call(arguments, 1);
//         return function (object) {
//             return object[name].apply(object, boundArguments.concat(arguments));
//         };
//     }
// };
// /* harmony default export */ var util = (Util);

// // CONCATENATED MODULE: ./src/core/utils/collections.ts


// function extend(target, ...sources) {
//     for (var i = 0; i < sources.length; i++) {
//         var extensions = sources[i];
//         for (var property in extensions) {
//             if (extensions[property] &&
//                 extensions[property].constructor &&
//                 extensions[property].constructor === Object) {
//                 target[property] = extend(target[property] || {}, extensions[property]);
//             }
//             else {
//                 target[property] = extensions[property];
//             }
//         }
//     }
//     return target;
// }
// function stringify() {
//     var m = ['Pusher'];
//     for (var i = 0; i < arguments.length; i++) {
//         if (typeof arguments[i] === 'string') {
//             m.push(arguments[i]);
//         }
//         else {
//             m.push(safeJSONStringify(arguments[i]));
//         }
//     }
//     return m.join(' : ');
// }
// function arrayIndexOf(array, item) {
//     var nativeIndexOf = Array.prototype.indexOf;
//     if (array === null) {
//         return -1;
//     }
//     if (nativeIndexOf && array.indexOf === nativeIndexOf) {
//         return array.indexOf(item);
//     }
//     for (var i = 0, l = array.length; i < l; i++) {
//         if (array[i] === item) {
//             return i;
//         }
//     }
//     return -1;
// }
// function objectApply(object, f) {
//     for (var key in object) {
//         if (Object.prototype.hasOwnProperty.call(object, key)) {
//             f(object[key], key, object);
//         }
//     }
// }
// function keys(object) {
//     var keys = [];
//     objectApply(object, function (_, key) {
//         keys.push(key);
//     });
//     return keys;
// }
// function values(object) {
//     var values = [];
//     objectApply(object, function (value) {
//         values.push(value);
//     });
//     return values;
// }
// function apply(array, f, context) {
//     for (var i = 0; i < array.length; i++) {
//         f.call(context || window, array[i], i, array);
//     }
// }
// function map(array, f) {
//     var result = [];
//     for (var i = 0; i < array.length; i++) {
//         result.push(f(array[i], i, array, result));
//     }
//     return result;
// }
// function mapObject(object, f) {
//     var result = {};
//     objectApply(object, function (value, key) {
//         result[key] = f(value);
//     });
//     return result;
// }
// function filter(array, test) {
//     test =
//         test ||
//             function (value) {
//                 return !!value;
//             };
//     var result = [];
//     for (var i = 0; i < array.length; i++) {
//         if (test(array[i], i, array, result)) {
//             result.push(array[i]);
//         }
//     }
//     return result;
// }
// function filterObject(object, test) {
//     var result = {};
//     objectApply(object, function (value, key) {
//         if ((test && test(value, key, object, result)) || Boolean(value)) {
//             result[key] = value;
//         }
//     });
//     return result;
// }
// function flatten(object) {
//     var result = [];
//     objectApply(object, function (value, key) {
//         result.push([key, value]);
//     });
//     return result;
// }
// function any(array, test) {
//     for (var i = 0; i < array.length; i++) {
//         if (test(array[i], i, array)) {
//             return true;
//         }
//     }
//     return false;
// }
// function collections_all(array, test) {
//     for (var i = 0; i < array.length; i++) {
//         if (!test(array[i], i, array)) {
//             return false;
//         }
//     }
//     return true;
// }
// function encodeParamsObject(data) {
//     return mapObject(data, function (value) {
//         if (typeof value === 'object') {
//             value = safeJSONStringify(value);
//         }
//         return encodeURIComponent(encode(value.toString()));
//     });
// }
// function buildQueryString(data) {
//     var params = filterObject(data, function (value) {
//         return value !== undefined;
//     });
//     var query = map(flatten(encodeParamsObject(params)), util.method('join', '=')).join('&');
//     return query;
// }
// function decycleObject(object) {
//     var objects = [], paths = [];
//     return (function derez(value, path) {
//         var i, name, nu;
//         switch (typeof value) {
//             case 'object':
//                 if (!value) {
//                     return null;
//                 }
//                 for (i = 0; i < objects.length; i += 1) {
//                     if (objects[i] === value) {
//                         return { $ref: paths[i] };
//                     }
//                 }
//                 objects.push(value);
//                 paths.push(path);
//                 if (Object.prototype.toString.apply(value) === '[object Array]') {
//                     nu = [];
//                     for (i = 0; i < value.length; i += 1) {
//                         nu[i] = derez(value[i], path + '[' + i + ']');
//                     }
//                 }
//                 else {
//                     nu = {};
//                     for (name in value) {
//                         if (Object.prototype.hasOwnProperty.call(value, name)) {
//                             nu[name] = derez(value[name], path + '[' + JSON.stringify(name) + ']');
//                         }
//                     }
//                 }
//                 return nu;
//             case 'number':
//             case 'string':
//             case 'boolean':
//                 return value;
//         }
//     })(object, '$');
// }
// function safeJSONStringify(source) {
//     try {
//         return JSON.stringify(source);
//     }
//     catch (e) {
//         return JSON.stringify(decycleObject(source));
//     }
// }

// // CONCATENATED MODULE: ./src/core/logger.ts


// class logger_Logger {
//     constructor() {
//         this.globalLog = (message) => {
//             if (window.console && window.console.log) {
//                 window.console.log(message);
//             }
//         };
//     }
//     debug(...args) {
//         this.log(this.globalLog, args);
//     }
//     warn(...args) {
//         this.log(this.globalLogWarn, args);
//     }
//     error(...args) {
//         this.log(this.globalLogError, args);
//     }
//     globalLogWarn(message) {
//         if (window.console && window.console.warn) {
//             window.console.warn(message);
//         }
//         else {
//             this.globalLog(message);
//         }
//     }
//     globalLogError(message) {
//         if (window.console && window.console.error) {
//             window.console.error(message);
//         }
//         else {
//             this.globalLogWarn(message);
//         }
//     }
//     log(defaultLoggingFunction, ...args) {
//         var message = stringify.apply(this, arguments);
//         if (core_pusher.log) {
//             core_pusher.log(message);
//         }
//         else if (core_pusher.logToConsole) {
//             const log = defaultLoggingFunction.bind(this);
//             log(message);
//         }
//     }
// }
// /* harmony default export */ var logger = (new logger_Logger());

// // CONCATENATED MODULE: ./src/runtimes/web/auth/jsonp_auth.ts

// var jsonp = function (context, query, authOptions, authRequestType, callback) {
//     if (authOptions.headers !== undefined ||
//         authOptions.headersProvider != null) {
//         logger.warn(`To send headers with the ${authRequestType.toString()} request, you must use AJAX, rather than JSONP.`);
//     }
//     var callbackName = context.nextAuthCallbackID.toString();
//     context.nextAuthCallbackID++;
//     var document = context.getDocument();
//     var script = document.createElement('script');
//     context.auth_callbacks[callbackName] = function (data) {
//         callback(null, data);
//     };
//     var callback_name = "Pusher.auth_callbacks['" + callbackName + "']";
//     script.src =
//         authOptions.endpoint +
//             '?callback=' +
//             encodeURIComponent(callback_name) +
//             '&' +
//             query;
//     var head = document.getElementsByTagName('head')[0] || document.documentElement;
//     head.insertBefore(script, head.firstChild);
// };
// /* harmony default export */ var jsonp_auth = (jsonp);

// // CONCATENATED MODULE: ./src/runtimes/web/dom/script_request.ts
// class ScriptRequest {
//     constructor(src) {
//         this.src = src;
//     }
//     send(receiver) {
//         var self = this;
//         var errorString = 'Error loading ' + self.src;
//         self.script = document.createElement('script');
//         self.script.id = receiver.id;
//         self.script.src = self.src;
//         self.script.type = 'text/javascript';
//         self.script.charset = 'UTF-8';
//         if (self.script.addEventListener) {
//             self.script.onerror = function () {
//                 receiver.callback(errorString);
//             };
//             self.script.onload = function () {
//                 receiver.callback(null);
//             };
//         }
//         else {
//             self.script.onreadystatechange = function () {
//                 if (self.script.readyState === 'loaded' ||
//                     self.script.readyState === 'complete') {
//                     receiver.callback(null);
//                 }
//             };
//         }
//         if (self.script.async === undefined &&
//             document.attachEvent &&
//             /opera/i.test(navigator.userAgent)) {
//             self.errorScript = document.createElement('script');
//             self.errorScript.id = receiver.id + '_error';
//             self.errorScript.text = receiver.name + "('" + errorString + "');";
//             self.script.async = self.errorScript.async = false;
//         }
//         else {
//             self.script.async = true;
//         }
//         var head = document.getElementsByTagName('head')[0];
//         head.insertBefore(self.script, head.firstChild);
//         if (self.errorScript) {
//             head.insertBefore(self.errorScript, self.script.nextSibling);
//         }
//     }
//     cleanup() {
//         if (this.script) {
//             this.script.onload = this.script.onerror = null;
//             this.script.onreadystatechange = null;
//         }
//         if (this.script && this.script.parentNode) {
//             this.script.parentNode.removeChild(this.script);
//         }
//         if (this.errorScript && this.errorScript.parentNode) {
//             this.errorScript.parentNode.removeChild(this.errorScript);
//         }
//         this.script = null;
//         this.errorScript = null;
//     }
// }

// // CONCATENATED MODULE: ./src/runtimes/web/dom/jsonp_request.ts


// class jsonp_request_JSONPRequest {
//     constructor(url, data) {
//         this.url = url;
//         this.data = data;
//     }
//     send(receiver) {
//         if (this.request) {
//             return;
//         }
//         var query = buildQueryString(this.data);
//         var url = this.url + '/' + receiver.number + '?' + query;
//         this.request = runtime.createScriptRequest(url);
//         this.request.send(receiver);
//     }
//     cleanup() {
//         if (this.request) {
//             this.request.cleanup();
//         }
//     }
// }

// // CONCATENATED MODULE: ./src/runtimes/web/timeline/jsonp_timeline.ts


// var getAgent = function (sender, useTLS) {
//     return function (data, callback) {
//         var scheme = 'http' + (useTLS ? 's' : '') + '://';
//         var url = scheme + (sender.host || sender.options.host) + sender.options.path;
//         var request = runtime.createJSONPRequest(url, data);
//         var receiver = runtime.ScriptReceivers.create(function (error, result) {
//             ScriptReceivers.remove(receiver);
//             request.cleanup();
//             if (result && result.host) {
//                 sender.host = result.host;
//             }
//             if (callback) {
//                 callback(error, result);
//             }
//         });
//         request.send(receiver);
//     };
// };
// var jsonp_timeline_jsonp = {
//     name: 'jsonp',
//     getAgent
// };
// /* harmony default export */ var jsonp_timeline = (jsonp_timeline_jsonp);

// // CONCATENATED MODULE: ./src/core/transports/url_schemes.ts

// function getGenericURL(baseScheme, params, path) {
//     var scheme = baseScheme + (params.useTLS ? 's' : '');
//     var host = params.useTLS ? params.hostTLS : params.hostNonTLS;
//     return scheme + '://' + host + path;
// }
// function getGenericPath(key, queryString) {
//     var path = '/app/' + key;
//     var query = '?protocol=' +
//         defaults.PROTOCOL +
//         '&client=js' +
//         '&version=' +
//         defaults.VERSION +
//         (queryString ? '&' + queryString : '');
//     return path + query;
// }
// var ws = {
//     getInitial: function (key, params) {
//         var path = (params.httpPath || '') + getGenericPath(key, 'flash=false');
//         return getGenericURL('ws', params, path);
//     }
// };
// var http = {
//     getInitial: function (key, params) {
//         var path = (params.httpPath || '/pusher') + getGenericPath(key);
//         return getGenericURL('http', params, path);
//     }
// };
// var sockjs = {
//     getInitial: function (key, params) {
//         return getGenericURL('http', params, params.httpPath || '/pusher');
//     },
//     getPath: function (key, params) {
//         return getGenericPath(key);
//     }
// };

// // CONCATENATED MODULE: ./src/core/events/callback_registry.ts

// class callback_registry_CallbackRegistry {
//     constructor() {
//         this._callbacks = {};
//     }
//     get(name) {
//         return this._callbacks[prefix(name)];
//     }
//     add(name, callback, context) {
//         var prefixedEventName = prefix(name);
//         this._callbacks[prefixedEventName] =
//             this._callbacks[prefixedEventName] || [];
//         this._callbacks[prefixedEventName].push({
//             fn: callback,
//             context: context
//         });
//     }
//     remove(name, callback, context) {
//         if (!name && !callback && !context) {
//             this._callbacks = {};
//             return;
//         }
//         var names = name ? [prefix(name)] : keys(this._callbacks);
//         if (callback || context) {
//             this.removeCallback(names, callback, context);
//         }
//         else {
//             this.removeAllCallbacks(names);
//         }
//     }
//     removeCallback(names, callback, context) {
//         apply(names, function (name) {
//             this._callbacks[name] = filter(this._callbacks[name] || [], function (binding) {
//                 return ((callback && callback !== binding.fn) ||
//                     (context && context !== binding.context));
//             });
//             if (this._callbacks[name].length === 0) {
//                 delete this._callbacks[name];
//             }
//         }, this);
//     }
//     removeAllCallbacks(names) {
//         apply(names, function (name) {
//             delete this._callbacks[name];
//         }, this);
//     }
// }
// function prefix(name) {
//     return '_' + name;
// }

// // CONCATENATED MODULE: ./src/core/events/dispatcher.ts


// class dispatcher_Dispatcher {
//     constructor(failThrough) {
//         this.callbacks = new callback_registry_CallbackRegistry();
//         this.global_callbacks = [];
//         this.failThrough = failThrough;
//     }
//     bind(eventName, callback, context) {
//         this.callbacks.add(eventName, callback, context);
//         return this;
//     }
//     bind_global(callback) {
//         this.global_callbacks.push(callback);
//         return this;
//     }
//     unbind(eventName, callback, context) {
//         this.callbacks.remove(eventName, callback, context);
//         return this;
//     }
//     unbind_global(callback) {
//         if (!callback) {
//             this.global_callbacks = [];
//             return this;
//         }
//         this.global_callbacks = filter(this.global_callbacks || [], c => c !== callback);
//         return this;
//     }
//     unbind_all() {
//         this.unbind();
//         this.unbind_global();
//         return this;
//     }
//     emit(eventName, data, metadata) {
//         for (var i = 0; i < this.global_callbacks.length; i++) {
//             this.global_callbacks[i](eventName, data);
//         }
//         var callbacks = this.callbacks.get(eventName);
//         var args = [];
//         if (metadata) {
//             args.push(data, metadata);
//         }
//         else if (data) {
//             args.push(data);
//         }
//         if (callbacks && callbacks.length > 0) {
//             for (var i = 0; i < callbacks.length; i++) {
//                 callbacks[i].fn.apply(callbacks[i].context || window, args);
//             }
//         }
//         else if (this.failThrough) {
//             this.failThrough(eventName, data);
//         }
//         return this;
//     }
// }

// // CONCATENATED MODULE: ./src/core/transports/transport_connection.ts





// class transport_connection_TransportConnection extends dispatcher_Dispatcher {
//     constructor(hooks, name, priority, key, options) {
//         super();
//         this.initialize = runtime.transportConnectionInitializer;
//         this.hooks = hooks;
//         this.name = name;
//         this.priority = priority;
//         this.key = key;
//         this.options = options;
//         this.state = 'new';
//         this.timeline = options.timeline;
//         this.activityTimeout = options.activityTimeout;
//         this.id = this.timeline.generateUniqueID();
//     }
//     handlesActivityChecks() {
//         return Boolean(this.hooks.handlesActivityChecks);
//     }
//     supportsPing() {
//         return Boolean(this.hooks.supportsPing);
//     }
//     connect() {
//         if (this.socket || this.state !== 'initialized') {
//             return false;
//         }
//         var url = this.hooks.urls.getInitial(this.key, this.options);
//         try {
//             this.socket = this.hooks.getSocket(url, this.options);
//         }
//         catch (e) {
//             util.defer(() => {
//                 this.onError(e);
//                 this.changeState('closed');
//             });
//             return false;
//         }
//         this.bindListeners();
//         logger.debug('Connecting', { transport: this.name, url });
//         this.changeState('connecting');
//         return true;
//     }
//     close() {
//         if (this.socket) {
//             this.socket.close();
//             return true;
//         }
//         else {
//             return false;
//         }
//     }
//     send(data) {
//         if (this.state === 'open') {
//             util.defer(() => {
//                 if (this.socket) {
//                     this.socket.send(data);
//                 }
//             });
//             return true;
//         }
//         else {
//             return false;
//         }
//     }
//     ping() {
//         if (this.state === 'open' && this.supportsPing()) {
//             this.socket.ping();
//         }
//     }
//     onOpen() {
//         if (this.hooks.beforeOpen) {
//             this.hooks.beforeOpen(this.socket, this.hooks.urls.getPath(this.key, this.options));
//         }
//         this.changeState('open');
//         this.socket.onopen = undefined;
//     }
//     onError(error) {
//         this.emit('error', { type: 'WebSocketError', error: error });
//         this.timeline.error(this.buildTimelineMessage({ error: error.toString() }));
//     }
//     onClose(closeEvent) {
//         if (closeEvent) {
//             this.changeState('closed', {
//                 code: closeEvent.code,
//                 reason: closeEvent.reason,
//                 wasClean: closeEvent.wasClean
//             });
//         }
//         else {
//             this.changeState('closed');
//         }
//         this.unbindListeners();
//         this.socket = undefined;
//     }
//     onMessage(message) {
//         this.emit('message', message);
//     }
//     onActivity() {
//         this.emit('activity');
//     }
//     bindListeners() {
//         this.socket.onopen = () => {
//             this.onOpen();
//         };
//         this.socket.onerror = error => {
//             this.onError(error);
//         };
//         this.socket.onclose = closeEvent => {
//             this.onClose(closeEvent);
//         };
//         this.socket.onmessage = message => {
//             this.onMessage(message);
//         };
//         if (this.supportsPing()) {
//             this.socket.onactivity = () => {
//                 this.onActivity();
//             };
//         }
//     }
//     unbindListeners() {
//         if (this.socket) {
//             this.socket.onopen = undefined;
//             this.socket.onerror = undefined;
//             this.socket.onclose = undefined;
//             this.socket.onmessage = undefined;
//             if (this.supportsPing()) {
//                 this.socket.onactivity = undefined;
//             }
//         }
//     }
//     changeState(state, params) {
//         this.state = state;
//         this.timeline.info(this.buildTimelineMessage({
//             state: state,
//             params: params
//         }));
//         this.emit(state, params);
//     }
//     buildTimelineMessage(message) {
//         return extend({ cid: this.id }, message);
//     }
// }

// // CONCATENATED MODULE: ./src/core/transports/transport.ts

// class transport_Transport {
//     constructor(hooks) {
//         this.hooks = hooks;
//     }
//     isSupported(environment) {
//         return this.hooks.isSupported(environment);
//     }
//     createConnection(name, priority, key, options) {
//         return new transport_connection_TransportConnection(this.hooks, name, priority, key, options);
//     }
// }

// // CONCATENATED MODULE: ./src/runtimes/isomorphic/transports/transports.ts




// var WSTransport = new transport_Transport({
//     urls: ws,
//     handlesActivityChecks: false,
//     supportsPing: false,
//     isInitialized: function () {
//         return Boolean(runtime.getWebSocketAPI());
//     },
//     isSupported: function () {
//         return Boolean(runtime.getWebSocketAPI());
//     },
//     getSocket: function (url) {
//         return runtime.createWebSocket(url);
//     }
// });
// var httpConfiguration = {
//     urls: http,
//     handlesActivityChecks: false,
//     supportsPing: true,
//     isInitialized: function () {
//         return true;
//     }
// };
// var streamingConfiguration = extend({
//     getSocket: function (url) {
//         return runtime.HTTPFactory.createStreamingSocket(url);
//     }
// }, httpConfiguration);
// var pollingConfiguration = extend({
//     getSocket: function (url) {
//         return runtime.HTTPFactory.createPollingSocket(url);
//     }
// }, httpConfiguration);
// var xhrConfiguration = {
//     isSupported: function () {
//         return runtime.isXHRSupported();
//     }
// };
// var XHRStreamingTransport = new transport_Transport((extend({}, streamingConfiguration, xhrConfiguration)));
// var XHRPollingTransport = new transport_Transport(extend({}, pollingConfiguration, xhrConfiguration));
// var Transports = {
//     ws: WSTransport,
//     xhr_streaming: XHRStreamingTransport,
//     xhr_polling: XHRPollingTransport
// };
// /* harmony default export */ var transports = (Transports);

// // CONCATENATED MODULE: ./src/runtimes/web/transports/transports.ts






// var SockJSTransport = new transport_Transport({
//     file: 'sockjs',
//     urls: sockjs,
//     handlesActivityChecks: true,
//     supportsPing: false,
//     isSupported: function () {
//         return true;
//     },
//     isInitialized: function () {
//         return window.SockJS !== undefined;
//     },
//     getSocket: function (url, options) {
//         return new window.SockJS(url, null, {
//             js_path: Dependencies.getPath('sockjs', {
//                 useTLS: options.useTLS
//             }),
//             ignore_null_origin: options.ignoreNullOrigin
//         });
//     },
//     beforeOpen: function (socket, path) {
//         socket.send(JSON.stringify({
//             path: path
//         }));
//     }
// });
// var xdrConfiguration = {
//     isSupported: function (environment) {
//         var yes = runtime.isXDRSupported(environment.useTLS);
//         return yes;
//     }
// };
// var XDRStreamingTransport = new transport_Transport((extend({}, streamingConfiguration, xdrConfiguration)));
// var XDRPollingTransport = new transport_Transport(extend({}, pollingConfiguration, xdrConfiguration));
// transports.xdr_streaming = XDRStreamingTransport;
// transports.xdr_polling = XDRPollingTransport;
// transports.sockjs = SockJSTransport;
// /* harmony default export */ var transports_transports = (transports);

// // CONCATENATED MODULE: ./src/runtimes/web/net_info.ts

// class net_info_NetInfo extends dispatcher_Dispatcher {
//     constructor() {
//         super();
//         var self = this;
//         if (window.addEventListener !== undefined) {
//             window.addEventListener('online', function () {
//                 self.emit('online');
//             }, false);
//             window.addEventListener('offline', function () {
//                 self.emit('offline');
//             }, false);
//         }
//     }
//     isOnline() {
//         if (window.navigator.onLine === undefined) {
//             return true;
//         }
//         else {
//             return window.navigator.onLine;
//         }
//     }
// }
// var net_info_Network = new net_info_NetInfo();

// // CONCATENATED MODULE: ./src/core/transports/assistant_to_the_transport_manager.ts


// class assistant_to_the_transport_manager_AssistantToTheTransportManager {
//     constructor(manager, transport, options) {
//         this.manager = manager;
//         this.transport = transport;
//         this.minPingDelay = options.minPingDelay;
//         this.maxPingDelay = options.maxPingDelay;
//         this.pingDelay = undefined;
//     }
//     createConnection(name, priority, key, options) {
//         options = extend({}, options, {
//             activityTimeout: this.pingDelay
//         });
//         var connection = this.transport.createConnection(name, priority, key, options);
//         var openTimestamp = null;
//         var onOpen = function () {
//             connection.unbind('open', onOpen);
//             connection.bind('closed', onClosed);
//             openTimestamp = util.now();
//         };
//         var onClosed = closeEvent => {
//             connection.unbind('closed', onClosed);
//             if (closeEvent.code === 1002 || closeEvent.code === 1003) {
//                 this.manager.reportDeath();
//             }
//             else if (!closeEvent.wasClean && openTimestamp) {
//                 var lifespan = util.now() - openTimestamp;
//                 if (lifespan < 2 * this.maxPingDelay) {
//                     this.manager.reportDeath();
//                     this.pingDelay = Math.max(lifespan / 2, this.minPingDelay);
//                 }
//             }
//         };
//         connection.bind('open', onOpen);
//         return connection;
//     }
//     isSupported(environment) {
//         return this.manager.isAlive() && this.transport.isSupported(environment);
//     }
// }

// // CONCATENATED MODULE: ./src/core/connection/protocol/protocol.ts
// const Protocol = {
//     decodeMessage: function (messageEvent) {
//         try {
//             var messageData = JSON.parse(messageEvent.data);
//             var pusherEventData = messageData.data;
//             if (typeof pusherEventData === 'string') {
//                 try {
//                     pusherEventData = JSON.parse(messageData.data);
//                 }
//                 catch (e) { }
//             }
//             var pusherEvent = {
//                 event: messageData.event,
//                 channel: messageData.channel,
//                 data: pusherEventData
//             };
//             if (messageData.user_id) {
//                 pusherEvent.user_id = messageData.user_id;
//             }
//             return pusherEvent;
//         }
//         catch (e) {
//             throw { type: 'MessageParseError', error: e, data: messageEvent.data };
//         }
//     },
//     encodeMessage: function (event) {
//         return JSON.stringify(event);
//     },
//     processHandshake: function (messageEvent) {
//         var message = Protocol.decodeMessage(messageEvent);
//         if (message.event === 'pusher:connection_established') {
//             if (!message.data.activity_timeout) {
//                 throw 'No activity timeout specified in handshake';
//             }
//             return {
//                 action: 'connected',
//                 id: message.data.socket_id,
//                 activityTimeout: message.data.activity_timeout * 1000
//             };
//         }
//         else if (message.event === 'pusher:error') {
//             return {
//                 action: this.getCloseAction(message.data),
//                 error: this.getCloseError(message.data)
//             };
//         }
//         else {
//             throw 'Invalid handshake';
//         }
//     },
//     getCloseAction: function (closeEvent) {
//         if (closeEvent.code < 4000) {
//             if (closeEvent.code >= 1002 && closeEvent.code <= 1004) {
//                 return 'backoff';
//             }
//             else {
//                 return null;
//             }
//         }
//         else if (closeEvent.code === 4000) {
//             return 'tls_only';
//         }
//         else if (closeEvent.code < 4100) {
//             return 'refused';
//         }
//         else if (closeEvent.code < 4200) {
//             return 'backoff';
//         }
//         else if (closeEvent.code < 4300) {
//             return 'retry';
//         }
//         else {
//             return 'refused';
//         }
//     },
//     getCloseError: function (closeEvent) {
//         if (closeEvent.code !== 1000 && closeEvent.code !== 1001) {
//             return {
//                 type: 'PusherError',
//                 data: {
//                     code: closeEvent.code,
//                     message: closeEvent.reason || closeEvent.message
//                 }
//             };
//         }
//         else {
//             return null;
//         }
//     }
// };
// /* harmony default export */ var protocol_protocol = (Protocol);

// // CONCATENATED MODULE: ./src/core/connection/connection.ts




// class connection_Connection extends dispatcher_Dispatcher {
//     constructor(id, transport) {
//         super();
//         this.id = id;
//         this.transport = transport;
//         this.activityTimeout = transport.activityTimeout;
//         this.bindListeners();
//     }
//     handlesActivityChecks() {
//         return this.transport.handlesActivityChecks();
//     }
//     send(data) {
//         return this.transport.send(data);
//     }
//     send_event(name, data, channel) {
//         var event = { event: name, data: data };
//         if (channel) {
//             event.channel = channel;
//         }
//         logger.debug('Event sent', event);
//         return this.send(protocol_protocol.encodeMessage(event));
//     }
//     ping() {
//         if (this.transport.supportsPing()) {
//             this.transport.ping();
//         }
//         else {
//             this.send_event('pusher:ping', {});
//         }
//     }
//     close() {
//         this.transport.close();
//     }
//     bindListeners() {
//         var listeners = {
//             message: (messageEvent) => {
//                 var pusherEvent;
//                 try {
//                     pusherEvent = protocol_protocol.decodeMessage(messageEvent);
//                 }
//                 catch (e) {
//                     this.emit('error', {
//                         type: 'MessageParseError',
//                         error: e,
//                         data: messageEvent.data
//                     });
//                 }
//                 if (pusherEvent !== undefined) {
//                     logger.debug('Event recd', pusherEvent);
//                     switch (pusherEvent.event) {
//                         case 'pusher:error':
//                             this.emit('error', {
//                                 type: 'PusherError',
//                                 data: pusherEvent.data
//                             });
//                             break;
//                         case 'pusher:ping':
//                             this.emit('ping');
//                             break;
//                         case 'pusher:pong':
//                             this.emit('pong');
//                             break;
//                     }
//                     this.emit('message', pusherEvent);
//                 }
//             },
//             activity: () => {
//                 this.emit('activity');
//             },
//             error: error => {
//                 this.emit('error', error);
//             },
//             closed: closeEvent => {
//                 unbindListeners();
//                 if (closeEvent && closeEvent.code) {
//                     this.handleCloseEvent(closeEvent);
//                 }
//                 this.transport = null;
//                 this.emit('closed');
//             }
//         };
//         var unbindListeners = () => {
//             objectApply(listeners, (listener, event) => {
//                 this.transport.unbind(event, listener);
//             });
//         };
//         objectApply(listeners, (listener, event) => {
//             this.transport.bind(event, listener);
//         });
//     }
//     handleCloseEvent(closeEvent) {
//         var action = protocol_protocol.getCloseAction(closeEvent);
//         var error = protocol_protocol.getCloseError(closeEvent);
//         if (error) {
//             this.emit('error', error);
//         }
//         if (action) {
//             this.emit(action, { action: action, error: error });
//         }
//     }
// }

// // CONCATENATED MODULE: ./src/core/connection/handshake/index.ts



// class handshake_Handshake {
//     constructor(transport, callback) {
//         this.transport = transport;
//         this.callback = callback;
//         this.bindListeners();
//     }
//     close() {
//         this.unbindListeners();
//         this.transport.close();
//     }
//     bindListeners() {
//         this.onMessage = m => {
//             this.unbindListeners();
//             var result;
//             try {
//                 result = protocol_protocol.processHandshake(m);
//             }
//             catch (e) {
//                 this.finish('error', { error: e });
//                 this.transport.close();
//                 return;
//             }
//             if (result.action === 'connected') {
//                 this.finish('connected', {
//                     connection: new connection_Connection(result.id, this.transport),
//                     activityTimeout: result.activityTimeout
//                 });
//             }
//             else {
//                 this.finish(result.action, { error: result.error });
//                 this.transport.close();
//             }
//         };
//         this.onClosed = closeEvent => {
//             this.unbindListeners();
//             var action = protocol_protocol.getCloseAction(closeEvent) || 'backoff';
//             var error = protocol_protocol.getCloseError(closeEvent);
//             this.finish(action, { error: error });
//         };
//         this.transport.bind('message', this.onMessage);
//         this.transport.bind('closed', this.onClosed);
//     }
//     unbindListeners() {
//         this.transport.unbind('message', this.onMessage);
//         this.transport.unbind('closed', this.onClosed);
//     }
//     finish(action, params) {
//         this.callback(extend({ transport: this.transport, action: action }, params));
//     }
// }

// // CONCATENATED MODULE: ./src/core/timeline/timeline_sender.ts

// class timeline_sender_TimelineSender {
//     constructor(timeline, options) {
//         this.timeline = timeline;
//         this.options = options || {};
//     }
//     send(useTLS, callback) {
//         if (this.timeline.isEmpty()) {
//             return;
//         }
//         this.timeline.send(runtime.TimelineTransport.getAgent(this, useTLS), callback);
//     }
// }

// // CONCATENATED MODULE: ./src/core/channels/channel.ts





// class channel_Channel extends dispatcher_Dispatcher {
//     constructor(name, pusher) {
//         super(function (event, data) {
//             logger.debug('No callbacks on ' + name + ' for ' + event);
//         });
//         this.name = name;
//         this.pusher = pusher;
//         this.subscribed = false;
//         this.subscriptionPending = false;
//         this.subscriptionCancelled = false;
//     }
//     authorize(socketId, callback) {
//         return callback(null, { auth: '' });
//     }
//     trigger(event, data) {
//         if (event.indexOf('client-') !== 0) {
//             throw new BadEventName("Event '" + event + "' does not start with 'client-'");
//         }
//         if (!this.subscribed) {
//             var suffix = url_store.buildLogSuffix('triggeringClientEvents');
//             logger.warn(`Client event triggered before channel 'subscription_succeeded' event . ${suffix}`);
//         }
//         return this.pusher.send_event(event, data, this.name);
//     }
//     disconnect() {
//         this.subscribed = false;
//         this.subscriptionPending = false;
//     }
//     handleEvent(event) {
//         var eventName = event.event;
//         var data = event.data;
//         if (eventName === 'pusher_internal:subscription_succeeded') {
//             this.handleSubscriptionSucceededEvent(event);
//         }
//         else if (eventName === 'pusher_internal:subscription_count') {
//             this.handleSubscriptionCountEvent(event);
//         }
//         else if (eventName.indexOf('pusher_internal:') !== 0) {
//             var metadata = {};
//             this.emit(eventName, data, metadata);
//         }
//     }
//     handleSubscriptionSucceededEvent(event) {
//         this.subscriptionPending = false;
//         this.subscribed = true;
//         if (this.subscriptionCancelled) {
//             this.pusher.unsubscribe(this.name);
//         }
//         else {
//             this.emit('pusher:subscription_succeeded', event.data);
//         }
//     }
//     handleSubscriptionCountEvent(event) {
//         if (event.data.subscription_count) {
//             this.subscriptionCount = event.data.subscription_count;
//         }
//         this.emit('pusher:subscription_count', event.data);
//     }
//     subscribe() {
//         if (this.subscribed) {
//             return;
//         }
//         this.subscriptionPending = true;
//         this.subscriptionCancelled = false;
//         this.authorize(this.pusher.connection.socket_id, (error, data) => {
//             if (error) {
//                 this.subscriptionPending = false;
//                 logger.error(error.toString());
//                 this.emit('pusher:subscription_error', Object.assign({}, {
//                     type: 'AuthError',
//                     error: error.message
//                 }, error instanceof HTTPAuthError ? { status: error.status } : {}));
//             }
//             else {
//                 this.pusher.send_event('pusher:subscribe', {
//                     auth: data.auth,
//                     channel_data: data.channel_data,
//                     channel: this.name
//                 });
//             }
//         });
//     }
//     unsubscribe() {
//         this.subscribed = false;
//         this.pusher.send_event('pusher:unsubscribe', {
//             channel: this.name
//         });
//     }
//     cancelSubscription() {
//         this.subscriptionCancelled = true;
//     }
//     reinstateSubscription() {
//         this.subscriptionCancelled = false;
//     }
// }

// // CONCATENATED MODULE: ./src/core/channels/private_channel.ts

// class private_channel_PrivateChannel extends channel_Channel {
//     authorize(socketId, callback) {
//         return this.pusher.config.channelAuthorizer({
//             channelName: this.name,
//             socketId: socketId
//         }, callback);
//     }
// }

// // CONCATENATED MODULE: ./src/core/channels/members.ts

// class members_Members {
//     constructor() {
//         this.reset();
//     }
//     get(id) {
//         if (Object.prototype.hasOwnProperty.call(this.members, id)) {
//             return {
//                 id: id,
//                 info: this.members[id]
//             };
//         }
//         else {
//             return null;
//         }
//     }
//     each(callback) {
//         objectApply(this.members, (member, id) => {
//             callback(this.get(id));
//         });
//     }
//     setMyID(id) {
//         this.myID = id;
//     }
//     onSubscription(subscriptionData) {
//         this.members = subscriptionData.presence.hash;
//         this.count = subscriptionData.presence.count;
//         this.me = this.get(this.myID);
//     }
//     addMember(memberData) {
//         if (this.get(memberData.user_id) === null) {
//             this.count++;
//         }
//         this.members[memberData.user_id] = memberData.user_info;
//         return this.get(memberData.user_id);
//     }
//     removeMember(memberData) {
//         var member = this.get(memberData.user_id);
//         if (member) {
//             delete this.members[memberData.user_id];
//             this.count--;
//         }
//         return member;
//     }
//     reset() {
//         this.members = {};
//         this.count = 0;
//         this.myID = null;
//         this.me = null;
//     }
// }

// // CONCATENATED MODULE: ./src/core/channels/presence_channel.ts
// var __awaiter = ( false) || function (thisArg, _arguments, P, generator) {
//     function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
//     return new (P || (P = Promise))(function (resolve, reject) {
//         function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
//         function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
//         function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
//         step((generator = generator.apply(thisArg, _arguments || [])).next());
//     });
// };




// class presence_channel_PresenceChannel extends private_channel_PrivateChannel {
//     constructor(name, pusher) {
//         super(name, pusher);
//         this.members = new members_Members();
//     }
//     authorize(socketId, callback) {
//         super.authorize(socketId, (error, authData) => __awaiter(this, void 0, void 0, function* () {
//             if (!error) {
//                 authData = authData;
//                 if (authData.channel_data != null) {
//                     var channelData = JSON.parse(authData.channel_data);
//                     this.members.setMyID(channelData.user_id);
//                 }
//                 else {
//                     yield this.pusher.user.signinDonePromise;
//                     if (this.pusher.user.user_data != null) {
//                         this.members.setMyID(this.pusher.user.user_data.id);
//                     }
//                     else {
//                         let suffix = url_store.buildLogSuffix('authorizationEndpoint');
//                         logger.error(`Invalid auth response for channel '${this.name}', ` +
//                             `expected 'channel_data' field. ${suffix}, ` +
//                             `or the user should be signed in.`);
//                         callback('Invalid auth response');
//                         return;
//                     }
//                 }
//             }
//             callback(error, authData);
//         }));
//     }
//     handleEvent(event) {
//         var eventName = event.event;
//         if (eventName.indexOf('pusher_internal:') === 0) {
//             this.handleInternalEvent(event);
//         }
//         else {
//             var data = event.data;
//             var metadata = {};
//             if (event.user_id) {
//                 metadata.user_id = event.user_id;
//             }
//             this.emit(eventName, data, metadata);
//         }
//     }
//     handleInternalEvent(event) {
//         var eventName = event.event;
//         var data = event.data;
//         switch (eventName) {
//             case 'pusher_internal:subscription_succeeded':
//                 this.handleSubscriptionSucceededEvent(event);
//                 break;
//             case 'pusher_internal:subscription_count':
//                 this.handleSubscriptionCountEvent(event);
//                 break;
//             case 'pusher_internal:member_added':
//                 var addedMember = this.members.addMember(data);
//                 this.emit('pusher:member_added', addedMember);
//                 break;
//             case 'pusher_internal:member_removed':
//                 var removedMember = this.members.removeMember(data);
//                 if (removedMember) {
//                     this.emit('pusher:member_removed', removedMember);
//                 }
//                 break;
//         }
//     }
//     handleSubscriptionSucceededEvent(event) {
//         this.subscriptionPending = false;
//         this.subscribed = true;
//         if (this.subscriptionCancelled) {
//             this.pusher.unsubscribe(this.name);
//         }
//         else {
//             this.members.onSubscription(event.data);
//             this.emit('pusher:subscription_succeeded', this.members);
//         }
//     }
//     disconnect() {
//         this.members.reset();
//         super.disconnect();
//     }
// }

// // EXTERNAL MODULE: ./node_modules/@stablelib/utf8/lib/utf8.js
// var utf8 = __nested_webpack_require_20109__(1);

// // EXTERNAL MODULE: ./node_modules/@stablelib/base64/lib/base64.js
// var base64 = __nested_webpack_require_20109__(0);

// // CONCATENATED MODULE: ./src/core/channels/encrypted_channel.ts





// class encrypted_channel_EncryptedChannel extends private_channel_PrivateChannel {
//     constructor(name, pusher, nacl) {
//         super(name, pusher);
//         this.key = null;
//         this.nacl = nacl;
//     }
//     authorize(socketId, callback) {
//         super.authorize(socketId, (error, authData) => {
//             if (error) {
//                 callback(error, authData);
//                 return;
//             }
//             let sharedSecret = authData['shared_secret'];
//             if (!sharedSecret) {
//                 callback(new Error(`No shared_secret key in auth payload for encrypted channel: ${this.name}`), null);
//                 return;
//             }
//             this.key = Object(base64["decode"])(sharedSecret);
//             delete authData['shared_secret'];
//             callback(null, authData);
//         });
//     }
//     trigger(event, data) {
//         throw new UnsupportedFeature('Client events are not currently supported for encrypted channels');
//     }
//     handleEvent(event) {
//         var eventName = event.event;
//         var data = event.data;
//         if (eventName.indexOf('pusher_internal:') === 0 ||
//             eventName.indexOf('pusher:') === 0) {
//             super.handleEvent(event);
//             return;
//         }
//         this.handleEncryptedEvent(eventName, data);
//     }
//     handleEncryptedEvent(event, data) {
//         if (!this.key) {
//             logger.debug('Received encrypted event before key has been retrieved from the authEndpoint');
//             return;
//         }
//         if (!data.ciphertext || !data.nonce) {
//             logger.error('Unexpected format for encrypted event, expected object with `ciphertext` and `nonce` fields, got: ' +
//                 data);
//             return;
//         }
//         let cipherText = Object(base64["decode"])(data.ciphertext);
//         if (cipherText.length < this.nacl.secretbox.overheadLength) {
//             logger.error(`Expected encrypted event ciphertext length to be ${this.nacl.secretbox.overheadLength}, got: ${cipherText.length}`);
//             return;
//         }
//         let nonce = Object(base64["decode"])(data.nonce);
//         if (nonce.length < this.nacl.secretbox.nonceLength) {
//             logger.error(`Expected encrypted event nonce length to be ${this.nacl.secretbox.nonceLength}, got: ${nonce.length}`);
//             return;
//         }
//         let bytes = this.nacl.secretbox.open(cipherText, nonce, this.key);
//         if (bytes === null) {
//             logger.debug('Failed to decrypt an event, probably because it was encrypted with a different key. Fetching a new key from the authEndpoint...');
//             this.authorize(this.pusher.connection.socket_id, (error, authData) => {
//                 if (error) {
//                     logger.error(`Failed to make a request to the authEndpoint: ${authData}. Unable to fetch new key, so dropping encrypted event`);
//                     return;
//                 }
//                 bytes = this.nacl.secretbox.open(cipherText, nonce, this.key);
//                 if (bytes === null) {
//                     logger.error(`Failed to decrypt event with new key. Dropping encrypted event`);
//                     return;
//                 }
//                 this.emit(event, this.getDataToEmit(bytes));
//                 return;
//             });
//             return;
//         }
//         this.emit(event, this.getDataToEmit(bytes));
//     }
//     getDataToEmit(bytes) {
//         let raw = Object(utf8["decode"])(bytes);
//         try {
//             return JSON.parse(raw);
//         }
//         catch (_a) {
//             return raw;
//         }
//     }
// }

// // CONCATENATED MODULE: ./src/core/connection/connection_manager.ts





// class connection_manager_ConnectionManager extends dispatcher_Dispatcher {
//     constructor(key, options) {
//         super();
//         this.state = 'initialized';
//         this.connection = null;
//         this.key = key;
//         this.options = options;
//         this.timeline = this.options.timeline;
//         this.usingTLS = this.options.useTLS;
//         this.errorCallbacks = this.buildErrorCallbacks();
//         this.connectionCallbacks = this.buildConnectionCallbacks(this.errorCallbacks);
//         this.handshakeCallbacks = this.buildHandshakeCallbacks(this.errorCallbacks);
//         var Network = runtime.getNetwork();
//         Network.bind('online', () => {
//             this.timeline.info({ netinfo: 'online' });
//             if (this.state === 'connecting' || this.state === 'unavailable') {
//                 this.retryIn(0);
//             }
//         });
//         Network.bind('offline', () => {
//             this.timeline.info({ netinfo: 'offline' });
//             if (this.connection) {
//                 this.sendActivityCheck();
//             }
//         });
//         this.updateStrategy();
//     }
//     switchCluster(key) {
//         this.key = key;
//         this.updateStrategy();
//         this.retryIn(0);
//     }
//     connect() {
//         if (this.connection || this.runner) {
//             return;
//         }
//         if (!this.strategy.isSupported()) {
//             this.updateState('failed');
//             return;
//         }
//         this.updateState('connecting');
//         this.startConnecting();
//         this.setUnavailableTimer();
//     }
//     send(data) {
//         if (this.connection) {
//             return this.connection.send(data);
//         }
//         else {
//             return false;
//         }
//     }
//     send_event(name, data, channel) {
//         if (this.connection) {
//             return this.connection.send_event(name, data, channel);
//         }
//         else {
//             return false;
//         }
//     }
//     disconnect() {
//         this.disconnectInternally();
//         this.updateState('disconnected');
//     }
//     isUsingTLS() {
//         return this.usingTLS;
//     }
//     startConnecting() {
//         var callback = (error, handshake) => {
//             if (error) {
//                 this.runner = this.strategy.connect(0, callback);
//             }
//             else {
//                 if (handshake.action === 'error') {
//                     this.emit('error', {
//                         type: 'HandshakeError',
//                         error: handshake.error
//                     });
//                     this.timeline.error({ handshakeError: handshake.error });
//                 }
//                 else {
//                     this.abortConnecting();
//                     this.handshakeCallbacks[handshake.action](handshake);
//                 }
//             }
//         };
//         this.runner = this.strategy.connect(0, callback);
//     }
//     abortConnecting() {
//         if (this.runner) {
//             this.runner.abort();
//             this.runner = null;
//         }
//     }
//     disconnectInternally() {
//         this.abortConnecting();
//         this.clearRetryTimer();
//         this.clearUnavailableTimer();
//         if (this.connection) {
//             var connection = this.abandonConnection();
//             connection.close();
//         }
//     }
//     updateStrategy() {
//         this.strategy = this.options.getStrategy({
//             key: this.key,
//             timeline: this.timeline,
//             useTLS: this.usingTLS
//         });
//     }
//     retryIn(delay) {
//         this.timeline.info({ action: 'retry', delay: delay });
//         if (delay > 0) {
//             this.emit('connecting_in', Math.round(delay / 1000));
//         }
//         this.retryTimer = new timers_OneOffTimer(delay || 0, () => {
//             this.disconnectInternally();
//             this.connect();
//         });
//     }
//     clearRetryTimer() {
//         if (this.retryTimer) {
//             this.retryTimer.ensureAborted();
//             this.retryTimer = null;
//         }
//     }
//     setUnavailableTimer() {
//         this.unavailableTimer = new timers_OneOffTimer(this.options.unavailableTimeout, () => {
//             this.updateState('unavailable');
//         });
//     }
//     clearUnavailableTimer() {
//         if (this.unavailableTimer) {
//             this.unavailableTimer.ensureAborted();
//         }
//     }
//     sendActivityCheck() {
//         this.stopActivityCheck();
//         this.connection.ping();
//         this.activityTimer = new timers_OneOffTimer(this.options.pongTimeout, () => {
//             this.timeline.error({ pong_timed_out: this.options.pongTimeout });
//             this.retryIn(0);
//         });
//     }
//     resetActivityCheck() {
//         this.stopActivityCheck();
//         if (this.connection && !this.connection.handlesActivityChecks()) {
//             this.activityTimer = new timers_OneOffTimer(this.activityTimeout, () => {
//                 this.sendActivityCheck();
//             });
//         }
//     }
//     stopActivityCheck() {
//         if (this.activityTimer) {
//             this.activityTimer.ensureAborted();
//         }
//     }
//     buildConnectionCallbacks(errorCallbacks) {
//         return extend({}, errorCallbacks, {
//             message: message => {
//                 this.resetActivityCheck();
//                 this.emit('message', message);
//             },
//             ping: () => {
//                 this.send_event('pusher:pong', {});
//             },
//             activity: () => {
//                 this.resetActivityCheck();
//             },
//             error: error => {
//                 this.emit('error', error);
//             },
//             closed: () => {
//                 this.abandonConnection();
//                 if (this.shouldRetry()) {
//                     this.retryIn(1000);
//                 }
//             }
//         });
//     }
//     buildHandshakeCallbacks(errorCallbacks) {
//         return extend({}, errorCallbacks, {
//             connected: (handshake) => {
//                 this.activityTimeout = Math.min(this.options.activityTimeout, handshake.activityTimeout, handshake.connection.activityTimeout || Infinity);
//                 this.clearUnavailableTimer();
//                 this.setConnection(handshake.connection);
//                 this.socket_id = this.connection.id;
//                 this.updateState('connected', { socket_id: this.socket_id });
//             }
//         });
//     }
//     buildErrorCallbacks() {
//         let withErrorEmitted = callback => {
//             return (result) => {
//                 if (result.error) {
//                     this.emit('error', { type: 'WebSocketError', error: result.error });
//                 }
//                 callback(result);
//             };
//         };
//         return {
//             tls_only: withErrorEmitted(() => {
//                 this.usingTLS = true;
//                 this.updateStrategy();
//                 this.retryIn(0);
//             }),
//             refused: withErrorEmitted(() => {
//                 this.disconnect();
//             }),
//             backoff: withErrorEmitted(() => {
//                 this.retryIn(1000);
//             }),
//             retry: withErrorEmitted(() => {
//                 this.retryIn(0);
//             })
//         };
//     }
//     setConnection(connection) {
//         this.connection = connection;
//         for (var event in this.connectionCallbacks) {
//             this.connection.bind(event, this.connectionCallbacks[event]);
//         }
//         this.resetActivityCheck();
//     }
//     abandonConnection() {
//         if (!this.connection) {
//             return;
//         }
//         this.stopActivityCheck();
//         for (var event in this.connectionCallbacks) {
//             this.connection.unbind(event, this.connectionCallbacks[event]);
//         }
//         var connection = this.connection;
//         this.connection = null;
//         return connection;
//     }
//     updateState(newState, data) {
//         var previousState = this.state;
//         this.state = newState;
//         if (previousState !== newState) {
//             var newStateDescription = newState;
//             if (newStateDescription === 'connected') {
//                 newStateDescription += ' with new socket ID ' + data.socket_id;
//             }
//             logger.debug('State changed', previousState + ' -> ' + newStateDescription);
//             this.timeline.info({ state: newState, params: data });
//             this.emit('state_change', { previous: previousState, current: newState });
//             this.emit(newState, data);
//         }
//     }
//     shouldRetry() {
//         return this.state === 'connecting' || this.state === 'connected';
//     }
// }

// // CONCATENATED MODULE: ./src/core/channels/channels.ts




// class channels_Channels {
//     constructor() {
//         this.channels = {};
//     }
//     add(name, pusher) {
//         if (!this.channels[name]) {
//             this.channels[name] = createChannel(name, pusher);
//         }
//         return this.channels[name];
//     }
//     all() {
//         return values(this.channels);
//     }
//     find(name) {
//         return this.channels[name];
//     }
//     remove(name) {
//         var channel = this.channels[name];
//         delete this.channels[name];
//         return channel;
//     }
//     disconnect() {
//         objectApply(this.channels, function (channel) {
//             channel.disconnect();
//         });
//     }
// }
// function createChannel(name, pusher) {
//     if (name.indexOf('private-encrypted-') === 0) {
//         if (pusher.config.nacl) {
//             return factory.createEncryptedChannel(name, pusher, pusher.config.nacl);
//         }
//         let errMsg = 'Tried to subscribe to a private-encrypted- channel but no nacl implementation available';
//         let suffix = url_store.buildLogSuffix('encryptedChannelSupport');
//         throw new UnsupportedFeature(`${errMsg}. ${suffix}`);
//     }
//     else if (name.indexOf('private-') === 0) {
//         return factory.createPrivateChannel(name, pusher);
//     }
//     else if (name.indexOf('presence-') === 0) {
//         return factory.createPresenceChannel(name, pusher);
//     }
//     else if (name.indexOf('#') === 0) {
//         throw new BadChannelName('Cannot create a channel with name "' + name + '".');
//     }
//     else {
//         return factory.createChannel(name, pusher);
//     }
// }

// // CONCATENATED MODULE: ./src/core/utils/factory.ts









// var Factory = {
//     createChannels() {
//         return new channels_Channels();
//     },
//     createConnectionManager(key, options) {
//         return new connection_manager_ConnectionManager(key, options);
//     },
//     createChannel(name, pusher) {
//         return new channel_Channel(name, pusher);
//     },
//     createPrivateChannel(name, pusher) {
//         return new private_channel_PrivateChannel(name, pusher);
//     },
//     createPresenceChannel(name, pusher) {
//         return new presence_channel_PresenceChannel(name, pusher);
//     },
//     createEncryptedChannel(name, pusher, nacl) {
//         return new encrypted_channel_EncryptedChannel(name, pusher, nacl);
//     },
//     createTimelineSender(timeline, options) {
//         return new timeline_sender_TimelineSender(timeline, options);
//     },
//     createHandshake(transport, callback) {
//         return new handshake_Handshake(transport, callback);
//     },
//     createAssistantToTheTransportManager(manager, transport, options) {
//         return new assistant_to_the_transport_manager_AssistantToTheTransportManager(manager, transport, options);
//     }
// };
// /* harmony default export */ var factory = (Factory);

// // CONCATENATED MODULE: ./src/core/transports/transport_manager.ts

// class transport_manager_TransportManager {
//     constructor(options) {
//         this.options = options || {};
//         this.livesLeft = this.options.lives || Infinity;
//     }
//     getAssistant(transport) {
//         return factory.createAssistantToTheTransportManager(this, transport, {
//             minPingDelay: this.options.minPingDelay,
//             maxPingDelay: this.options.maxPingDelay
//         });
//     }
//     isAlive() {
//         return this.livesLeft > 0;
//     }
//     reportDeath() {
//         this.livesLeft -= 1;
//     }
// }

// // CONCATENATED MODULE: ./src/core/strategies/sequential_strategy.ts



// class sequential_strategy_SequentialStrategy {
//     constructor(strategies, options) {
//         this.strategies = strategies;
//         this.loop = Boolean(options.loop);
//         this.failFast = Boolean(options.failFast);
//         this.timeout = options.timeout;
//         this.timeoutLimit = options.timeoutLimit;
//     }
//     isSupported() {
//         return any(this.strategies, util.method('isSupported'));
//     }
//     connect(minPriority, callback) {
//         var strategies = this.strategies;
//         var current = 0;
//         var timeout = this.timeout;
//         var runner = null;
//         var tryNextStrategy = (error, handshake) => {
//             if (handshake) {
//                 callback(null, handshake);
//             }
//             else {
//                 current = current + 1;
//                 if (this.loop) {
//                     current = current % strategies.length;
//                 }
//                 if (current < strategies.length) {
//                     if (timeout) {
//                         timeout = timeout * 2;
//                         if (this.timeoutLimit) {
//                             timeout = Math.min(timeout, this.timeoutLimit);
//                         }
//                     }
//                     runner = this.tryStrategy(strategies[current], minPriority, { timeout, failFast: this.failFast }, tryNextStrategy);
//                 }
//                 else {
//                     callback(true);
//                 }
//             }
//         };
//         runner = this.tryStrategy(strategies[current], minPriority, { timeout: timeout, failFast: this.failFast }, tryNextStrategy);
//         return {
//             abort: function () {
//                 runner.abort();
//             },
//             forceMinPriority: function (p) {
//                 minPriority = p;
//                 if (runner) {
//                     runner.forceMinPriority(p);
//                 }
//             }
//         };
//     }
//     tryStrategy(strategy, minPriority, options, callback) {
//         var timer = null;
//         var runner = null;
//         if (options.timeout > 0) {
//             timer = new timers_OneOffTimer(options.timeout, function () {
//                 runner.abort();
//                 callback(true);
//             });
//         }
//         runner = strategy.connect(minPriority, function (error, handshake) {
//             if (error && timer && timer.isRunning() && !options.failFast) {
//                 return;
//             }
//             if (timer) {
//                 timer.ensureAborted();
//             }
//             callback(error, handshake);
//         });
//         return {
//             abort: function () {
//                 if (timer) {
//                     timer.ensureAborted();
//                 }
//                 runner.abort();
//             },
//             forceMinPriority: function (p) {
//                 runner.forceMinPriority(p);
//             }
//         };
//     }
// }

// // CONCATENATED MODULE: ./src/core/strategies/best_connected_ever_strategy.ts


// class best_connected_ever_strategy_BestConnectedEverStrategy {
//     constructor(strategies) {
//         this.strategies = strategies;
//     }
//     isSupported() {
//         return any(this.strategies, util.method('isSupported'));
//     }
//     connect(minPriority, callback) {
//         return connect(this.strategies, minPriority, function (i, runners) {
//             return function (error, handshake) {
//                 runners[i].error = error;
//                 if (error) {
//                     if (allRunnersFailed(runners)) {
//                         callback(true);
//                     }
//                     return;
//                 }
//                 apply(runners, function (runner) {
//                     runner.forceMinPriority(handshake.transport.priority);
//                 });
//                 callback(null, handshake);
//             };
//         });
//     }
// }
// function connect(strategies, minPriority, callbackBuilder) {
//     var runners = map(strategies, function (strategy, i, _, rs) {
//         return strategy.connect(minPriority, callbackBuilder(i, rs));
//     });
//     return {
//         abort: function () {
//             apply(runners, abortRunner);
//         },
//         forceMinPriority: function (p) {
//             apply(runners, function (runner) {
//                 runner.forceMinPriority(p);
//             });
//         }
//     };
// }
// function allRunnersFailed(runners) {
//     return collections_all(runners, function (runner) {
//         return Boolean(runner.error);
//     });
// }
// function abortRunner(runner) {
//     if (!runner.error && !runner.aborted) {
//         runner.abort();
//         runner.aborted = true;
//     }
// }

// // CONCATENATED MODULE: ./src/core/strategies/websocket_prioritized_cached_strategy.ts




// class websocket_prioritized_cached_strategy_WebSocketPrioritizedCachedStrategy {
//     constructor(strategy, transports, options) {
//         this.strategy = strategy;
//         this.transports = transports;
//         this.ttl = options.ttl || 1800 * 1000;
//         this.usingTLS = options.useTLS;
//         this.timeline = options.timeline;
//     }
//     isSupported() {
//         return this.strategy.isSupported();
//     }
//     connect(minPriority, callback) {
//         var usingTLS = this.usingTLS;
//         var info = fetchTransportCache(usingTLS);
//         var cacheSkipCount = info && info.cacheSkipCount ? info.cacheSkipCount : 0;
//         var strategies = [this.strategy];
//         if (info && info.timestamp + this.ttl >= util.now()) {
//             var transport = this.transports[info.transport];
//             if (transport) {
//                 if (['ws', 'wss'].includes(info.transport) || cacheSkipCount > 3) {
//                     this.timeline.info({
//                         cached: true,
//                         transport: info.transport,
//                         latency: info.latency
//                     });
//                     strategies.push(new sequential_strategy_SequentialStrategy([transport], {
//                         timeout: info.latency * 2 + 1000,
//                         failFast: true
//                     }));
//                 }
//                 else {
//                     cacheSkipCount++;
//                 }
//             }
//         }
//         var startTimestamp = util.now();
//         var runner = strategies
//             .pop()
//             .connect(minPriority, function cb(error, handshake) {
//             if (error) {
//                 flushTransportCache(usingTLS);
//                 if (strategies.length > 0) {
//                     startTimestamp = util.now();
//                     runner = strategies.pop().connect(minPriority, cb);
//                 }
//                 else {
//                     callback(error);
//                 }
//             }
//             else {
//                 storeTransportCache(usingTLS, handshake.transport.name, util.now() - startTimestamp, cacheSkipCount);
//                 callback(null, handshake);
//             }
//         });
//         return {
//             abort: function () {
//                 runner.abort();
//             },
//             forceMinPriority: function (p) {
//                 minPriority = p;
//                 if (runner) {
//                     runner.forceMinPriority(p);
//                 }
//             }
//         };
//     }
// }
// function getTransportCacheKey(usingTLS) {
//     return 'pusherTransport' + (usingTLS ? 'TLS' : 'NonTLS');
// }
// function fetchTransportCache(usingTLS) {
//     var storage = runtime.getLocalStorage();
//     if (storage) {
//         try {
//             var serializedCache = storage[getTransportCacheKey(usingTLS)];
//             if (serializedCache) {
//                 return JSON.parse(serializedCache);
//             }
//         }
//         catch (e) {
//             flushTransportCache(usingTLS);
//         }
//     }
//     return null;
// }
// function storeTransportCache(usingTLS, transport, latency, cacheSkipCount) {
//     var storage = runtime.getLocalStorage();
//     if (storage) {
//         try {
//             storage[getTransportCacheKey(usingTLS)] = safeJSONStringify({
//                 timestamp: util.now(),
//                 transport: transport,
//                 latency: latency,
//                 cacheSkipCount: cacheSkipCount
//             });
//         }
//         catch (e) {
//         }
//     }
// }
// function flushTransportCache(usingTLS) {
//     var storage = runtime.getLocalStorage();
//     if (storage) {
//         try {
//             delete storage[getTransportCacheKey(usingTLS)];
//         }
//         catch (e) {
//         }
//     }
// }

// // CONCATENATED MODULE: ./src/core/strategies/delayed_strategy.ts

// class delayed_strategy_DelayedStrategy {
//     constructor(strategy, { delay: number }) {
//         this.strategy = strategy;
//         this.options = { delay: number };
//     }
//     isSupported() {
//         return this.strategy.isSupported();
//     }
//     connect(minPriority, callback) {
//         var strategy = this.strategy;
//         var runner;
//         var timer = new timers_OneOffTimer(this.options.delay, function () {
//             runner = strategy.connect(minPriority, callback);
//         });
//         return {
//             abort: function () {
//                 timer.ensureAborted();
//                 if (runner) {
//                     runner.abort();
//                 }
//             },
//             forceMinPriority: function (p) {
//                 minPriority = p;
//                 if (runner) {
//                     runner.forceMinPriority(p);
//                 }
//             }
//         };
//     }
// }

// // CONCATENATED MODULE: ./src/core/strategies/if_strategy.ts
// class IfStrategy {
//     constructor(test, trueBranch, falseBranch) {
//         this.test = test;
//         this.trueBranch = trueBranch;
//         this.falseBranch = falseBranch;
//     }
//     isSupported() {
//         var branch = this.test() ? this.trueBranch : this.falseBranch;
//         return branch.isSupported();
//     }
//     connect(minPriority, callback) {
//         var branch = this.test() ? this.trueBranch : this.falseBranch;
//         return branch.connect(minPriority, callback);
//     }
// }

// // CONCATENATED MODULE: ./src/core/strategies/first_connected_strategy.ts
// class FirstConnectedStrategy {
//     constructor(strategy) {
//         this.strategy = strategy;
//     }
//     isSupported() {
//         return this.strategy.isSupported();
//     }
//     connect(minPriority, callback) {
//         var runner = this.strategy.connect(minPriority, function (error, handshake) {
//             if (handshake) {
//                 runner.abort();
//             }
//             callback(error, handshake);
//         });
//         return runner;
//     }
// }

// // CONCATENATED MODULE: ./src/runtimes/web/default_strategy.ts







// function testSupportsStrategy(strategy) {
//     return function () {
//         return strategy.isSupported();
//     };
// }
// var getDefaultStrategy = function (config, baseOptions, defineTransport) {
//     var definedTransports = {};
//     function defineTransportStrategy(name, type, priority, options, manager) {
//         var transport = defineTransport(config, name, type, priority, options, manager);
//         definedTransports[name] = transport;
//         return transport;
//     }
//     var ws_options = Object.assign({}, baseOptions, {
//         hostNonTLS: config.wsHost + ':' + config.wsPort,
//         hostTLS: config.wsHost + ':' + config.wssPort,
//         httpPath: config.wsPath
//     });
//     var wss_options = Object.assign({}, ws_options, {
//         useTLS: true
//     });
//     var sockjs_options = Object.assign({}, baseOptions, {
//         hostNonTLS: config.httpHost + ':' + config.httpPort,
//         hostTLS: config.httpHost + ':' + config.httpsPort,
//         httpPath: config.httpPath
//     });
//     var timeouts = {
//         loop: true,
//         timeout: 15000,
//         timeoutLimit: 60000
//     };
//     var ws_manager = new transport_manager_TransportManager({
//         minPingDelay: 10000,
//         maxPingDelay: config.activityTimeout
//     });
//     var streaming_manager = new transport_manager_TransportManager({
//         lives: 2,
//         minPingDelay: 10000,
//         maxPingDelay: config.activityTimeout
//     });
//     var ws_transport = defineTransportStrategy('ws', 'ws', 3, ws_options, ws_manager);
//     var wss_transport = defineTransportStrategy('wss', 'ws', 3, wss_options, ws_manager);
//     var sockjs_transport = defineTransportStrategy('sockjs', 'sockjs', 1, sockjs_options);
//     var xhr_streaming_transport = defineTransportStrategy('xhr_streaming', 'xhr_streaming', 1, sockjs_options, streaming_manager);
//     var xdr_streaming_transport = defineTransportStrategy('xdr_streaming', 'xdr_streaming', 1, sockjs_options, streaming_manager);
//     var xhr_polling_transport = defineTransportStrategy('xhr_polling', 'xhr_polling', 1, sockjs_options);
//     var xdr_polling_transport = defineTransportStrategy('xdr_polling', 'xdr_polling', 1, sockjs_options);
//     var ws_loop = new sequential_strategy_SequentialStrategy([ws_transport], timeouts);
//     var wss_loop = new sequential_strategy_SequentialStrategy([wss_transport], timeouts);
//     var sockjs_loop = new sequential_strategy_SequentialStrategy([sockjs_transport], timeouts);
//     var streaming_loop = new sequential_strategy_SequentialStrategy([
//         new IfStrategy(testSupportsStrategy(xhr_streaming_transport), xhr_streaming_transport, xdr_streaming_transport)
//     ], timeouts);
//     var polling_loop = new sequential_strategy_SequentialStrategy([
//         new IfStrategy(testSupportsStrategy(xhr_polling_transport), xhr_polling_transport, xdr_polling_transport)
//     ], timeouts);
//     var http_loop = new sequential_strategy_SequentialStrategy([
//         new IfStrategy(testSupportsStrategy(streaming_loop), new best_connected_ever_strategy_BestConnectedEverStrategy([
//             streaming_loop,
//             new delayed_strategy_DelayedStrategy(polling_loop, { delay: 4000 })
//         ]), polling_loop)
//     ], timeouts);
//     var http_fallback_loop = new IfStrategy(testSupportsStrategy(http_loop), http_loop, sockjs_loop);
//     var wsStrategy;
//     if (baseOptions.useTLS) {
//         wsStrategy = new best_connected_ever_strategy_BestConnectedEverStrategy([
//             ws_loop,
//             new delayed_strategy_DelayedStrategy(http_fallback_loop, { delay: 2000 })
//         ]);
//     }
//     else {
//         wsStrategy = new best_connected_ever_strategy_BestConnectedEverStrategy([
//             ws_loop,
//             new delayed_strategy_DelayedStrategy(wss_loop, { delay: 2000 }),
//             new delayed_strategy_DelayedStrategy(http_fallback_loop, { delay: 5000 })
//         ]);
//     }
//     return new websocket_prioritized_cached_strategy_WebSocketPrioritizedCachedStrategy(new FirstConnectedStrategy(new IfStrategy(testSupportsStrategy(ws_transport), wsStrategy, http_fallback_loop)), definedTransports, {
//         ttl: 1800000,
//         timeline: baseOptions.timeline,
//         useTLS: baseOptions.useTLS
//     });
// };
// /* harmony default export */ var default_strategy = (getDefaultStrategy);

// // CONCATENATED MODULE: ./src/runtimes/web/transports/transport_connection_initializer.ts

// /* harmony default export */ var transport_connection_initializer = (function () {
//     var self = this;
//     self.timeline.info(self.buildTimelineMessage({
//         transport: self.name + (self.options.useTLS ? 's' : '')
//     }));
//     if (self.hooks.isInitialized()) {
//         self.changeState('initialized');
//     }
//     else if (self.hooks.file) {
//         self.changeState('initializing');
//         Dependencies.load(self.hooks.file, { useTLS: self.options.useTLS }, function (error, callback) {
//             if (self.hooks.isInitialized()) {
//                 self.changeState('initialized');
//                 callback(true);
//             }
//             else {
//                 if (error) {
//                     self.onError(error);
//                 }
//                 self.onClose();
//                 callback(false);
//             }
//         });
//     }
//     else {
//         self.onClose();
//     }
// });

// // CONCATENATED MODULE: ./src/runtimes/web/http/http_xdomain_request.ts

// var http_xdomain_request_hooks = {
//     getRequest: function (socket) {
//         var xdr = new window.XDomainRequest();
//         xdr.ontimeout = function () {
//             socket.emit('error', new RequestTimedOut());
//             socket.close();
//         };
//         xdr.onerror = function (e) {
//             socket.emit('error', e);
//             socket.close();
//         };
//         xdr.onprogress = function () {
//             if (xdr.responseText && xdr.responseText.length > 0) {
//                 socket.onChunk(200, xdr.responseText);
//             }
//         };
//         xdr.onload = function () {
//             if (xdr.responseText && xdr.responseText.length > 0) {
//                 socket.onChunk(200, xdr.responseText);
//             }
//             socket.emit('finished', 200);
//             socket.close();
//         };
//         return xdr;
//     },
//     abortRequest: function (xdr) {
//         xdr.ontimeout = xdr.onerror = xdr.onprogress = xdr.onload = null;
//         xdr.abort();
//     }
// };
// /* harmony default export */ var http_xdomain_request = (http_xdomain_request_hooks);

// // CONCATENATED MODULE: ./src/core/http/http_request.ts


// const MAX_BUFFER_LENGTH = 256 * 1024;
// class http_request_HTTPRequest extends dispatcher_Dispatcher {
//     constructor(hooks, method, url) {
//         super();
//         this.hooks = hooks;
//         this.method = method;
//         this.url = url;
//     }
//     start(payload) {
//         this.position = 0;
//         this.xhr = this.hooks.getRequest(this);
//         this.unloader = () => {
//             this.close();
//         };
//         runtime.addUnloadListener(this.unloader);
//         this.xhr.open(this.method, this.url, true);
//         if (this.xhr.setRequestHeader) {
//             this.xhr.setRequestHeader('Content-Type', 'application/json');
//         }
//         this.xhr.send(payload);
//     }
//     close() {
//         if (this.unloader) {
//             runtime.removeUnloadListener(this.unloader);
//             this.unloader = null;
//         }
//         if (this.xhr) {
//             this.hooks.abortRequest(this.xhr);
//             this.xhr = null;
//         }
//     }
//     onChunk(status, data) {
//         while (true) {
//             var chunk = this.advanceBuffer(data);
//             if (chunk) {
//                 this.emit('chunk', { status: status, data: chunk });
//             }
//             else {
//                 break;
//             }
//         }
//         if (this.isBufferTooLong(data)) {
//             this.emit('buffer_too_long');
//         }
//     }
//     advanceBuffer(buffer) {
//         var unreadData = buffer.slice(this.position);
//         var endOfLinePosition = unreadData.indexOf('\n');
//         if (endOfLinePosition !== -1) {
//             this.position += endOfLinePosition + 1;
//             return unreadData.slice(0, endOfLinePosition);
//         }
//         else {
//             return null;
//         }
//     }
//     isBufferTooLong(buffer) {
//         return this.position === buffer.length && buffer.length > MAX_BUFFER_LENGTH;
//     }
// }

// // CONCATENATED MODULE: ./src/core/http/state.ts
// var State;
// (function (State) {
//     State[State["CONNECTING"] = 0] = "CONNECTING";
//     State[State["OPEN"] = 1] = "OPEN";
//     State[State["CLOSED"] = 3] = "CLOSED";
// })(State || (State = {}));
// /* harmony default export */ var state = (State);

// // CONCATENATED MODULE: ./src/core/http/http_socket.ts



// var autoIncrement = 1;
// class http_socket_HTTPSocket {
//     constructor(hooks, url) {
//         this.hooks = hooks;
//         this.session = randomNumber(1000) + '/' + randomString(8);
//         this.location = getLocation(url);
//         this.readyState = state.CONNECTING;
//         this.openStream();
//     }
//     send(payload) {
//         return this.sendRaw(JSON.stringify([payload]));
//     }
//     ping() {
//         this.hooks.sendHeartbeat(this);
//     }
//     close(code, reason) {
//         this.onClose(code, reason, true);
//     }
//     sendRaw(payload) {
//         if (this.readyState === state.OPEN) {
//             try {
//                 runtime.createSocketRequest('POST', getUniqueURL(getSendURL(this.location, this.session))).start(payload);
//                 return true;
//             }
//             catch (e) {
//                 return false;
//             }
//         }
//         else {
//             return false;
//         }
//     }
//     reconnect() {
//         this.closeStream();
//         this.openStream();
//     }
//     onClose(code, reason, wasClean) {
//         this.closeStream();
//         this.readyState = state.CLOSED;
//         if (this.onclose) {
//             this.onclose({
//                 code: code,
//                 reason: reason,
//                 wasClean: wasClean
//             });
//         }
//     }
//     onChunk(chunk) {
//         if (chunk.status !== 200) {
//             return;
//         }
//         if (this.readyState === state.OPEN) {
//             this.onActivity();
//         }
//         var payload;
//         var type = chunk.data.slice(0, 1);
//         switch (type) {
//             case 'o':
//                 payload = JSON.parse(chunk.data.slice(1) || '{}');
//                 this.onOpen(payload);
//                 break;
//             case 'a':
//                 payload = JSON.parse(chunk.data.slice(1) || '[]');
//                 for (var i = 0; i < payload.length; i++) {
//                     this.onEvent(payload[i]);
//                 }
//                 break;
//             case 'm':
//                 payload = JSON.parse(chunk.data.slice(1) || 'null');
//                 this.onEvent(payload);
//                 break;
//             case 'h':
//                 this.hooks.onHeartbeat(this);
//                 break;
//             case 'c':
//                 payload = JSON.parse(chunk.data.slice(1) || '[]');
//                 this.onClose(payload[0], payload[1], true);
//                 break;
//         }
//     }
//     onOpen(options) {
//         if (this.readyState === state.CONNECTING) {
//             if (options && options.hostname) {
//                 this.location.base = replaceHost(this.location.base, options.hostname);
//             }
//             this.readyState = state.OPEN;
//             if (this.onopen) {
//                 this.onopen();
//             }
//         }
//         else {
//             this.onClose(1006, 'Server lost session', true);
//         }
//     }
//     onEvent(event) {
//         if (this.readyState === state.OPEN && this.onmessage) {
//             this.onmessage({ data: event });
//         }
//     }
//     onActivity() {
//         if (this.onactivity) {
//             this.onactivity();
//         }
//     }
//     onError(error) {
//         if (this.onerror) {
//             this.onerror(error);
//         }
//     }
//     openStream() {
//         this.stream = runtime.createSocketRequest('POST', getUniqueURL(this.hooks.getReceiveURL(this.location, this.session)));
//         this.stream.bind('chunk', chunk => {
//             this.onChunk(chunk);
//         });
//         this.stream.bind('finished', status => {
//             this.hooks.onFinished(this, status);
//         });
//         this.stream.bind('buffer_too_long', () => {
//             this.reconnect();
//         });
//         try {
//             this.stream.start();
//         }
//         catch (error) {
//             util.defer(() => {
//                 this.onError(error);
//                 this.onClose(1006, 'Could not start streaming', false);
//             });
//         }
//     }
//     closeStream() {
//         if (this.stream) {
//             this.stream.unbind_all();
//             this.stream.close();
//             this.stream = null;
//         }
//     }
// }
// function getLocation(url) {
//     var parts = /([^\?]*)\/*(\??.*)/.exec(url);
//     return {
//         base: parts[1],
//         queryString: parts[2]
//     };
// }
// function getSendURL(url, session) {
//     return url.base + '/' + session + '/xhr_send';
// }
// function getUniqueURL(url) {
//     var separator = url.indexOf('?') === -1 ? '?' : '&';
//     return url + separator + 't=' + +new Date() + '&n=' + autoIncrement++;
// }
// function replaceHost(url, hostname) {
//     var urlParts = /(https?:\/\/)([^\/:]+)((\/|:)?.*)/.exec(url);
//     return urlParts[1] + hostname + urlParts[3];
// }
// function randomNumber(max) {
//     return runtime.randomInt(max);
// }
// function randomString(length) {
//     var result = [];
//     for (var i = 0; i < length; i++) {
//         result.push(randomNumber(32).toString(32));
//     }
//     return result.join('');
// }
// /* harmony default export */ var http_socket = (http_socket_HTTPSocket);

// // CONCATENATED MODULE: ./src/core/http/http_streaming_socket.ts
// var http_streaming_socket_hooks = {
//     getReceiveURL: function (url, session) {
//         return url.base + '/' + session + '/xhr_streaming' + url.queryString;
//     },
//     onHeartbeat: function (socket) {
//         socket.sendRaw('[]');
//     },
//     sendHeartbeat: function (socket) {
//         socket.sendRaw('[]');
//     },
//     onFinished: function (socket, status) {
//         socket.onClose(1006, 'Connection interrupted (' + status + ')', false);
//     }
// };
// /* harmony default export */ var http_streaming_socket = (http_streaming_socket_hooks);

// // CONCATENATED MODULE: ./src/core/http/http_polling_socket.ts
// var http_polling_socket_hooks = {
//     getReceiveURL: function (url, session) {
//         return url.base + '/' + session + '/xhr' + url.queryString;
//     },
//     onHeartbeat: function () {
//     },
//     sendHeartbeat: function (socket) {
//         socket.sendRaw('[]');
//     },
//     onFinished: function (socket, status) {
//         if (status === 200) {
//             socket.reconnect();
//         }
//         else {
//             socket.onClose(1006, 'Connection interrupted (' + status + ')', false);
//         }
//     }
// };
// /* harmony default export */ var http_polling_socket = (http_polling_socket_hooks);

// // CONCATENATED MODULE: ./src/runtimes/isomorphic/http/http_xhr_request.ts

// var http_xhr_request_hooks = {
//     getRequest: function (socket) {
//         var Constructor = runtime.getXHRAPI();
//         var xhr = new Constructor();
//         xhr.onreadystatechange = xhr.onprogress = function () {
//             switch (xhr.readyState) {
//                 case 3:
//                     if (xhr.responseText && xhr.responseText.length > 0) {
//                         socket.onChunk(xhr.status, xhr.responseText);
//                     }
//                     break;
//                 case 4:
//                     if (xhr.responseText && xhr.responseText.length > 0) {
//                         socket.onChunk(xhr.status, xhr.responseText);
//                     }
//                     socket.emit('finished', xhr.status);
//                     socket.close();
//                     break;
//             }
//         };
//         return xhr;
//     },
//     abortRequest: function (xhr) {
//         xhr.onreadystatechange = null;
//         xhr.abort();
//     }
// };
// /* harmony default export */ var http_xhr_request = (http_xhr_request_hooks);

// // CONCATENATED MODULE: ./src/runtimes/isomorphic/http/http.ts





// var HTTP = {
//     createStreamingSocket(url) {
//         return this.createSocket(http_streaming_socket, url);
//     },
//     createPollingSocket(url) {
//         return this.createSocket(http_polling_socket, url);
//     },
//     createSocket(hooks, url) {
//         return new http_socket(hooks, url);
//     },
//     createXHR(method, url) {
//         return this.createRequest(http_xhr_request, method, url);
//     },
//     createRequest(hooks, method, url) {
//         return new http_request_HTTPRequest(hooks, method, url);
//     }
// };
// /* harmony default export */ var http_http = (HTTP);

// // CONCATENATED MODULE: ./src/runtimes/web/http/http.ts


// http_http.createXDR = function (method, url) {
//     return this.createRequest(http_xdomain_request, method, url);
// };
// /* harmony default export */ var web_http_http = (http_http);

// // CONCATENATED MODULE: ./src/runtimes/web/runtime.ts












// var Runtime = {
//     nextAuthCallbackID: 1,
//     auth_callbacks: {},
//     ScriptReceivers: ScriptReceivers,
//     DependenciesReceivers: DependenciesReceivers,
//     getDefaultStrategy: default_strategy,
//     Transports: transports_transports,
//     transportConnectionInitializer: transport_connection_initializer,
//     HTTPFactory: web_http_http,
//     TimelineTransport: jsonp_timeline,
//     getXHRAPI() {
//         return window.XMLHttpRequest;
//     },
//     getWebSocketAPI() {
//         return window.WebSocket || window.MozWebSocket;
//     },
//     setup(PusherClass) {
//         window.Pusher = PusherClass;
//         var initializeOnDocumentBody = () => {
//             this.onDocumentBody(PusherClass.ready);
//         };
//         if (!window.JSON) {
//             Dependencies.load('json2', {}, initializeOnDocumentBody);
//         }
//         else {
//             initializeOnDocumentBody();
//         }
//     },
//     getDocument() {
//         return document;
//     },
//     getProtocol() {
//         return this.getDocument().location.protocol;
//     },
//     getAuthorizers() {
//         return { ajax: xhr_auth, jsonp: jsonp_auth };
//     },
//     onDocumentBody(callback) {
//         if (document.body) {
//             callback();
//         }
//         else {
//             setTimeout(() => {
//                 this.onDocumentBody(callback);
//             }, 0);
//         }
//     },
//     createJSONPRequest(url, data) {
//         return new jsonp_request_JSONPRequest(url, data);
//     },
//     createScriptRequest(src) {
//         return new ScriptRequest(src);
//     },
//     getLocalStorage() {
//         try {
//             return window.localStorage;
//         }
//         catch (e) {
//             return undefined;
//         }
//     },
//     createXHR() {
//         if (this.getXHRAPI()) {
//             return this.createXMLHttpRequest();
//         }
//         else {
//             return this.createMicrosoftXHR();
//         }
//     },
//     createXMLHttpRequest() {
//         var Constructor = this.getXHRAPI();
//         return new Constructor();
//     },
//     createMicrosoftXHR() {
//         return new ActiveXObject('Microsoft.XMLHTTP');
//     },
//     getNetwork() {
//         return net_info_Network;
//     },
//     createWebSocket(url) {
//         var Constructor = this.getWebSocketAPI();
//         return new Constructor(url);
//     },
//     createSocketRequest(method, url) {
//         if (this.isXHRSupported()) {
//             return this.HTTPFactory.createXHR(method, url);
//         }
//         else if (this.isXDRSupported(url.indexOf('https:') === 0)) {
//             return this.HTTPFactory.createXDR(method, url);
//         }
//         else {
//             throw 'Cross-origin HTTP requests are not supported';
//         }
//     },
//     isXHRSupported() {
//         var Constructor = this.getXHRAPI();
//         return (Boolean(Constructor) && new Constructor().withCredentials !== undefined);
//     },
//     isXDRSupported(useTLS) {
//         var protocol = useTLS ? 'https:' : 'http:';
//         var documentProtocol = this.getProtocol();
//         return (Boolean(window['XDomainRequest']) && documentProtocol === protocol);
//     },
//     addUnloadListener(listener) {
//         if (window.addEventListener !== undefined) {
//             window.addEventListener('unload', listener, false);
//         }
//         else if (window.attachEvent !== undefined) {
//             window.attachEvent('onunload', listener);
//         }
//     },
//     removeUnloadListener(listener) {
//         if (window.addEventListener !== undefined) {
//             window.removeEventListener('unload', listener, false);
//         }
//         else if (window.detachEvent !== undefined) {
//             window.detachEvent('onunload', listener);
//         }
//     },
//     randomInt(max) {
//         const random = function () {
//             const crypto = window.crypto || window['msCrypto'];
//             const random = crypto.getRandomValues(new Uint32Array(1))[0];
//             return random / Math.pow(2, 32);
//         };
//         return Math.floor(random() * max);
//     }
// };
// /* harmony default export */ var runtime = (Runtime);

// // CONCATENATED MODULE: ./src/core/timeline/level.ts
// var TimelineLevel;
// (function (TimelineLevel) {
//     TimelineLevel[TimelineLevel["ERROR"] = 3] = "ERROR";
//     TimelineLevel[TimelineLevel["INFO"] = 6] = "INFO";
//     TimelineLevel[TimelineLevel["DEBUG"] = 7] = "DEBUG";
// })(TimelineLevel || (TimelineLevel = {}));
// /* harmony default export */ var timeline_level = (TimelineLevel);

// // CONCATENATED MODULE: ./src/core/timeline/timeline.ts



// class timeline_Timeline {
//     constructor(key, session, options) {
//         this.key = key;
//         this.session = session;
//         this.events = [];
//         this.options = options || {};
//         this.sent = 0;
//         this.uniqueID = 0;
//     }
//     log(level, event) {
//         if (level <= this.options.level) {
//             this.events.push(extend({}, event, { timestamp: util.now() }));
//             if (this.options.limit && this.events.length > this.options.limit) {
//                 this.events.shift();
//             }
//         }
//     }
//     error(event) {
//         this.log(timeline_level.ERROR, event);
//     }
//     info(event) {
//         this.log(timeline_level.INFO, event);
//     }
//     debug(event) {
//         this.log(timeline_level.DEBUG, event);
//     }
//     isEmpty() {
//         return this.events.length === 0;
//     }
//     send(sendfn, callback) {
//         var data = extend({
//             session: this.session,
//             bundle: this.sent + 1,
//             key: this.key,
//             lib: 'js',
//             version: this.options.version,
//             cluster: this.options.cluster,
//             features: this.options.features,
//             timeline: this.events
//         }, this.options.params);
//         this.events = [];
//         sendfn(data, (error, result) => {
//             if (!error) {
//                 this.sent++;
//             }
//             if (callback) {
//                 callback(error, result);
//             }
//         });
//         return true;
//     }
//     generateUniqueID() {
//         this.uniqueID++;
//         return this.uniqueID;
//     }
// }

// // CONCATENATED MODULE: ./src/core/strategies/transport_strategy.ts




// class transport_strategy_TransportStrategy {
//     constructor(name, priority, transport, options) {
//         this.name = name;
//         this.priority = priority;
//         this.transport = transport;
//         this.options = options || {};
//     }
//     isSupported() {
//         return this.transport.isSupported({
//             useTLS: this.options.useTLS
//         });
//     }
//     connect(minPriority, callback) {
//         if (!this.isSupported()) {
//             return failAttempt(new UnsupportedStrategy(), callback);
//         }
//         else if (this.priority < minPriority) {
//             return failAttempt(new TransportPriorityTooLow(), callback);
//         }
//         var connected = false;
//         var transport = this.transport.createConnection(this.name, this.priority, this.options.key, this.options);
//         var handshake = null;
//         var onInitialized = function () {
//             transport.unbind('initialized', onInitialized);
//             transport.connect();
//         };
//         var onOpen = function () {
//             handshake = factory.createHandshake(transport, function (result) {
//                 connected = true;
//                 unbindListeners();
//                 callback(null, result);
//             });
//         };
//         var onError = function (error) {
//             unbindListeners();
//             callback(error);
//         };
//         var onClosed = function () {
//             unbindListeners();
//             var serializedTransport;
//             serializedTransport = safeJSONStringify(transport);
//             callback(new TransportClosed(serializedTransport));
//         };
//         var unbindListeners = function () {
//             transport.unbind('initialized', onInitialized);
//             transport.unbind('open', onOpen);
//             transport.unbind('error', onError);
//             transport.unbind('closed', onClosed);
//         };
//         transport.bind('initialized', onInitialized);
//         transport.bind('open', onOpen);
//         transport.bind('error', onError);
//         transport.bind('closed', onClosed);
//         transport.initialize();
//         return {
//             abort: () => {
//                 if (connected) {
//                     return;
//                 }
//                 unbindListeners();
//                 if (handshake) {
//                     handshake.close();
//                 }
//                 else {
//                     transport.close();
//                 }
//             },
//             forceMinPriority: p => {
//                 if (connected) {
//                     return;
//                 }
//                 if (this.priority < p) {
//                     if (handshake) {
//                         handshake.close();
//                     }
//                     else {
//                         transport.close();
//                     }
//                 }
//             }
//         };
//     }
// }
// function failAttempt(error, callback) {
//     util.defer(function () {
//         callback(error);
//     });
//     return {
//         abort: function () { },
//         forceMinPriority: function () { }
//     };
// }

// // CONCATENATED MODULE: ./src/core/strategies/strategy_builder.ts





// const { Transports: strategy_builder_Transports } = runtime;
// var strategy_builder_defineTransport = function (config, name, type, priority, options, manager) {
//     var transportClass = strategy_builder_Transports[type];
//     if (!transportClass) {
//         throw new UnsupportedTransport(type);
//     }
//     var enabled = (!config.enabledTransports ||
//         arrayIndexOf(config.enabledTransports, name) !== -1) &&
//         (!config.disabledTransports ||
//             arrayIndexOf(config.disabledTransports, name) === -1);
//     var transport;
//     if (enabled) {
//         options = Object.assign({ ignoreNullOrigin: config.ignoreNullOrigin }, options);
//         transport = new transport_strategy_TransportStrategy(name, priority, manager ? manager.getAssistant(transportClass) : transportClass, options);
//     }
//     else {
//         transport = strategy_builder_UnsupportedStrategy;
//     }
//     return transport;
// };
// var strategy_builder_UnsupportedStrategy = {
//     isSupported: function () {
//         return false;
//     },
//     connect: function (_, callback) {
//         var deferred = util.defer(function () {
//             callback(new UnsupportedStrategy());
//         });
//         return {
//             abort: function () {
//                 deferred.ensureAborted();
//             },
//             forceMinPriority: function () { }
//         };
//     }
// };

// // CONCATENATED MODULE: ./src/core/options.ts

// function validateOptions(options) {
//     if (options == null) {
//         throw 'You must pass an options object';
//     }
//     if (options.cluster == null) {
//         throw 'Options object must provide a cluster';
//     }
//     if ('disableStats' in options) {
//         logger.warn('The disableStats option is deprecated in favor of enableStats');
//     }
// }

// // CONCATENATED MODULE: ./src/core/auth/user_authenticator.ts


// const composeChannelQuery = (params, authOptions) => {
//     var query = 'socket_id=' + encodeURIComponent(params.socketId);
//     for (var key in authOptions.params) {
//         query +=
//             '&' +
//                 encodeURIComponent(key) +
//                 '=' +
//                 encodeURIComponent(authOptions.params[key]);
//     }
//     if (authOptions.paramsProvider != null) {
//         let dynamicParams = authOptions.paramsProvider();
//         for (var key in dynamicParams) {
//             query +=
//                 '&' +
//                     encodeURIComponent(key) +
//                     '=' +
//                     encodeURIComponent(dynamicParams[key]);
//         }
//     }
//     return query;
// };
// const UserAuthenticator = (authOptions) => {
//     if (typeof runtime.getAuthorizers()[authOptions.transport] === 'undefined') {
//         throw `'${authOptions.transport}' is not a recognized auth transport`;
//     }
//     return (params, callback) => {
//         const query = composeChannelQuery(params, authOptions);
//         runtime.getAuthorizers()[authOptions.transport](runtime, query, authOptions, AuthRequestType.UserAuthentication, callback);
//     };
// };
// /* harmony default export */ var user_authenticator = (UserAuthenticator);

// // CONCATENATED MODULE: ./src/core/auth/channel_authorizer.ts


// const channel_authorizer_composeChannelQuery = (params, authOptions) => {
//     var query = 'socket_id=' + encodeURIComponent(params.socketId);
//     query += '&channel_name=' + encodeURIComponent(params.channelName);
//     for (var key in authOptions.params) {
//         query +=
//             '&' +
//                 encodeURIComponent(key) +
//                 '=' +
//                 encodeURIComponent(authOptions.params[key]);
//     }
//     if (authOptions.paramsProvider != null) {
//         let dynamicParams = authOptions.paramsProvider();
//         for (var key in dynamicParams) {
//             query +=
//                 '&' +
//                     encodeURIComponent(key) +
//                     '=' +
//                     encodeURIComponent(dynamicParams[key]);
//         }
//     }
//     return query;
// };
// const ChannelAuthorizer = (authOptions) => {
//     if (typeof runtime.getAuthorizers()[authOptions.transport] === 'undefined') {
//         throw `'${authOptions.transport}' is not a recognized auth transport`;
//     }
//     return (params, callback) => {
//         const query = channel_authorizer_composeChannelQuery(params, authOptions);
//         runtime.getAuthorizers()[authOptions.transport](runtime, query, authOptions, AuthRequestType.ChannelAuthorization, callback);
//     };
// };
// /* harmony default export */ var channel_authorizer = (ChannelAuthorizer);

// // CONCATENATED MODULE: ./src/core/auth/deprecated_channel_authorizer.ts
// const ChannelAuthorizerProxy = (pusher, authOptions, channelAuthorizerGenerator) => {
//     const deprecatedAuthorizerOptions = {
//         authTransport: authOptions.transport,
//         authEndpoint: authOptions.endpoint,
//         auth: {
//             params: authOptions.params,
//             headers: authOptions.headers
//         }
//     };
//     return (params, callback) => {
//         const channel = pusher.channel(params.channelName);
//         const channelAuthorizer = channelAuthorizerGenerator(channel, deprecatedAuthorizerOptions);
//         channelAuthorizer.authorize(params.socketId, callback);
//     };
// };

// // CONCATENATED MODULE: ./src/core/config.ts





// function getConfig(opts, pusher) {
//     let config = {
//         activityTimeout: opts.activityTimeout || defaults.activityTimeout,
//         cluster: opts.cluster,
//         httpPath: opts.httpPath || defaults.httpPath,
//         httpPort: opts.httpPort || defaults.httpPort,
//         httpsPort: opts.httpsPort || defaults.httpsPort,
//         pongTimeout: opts.pongTimeout || defaults.pongTimeout,
//         statsHost: opts.statsHost || defaults.stats_host,
//         unavailableTimeout: opts.unavailableTimeout || defaults.unavailableTimeout,
//         wsPath: opts.wsPath || defaults.wsPath,
//         wsPort: opts.wsPort || defaults.wsPort,
//         wssPort: opts.wssPort || defaults.wssPort,
//         enableStats: getEnableStatsConfig(opts),
//         httpHost: getHttpHost(opts),
//         useTLS: shouldUseTLS(opts),
//         wsHost: getWebsocketHost(opts),
//         userAuthenticator: buildUserAuthenticator(opts),
//         channelAuthorizer: buildChannelAuthorizer(opts, pusher)
//     };
//     if ('disabledTransports' in opts)
//         config.disabledTransports = opts.disabledTransports;
//     if ('enabledTransports' in opts)
//         config.enabledTransports = opts.enabledTransports;
//     if ('ignoreNullOrigin' in opts)
//         config.ignoreNullOrigin = opts.ignoreNullOrigin;
//     if ('timelineParams' in opts)
//         config.timelineParams = opts.timelineParams;
//     if ('nacl' in opts) {
//         config.nacl = opts.nacl;
//     }
//     return config;
// }
// function getHttpHost(opts) {
//     if (opts.httpHost) {
//         return opts.httpHost;
//     }
//     if (opts.cluster) {
//         return `sockjs-${opts.cluster}.pusher.com`;
//     }
//     return defaults.httpHost;
// }
// function getWebsocketHost(opts) {
//     if (opts.wsHost) {
//         return opts.wsHost;
//     }
//     return getWebsocketHostFromCluster(opts.cluster);
// }
// function getWebsocketHostFromCluster(cluster) {
//     return `ws-${cluster}.pusher.com`;
// }
// function shouldUseTLS(opts) {
//     if (runtime.getProtocol() === 'https:') {
//         return true;
//     }
//     else if (opts.forceTLS === false) {
//         return false;
//     }
//     return true;
// }
// function getEnableStatsConfig(opts) {
//     if ('enableStats' in opts) {
//         return opts.enableStats;
//     }
//     if ('disableStats' in opts) {
//         return !opts.disableStats;
//     }
//     return false;
// }
// const hasCustomHandler = (auth) => {
//     return 'customHandler' in auth && auth['customHandler'] != null;
// };
// function buildUserAuthenticator(opts) {
//     const userAuthentication = Object.assign(Object.assign({}, defaults.userAuthentication), opts.userAuthentication);
//     if (hasCustomHandler(userAuthentication)) {
//         return userAuthentication['customHandler'];
//     }
//     return user_authenticator(userAuthentication);
// }
// function buildChannelAuth(opts, pusher) {
//     let channelAuthorization;
//     if ('channelAuthorization' in opts) {
//         channelAuthorization = Object.assign(Object.assign({}, defaults.channelAuthorization), opts.channelAuthorization);
//     }
//     else {
//         channelAuthorization = {
//             transport: opts.authTransport || defaults.authTransport,
//             endpoint: opts.authEndpoint || defaults.authEndpoint
//         };
//         if ('auth' in opts) {
//             if ('params' in opts.auth)
//                 channelAuthorization.params = opts.auth.params;
//             if ('headers' in opts.auth)
//                 channelAuthorization.headers = opts.auth.headers;
//         }
//         if ('authorizer' in opts) {
//             return {
//                 customHandler: ChannelAuthorizerProxy(pusher, channelAuthorization, opts.authorizer)
//             };
//         }
//     }
//     return channelAuthorization;
// }
// function buildChannelAuthorizer(opts, pusher) {
//     const channelAuthorization = buildChannelAuth(opts, pusher);
//     if (hasCustomHandler(channelAuthorization)) {
//         return channelAuthorization['customHandler'];
//     }
//     return channel_authorizer(channelAuthorization);
// }

// // CONCATENATED MODULE: ./src/core/watchlist.ts


// class watchlist_WatchlistFacade extends dispatcher_Dispatcher {
//     constructor(pusher) {
//         super(function (eventName, data) {
//             logger.debug(`No callbacks on watchlist events for ${eventName}`);
//         });
//         this.pusher = pusher;
//         this.bindWatchlistInternalEvent();
//     }
//     handleEvent(pusherEvent) {
//         pusherEvent.data.events.forEach(watchlistEvent => {
//             this.emit(watchlistEvent.name, watchlistEvent);
//         });
//     }
//     bindWatchlistInternalEvent() {
//         this.pusher.connection.bind('message', pusherEvent => {
//             var eventName = pusherEvent.event;
//             if (eventName === 'pusher_internal:watchlist_events') {
//                 this.handleEvent(pusherEvent);
//             }
//         });
//     }
// }

// // CONCATENATED MODULE: ./src/core/utils/flat_promise.ts
// function flatPromise() {
//     let resolve, reject;
//     const promise = new Promise((res, rej) => {
//         resolve = res;
//         reject = rej;
//     });
//     return { promise, resolve, reject };
// }
// /* harmony default export */ var flat_promise = (flatPromise);

// // CONCATENATED MODULE: ./src/core/user.ts





// class user_UserFacade extends dispatcher_Dispatcher {
//     constructor(pusher) {
//         super(function (eventName, data) {
//             logger.debug('No callbacks on user for ' + eventName);
//         });
//         this.signin_requested = false;
//         this.user_data = null;
//         this.serverToUserChannel = null;
//         this.signinDonePromise = null;
//         this._signinDoneResolve = null;
//         this._onAuthorize = (err, authData) => {
//             if (err) {
//                 logger.warn(`Error during signin: ${err}`);
//                 this._cleanup();
//                 return;
//             }
//             this.pusher.send_event('pusher:signin', {
//                 auth: authData.auth,
//                 user_data: authData.user_data
//             });
//         };
//         this.pusher = pusher;
//         this.pusher.connection.bind('state_change', ({ previous, current }) => {
//             if (previous !== 'connected' && current === 'connected') {
//                 this._signin();
//             }
//             if (previous === 'connected' && current !== 'connected') {
//                 this._cleanup();
//                 this._newSigninPromiseIfNeeded();
//             }
//         });
//         this.watchlist = new watchlist_WatchlistFacade(pusher);
//         this.pusher.connection.bind('message', event => {
//             var eventName = event.event;
//             if (eventName === 'pusher:signin_success') {
//                 this._onSigninSuccess(event.data);
//             }
//             if (this.serverToUserChannel &&
//                 this.serverToUserChannel.name === event.channel) {
//                 this.serverToUserChannel.handleEvent(event);
//             }
//         });
//     }
//     signin() {
//         if (this.signin_requested) {
//             return;
//         }
//         this.signin_requested = true;
//         this._signin();
//     }
//     _signin() {
//         if (!this.signin_requested) {
//             return;
//         }
//         this._newSigninPromiseIfNeeded();
//         if (this.pusher.connection.state !== 'connected') {
//             return;
//         }
//         this.pusher.config.userAuthenticator({
//             socketId: this.pusher.connection.socket_id
//         }, this._onAuthorize);
//     }
//     _onSigninSuccess(data) {
//         try {
//             this.user_data = JSON.parse(data.user_data);
//         }
//         catch (e) {
//             logger.error(`Failed parsing user data after signin: ${data.user_data}`);
//             this._cleanup();
//             return;
//         }
//         if (typeof this.user_data.id !== 'string' || this.user_data.id === '') {
//             logger.error(`user_data doesn't contain an id. user_data: ${this.user_data}`);
//             this._cleanup();
//             return;
//         }
//         this._signinDoneResolve();
//         this._subscribeChannels();
//     }
//     _subscribeChannels() {
//         const ensure_subscribed = channel => {
//             if (channel.subscriptionPending && channel.subscriptionCancelled) {
//                 channel.reinstateSubscription();
//             }
//             else if (!channel.subscriptionPending &&
//                 this.pusher.connection.state === 'connected') {
//                 channel.subscribe();
//             }
//         };
//         this.serverToUserChannel = new channel_Channel(`#server-to-user-${this.user_data.id}`, this.pusher);
//         this.serverToUserChannel.bind_global((eventName, data) => {
//             if (eventName.indexOf('pusher_internal:') === 0 ||
//                 eventName.indexOf('pusher:') === 0) {
//                 return;
//             }
//             this.emit(eventName, data);
//         });
//         ensure_subscribed(this.serverToUserChannel);
//     }
//     _cleanup() {
//         this.user_data = null;
//         if (this.serverToUserChannel) {
//             this.serverToUserChannel.unbind_all();
//             this.serverToUserChannel.disconnect();
//             this.serverToUserChannel = null;
//         }
//         if (this.signin_requested) {
//             this._signinDoneResolve();
//         }
//     }
//     _newSigninPromiseIfNeeded() {
//         if (!this.signin_requested) {
//             return;
//         }
//         if (this.signinDonePromise && !this.signinDonePromise.done) {
//             return;
//         }
//         const { promise, resolve, reject: _ } = flat_promise();
//         promise.done = false;
//         const setDone = () => {
//             promise.done = true;
//         };
//         promise.then(setDone).catch(setDone);
//         this.signinDonePromise = promise;
//         this._signinDoneResolve = resolve;
//     }
// }

// // CONCATENATED MODULE: ./src/core/pusher.ts













// class pusher_Pusher {
//     static ready() {
//         pusher_Pusher.isReady = true;
//         for (var i = 0, l = pusher_Pusher.instances.length; i < l; i++) {
//             pusher_Pusher.instances[i].connect();
//         }
//     }
//     static getClientFeatures() {
//         return keys(filterObject({ ws: runtime.Transports.ws }, function (t) {
//             return t.isSupported({});
//         }));
//     }
//     constructor(app_key, options) {
//         checkAppKey(app_key);
//         validateOptions(options);
//         this.key = app_key;
//         this.options = options;
//         this.config = getConfig(this.options, this);
//         this.channels = factory.createChannels();
//         this.global_emitter = new dispatcher_Dispatcher();
//         this.sessionID = runtime.randomInt(1000000000);
//         this.timeline = new timeline_Timeline(this.key, this.sessionID, {
//             cluster: this.config.cluster,
//             features: pusher_Pusher.getClientFeatures(),
//             params: this.config.timelineParams || {},
//             limit: 50,
//             level: timeline_level.INFO,
//             version: defaults.VERSION
//         });
//         if (this.config.enableStats) {
//             this.timelineSender = factory.createTimelineSender(this.timeline, {
//                 host: this.config.statsHost,
//                 path: '/timeline/v2/' + runtime.TimelineTransport.name
//             });
//         }
//         var getStrategy = (options) => {
//             return runtime.getDefaultStrategy(this.config, options, strategy_builder_defineTransport);
//         };
//         this.connection = factory.createConnectionManager(this.key, {
//             getStrategy: getStrategy,
//             timeline: this.timeline,
//             activityTimeout: this.config.activityTimeout,
//             pongTimeout: this.config.pongTimeout,
//             unavailableTimeout: this.config.unavailableTimeout,
//             useTLS: Boolean(this.config.useTLS)
//         });
//         this.connection.bind('connected', () => {
//             this.subscribeAll();
//             if (this.timelineSender) {
//                 this.timelineSender.send(this.connection.isUsingTLS());
//             }
//         });
//         this.connection.bind('message', event => {
//             var eventName = event.event;
//             var internal = eventName.indexOf('pusher_internal:') === 0;
//             if (event.channel) {
//                 var channel = this.channel(event.channel);
//                 if (channel) {
//                     channel.handleEvent(event);
//                 }
//             }
//             if (!internal) {
//                 this.global_emitter.emit(event.event, event.data);
//             }
//         });
//         this.connection.bind('connecting', () => {
//             this.channels.disconnect();
//         });
//         this.connection.bind('disconnected', () => {
//             this.channels.disconnect();
//         });
//         this.connection.bind('error', err => {
//             logger.warn(err);
//         });
//         pusher_Pusher.instances.push(this);
//         this.timeline.info({ instances: pusher_Pusher.instances.length });
//         this.user = new user_UserFacade(this);
//         if (pusher_Pusher.isReady) {
//             this.connect();
//         }
//     }
//     switchCluster(options) {
//         const { appKey, cluster } = options;
//         this.key = appKey;
//         this.options = Object.assign(Object.assign({}, this.options), { cluster });
//         this.config = getConfig(this.options, this);
//         this.connection.switchCluster(this.key);
//     }
//     channel(name) {
//         return this.channels.find(name);
//     }
//     allChannels() {
//         return this.channels.all();
//     }
//     connect() {
//         this.connection.connect();
//         if (this.timelineSender) {
//             if (!this.timelineSenderTimer) {
//                 var usingTLS = this.connection.isUsingTLS();
//                 var timelineSender = this.timelineSender;
//                 this.timelineSenderTimer = new timers_PeriodicTimer(60000, function () {
//                     timelineSender.send(usingTLS);
//                 });
//             }
//         }
//     }
//     disconnect() {
//         this.connection.disconnect();
//         if (this.timelineSenderTimer) {
//             this.timelineSenderTimer.ensureAborted();
//             this.timelineSenderTimer = null;
//         }
//     }
//     bind(event_name, callback, context) {
//         this.global_emitter.bind(event_name, callback, context);
//         return this;
//     }
//     unbind(event_name, callback, context) {
//         this.global_emitter.unbind(event_name, callback, context);
//         return this;
//     }
//     bind_global(callback) {
//         this.global_emitter.bind_global(callback);
//         return this;
//     }
//     unbind_global(callback) {
//         this.global_emitter.unbind_global(callback);
//         return this;
//     }
//     unbind_all(callback) {
//         this.global_emitter.unbind_all();
//         return this;
//     }
//     subscribeAll() {
//         var channelName;
//         for (channelName in this.channels.channels) {
//             if (this.channels.channels.hasOwnProperty(channelName)) {
//                 this.subscribe(channelName);
//             }
//         }
//     }
//     subscribe(channel_name) {
//         var channel = this.channels.add(channel_name, this);
//         if (channel.subscriptionPending && channel.subscriptionCancelled) {
//             channel.reinstateSubscription();
//         }
//         else if (!channel.subscriptionPending &&
//             this.connection.state === 'connected') {
//             channel.subscribe();
//         }
//         return channel;
//     }
//     unsubscribe(channel_name) {
//         var channel = this.channels.find(channel_name);
//         if (channel && channel.subscriptionPending) {
//             channel.cancelSubscription();
//         }
//         else {
//             channel = this.channels.remove(channel_name);
//             if (channel && channel.subscribed) {
//                 channel.unsubscribe();
//             }
//         }
//     }
//     send_event(event_name, data, channel) {
//         return this.connection.send_event(event_name, data, channel);
//     }
//     shouldUseTLS() {
//         return this.config.useTLS;
//     }
//     signin() {
//         this.user.signin();
//     }
// }
// pusher_Pusher.instances = [];
// pusher_Pusher.isReady = false;
// pusher_Pusher.logToConsole = false;
// pusher_Pusher.Runtime = runtime;
// pusher_Pusher.ScriptReceivers = runtime.ScriptReceivers;
// pusher_Pusher.DependenciesReceivers = runtime.DependenciesReceivers;
// pusher_Pusher.auth_callbacks = runtime.auth_callbacks;
// /* harmony default export */ var core_pusher = __nested_webpack_exports__["default"] = (pusher_Pusher);
// function checkAppKey(key) {
//     if (key === null || key === undefined) {
//         throw 'You must pass your app key when you instantiate Pusher.';
//     }
// }
// runtime.setup(pusher_Pusher);


// /***/ })
// /******/ ]);
// });
// //# sourceMappingURL=pusher.js.map

// /***/ }),

// /***/ "./resources/js/components/ExampleComponent.vue":
// /*!******************************************************!*\
//   !*** ./resources/js/components/ExampleComponent.vue ***!
//   \******************************************************/
// /***/ (() => {

// throw new Error("Module parse failed: Unexpected token (1:0)\nYou may need an appropriate loader to handle this file type, currently no loaders are configured to process this file. See https://webpack.js.org/concepts#loaders\n> <template>\n|     <div class=\"container\">\n|         <div class=\"row justify-content-center\">");

// /***/ })

// /******/ 	});
// /************************************************************************/
// /******/ 	// The module cache
// /******/ 	var __webpack_module_cache__ = {};
// /******/
// /******/ 	// The require function
// /******/ 	function __webpack_require__(moduleId) {
// /******/ 		// Check if module is in cache
// /******/ 		var cachedModule = __webpack_module_cache__[moduleId];
// /******/ 		if (cachedModule !== undefined) {
// /******/ 			return cachedModule.exports;
// /******/ 		}
// /******/ 		// Create a new module (and put it into the cache)
// /******/ 		var module = __webpack_module_cache__[moduleId] = {
// /******/ 			// no module.id needed
// /******/ 			// no module.loaded needed
// /******/ 			exports: {}
// /******/ 		};
// /******/
// /******/ 		// Execute the module function
// /******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
// /******/
// /******/ 		// Return the exports of the module
// /******/ 		return module.exports;
// /******/ 	}
// /******/
// /******/ 	// expose the modules object (__webpack_modules__)
// /******/ 	__webpack_require__.m = __webpack_modules__;
// /******/
// /************************************************************************/
// /******/ 	/* webpack/runtime/chunk loaded */
// /******/ 	(() => {
// /******/ 		var deferred = [];
// /******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
// /******/ 			if(chunkIds) {
// /******/ 				priority = priority || 0;
// /******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
// /******/ 				deferred[i] = [chunkIds, fn, priority];
// /******/ 				return;
// /******/ 			}
// /******/ 			var notFulfilled = Infinity;
// /******/ 			for (var i = 0; i < deferred.length; i++) {
// /******/ 				var [chunkIds, fn, priority] = deferred[i];
// /******/ 				var fulfilled = true;
// /******/ 				for (var j = 0; j < chunkIds.length; j++) {
// /******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
// /******/ 						chunkIds.splice(j--, 1);
// /******/ 					} else {
// /******/ 						fulfilled = false;
// /******/ 						if(priority < notFulfilled) notFulfilled = priority;
// /******/ 					}
// /******/ 				}
// /******/ 				if(fulfilled) {
// /******/ 					deferred.splice(i--, 1)
// /******/ 					var r = fn();
// /******/ 					if (r !== undefined) result = r;
// /******/ 				}
// /******/ 			}
// /******/ 			return result;
// /******/ 		};
// /******/ 	})();
// /******/
// /******/ 	/* webpack/runtime/compat get default export */
// /******/ 	(() => {
// /******/ 		// getDefaultExport function for compatibility with non-harmony modules
// /******/ 		__webpack_require__.n = (module) => {
// /******/ 			var getter = module && module.__esModule ?
// /******/ 				() => (module['default']) :
// /******/ 				() => (module);
// /******/ 			__webpack_require__.d(getter, { a: getter });
// /******/ 			return getter;
// /******/ 		};
// /******/ 	})();
// /******/
// /******/ 	/* webpack/runtime/define property getters */
// /******/ 	(() => {
// /******/ 		// define getter functions for harmony exports
// /******/ 		__webpack_require__.d = (exports, definition) => {
// /******/ 			for(var key in definition) {
// /******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
// /******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
// /******/ 				}
// /******/ 			}
// /******/ 		};
// /******/ 	})();
// /******/
// /******/ 	/* webpack/runtime/hasOwnProperty shorthand */
// /******/ 	(() => {
// /******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
// /******/ 	})();
// /******/
// /******/ 	/* webpack/runtime/make namespace object */
// /******/ 	(() => {
// /******/ 		// define __esModule on exports
// /******/ 		__webpack_require__.r = (exports) => {
// /******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
// /******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
// /******/ 			}
// /******/ 			Object.defineProperty(exports, '__esModule', { value: true });
// /******/ 		};
// /******/ 	})();
// /******/
// /******/ 	/* webpack/runtime/jsonp chunk loading */
// /******/ 	(() => {
// /******/ 		// no baseURI
// /******/
// /******/ 		// object to store loaded and loading chunks
// /******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
// /******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
// /******/ 		var installedChunks = {
// /******/ 			"/js/app": 0,
// /******/ 			"css/app": 0
// /******/ 		};
// /******/
// /******/ 		// no chunk on demand loading
// /******/
// /******/ 		// no prefetching
// /******/
// /******/ 		// no preloaded
// /******/
// /******/ 		// no HMR
// /******/
// /******/ 		// no HMR manifest
// /******/
// /******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
// /******/
// /******/ 		// install a JSONP callback for chunk loading
// /******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
// /******/ 			var [chunkIds, moreModules, runtime] = data;
// /******/ 			// add "moreModules" to the modules object,
// /******/ 			// then flag all "chunkIds" as loaded and fire callback
// /******/ 			var moduleId, chunkId, i = 0;
// /******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
// /******/ 				for(moduleId in moreModules) {
// /******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
// /******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
// /******/ 					}
// /******/ 				}
// /******/ 				if(runtime) var result = runtime(__webpack_require__);
// /******/ 			}
// /******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
// /******/ 			for(;i < chunkIds.length; i++) {
// /******/ 				chunkId = chunkIds[i];
// /******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
// /******/ 					installedChunks[chunkId][0]();
// /******/ 				}
// /******/ 				installedChunks[chunkId] = 0;
// /******/ 			}
// /******/ 			return __webpack_require__.O(result);
// /******/ 		}
// /******/
// /******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
// /******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
// /******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
// /******/ 	})();
// /******/
// /************************************************************************/
// /******/
// /******/ 	// startup
// /******/ 	// Load entry module and return exports
// /******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
// /******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
// /******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/css/app.css")))
// /******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
// /******/
// /******/ })()
// ;

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Bootstrap and other libraries. It is a great starting point
 * when building robust, powerful web applications using Laravel.
 */

// import './bootstrap';

// // Inicializa Laravel Echo y escucha notificaciones
// console.log('Conexión a Pusher:', window.Echo?.connector?.pusher?.connection.state);

// window.Echo.channel('notifications')
//     .listen('RealTimeNotification', (event) => {
//         console.log('Notificación recibida:', event.message);
//         alert(`Nueva notificación: ${event.message}`);
//     });

// console.log('Frontend cargado sin Vue.');

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ddfeb8029c8fce193f9a',
    cluster: 'us2',
    forceTLS: true,
    authEndpoint: '/broadcasting/auth', // Asegúrate de que esta ruta sea correcta
    auth: {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}` // Si usas tokens
        }
    }
});



