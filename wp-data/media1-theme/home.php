<?php get_header(); ?>

<div class="news__inner page__inner js-scroll-first">
  <h1 class="mod-page-title"><span class="mod-page-title__decoration">news</span>Archive</h1>
  <div class="news__content">


  <!-- カテゴリー -->
  <?php
    $term = get_term_by('slug','category');
    $term_id = !empty($term)? $term->term_id : '';
    $args = [
      'taxonomy' => 'category',
      'hide_empty' => true,
      'exclude' => [1,$term_id]
    ];
    $terms = get_terms($args);
  ?>

  <!-- クエリパラメータあり -->
  <?php if(!empty($_GET)): ?>
    <!-- カテゴリー -->
    <ul class="news__category-links">
    <!-- All -->
      <li class="news__category-item">
        <a class="news__category-link" href="<?php echo esc_url(home_url('/news')); ?>">ALL<span class="mod-arrow"></span></a>
      </li>
      <?php foreach($terms as $term): ?>
        <?php $category_path= home_url('/news') . '?category=' . $term->slug; ?>
        <li class="news__category-item"><a class="news__category-link <?php if(get_query_var('category') == $term->slug ) : echo 'is-active'; endif; ?>" href="<?php echo esc_url($category_path); ?>"><?php echo $term->name; ?><span class="mod-arrow"></span></a></li>
      <?php endforeach; ?>
    </ul>

    <!-- お知らせ一覧 -->
    <?php
      if(get_query_var('category')) :
        $paged = get_query_var( 'paged' ) ?: 1;
        $args = [
          'post_type' => 'post',
          'paged' => $paged,
          'tax_query' => [[
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => get_query_var('category')
          ]]
        ];
      elseif(get_query_var('tags')) :
        $args = [
          'post_type' => 'post',
          'tax_query' => [[
            'taxonomy' => 'tag',
            'field' => 'slug',
            'terms' => get_query_var('tags')
          ]]
        ];
      else :
        $args = [
          'post_type' => 'post'
        ];
      endif;
      
      $the_query = new WP_Query($args);
    ?>

    <?php if($the_query->have_posts()): ?>
      <div class="news__content-item">
        <ul class="news__list">
          <?php while($the_query->have_posts()): $the_query->the_post(); ?>
            <li class="news__item">
              <a href="<?php the_permalink(); ?>" class="news__link">
                <div class="news__item-wrapper">
                  <time datetime="<?php echo get_the_date('Y-m-d') ?>" class="news-detail__date"><?php echo get_the_date('Y.m.d') ?></time>
                  <?php
                    $category_slug = get_query_var('category');
                    $category = get_category_by_slug($category_slug);
                  ?>
                  <span class="news__category"><?php echo $category->cat_name; ?></span>
                </div>
                <p class="news__title"><?php the_title(); ?></p>
                <span class="mod-arrow"></span>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    <?php else: ?>
      <div class="news__content-item">
        <ul class="news__list">
          <li class="news__item"><p>該当記事がありません</p></li>
        </ul>
      </div>
    <?php endif; ?>

    <!-- ページネーション -->
    <?php
      if($the_query->max_num_pages > 1):
        $is_mobile = wp_is_mobile();
        $mid_size = $is_mobile ? 0.5 : 2;
        $args = [
          'total' => $the_query->max_num_pages,
          'mid_size' => $mid_size,
          'prev_text' => '',
          'next_text' => '',
          'screen_reader_text' => 'ページャー',
          'type' => 'list'
        ];
        the_posts_pagination($args);
      endif;
    ?>
    <?php wp_reset_postdata(); ?>

  <!-- クエリパラメータなし -->
  <?php else: ?>

    <!-- カテゴリー -->
    <ul class="news__category-links">
      <!-- All -->
      <li class="news__category-item">
          <a class="news__category-link is-active" href="<?php echo esc_url(home_url('/news')); ?>">ALL<span class="mod-arrow"></span></a>
      </li>
      <?php foreach($terms as $term): ?>
        <?php $category_path= home_url('/news') . '?category=' . $term->slug; ?>
        <li class="news__category-item"><a class="news__category-link" href="<?php echo esc_url($category_path); ?>"><?php echo $term->name; ?><span class="mod-arrow"></span></a></li>
      <?php endforeach; ?>
    </ul>

    <!-- お知らせ一覧 -->
    <?php if (have_posts()) : ?>
      <div class="news__content-item">
        <ul class="news__list">
          <?php while (have_posts()) :the_post(); ?>
            <li class="news__item">
              <a href="<?php the_permalink(); ?>" class="news__link">
                <div class="news__item-wrapper">
                  <time datetime="<?php echo get_the_date('Y-m-d') ?>" class="news-detail__date"><?php echo get_the_date('Y.m.d') ?></time>
                  <?php
                    $categories = get_the_category();
                    foreach($categories as $category):
                  ?>
                    <span class="news__category"><?php echo $category->cat_name; ?></span>
                  <?php endforeach;?>
                </div>
                <p class="news__title"><?php the_title(); ?></p>
                <span class="mod-arrow"></span>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- ページネーション -->
    <?php
      $is_mobile = wp_is_mobile();
      $mid_size = $is_mobile ? 0.5 : 2;
      $args = [
        'mid_size' => $mid_size,
        'prev_text' => '',
        'next_text' => '',
        'screen_reader_text' => 'ページャー',
        'type' => 'list'
      ];

      the_posts_pagination($args);
    ?>
  <?php endif; ?> 


  </div>
  <!-- /.news__content -->


  <!-- パンくず -->
  <?php if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs(); ?>

</div>
<!-- /.news__inner -->

<?php get_footer(); ?>