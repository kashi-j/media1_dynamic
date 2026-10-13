<div class="company__inner page__inner">
  <h1 class="mod-page-title js-scroll-first"><span class="mod-page-title__decoration">company</span>企業情報</h1>
  <div class="company__content">
    <div class="company__main-content">

      <?php 
        if (have_posts()) :
          while (have_posts()) :the_post();
            the_content();
          endwhile;
        endif;
      ?>

    </div>
    <?php get_sidebar(); ?>
  </div>
  <?php if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs(); ?>
</div>

