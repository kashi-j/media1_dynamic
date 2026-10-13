<div class="products__inner page__inner">
  <h1 class="mod-page-title js-scroll-first"><span class="mod-page-title__decoration">Brand</span>Search By Brand</h1>
  <section class="products__content js-scroll-up">
    <ul class="products__wrapper">
      <?php
        $args = [
          'taxonomy' => 'brand',
          'hide_empty' => false,
        ];
        $terms = get_terms($args);
        foreach($terms as $term):
          $term_info = 'brand_' . $term->term_id;
          $image_group = get_field('image_group', $term_info);
          if(!empty($image_group['brand_image01'])):
            $image = wp_get_attachment_image($image_group['brand_image01'],'full');
          else:
            $no_image_url = get_theme_file_uri('assets/img/common/noimage.png');
            $image = '<img src="' . $no_image_url . '" loading="lazy">';
          endif;
          $brand_copy = mb_substr(get_field('catch_copy',$term_info),0,26);
          $brand_url = home_url('products/brand/') . $term->slug;
      ?>
        <li class="products__item">
          <div class="products__item-inner">
            <figure class="products__item-img">
              <?php echo $image; ?>
            </figure>
            <div class="products__item-text">
              <h3 class="products__item-name"><a class="mod-item-link" href="<?php echo esc_url($brand_url); ?>"><span class="mod-item-link__name"><?php echo $term->name; ?></span><span class="mod-item-link__arrow"></span></a></h3>
              <?php if($brand_copy): ?>
                <p class="products__item-description"><?php echo $brand_copy; ?></p>
              <?php endif; ?>
            </div>
          </div>
        </li>
      <?php endforeach;?>
    </ul>
  </section>
        
  <!-- 商品検索 -->
  <section class="products__content js-scroll-up" id="item-search">
    <h1 class="mod-page-title"><span class="mod-page-title__decoration">Item</span>Item Search</h1>

    <!-- 商品検索フォーム -->
    <?php get_template_part('parts/searchform','products'); ?>

    <!-- クエリパラメータあり -->
    <?php if(!empty($_GET)): ?>
      <?php
        // ページ番号
        $paged = get_query_var( 'paged' ) ?: 1;
        $posts_per_page = 20; //メインクエリと揃える
        if(isset($_GET['product_category'])){
          $product_categories = $_GET['product_category'];
          $taxquerysp = [[
            'taxonomy'=> 'product_category',
            'field' => 'slug',
            'terms'=> $product_categories
          ]];
        }else{
          $taxquerysp = [['']];
        }
        $search_args=[
          's' => $_GET['s'],
          'tax_query' => $taxquerysp,
          'paged' => $paged,
          'post_type' => 'products',
          'posts_per_page' => $posts_per_page, // メインクエリと揃える
          'no_found_rows' => false,
        ];
        $the_query = new WP_Query($search_args);
        $found_posts = $the_query->found_posts;
        if($found_posts > 0):
          $display_start_num = ($paged -1) * $posts_per_page +1;
          $display_finish_num = $display_start_num + $the_query->post_count - 1;
        else:
          $display_start_num = 0;
          $display_finish_num = 0;
        endif;
      ?>
      <div class="products__result">
        <?php if ($the_query -> have_posts()) : ?>
          <?php if(isset($product_categories)): ?>
            <h3 class="products__result-title">Search Result Category：
              <?php
                foreach($product_categories as $product_category):
                  $term = get_term_by('slug', $product_category, 'product_category');
                  if($product_category == end($product_categories)):
                    echo '"' . $term->name . '"';
                  else:
                    echo '"' . $term->name . '",';
                  endif;
                endforeach;
              ?>
            </h3>
          <?php else: ?>
            <h3 class="products__result-title">Search Results：“<span class="name"><?php echo get_search_query(); ?></span>”</h3>
          <?php endif; ?>
          <p class="products__result-hits"><span class="total"><?php echo $the_query->found_posts; ?></span>件中/<span class="number"><?php echo $display_start_num; ?>~<?php echo $display_finish_num; ?></span>件</p>
      
          <ul class="products__result-list">
            <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
              <li class="products__result-item item">
                <div class="item__inner">
                  <a href="<?php the_permalink(); ?>">
                    <figure class="item__img">

                      <!-- サムネイル -->
                      <?php
                        if (has_post_thumbnail()):
                          the_post_thumbnail();
                        else:
                      ?>
                        <img src="<?php echo esc_url(get_theme_file_uri('assets/img/common/noimage.png')); ?>">
                      <?php endif; ?>
                    </figure>
                    <div class="item__info">

                      <!-- 食品カテゴリー -->
                      <?php
                        $terms = get_the_terms($post->ID,'product_category');
                        foreach($terms as $term):
                      ?>
                        <p class="item__category"><?php echo $term->name; ?></p>
                      <?php endforeach; ?>

                      <!-- ブランドロゴ -->
                      <?php
                        $terms = get_the_terms($post->ID,'brand');
                        foreach($terms as $term):
                          $term_info = "brand_" . $term->term_id;
                          $brand_logo = get_field('brand_logo', $term_info);
                          if(empty($brand_logo)):
                            $brand_logo = get_theme_file_uri('assets/img/common/noimage.png');
                          endif;
                      ?>
                        <figure class="item__brand">
                          <img src="<?php echo $brand_logo; ?>" alt="" width="30" height="30">
                        </figure>
                      <?php endforeach;?>
                    </div>
                    <h4 class="item__name"><?php the_title(); ?></h4>
                  </a>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>

          <!-- ページネーション -->
          <?php
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
          ?>
          <?php wp_reset_postdata(); ?>
        <?php else: ?>
          <p class="products__error-text">ご指定の検索条件に該当する商品が見つかりませんでした。<br>申し訳ございませんが、再度ご検索をお願いいたします。</p>
        <?php endif; ?>
      </div>
    <?php endif;?>
    <?php if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs(); ?>
  </section>
</div>