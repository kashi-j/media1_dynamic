<?php
/* Template Name: 特集専用レイアウト */
?>

<?php get_header(); ?>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) :the_post(); ?>
      <?php $recommended_posts = get_field('recommendation'); ?>
      <div class="feature__topick">
        <div class="feature__topick-inner">
          <div class="feature__topick-content">
            <h1 class="feature__topick-content-title"><?php the_title(); ?></h1>
            <p class="feature__topick-content-text"><?php the_content(); ?></p>
          </div>
          <!-- パンクズ -->
          <?php
            if(!$recommended_posts):
              if( function_exists( 'aioseo_breadcrumbs')) :
                aioseo_breadcrumbs();
              endif;
            endif;
          ?>
        </div>
      </div>
      
      <!-- おすすめ商品 -->
      <?php if($recommended_posts): ?>
        <div class="feature__deco"></div>
        <div class="feature__inner page__inner">
          <section class="feature__items">
            <h2 class="feature__title mod-subtitle-slash">Recommended product</h2>
            <ul class="feature__items-list">
              <?php
                foreach($recommended_posts as $recommended_post):
                  $image_url = get_the_post_thumbnail_url($recommended_post->ID) ?: get_theme_file_uri('assets/img/common/noimage.png');
                  $product_description = get_field('product_description',$recommended_post->ID);
              ?>
              <li class="feature__items-content">
                <figure class="feature__items-img">
                  <img src="<?php echo $image_url; ?>" alt="">
                </figure>
                <div class="feature__items-detail">
                  <div class="feature__items-wrapper">
                    <h3 class="feature__items-title"><?php echo $recommended_post->post_title; ?></h3>
                    <p class="feature__items-text"><?php echo nl2br(esc_html($product_description)); ?></p>
                  </div>
                  <a class="mod-text-btn" href="<?php echo get_permalink($recommended_post->ID); ?>">Return to detail<span class="mod-text-btn__arrow"></span></a>
                </div>
              </li>
              <?php endforeach;?>
            </ul>
          </section>
          <!-- パンクズ -->
          <?php
            if( function_exists( 'aioseo_breadcrumbs')) :
              aioseo_breadcrumbs();
            endif;
          ?>
        </div>
      <?php endif; ?>
    <?php endwhile; ?>
  <?php endif; ?>
<?php get_footer(); ?>