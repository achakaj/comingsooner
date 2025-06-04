<?php
/**
 * Default Maintenance Mode template
 */
include COMING_SOONER_PLUGIN_DIR . 'includes/Templates/coming-sooner-header.php';
?>

<div class="coming-soon-container">
    <div class="logo-placeholder">🛠️</div>
    <h1><?php esc_html_e('Maintenance Mode', 'coming-sooner'); ?></h1>
    <p><?php esc_html_e('We\'re currently working on some improvements. Check back shortly!', 'coming-sooner'); ?></p>
</div>

<?php include COMING_SOONER_PLUGIN_DIR . 'includes/Templates/coming-sooner-footer.php'; ?>
