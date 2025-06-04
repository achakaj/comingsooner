<?php
/**
 * Default coming soon template
 */

include COMING_SOONER_PLUGIN_DIR . 'includes/Templates/coming-sooner-header.php';
?>

<div class="coming-soon-container">
    <div class="logo-placeholder">🚀</div>
    <h1><?php esc_html_e('Something Awesome is Coming!', 'coming-sooner'); ?></h1>
    <p><?php esc_html_e('We’re working hard to launch our new website. Stay tuned!', 'coming-sooner'); ?></p>
</div>

<?php include COMING_SOONER_PLUGIN_DIR . 'includes/Templates/coming-sooner-footer.php'; ?>
