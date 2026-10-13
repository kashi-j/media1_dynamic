<?php get_header(); ?>

  <?php get_search_form(); ?>

  <!-- 商品一覧 -->
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) :the_post(); ?>
      
      <!-- 記事リンク -->
      <a href="<?php the_permalink(); ?>">商品詳細ページのリンク</a>
      <!-- 店舗名 -->
      <?php the_title(); ?>
      <!-- 見栄え調整 -->
      <br>

    <?php endwhile; ?>
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
    
<?php get_footer(); ?>
