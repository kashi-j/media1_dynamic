<?php get_header(); ?>

<?php 
  $args = [
    'post_type' => 'management',
    'name' => 'top-main-visual'
  ];
  $the_query = new WP_Query($args);
?>

<!-- MV -->
<div class="top__mv">
  <div class="top__mv-swiper swiper-container">
    <div class="top__mv-swiper-wrapper swiper-wrapper">
      <?php if ($the_query -> have_posts()) : ?>
        <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

          <?php
            $media_group = get_field('media_select');
            for ($i = 1; $i <= 8; $i++) :
              $media_field = 'media0' . $i;
              $media_type = 'media_type0' . $i;
              $image_field = 'image0' . $i;
              $url_field = 'url0' . $i;
              $video_url = 'video_url0' . $i;
              $media_format = $media_group[$media_field][$media_type];
              if($media_format == 'unselected' || (empty($media_group[$media_field][$image_field]) && empty($media_group[$media_field][$video_url]))):
                continue;
              endif;
          ?>
            <div class="top__mv-swiper-slide swiper-slide">
              <?php if($media_format == 'image'): ?>
                <?php 
                  if(!empty($media_group[$media_field][$image_field])):
                    $image = wp_get_attachment_image($media_group[$media_field][$image_field],'full');
                    $banner_url = $media_group[$media_field][$url_field];
                ?>
                    <?php if($banner_url): ?><a class="top__mv-swiper-link" href="<?php echo esc_url($banner_url); ?>"><?php endif; ?>
                      <figure class="top__mv-swiper-img">
                        <?php echo $image; ?>
                      </figure>
                    <?php if($banner_url): ?></a><?php endif; ?>
                <?php endif; ?>
              <?php elseif($media_format == 'video'): ?>
                <?php if(!empty($media_group[$media_field][$video_url])): ?>
                  <div class="top__mv-swiper-img">
                    <video src="<?php echo $media_group[$media_field][$video_url]; ?>" type="video/mp4" <?php if($i == 1){echo 'autoplay';} ?> muted loop playsinline></video>
                  </div>
                <?php endif; ?>
              <?php else: ?>
                <?php ?>
              <?php endif; ?>
            </div>
          <?php endfor; ?>

        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
    <div class="swiper-button-prev">
      <img src="<?php echo esc_url(get_theme_file_uri('/assets/img/top/icon_arrow.png')); ?>" alt="次へ" width="60" height="60">
    </div>
    <div class="swiper-button-next">
      <img src="<?php echo esc_url(get_theme_file_uri('/assets/img/top/icon_arrow.png')); ?>" alt="前へ" width="60" height="60">
    </div>
  </div>
    

  <!-- お知らせ取得 -->
  <?php
    $args = [
      'post_type' => 'post',
      'post__in' => get_option('sticky_posts'), // 先頭固定表示指定
      'posts_per_page' => 5,
      'order' => 'DESC',
      'orderby' => 'date',
    ];
    $the_query = new WP_Query($args);
  ?>

  <?php if ($the_query -> have_posts()) : ?>
    <div class="top__mv-news mv-news">
      <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
        <a class="mv-news__link" href="<?php the_permalink(); ?>">
          <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="mv-news__date"><?php echo get_the_date('Y.m.d') ?></time>
          <span class="mv-news__title"><?php the_title(); ?></span>
        </a>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  <?php endif; ?>


</div>

<!-- Brand -->
<section class="top__content brand">
  <div class="brand__inner side-scroll">
    <div class="brand__container side-scroll-container container">
      <div class="brand__heading side-scroll-heading">
        <h2 class="top__content-title"><span>Item Brand</span></h2>
        <div class="top__content-lead">
          <p class="top__content-text">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.</br> Soluta beatae facere sequi vitae excepturi consectetur assumenda eveniet alias placeat.</br> Illo pariatur excepturi earum architecto sed, illum voluptatem eius iste fuga!
          </p>
          <a class="mod-text-btn mod-text-btn--black" href="<?php echo esc_url(home_url('/products')); ?>"><span class="mod-text-btn__arrow"></span></a>
        </div>
      </div>
      <div class="brand__content side-scroll-list-wrapper">
        <ul class="brand__content-list side-scroll-list list">
          <?php
            $args = [
              'taxonomy' => 'brand',
              'hide_empty' => false,
            ];
            $terms = get_terms($args);
            foreach($terms as $term):
              $brand_path = home_url('/products/brand/') . $term -> slug;
              $term_info = 'brand_' . $term->term_id;
              $image_group = get_field('image_group',$term_info);
              if(!empty($image_group['brand_image01'])):
                $image = wp_get_attachment_image($image_group['brand_image01'],'full');
              else:
                $no_image_url = get_theme_file_uri('assets/img/common/noimage.png');
                $image = '<img src="' . $no_image_url . '" loading="lazy">';
              endif;
          ?>
          <li class="list__item side-scroll-item">
            <a href="<?php echo esc_url($brand_path); ?>">
              <div class="list__inner">
                <figure class="list__img">
                  <?php echo $image; ?>
                </figure>
                <h3 class="list__title"><?php echo $term->name; ?></h3>
                <p class="list__text"><?php the_field('catch_copy',$term_info); ?></p>
              </div>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- product -->
<section class="top__content product">
  <div class="top__content-wrapper">
    <h2 class="top__content-title"><span>Recommended Item</span></h2>
    <div class="top__content-lead">
      <p class="top__content-text">            Lorem ipsum, dolor sit amet consectetur adipisicing elit.</br> Soluta beatae facere sequi vitae excepturi consectetur assumenda eveniet alias placeat.</br> Illo pariatur excepturi earum architecto sed, illum voluptatem eius iste fuga!</p>
      <a class="mod-text-btn mod-text-btn--black" href="<?php echo esc_url(home_url('/products#item-search')); ?>"><span class="mod-text-btn__arrow"></span></a>
    </div>
  </div>
  <!-- スライダー -->
  <div class="product__swiper swiper-container">
    <div class="product__swiper-wrapper swiper-wrapper">
      <?php
        $args = [
          'post_type' => 'management',
          'name' => 'recommended_top'
        ];
        $the_query = new WP_Query($args);
      ?>
      <?php if ($the_query -> have_posts()) : ?>
        <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
          <?php
            $recommended_posts = get_field('post_select');
            foreach($recommended_posts as $recommended_post):
          ?>
            <?php
              $image_url = get_the_post_thumbnail_url($recommended_post->ID) ?: get_theme_file_uri('assets/img/common/noimage.png');
            ?>
            <div class="swiper-slide product__swiper-slide">
              <a class="product__swiper-link" href="<?php echo get_permalink($recommended_post->ID); ?>">
                <figure class="product__swiper-img">
                  <img src="<?php echo esc_url($image_url); ?>" alt="" width="237" height="244" loading="lazy">
                </figure>
                <h3 class="product__swiper-name"><?php echo $recommended_post->post_title; ?></h3>
              </a>
            </div>
          <?php endforeach; ?>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No recommended products are registered.</p>
      <?php endif; ?>
    </div>
    <div class="swiper-button">
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</section>

<section class="top__content effort">
  <h2 class="effort__title">Section Title</h2>
  <div class="effort__slide slide">
    <button class="slide__btn slide__btn--prev mod-arrow" id="js-prev-btn"></button>
    <div class="slide__item front">
      <div class="slide__item-inner">
        <figure class="slide__item-img">
          <img src="<?php echo esc_url(get_theme_file_uri('/assets/img/common/noimage.png')); ?>" alt="" width="400" height="300">
        </figure>
        <div class="slide__item-text">
          <h3 class="slide__item-title"><span>01</span>heading1</h3>
          <p class="slide__item-lead">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error illum, nostrum qui blanditiis suscipit quas, veniam atque labore dolorem voluptas nam quidem asperiores enim molestias aut tempore? Maxime, iusto laudantium.
          </p>
        </div>
      </div>
    </div>
    <div class="slide__item right">
      <div class="slide__item-inner">
        <figure class="slide__item-img">
          <img src="<?php echo esc_url(get_theme_file_uri('/assets/img/common/noimage.png')); ?>" alt="" width="400" height="300">
        </figure>
        <div class="slide__item-text">
          <h3 class="slide__item-title"><span>02</span>heading2</h3>
          <p class="slide__item-lead">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi quod nesciunt praesentium animi quidem autem numquam fuga hic distinctio voluptas molestiae odio veniam reprehenderit suscipit, natus nobis, aperiam provident quia!
          </p>
        </div>
      </div>
    </div>
    <div class="slide__item left">
      <div class="slide__item-inner">
        <figure class="slide__item-img">
          <img src="<?php echo esc_url(get_theme_file_uri('/assets/img/common/noimage.png')); ?>" alt="" width="400" height="300">
        </figure>
        <div class="slide__item-text">
          <h3 class="slide__item-title"><span>03</span>heading3</h3>
          <p class="slide__item-lead">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis quia asperiores laborum, enim nulla amet cumque dolores totam mollitia, molestias voluptates? Placeat pariatur commodi vitae. Alias culpa sapiente aperiam corrupti.
          </p>
        </div>
      </div>
    </div>
    <button class="slide__btn slide__btn--next mod-arrow" id="js-next-btn"></button>
  </div>
</section>
  
<!-- 最新のお知らせ -->
<section class="top__content news">
  <div class="top__content-inner">
    <div class="top__content-title">
      <h2 class="mod-subtitle-slash">News</h2>
      <a class="mod-text-btn mod-text-btn--black" href="<?php echo esc_url(home_url('/news')); ?>"><span class="mod-text-btn__arrow"></span></a>
    </div>

    <!-- 通常お知らせ　表示件数：6件、日付、カテゴリ名、タイトルを表示 -->
    <?php
      $args = array(
        'post_type' => 'post',
        'ignore_sticky_posts' => 1, // 先頭固定表示を無効
        'posts_per_page' => 6,
        'order' => 'DESC',
        'orderby' => 'date',
      );
      $the_query = new WP_Query($args);
    ?>

    <?php if ($the_query -> have_posts()) : ?>
      <ul class="news__list">
        <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
          <li class="news__item">
            <a class="news__link" href="<?php the_permalink(); ?>">
              <div class="news__item-wrapper">
                <time datetime="<?php echo get_the_date('Y-m-d') ?>" class="news-detail__date"><?php echo get_the_date('Y.m.d') ?></time>

                <?php
                  $cat = get_the_category();
                  $cat = $cat[0];
                ?>

                <span class="news__category"><?php echo $cat->cat_name; ?></span>
              </div>
              <p class="news__title"><?php the_title(); ?></p>
              <span class="mod-arrow"></span>
            </a>
          </li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </ul>
    <?php else: ?>
      <?php echo '投稿記事がありません。' ?>
    <?php endif; ?>
  </div>
</section>

<!-- Instagram -->
<section class="top__content insta">
  <div class="top__content-inner">
    <div class="insta__title-wrapper">
      <h2 class="insta__title mod-subtitle-slash">instagram</h2>
    </div>
    <div class="insta__wrapper">
      <?php
        echo do_shortcode('[instagram-feed feed=1]');
      ?>
    </div>
  </div>
</section>

<!-- banner -->
<?php
  $args = [
    'post_type' => 'management',
    'name' => 'top-banner'
  ];
  $the_query = new WP_Query($args);
?>

<section class="top__banner banner">
  <?php if ($the_query -> have_posts()) : ?>
    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
      <?php
        $banner_group = get_field('images_select');
        $is_empty = true; 
        foreach($banner_group as $banner):
          if (!empty($banner)) : // フィールドが空でない場合
            $is_empty = false;
            break;
          endif;
        endforeach;
      ?>

        <ul class="banner__list">
          <?php
            for ($i = 1; $i <= 8; $i++) :
              $banner_field = 'banner0' . $i;
              $image_field = 'image0' . $i;
              $url_field = 'url0' . $i;
              if(!empty($banner_group[$banner_field][$image_field])):
                $image = wp_get_attachment_image($banner_group[$banner_field][$image_field],'full');
              else:
                continue;
              endif;
              $banner_url = $banner_group[$banner_field][$url_field];
          ?>
            <li class="banner__item">
              <?php if($banner_url): ?>
                <a href="<?php echo esc_url($banner_url); ?>">
              <?php endif; ?>
              <?php echo $image; ?>
              <?php if($banner_url): ?>
                </a>
              <?php endif; ?>
            </li>
          <?php endfor; ?>
        </ul>
        
      <?php endwhile; ?>
  <?php endif; ?>

  <?php if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs(); ?>
</section>

<?php get_footer(); ?>