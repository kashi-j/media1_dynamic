    <!-- .footer -->
    <footer class="footer" id="js-footer">
      <div class="footer__inner">
        <div class="footer__content">
          <div class="footer__content-inner">
            <address class="footer__address grid-item01">
              <span class="footer__company-name"></span>
              &#12306;xxx-xxxx<br>
              xxxxxxxxxxxxxxxxxxxx
            </address>

            <!-- ナビメニュー -->
            <?php
              $args = [
                'theme_location'  => 'footer-navigation',
                'container'       => '',
                'container_class' => '',
                'menu_class' => 'footer__list grid-item03',
                'menu_id' => 'footer__list',
                'list_class' => 'footer__item　mod-text-link', // liタグへclass追加
                'anchor_class' => 'mod-text-link', // aタグへclass追加
                'link_before' => '<span class="mod-text-link__underline">',
                'link_after' => '</span>'
              ];
              $nav = wp_nav_menu($args);
            ?>

            <div class="footer__contact grid-item04">
              <div class="footer__btn">
                <a class="footer__btn-link" href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a>
              </div>
              <div class="footer__tel">
                <a class="footer__tel-link" href="tel:xxxxxxxx">TEL:xxx-xxxx-xxxx</a>
              </div>
            </div>

          </div>
        </div>
        <small class="footer__copyright">Copyright(C)All rights reserved.</small>
      </div>
      <div class="footer__backtop" id="js-backtop-btn">
        <a class="footer__backtop-link" href="#pageTop">TOP</a>
      </div>
    </footer>
    <!-- /.footer-->

    <?php wp_footer(); ?>
  </body>
</html>