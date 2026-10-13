<?php get_header(); ?>

<div class="products-detail__inner page__inner">
  <a class="mod-text-btn mod-text-btn--black" href="<?php echo esc_url(home_url('/products')); ?>"><span class="mod-text-btn__arrow"></span>Return</a>
  
  <div class="content__list js-scroll-first">
    <ul class="content__list-wrapper list">
      <?php 
        $args = [
          'taxonomy' => 'brand',
          'hide_empty' => false,
        ];
        $terms = get_terms($args);
      ?>
      <?php
        foreach($terms as $term):
          $brand_url = home_url('/products/brand/') . $term->slug;
      ?>
        <li class="list__item">
        <a class="list__link mod-item-link" href="<?php echo esc_url($brand_url); ?>"><?php echo $term->name; ?><span class="mod-item-link__arrow"></span></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <?php 
    $term = get_queried_object();
    $term_info = 'brand_' . $term->term_id;
  ?>

  <div class="products-detail__content content js-scroll-up">
    <div class="content__wrapper">
      <div class="content__img">
        <?php $image_group = get_field('image_group',$term_info); ?>
        <figure class="content__img-main">
          <?php
            $image_id = $image_group['brand_image01'];
            if(!empty($image_id)):
              $image = wp_get_attachment_image_src($image_id,'large');
              $image_url = $image[0];
              $image_alt = get_post_meta ( get_post ($image_id) -> ID , '_wp_attachment_image_alt' , true );
            else:
              $image_url = get_theme_file_uri('assets/img/common/noimage.png');
              $image_alt = '';
            endif;
          ?>
          <img width="429" height="420" src="<?php echo $image_url ?>" alt="<?php echo $image_alt; ?>" id="js-product-mainImg" class="" loading="eager">
        </figure>
        <div class="content__swiper swiper-container">
          <div class="swiper-wrapper content__swiper-wrapper">
            <?php
              for ($i = 1; $i <= 6; $i++) :
                $brand_image_field = 'brand_image0' . $i;
                if(!empty($image_group[$brand_image_field])):
                  $brand_image_id = $image_group[$brand_image_field];
                  $brand_image_alt = get_post_meta ( get_post ($brand_image_id) -> ID , '_wp_attachment_image_alt' , true );
                  // 小画像
                  $brand_small_image = wp_get_attachment_image_src($brand_image_id,'thumbnail');
                  $brand_small_image_url = $brand_small_image[0];
                  // 大画像
                  $brand_large_image = wp_get_attachment_image_src($brand_image_id,'large');
                  $brand_large_image_url = $brand_large_image[0];
            ?>
                <div class="swiper-slide content__swiper-slide">
                  <figure class="content__swiper-item">
                    <img
                      width="90"
                      height="90"
                      src="<?php echo $brand_small_image_url; ?>" alt="<?php echo $brand_image_alt; ?>"
                      loading="lazy" class="content__swiper-img"
                      data-image="<?php echo $brand_large_image_url; ?>"
                    >
                  </figure>
                </div>
            <?php
                else:
                  if($i == 1):
            ?>
                    <div class="swiper-slide content__swiper-slide">
                      <figure class="content__swiper-item">
                        <img
                          width="90"
                          height="90"
                          src="<?php echo get_theme_file_uri('assets/img/common/noimage.png'); ?>" alt=""
                          loading="lazy" class="content__swiper-img"
                          data-image="<?php echo get_theme_file_uri('assets/img/common/noimage.png'); ?>"
                        >
                      </figure>
                    </div>
            <?php
                  else:
                    continue;
                  endif;
                endif;
              endfor;
            ?>
          </div>
        </div>
      </div>
      <div class="content__info">
        <h1 class="content__title"><?php echo $term->name; ?></h1>
        <p class="content__text"><?php echo $term->description; ?></p>
        <?php
          $notice_list = get_field('notice_list',$term_info);
          $is_empty = true;

          if ($notice_list) {
            foreach ($notice_list as $notice) {
              if (!empty($notice)) {
                $is_empty = false;
                break;
              }
            }
          }
        ?>
        <?php if(!$is_empty) : ?>
          <ul class="content__notes">
            <?php if($notice_list['notice01']): ?>
              <li class="content__notes-text"><?php echo $notice_list['notice01']; ?></li>
            <?php endif; ?>
            <?php if($notice_list['notice02']): ?>
              <li class="content__notes-text"><?php echo $notice_list['notice02']; ?></li>
            <?php endif; ?>
            <?php if($notice_list['notice03']): ?>
              <li class="content__notes-text"><?php echo $notice_list['notice03']; ?></li>
            <?php endif; ?>
            <?php if($notice_list['notice04']): ?>
              <li class="content__notes-text"><?php echo $notice_list['notice04']; ?></li>
            <?php endif; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
    <?php $feature_group = get_field('feature_group',$term_info); ?>
    <?php if($feature_group): ?>
      <div class="content__details">
        <div class="content__details-table">
          <?php if($feature_group['feature_title01'] && $feature_group['feature_content01']): ?>
            <dl class="content__details-item">
              <dt class="content__details-head"><?php echo $feature_group['feature_title01']; ?></dt>
              <dd class="content__details-detail"><?php echo $feature_group['feature_content01']; ?></dd>
            </dl>
          <?php endif; ?>
          <?php if($feature_group['feature_title02'] && $feature_group['feature_content02']): ?>
            <dl class="content__details-item">
              <dt class="content__details-head"><?php echo $feature_group['feature_title02']; ?></dt>
              <dd class="content__details-detail"><?php echo $feature_group['feature_content02']; ?></dd>
            </dl>
          <?php endif; ?>
          <?php if($feature_group['feature_title03'] && $feature_group['feature_content03']): ?>
            <dl class="content__details-item">
              <dt class="content__details-head"><?php echo $feature_group['feature_title03']; ?></dt>
              <dd class="content__details-detail"><?php echo $feature_group['feature_content03']; ?></dd>
            </dl>
          <?php endif; ?>
          <?php if($feature_group['feature_title04'] && $feature_group['feature_content04']): ?>
            <dl class="content__details-item">
              <dt class="content__details-head"><?php echo $feature_group['feature_title04']; ?></dt>
              <dd class="content__details-detail"><?php echo $feature_group['feature_content04']; ?></dd>
            </dl>
          <?php endif; ?>
          <?php if($feature_group['feature_title05'] && $feature_group['feature_content05']): ?>
            <dl class="content__details-item">
              <dt class="content__details-head"><?php echo $feature_group['feature_title05']; ?></dt>
              <dd class="content__details-detail"><?php echo $feature_group['feature_content05']; ?></dd>
            </dl>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
    <?php $store_url = get_field('store_url',$term_info); ?>
    <?php if(!empty($store_url)): ?>
      <a class="mod-shop-link mod-shop-link--official" target="_blank" href="<?php echo esc_url($store_url); ?>">Purchase from official online store</a>
    <?php endif; ?>

    <?php
      $term = get_queried_object();
      $args = [
        'post_type' => 'products',
        'tax_query' => [[
          'taxonomy' => 'brand',
          'field' => 'slug',
          'terms' => $term->slug
        ]],
        'post__not_in' => [get_queried_object_id()],
        'posts_per_page' => -1
      ];
      $the_query = new WP_Query($args);
      $found_posts = $the_query->found_posts;
    ?>
    <?php
      if($found_posts < 1):
        if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs();
      endif; 
    ?>
  </div>
</div>



<?php if ($the_query -> have_posts()) : ?>
  <section class="products-detail__related related js-scroll-up">
    <div class="related__inner">
      <h2 class="related__title">Related products of <span class="title-in">"<?php echo $term->name; ?>"</span></h2>
      <div class="related__swiper swiper-container">
        <div class="swiper-wrapper related__swiper-wrapper">
          <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
            <!-- スライド -->
            <div class="swiper-slide related__swiper-slide">
              <a class="swiper-link" href="<?php the_permalink(); ?>">
                <figure class="swiper-img">
                  <?php
                    if(has_post_thumbnail()):
                      the_post_thumbnail();
                    else:
                      echo '<img src="' . get_theme_file_uri('assets/img/common/noimage.png') . '" />';
                    endif;
                  ?>
                </figure>
                <?php $terms = get_the_terms($post->ID,'brand'); ?>
                <?php foreach($terms as $term): ?>
                  <div class="swiper-name__wrapper">
                    <figure class="swiper-logo">
                      <?php
                        $term_info="brand_" . $term->term_id;
                        $brand_logo_url = get_field('brand_logo',$term_info)
                      ?>
                      <img src="<?php echo $brand_logo_url; ?>" alt="" width="30" height="30">
                    </figure>
                    <h3 class="swiper-name"><?php the_title(); ?></h3>
                  </div>
                <?php endforeach; ?>
              </a>
            </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        </div>
        <div class="swiper-button">
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>
      <?php if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs(); ?>
    </div>
  </section>
<?php endif; ?>

<?php get_footer(); ?>
