/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/css/admin.scss":
/*!*******************************!*\
  !*** ./assets/css/admin.scss ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://coming-sooner/./assets/css/admin.scss?");

/***/ }),

/***/ "./assets/js/admin.js":
/*!****************************!*\
  !*** ./assets/js/admin.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _css_admin_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../css/admin.scss */ \"./assets/css/admin.scss\");\n\njQuery(document).ready(function ($) {\n  // Toggle Coming Soon ON/OFF\n  $('#coming-soon-toggle').on('change', function () {\n    const isActive = $(this).is(':checked');\n    $.ajax({\n      url: comingSoonerData.ajaxUrl,\n      method: 'POST',\n      data: {\n        action: 'coming_sooner_toggle',\n        nonce: comingSoonerData.nonce,\n        active: isActive\n      },\n      success(response) {\n        if (response.success) {\n          alert(response.data.message);\n        } else {\n          alert('Error: ' + (response.data || 'Unknown error'));\n          // Revert toggle\n          $('#coming-soon-toggle').prop('checked', !isActive);\n        }\n      },\n      error() {\n        alert('AJAX error. Please try again.');\n        $('#coming-soon-toggle').prop('checked', !isActive);\n      }\n    });\n  });\n\n  // Template Type (Mode) selection (Default / Elementor)\n  $('input[name=\"template_type\"]').on('change', function () {\n    const selectedType = $(this).val();\n    $.ajax({\n      url: comingSoonerData.ajaxUrl,\n      method: 'POST',\n      data: {\n        action: 'coming_sooner_save_template_type',\n        nonce: comingSoonerData.nonce,\n        template_type: selectedType\n      },\n      success(response) {\n        if (response.success) {\n          if (selectedType === 'default') {\n            $('.default-templates').show();\n            $('.elementor-templates').hide();\n          } else if (selectedType === 'elementor') {\n            $('.default-templates').hide();\n            $('.elementor-templates').show();\n          }\n        } else {\n          alert('Error saving template type.');\n        }\n      },\n      error() {\n        alert('AJAX error saving template type.');\n      }\n    });\n  });\n\n  // Select a template button click\n  $('.select-template').on('click', function (e) {\n    e.preventDefault();\n    const templateId = $(this).data('template-id');\n    const templateType = $(this).data('template-type');\n    const $templateCards = templateType === 'default' ? $('.default-templates .template-card') : $('.elementor-templates .template-card');\n    $.ajax({\n      url: comingSoonerData.ajaxUrl,\n      method: 'POST',\n      data: {\n        action: 'coming_sooner_save_template',\n        nonce: comingSoonerData.nonce,\n        template_id: templateId,\n        template_type: templateType\n      },\n      success(response) {\n        if (response.success) {\n          alert(response.data.message);\n          // Update UI to highlight selected template\n          $templateCards.removeClass('selected');\n          $templateCards.filter(function () {\n            return $(this).find('.select-template').data('template-id') === templateId;\n          }).addClass('selected');\n        } else {\n          alert('Error saving template selection.');\n        }\n      },\n      error() {\n        alert('AJAX error saving template selection.');\n      }\n    });\n  });\n\n  // Install Elementor button\n  $('#install-elementor').on('click', function (e) {\n    e.preventDefault();\n    if (!confirm(comingSoonerData.confirmInstall)) {\n      return;\n    }\n    const $btn = $(this);\n    $btn.prop('disabled', true).text('Installing...');\n    $.ajax({\n      url: comingSoonerData.ajaxUrl,\n      method: 'POST',\n      data: {\n        action: 'coming_sooner_install_elementor',\n        nonce: comingSoonerData.nonce\n      },\n      success(response) {\n        if (response.success) {\n          alert(response.data.message);\n          if (response.data.reload) {\n            location.reload();\n          }\n        } else {\n          alert('Error installing Elementor: ' + (response.data || 'Unknown error'));\n          $btn.prop('disabled', false).text('Install Elementor Now');\n        }\n      },\n      error() {\n        alert('AJAX error during Elementor installation.');\n        $btn.prop('disabled', false).text('Install Elementor Now');\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack://coming-sooner/./assets/js/admin.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/js/admin.js");
/******/ 	
/******/ })()
;