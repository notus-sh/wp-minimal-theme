<?php

/**
 * Template to display the footer
 */

use MT\Templates\Layout;

?>
    <footer id="site-footer" role="contentinfo" class="header-footer-group">
        
        <?php get_template_part('partials/layout/footer-menu'); ?>
        
        <div class="footer-credits">
            <p><?php echo Layout::copyright(); ?></p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
