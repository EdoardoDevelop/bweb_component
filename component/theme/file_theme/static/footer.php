<?php
/**
 * Footer template for easyParent
 *
 * 
 *
 * @package easyParent
 */
?>

<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?php
                if(is_active_sidebar('footer1')){
                    dynamic_sidebar('footer1');
                }
                ?>
            </div>
            <div class="col-md-4">
                <?php
                if(is_active_sidebar('footer2')){
                    dynamic_sidebar('footer2');
                }
                ?>
            </div>
            <div class="col-md-4">
                <?php
                if(is_active_sidebar('footer3')){
                    dynamic_sidebar('footer3');
                }
                ?>
                <p class="text-right">
                Powered by <a href="https://www.bwebinformatica.com" target="_blank">Bweb Agency</a>
                <p>
            </div>
        </div>
    </div>
</div>
</footer><!-- #colophon -->
    

    <?php wp_footer();?>
</body>
</html>