<h1 class="mod-page-title js-scroll-first"><span class="mod-page-title__decoration">SHOP</span>INFORMATION</h1>
<section class="shop__search">
  <h2 class="shop__subtitle mod-subtitle-slash js-scroll-up">SEARCH STORE</h2>

  <!-- 店舗検索フォーム -->
  <?php get_template_part('parts/searchform', 'shop'); ?>

  <!-- 検索結果 -->
  <div class="shop__inner page__inner js-scroll-up">
    <?php
      // tax_queryの条件作成
      $taxquerysp = array('relation' => 'AND');
      if(isset($_GET['prefecture']) && !empty($_GET['prefecture'])):
        $taxquerysp[] = [
          'taxonomy'=> 'area',
          'field' => 'slug',
          'terms'=> $_GET['prefecture']
        ];
      endif;
      if(isset($_GET['shop_handled_type']) && !empty($_GET['shop_handled_type'])):
        foreach($_GET['shop_handled_type'] as $shop_handled_type):
          $taxquerysp[] = [
            'taxonomy'=> 'products_handled',
            'field' => 'slug',
            'terms'=> $shop_handled_type
          ];
        endforeach;
      endif;
      if(isset($_GET['shop_counter_selling']) && !empty($_GET['shop_counter_selling'])):
        foreach($_GET['shop_counter_selling'] as $shop_counter_selling):
          $taxquerysp[] = [
            'taxonomy'=> 'counter_selling',
            'field' => 'slug',
            'terms'=> $shop_counter_selling
          ];
        endforeach;
      endif;
      $search_args=[
        'tax_query' => $taxquerysp,
        'post_type' => 'shop',
        'no_found_rows' => false,
        'posts_per_page' => -1
      ];
      $the_query = new WP_Query($search_args);
      $found_posts = $the_query->found_posts;
    ?>

    <!-- 店舗が存在する場合 -->
    <?php if($found_posts > 0): ?>
      <div class="shop__search-results">
        <?php
          // 絞り込み店舗のカテゴリ情報を取得
          if ($the_query -> have_posts()) :
            // カテゴリツリーを格納するための配列を初期化
            $category_array = [
              'area_id' => [],
              'prefecture_id' => []
            ];
            while ($the_query -> have_posts()) :$the_query -> the_post();
              $post_id = get_the_ID(); // 現在の投稿IDを取得
              $categories = get_the_terms($post_id,'area'); // 投稿の子カテゴリを取得
              if (is_array($categories) || is_object($categories)):
                foreach ($categories as $category):
                  $child_id = $category->term_id;
                  $parent_id = $category->parent;
  
                  if (!in_array($parent_id, $category_array['area_id'])):
                    $category_array['area_id'][]  = $parent_id;
                  endif;
                  if(!in_array($child_id, $category_array['prefecture_id'])):
                    $category_array['prefecture_id'][]  = $child_id;
                  endif;
                endforeach;
              endif;
            endwhile;
            wp_reset_postdata();
          endif;

          $args = [
            'taxonomy'   => 'area',
            'hide_empty' => true,
            'include' => $category_array['area_id'],
            'parent'     => '0',
          ];
          $terms = get_terms($args);
        ?>

        <?php foreach($terms as $term): ?>
          <div class="results">
            <!-- エリア -->
            <h3 class="results__area"><?php echo $term->name; ?></h3>
            <?php
              $args = [
                'taxonomy'   => 'area',
                'hide_empty' => true,
                'parent' => $term->term_id,
                'include' => $category_array['prefecture_id']
              ];
              $term_children = get_terms($args);
            ?>

            <!-- 都道府県 -->
            <?php foreach($term_children as $term_child):
                $taxquerysp[] = [
                  'taxonomy' => 'area',
                  'field' => 'slug',
                  'terms' => [$term_child->slug]
                ];
                $search_args = [
                  'post_type' => 'shop',
                  'tax_query' => $taxquerysp,
                  'no_found_rows' => false,
                  'posts_per_page' => -1
                ];
                // ループ処理でtax_queryが追加されないよう削除
                array_pop($taxquerysp);
                $the_query = new WP_Query($search_args);
            ?>
            <?php if (have_posts()) : ?>
              <?php while (have_posts()) :the_post(); ?>
                <?php the_content(); ?>
              <?php endwhile; ?>
            <?php endif; ?>
              <div class="results__prefecture">
                <h4 class="results__prefecture-name"><?php echo $term_child -> name; ?></h4>
                <?php if ($the_query -> have_posts()) : ?>
                  <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
                    <div class="results__shop">
                      <h5 class="results__shop-name">
                        <span class="name"><a href="<?php the_permalink(); ?>" class="name__link"><?php the_title(); ?></a></span>
                        <?php
                          $terms = get_the_terms($post->ID, 'shop_type');
                          foreach ($terms as $term) :
                            $shop_type_name = $term->name;
                            $term_info = 'shop_type_' . $term->term_id;
                            $shop_type_color = get_field('label_color',$term_info);
                        ?>
                          <span style="background-color:<?php echo $shop_type_color; ?>" class="category category--media1"><?php echo $shop_type_name; ?></span>
                        <?php endforeach; ?>
                      </h5>
                      <dl>
                        <dt class="results__shop-btn js-detail-trigger"><span></span></dt>
                        <dd class="results__shop-details">
                          <div class="results__shop-info">
                            <div class="results__shop-info-wrapper">
                              <figure class="results__shop-info-img">
                                <img src="<?php echo esc_url(get_theme_file_uri('/assets/img/shop/icon_time.svg')); ?>" alt="営業時間">
                              </figure>
                              <p class="results__shop-hours">
                                <?php 
                                  $business_hours = get_field('business_hours');
                                  $start_time = $business_hours['time']['start_time'];
                                  $finish_time = $business_hours['time']['finish_time'];
                                  echo $start_time . '〜' . $finish_time;
                                ?>
                              </p>
                            </div>
                            <div class="results__shop-info-wrapper">
                              <figure class="results__shop-info-img">
                                <img src="<?php echo esc_url(get_theme_file_uri('/assets/img/shop/icon_tel.svg')); ?>" alt="電話番号">
                              </figure>
                              <?php
                                $tel_number = get_field('tel_number');
                                $changed_tel_number = str_replace("-", "", $tel_number);
                              ?>
                              <a class="results__shop-tel" href="tel:<?php echo $changed_tel_number; ?>"><?php echo get_field('tel_number'); ?></a>
                            </div>
                          </div>
                          <dl class="results__shop-type">
                            <dt class="results__shop-category">Products handled</dt>
                            <dd class="results__shop-handled">
                              <?php
                                $terms = get_the_terms($post->ID, 'products_handled');
                                foreach ($terms as $term) :
                                  $products_handled = $term->name;
                                  $term_info = 'products_handled_' . $term->term_id;
                                  $products_handled_logo_url = get_field('icon_image',$term_info);
                              ?>
                              <figure class="results__shop-icon">
                                <img src="<?php echo $products_handled_logo_url; ?>" alt="<?php echo $products_handled; ?>">
                              </figure>
                              <?php endforeach; ?>
                            </dd>
                          </dl>
                          <dl class="results__shop-type">
                            <dt class="results__shop-category">Services handled</dt>
                            <dd class="results__shop-handled">
                              <?php
                                $terms = get_the_terms($post->ID, 'counter_selling');
                                foreach ($terms as $term) :
                                  $counter_selling = $term->name;
                                  $term_info = 'counter_selling_' . $term->term_id;
                                  $counter_selling_logo_url = get_field('counter_selling_icon',$term_info);
                              ?>
                              <figure class="results__shop-icon">
                                <img src="<?php echo $counter_selling_logo_url; ?>" alt="<?php echo $counter_selling; ?>">
                              </figure>
                              <?php endforeach; ?>
                            </dd>
                          </dl>
                        </dd>
                      </dl>
                    </div>
                  <?php endwhile; ?>
                  <?php wp_reset_postdata(); ?>
                <?php endif; ?>
              </div>
              <!-- ./results__prefecture -->
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

      </div>
    <!-- 該当店舗が存在しない場合 -->
    <?php else: ?>
      <p class="shop__error-text">Not Found</p>
    <?php endif; ?>
    <?php if( function_exists( 'aioseo_breadcrumbs' )): ?>
      <div class="aioseo-breadcrumbs">
        <span class="aioseo-breadcrumb"><a href="http://localhost:10091" title="HOME">HOME</a></span>
        <span class="aioseo-breadcrumb-separator">&gt;</span>
        <span class="aioseo-breadcrumb">STORE INFORMATION</span>
      </div>
    <?php endif; ?>
  </div>
</section>
