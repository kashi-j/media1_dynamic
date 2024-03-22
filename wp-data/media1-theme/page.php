<?php get_header(); ?>

  <?php 
    // お問い合わせ
    if(is_page('contact')):
      get_template_part('pages/content','contact_input');
    elseif(is_page('confirm')):
      get_template_part('pages/content','contact_confirm');
    elseif(is_page('comp')):
      get_template_part('pages/content','contact_comp');
    // 店舗一覧
    elseif(is_page('shop')):
      get_template_part('pages/content','shop');
    // 店舗一覧
    elseif(is_page('products')):
      get_template_part('pages/content','products');
    // 企業情報
    elseif(is_page('company')):
      get_template_part('pages/content','company');
    // 事業説明
    elseif(is_page('business_information')):
      get_template_part('pages/content','business_information');
    // プライバシーポリシー
    elseif(is_page('privacypolicy')):
      get_template_part('pages/content','privacypolicy');
    // 利用規約
    elseif(is_page('terms')):
      get_template_part('pages/content','terms');
    // オンラインショップ
    elseif(is_page('online-shop')):
      get_template_part('pages/content','online-shop');
    // 求人情報
    elseif(is_page('recruit')):
      get_template_part('pages/content','recruit');
    // 特集
    elseif(is_page('special_feature')):
      get_template_part('pages/content','special_feature');
    else:
    ?>

      <?php if (have_posts()) : ?>
        <?php while (have_posts()) :the_post(); ?>
          <div class="feature__topick">
            <div class="feature__topick-inner">
              <div class="feature__topick-content">
                <h1 class="feature__topick-content-title"><?php the_title(); ?></h1>
                <p class="feature__topick-content-text"><?php the_content(); ?></p>
              </div>
              <figure class="feature__topick-content-img">
                <?php the_post_thumbnail(); ?>
              </figure>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
      
    <?php endif; ?>

<?php get_footer(); ?>