/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/admin.js":
/*!****************************!*\
  !*** ./assets/js/admin.js ***!
  \****************************/
/***/ (() => {

eval("jQuery(document).ready(function ($) {\n  // Toggle Coming Soon ON/OFF\n  $('#coming-soon-toggle').on('change', function () {\n    const isActive = $(this).is(':checked');\n    $.ajax({\n      url: comingSoonerData.ajaxUrl,\n      method: 'POST',\n      data: {\n        action: 'coming_sooner_toggle',\n        nonce: comingSoonerData.nonce,\n        active: isActive\n      },\n      success(response) {\n        if (response.success) {\n          alert(response.data.message);\n        } else {\n          alert('Error: ' + (response.data || 'Unknown error'));\n          // Revert toggle\n          $('#coming-soon-toggle').prop('checked', !isActive);\n        }\n      },\n      error() {\n        alert('AJAX error. Please try again.');\n        $('#coming-soon-toggle').prop('checked', !isActive);\n      }\n    });\n  });\n\n  // Template Type (Mode) selection (Default / Elementor)\n  $('input[name=\"template_type\"]').on('change', function () {\n    const selectedType = $(this).val();\n    $.ajax({\n      url: comingSoonerData.ajaxUrl,\n      method: 'POST',\n      data: {\n        action: 'coming_sooner_save_template_type',\n        nonce: comingSoonerData.nonce,\n        template_type: selectedType\n      },\n      success(response) {\n        if (response.success) {\n          if (selectedType === 'default') {\n            $('.default-templates').show();\n            $('.elementor-templates').hide();\n          } else if (selectedType === 'elementor') {\n            $('.default-templates').hide();\n            $('.elementor-templates').show();\n          }\n        } else {\n          alert('Error saving template type.');\n        }\n      },\n      error() {\n        alert('AJAX error saving template type.');\n      }\n    });\n  });\n\n  // Select a template button click\n  $('.select-template').on('click', function (e) {\n    e.preventDefault();\n    const templateId = $(this).data('template-id');\n    const templateType = $(this).data('template-type');\n    const $templateCards = templateType === 'default' ? $('.default-templates .template-card') : $('.elementor-templates .template-card');\n    $.ajax({\n      url: comingSoonerData.ajaxUrl,\n      method: 'POST',\n      data: {\n        action: 'coming_sooner_save_template',\n        nonce: comingSoonerData.nonce,\n        template_id: templateId,\n        template_type: templateType\n      },\n      success(response) {\n        if (response.success) {\n          alert(response.data.message);\n          // Update UI to highlight selected template\n          $templateCards.removeClass('selected');\n          $templateCards.filter(function () {\n            return $(this).find('.select-template').data('template-id') === templateId;\n          }).addClass('selected');\n        } else {\n          alert('Error saving template selection.');\n        }\n      },\n      error() {\n        alert('AJAX error saving template selection.');\n      }\n    });\n  });\n\n  // Install Elementor button\n  $('#install-elementor').on('click', function (e) {\n    e.preventDefault();\n    if (!confirm(comingSoonerData.confirmInstall)) {\n      return;\n    }\n    const $btn = $(this);\n    $btn.prop('disabled', true).text('Installing...');\n    $.ajax({\n      url: comingSoonerData.ajaxUrl,\n      method: 'POST',\n      data: {\n        action: 'coming_sooner_install_elementor',\n        nonce: comingSoonerData.nonce\n      },\n      success(response) {\n        if (response.success) {\n          alert(response.data.message);\n          if (response.data.reload) {\n            location.reload();\n          }\n        } else {\n          alert('Error installing Elementor: ' + (response.data || 'Unknown error'));\n          $btn.prop('disabled', false).text('Install Elementor Now');\n        }\n      },\n      error() {\n        alert('AJAX error during Elementor installation.');\n        $btn.prop('disabled', false).text('Install Elementor Now');\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack://coming-sooner/./assets/js/admin.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/js/admin.js"]();
/******/ 	
/******/ })()
;