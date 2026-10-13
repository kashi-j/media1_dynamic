<div class="news-detail__inner page__inner js-scroll-first">
  <h1 class="mod-page-title"><span class="mod-page-title__decoration">news</span></h1>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) :the_post(); ?>
      <div class="news-detail__content">
        <div class="news-detail__title-info">
          <time
            datetime="<?php echo get_the_date('Y-m-d') ?>"
            class="news-detail__date">
            <?php echo get_the_date('Y.m.d') ?>
          </time>
          <span class="news-detail__category">
            <?php
              $cat = get_the_category();
              $cat = $cat[0];
              echo $cat->cat_name; 
            ?>
          </span>
        </div>
        <h2 class="news-detail__title"><?php the_title(); ?></h2>
        <div class="blog-content-wrapper">
          <?php the_content(); ?>
        </div>
        <a class="mod-text-btn" href="<?php echo esc_url(home_url('/news'));?>"><span class="mod-text-btn__arrow"></span>return archive</a>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>