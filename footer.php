<?php

/**
 * Template to display the footer
 */

use MT\Templates\Layout;

?>

    <footer id="site-footer" role="contentinfo" class="header-footer-group">
        <div class="section-inner">
            <div class="footer-credits">
              <p class="footer-copyright"><?php echo Layout::copyright(); ?></p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
