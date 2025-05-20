jQuery(document).ready(function ($) {
  // Toggle Coming Soon ON/OFF
  $('#coming-soon-toggle').on('change', function () {
    const isActive = $(this).is(':checked');

    $.ajax({
      url: comingSoonerData.ajaxUrl,
      method: 'POST',
      data: {
        action: 'coming_sooner_toggle',
        nonce: comingSoonerData.nonce,
        active: isActive,
      },
      success(response) {
        if (response.success) {
          alert(response.data.message);
        } else {
          alert('Error: ' + (response.data || 'Unknown error'));
          // Revert toggle
          $('#coming-soon-toggle').prop('checked', !isActive);
        }
      },
      error() {
        alert('AJAX error. Please try again.');
        $('#coming-soon-toggle').prop('checked', !isActive);
      },
    });
  });

  // Template Type (Mode) selection (Default / Elementor)
  $('input[name="template_type"]').on('change', function () {
    const selectedType = $(this).val();

    $.ajax({
      url: comingSoonerData.ajaxUrl,
      method: 'POST',
      data: {
        action: 'coming_sooner_save_template_type',
        nonce: comingSoonerData.nonce,
        template_type: selectedType,
      },
      success(response) {
        if (response.success) {
          if (selectedType === 'default') {
            $('.default-templates').show();
            $('.elementor-templates').hide();
          } else if (selectedType === 'elementor') {
            $('.default-templates').hide();
            $('.elementor-templates').show();
          }
        } else {
          alert('Error saving template type.');
        }
      },
      error() {
        alert('AJAX error saving template type.');
      },
    });
  });

  // Select a template button click
  $('.select-template').on('click', function (e) {
    e.preventDefault();

    const templateId = $(this).data('template-id');
    const templateType = $(this).data('template-type');
    const $templateCards =
      templateType === 'default'
        ? $('.default-templates .template-card')
        : $('.elementor-templates .template-card');

    $.ajax({
      url: comingSoonerData.ajaxUrl,
      method: 'POST',
      data: {
        action: 'coming_sooner_save_template',
        nonce: comingSoonerData.nonce,
        template_id: templateId,
        template_type: templateType,
      },
      success(response) {
        if (response.success) {
          alert(response.data.message);
          // Update UI to highlight selected template
          $templateCards.removeClass('selected');
          $templateCards
            .filter(function () {
              return $(this).find('.select-template').data('template-id') === templateId;
            })
            .addClass('selected');
        } else {
          alert('Error saving template selection.');
        }
      },
      error() {
        alert('AJAX error saving template selection.');
      },
    });
  });

  // Install Elementor button
  $('#install-elementor').on('click', function (e) {
    e.preventDefault();

    if (!confirm(comingSoonerData.confirmInstall)) {
      return;
    }

    const $btn = $(this);
    $btn.prop('disabled', true).text('Installing...');

    $.ajax({
      url: comingSoonerData.ajaxUrl,
      method: 'POST',
      data: {
        action: 'coming_sooner_install_elementor',
        nonce: comingSoonerData.nonce,
      },
      success(response) {
        if (response.success) {
          alert(response.data.message);
          if (response.data.reload) {
            location.reload();
          }
        } else {
          alert('Error installing Elementor: ' + (response.data || 'Unknown error'));
          $btn.prop('disabled', false).text('Install Elementor Now');
        }
      },
      error() {
        alert('AJAX error during Elementor installation.');
        $btn.prop('disabled', false).text('Install Elementor Now');
      },
    });
  });
});
