<?php get_header(); ?>

  <?php 
    // お知らせ
    if(is_singular('post')):
      get_template_part('posts/post','news');
    // 店舗情報
    elseif(is_singular('shop')):
      get_template_part('posts/post','shop');
    // 商品情報
    elseif(is_singular('products')):
      get_template_part('posts/post','product');
    else:
      // メインクエリ
      if (have_posts()) :
        while (have_posts()) :the_post();
          the_content();
        endwhile;
      endif;
    endif
  ?>


<?php get_footer(); ?>
