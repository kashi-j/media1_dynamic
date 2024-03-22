<?php if (have_posts()) : ?>
  <?php while (have_posts()) :the_post(); ?>
    <div class="products-detail__inner page__inner">
      <a class="mod-text-btn mod-text-btn--black" href="<?php echo esc_url(home_url('/products')); ?>"><span class="mod-text-btn__arrow"></span>Return</a>
      <div class="products-detail__content content js-scroll-first">
        <div class="content__wrapper">
          <div class="content__img">
            <?php $image_group = get_field('image_group'); ?>
            <!-- 1枚目 -->
            <figure class="content__img-main">
              <?php $image_url = $image_group['product_image01'] ?: get_theme_file_uri('assets/img/common/noimage.png'); ?>
              <img id="js-product-mainImg" src="<?php echo esc_url($image_url); ?>">
            </figure>
            <div class="content__swiper swiper-container">
              <div class="swiper-wrapper content__swiper-wrapper">
                <!-- 1枚目 -->
                <div class="swiper-slide content__swiper-slide">
                  <figure class="content__swiper-item">
                    <?php $image_url = $image_group['product_image01'] ?: get_theme_file_uri('assets/img/common/noimage.png'); ?>
                    <img src="<?php echo esc_url($image_url); ?>" class="content__swiper-img" data-image="<?php echo esc_url($image_url); ?>">
                  </figure>
                </div>
                <!-- 2枚目 -->
                <?php if($image_group['product_image02']): ?>
                  <div class="swiper-slide content__swiper-slide">
                    <figure class="content__swiper-item">
                      <img src="<?php echo $image_group['product_image02']; ?>" alt="" class="content__swiper-img"
                        data-image="<?php echo $image_group['product_image02']; ?>">
                    </figure>
                  </div>
                <?php endif; ?>
                <!-- 3枚目 -->
                <?php if($image_group['product_image03']): ?>
                  <div class="swiper-slide content__swiper-slide">
                    <figure class="content__swiper-item">
                      <img src="<?php echo $image_group['product_image03']; ?>" alt="" class="content__swiper-img"
                        data-image="<?php echo $image_group['product_image03']; ?>">
                    </figure>
                  </div>
                <?php endif; ?>
                <!-- 4枚目 -->
                <?php if($image_group['product_image04']): ?>
                  <div class="swiper-slide content__swiper-slide">
                    <figure class="content__swiper-item">
                      <img src="<?php echo $image_group['product_image04']; ?>" alt="" class="content__swiper-img"
                        data-image="<?php echo $image_group['product_image04']; ?>">
                    </figure>
                  </div>
                <?php endif; ?>
                <!-- 5枚目 -->
                <?php if($image_group['product_image05']): ?>
                  <div class="swiper-slide content__swiper-slide">
                    <figure class="content__swiper-item">
                      <img src="<?php echo $image_group['product_image05']; ?>" alt="" class="content__swiper-img"
                        data-image="<?php echo $image_group['product_image05']; ?>">
                    </figure>
                  </div>
                <?php endif; ?>
                <!-- 6枚目 -->
                <?php if($image_group['product_image06']): ?>
                  <div class="swiper-slide content__swiper-slide">
                    <figure class="content__swiper-item">
                      <img src="<?php echo $image_group['product_image06']; ?>" alt="" class="content__swiper-img"
                        data-image="<?php echo $image_group['product_image06']; ?>">
                    </figure>
                  </div>
                <?php endif; ?>
                <!-- 7枚目 -->
                <?php if($image_group['product_image07']): ?>
                  <div class="swiper-slide content__swiper-slide">
                    <figure class="content__swiper-item">
                      <img src="<?php echo $image_group['product_image07']; ?>" alt="" class="content__swiper-img"
                        data-image="<?php echo $image_group['product_image07']; ?>">
                    </figure>
                  </div>
                <?php endif; ?>
                <!-- 8枚目 -->
                <?php if($image_group['product_image08']): ?>
                  <div class="swiper-slide content__swiper-slide">
                    <figure class="content__swiper-item">
                      <img src="<?php echo $image_group['product_image08']; ?>" alt="" class="content__swiper-img"
                        data-image="<?php echo $image_group['product_image08']; ?>">
                    </figure>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="content__info">
            <!-- NEWラベル -->
            <h1 class="content__title <?php if(get_field('new_label')){echo 'content__title--new';}; ?>"><?php the_title(); ?></h1>
            <!-- ブランド -->
            <?php
              $terms = get_the_terms($post->ID, 'brand');
              foreach ($terms as $term) :
                $term_info = 'brand_' . $term->term_id;
                $brand_logo = get_field('brand_logo',$term_info);
                if(empty($brand_logo)):
                  $brand_logo = get_theme_file_uri('assets/img/common/noimage.png');
                endif;
            ?>
              <p class="content__brand">
                <figure class="content__brand-logo">
                  <img src="<?php echo $brand_logo; ?>" alt="" width="30" height="30">
                </figure>
                <span><?php echo $term->name; ?></span>
              </p>
            <?php endforeach; ?>
            
            <p class="content__text"><?php the_field(('product_description')); ?></p>
            <!-- 注意書き -->
            <?php
              $notices = get_field('notice_list');
              $is_empty = true;

              if ($notices) {
                foreach ($notices as $notice) {
                  if (!empty($notice)) {
                    $is_empty = false;
                    break;
                  }
                }
              }
            ?>
            <?php if(!($is_empty)) : ?>
              <ul class="content__notes">
                <?php if($notices['notice01']): ?>
                  <li class="content__notes-text"><?php echo $notices['notice01']; ?></li>
                <?php endif; ?>
                <?php if($notices['notice02']): ?>
                  <li class="content__notes-text"><?php echo $notices['notice02']; ?></li>
                <?php endif; ?>
                <?php if($notices['notice03']): ?>
                  <li class="content__notes-text"><?php echo $notices['notice03']; ?></li>
                <?php endif; ?>
                <?php if($notices['notice04']): ?>
                  <li class="content__notes-text"><?php echo $notices['notice04']; ?></li>
                <?php endif; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>

        <!-- 商品情報 -->
        <?php
          $product_informations = get_field('product_info');
          $is_empty = true; 
          foreach($product_informations as $product_information):
            if (!empty($product_information)) : // フィールドが空でない場合
              $is_empty = false;
              break;
            endif;
          endforeach;
        ?>
        <?php if(!($is_empty)) : ?>
          <div class="content__details">
            <p class="content__details-title">Item Information</p>
            <div class="content__details-table">
              <?php if($product_informations['info_title01']): ?>
                <dl class="content__details-item">
                  <dt class="content__details-head"><?php echo $product_informations['info_title01']; ?></dt>
                  <dd class="content__details-detail">
                    <?php if($product_informations['info_content01']) : ?>
                      <?php echo $product_informations['info_content01']; ?>
                    <?php endif; ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php if($product_informations['info_title02']): ?>
                <dl class="content__details-item">
                  <dt class="content__details-head"><?php echo $product_informations['info_title02']; ?></dt>
                  <dd class="content__details-detail">
                    <?php if($product_informations['info_content02']) : ?>
                      <?php echo $product_informations['info_content02']; ?>
                    <?php endif; ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php if($product_informations['info_title03']): ?>
                <dl class="content__details-item">
                  <dt class="content__details-head"><?php echo $product_informations['info_title03']; ?></dt>
                  <dd class="content__details-detail">
                    <?php if($product_informations['info_content03']) : ?>
                      <?php echo $product_informations['info_content03']; ?>
                    <?php endif; ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php if($product_informations['info_title04']): ?>
                <dl class="content__details-item">
                  <dt class="content__details-head"><?php echo $product_informations['info_title04']; ?></dt>
                  <dd class="content__details-detail">
                    <?php if($product_informations['info_content04']) : ?>
                      <?php echo $product_informations['info_content04']; ?>
                    <?php endif; ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php if($product_informations['info_title05']): ?>
                <dl class="content__details-item">
                  <dt class="content__details-head"><?php echo $product_informations['info_title05']; ?></dt>
                  <dd class="content__details-detail">
                    <?php if($product_informations['info_content05']) : ?>
                      <?php echo $product_informations['info_content05']; ?>
                    <?php endif; ?>
                  </dd>
                </dl>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if(get_field('store_url')): ?>
          <a class="mod-shop-link mod-shop-link--official" href="<?php the_field('store_url'); ?>">Purchase from official online store</a>
        <?php endif; ?>

        <?php
          $args = [
            'taxonomy' => 'product_category',
            'hide_empty' => true
          ];
          $terms = get_terms($args);

          $is_empty = true;
          foreach($terms as $term):
            if (!empty($term)) : // フィールドが空でない場合
              $is_empty = false;
              break;
            endif;
          endforeach;
        ?>

        <?php if(!($is_empty)): ?>
          <div class="content__list">
            <p class="content__list-title">Search products by category</p>
            <ul class="content__list-wrapper list">
              <?php
                foreach($terms as $term):
                  $search_url = home_url('?post_type=products&s=&product_category%5B%5D=') . $term->slug . '#item-search';
              ?>
                <li class="list__item">
                  <a class="list__link mod-item-link" href="<?php echo esc_url($search_url); ?>"><?php echo $term->name; ?><span class="mod-item-link__arrow"></span></a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

      </div>
    </div>

    <!-- おすすめ商品 -->
    <?php
      $recommendations = get_field('recommendation');
      $is_empty = !is_array($recommendations) || empty($recommendations);
    ?>
    <?php if(!$is_empty): ?>
      <section class="products-detail__related related js-scroll-up">
        <div class="related__inner">
          <h2 class="related__title">Recommended product</h2>
          <div class="related__swiper swiper-container">
            <div class="swiper-wrapper related__swiper-wrapper">
              <?php foreach($recommendations as $recommendation): ?>
                <!-- スライド -->
                <div class="swiper-slide related__swiper-slide">
                  <a class="swiper-link" href="<?php echo get_permalink($recommendation->ID); ?>">
                    <figure class="swiper-img">
                      <?php 
                          $image_url = get_the_post_thumbnail_url($recommendation->ID) ? get_the_post_thumbnail_url($recommendation->ID) : get_theme_file_uri('assets/img/common/noimage.png');
                      ?>
                      <img src="<?php echo esc_url($image_url); ?>" alt="">
                    </figure>
                    <?php
                      $terms = get_the_terms($recommendation->ID,'brand');
                      foreach($terms as $term):
                        $brand_logo = get_field('brand_logo','brand_' . $term->term_id);
                    ?>
                    <div class="swiper-name__wrapper">
                      <figure class="swiper-logo">
                        <img src="<?php echo $brand_logo; ?>" alt="" width="30" height="30">
                      </figure>
                      <h3 class="swiper-name"><?php echo $recommendation->post_title; ?></h3>
                    </div>
                  </a>
                  <?php endforeach; ?>

                </div>
              <?php endforeach; ?>
            </div>
            <div class="swiper-button">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>

          <?php 
            $terms = get_the_terms($post->ID,'brand');
            foreach($terms as $term):
              $args = [
                'post_type' => 'products',
                'tax_query' => [[
                  'taxonomy' => 'brand',
                  'field' => 'slug',
                  'terms' => $term->slug
                ]],
                'post__not_in' => [$post->ID],
                'posts_per_page' => -1
              ];
              $the_query = new WP_Query($args);
          ?>
            <?php if ($the_query -> have_posts()) : ?>
              <h2 class="related__title">Related products of <span class="title-in">"<?php echo $term->name; ?>"</span></h2>
              <div class="related__swiper swiper-container">
                <div class="swiper-wrapper related__swiper-wrapper">
                    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
                      <div class="swiper-slide related__swiper-slide">
                        <a class="swiper-link" href="<?php the_permalink(); ?>">
                          <figure class="swiper-img">
                            <?php $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url() : get_theme_file_uri('assets/img/common/noimage.png'); ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="">
                          </figure>
                          <div class="swiper-name__wrapper">
                            <figure class="swiper-logo">
                              <img src="<?php echo $brand_logo; ?>" alt="" width="30" height="30">
                            </figure>
                            <h3 class="swiper-name"><?php the_title(); ?></h3>
                          </div>
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
            <?php endif; ?>
          <?php endforeach; ?>

          <?php if( function_exists( 'aioseo_breadcrumbs' ) ) aioseo_breadcrumbs(); ?>
        </div>
      </section>
    <?php endif; ?>
  <?php endwhile; ?>
<?php endif; ?>