<div class="shop-detail__inner page__inner">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) :the_post(); ?>
      <h1 class="mod-page-title js-scroll-first"><span class="mod-page-title__decoration">Store</span>Information</h1>
      <section class="shop-detail__content">
        <figure class="shop-detail__logo js-scroll-up">
          <?php
            $shop_types = get_field('shop_type');
            $term_info = 'shop_type' . '_' . $shop_types->term_id;
            $logo_image = get_field('logo_image',$term_info);
          ?>
          <img src="<?php echo $logo_image; ?>" alt="Site Name">
        </figure>
        <h2 class="shop-detail__name js-scroll-up"><?php the_title(); ?></h2>

        <section class="shop-detail__content-item  js-scroll-up">
          <div class="shop-detail__content-inner shop-detail__content-inner--top">
            <div class="shop-detail__content-wrapper">

              <dl class="item">
                <dt class="item__head">Address</dt>
                <?php
                  $address_group = get_field('address');
                  $post_number = $address_group['post_number'];
                  $prefecture = $address_group['address_group']['prefecture']->name;
                  $address = $address_group['address_group']['address'];
                  $building = $address_group['address_group']['building_name'];
                ?>
                <dd class="item__detail">
                  <?php
                    echo '〒' . $post_number . '<br>';
                    echo $prefecture . $address . '<br>';
                    echo $building
                  ?>
                </dd>
              </dl>

              <dl class="item">
                <dt class="item__head">Business Hours</dt>
                <?php
                  $business_hours = get_field('business_hours');
                  $start_time = $business_hours['time']['start_time'];
                  $finish_time = $business_hours['time']['finish_time'];
                  $notice = $business_hours['notice'];
                ?>
                <dd class="item__detail">
                  <?php 
                    echo $start_time . '～' . $finish_time . '<br>';
                    if($notice):
                      echo $notice;
                    endif;
                  ?>
                </dd>
              </dl>

              <dl class="item">
                <dt class="item__head">Tel</dt>
                <?php
                  $tel_number = get_field('tel_number');
                  $changed_tel_number = str_replace("-", "", $tel_number);
                ?>
                <dd class="item__detail"><a href="tel:<?php echo $changed_tel_number; ?>"><?php echo $tel_number; ?></a></dd>
              </dl>

              <dl class="item">
                <dt class="item__head">Service</dt>
                <dd class="item__detail">
                  <div class="item__detail-wrapper">
                    <?php
                      $counter_sellings = get_field('counter_selling');
                      foreach($counter_sellings as $counter_selling):
                        $term_info = 'counter_selling' . '_' . $counter_selling->term_id;
                        $logo_icon = get_field('counter_selling_icon', $term_info);
                    ?>
                      <div class="item__detail-icon-wrapper">
                        <figure class="item__detail-icon">
                          <img src="<?php echo $logo_icon; ?>" width="32" height="">
                        </figure>
                        <span class="item__detail-icon-name"><?php echo $counter_selling->name; ?></span>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </dd>
              </dl>

              <?php $event_campaign = get_field('event_campaign'); ?>
              <?php if($event_campaign): ?>
                <dl class="item">
                  <dt class="item__head">Campaign</dt>
                  <dd class="item__detail"><?php echo $event_campaign; ?></dd>
                </dl>
              <?php endif; ?>

              <?php $notice_from_store = get_field('notice_from_store'); ?>
              <?php if($notice_from_store) : ?>
                <dl class="item">
                  <dt class="item__head">News</dt>
                  <dd class="item__detail"><?php echo $notice_from_store; ?></dd>
                </dl>
                <?php endif; ?>

              <?php
                $advertisement_anchor_text = get_field('advertisement_anchor_text');
                $advertisement_site_url = get_field('advertisement_site_url');
                if($advertisement_anchor_text && $advertisement_site_url) :
              ?>
                <dl class="item">
                  <dt class="item__head">Advertizement</dt>
                  <dd class="item__detail">
                    <a class="item__external-link" href="<?php echo $advertisement_site_url; ?>" target="_blank"><?php echo $advertisement_anchor_text; ?></a>
                  </dd>
                </dl>
              <?php endif; ?>

              <?php 
                $recruit_anchor_text = get_field('recruit_anchor_text');
                $recruit_site_url = get_field('recruit_site_url');
                if($recruit_anchor_text && $recruit_site_url) :
              ?>
                <dl class="item">
                  <dt class="item__head">Recruit Info</dt>
                  <dd class="item__detail">
                    <a class="item__external-link" href="<?php echo $recruit_site_url; ?>" target="_blank"><?php echo $recruit_anchor_text; ?></a>
                  </dd>
                </dl>
              <?php endif; ?>
            </div>
            <figure class="shop-detail__content-img">
              <?php the_post_thumbnail(); ?>
            </figure>
          </div>
        </section>


        <section class="shop-detail__content-item">
          <h3 class="shop-detail__content-title mod-subtitle-slash">Handled Item</h3>
          <div class="shop-detail__content-inner">
            <dl class="item">
              <dt class="item__head">Item</dt>
              <dd class="item__detail">
                <div class="item__detail-wrapper">
                  <?php
                    $products = get_field('products');
                    foreach($products as $product):
                      $term_info = 'products_handled' . '_' . $product->term_id;
                      $logo_icon = get_field('icon_image', $term_info);
                  ?>
                  <div class="item__detail-icon-wrapper">
                    <figure class="item__detail-icon">
                      <img src="<?php echo $logo_icon; ?>" width="32" height="">
                    </figure>
                    <span class="item__detail-icon-name"><?php echo $product->name; ?></span>
                  </div>
                  <?php endforeach; ?>
                </div>
              </dd>
            </dl>

            <?php
              $brands = get_field('brand_name');
              if(is_array($brands)):
            ?>
              <dl class="item">
                <dt class="item__head">Brand</dt>
                <dd class="item__detail">
                  <div class="item__detail-wrapper item__detail-wrapper--brand">
                    <?php
                        foreach($brands as $brand):
                          $term_info = 'brand' . '_' . $brand->term_id;
                          $brand_logo = get_field('brand_logo', $term_info);
                    ?>
                      <figure class="item__logo">
                        <img src="<?php echo $brand_logo; ?>" alt="" width="30" height="30">
                      </figure>
                    <?php
                        endforeach;
                    ?>
                  </div>

                  <?php
                    $other_brands = get_field('other_brand_name');
                    $is_empty = true;
                    if($other_brands){
                      foreach($other_brands as $other_brand):
                        if (!empty($other_brand)) : // フィールドが空でない場合
                          $is_empty = false;
                          break;
                        endif;
                      endforeach;
                    }
                    if(!$is_empty):
                  ?>
                    <dl class="item__other-brand">
                      <dt>Others：</dt>
                      <dd>
                        <?php
                          foreach($other_brands as $other_brand):
                            if($other_brand == end($other_brands)):
                              echo $other_brand;
                            else:
                              echo $other_brand . '、';
                            endif;
                          endforeach;
                        ?>
                      </dd>
                    </dl>
                  <?php endif; ?>
                </dd>
              </dl>
            <?php endif; ?>
          </div>
        </section>

        <section class="shop-detail__content-item">
          <h3 class="shop-detail__content-title mod-subtitle-slash">Access</h3>
          <div class="shop-detail__content-inner">
            <div class="shop-detail__content-map">
              <?php
                $map_code = get_field('map_code');
                if($map_code):
                  echo $map_code;
                endif;
              ?>
              <?php
                $short_map_url = get_field('short_map_url');
                if($short_map_url):
              ?>
              <?php endif; ?>
            </div>
            <a class="mod-secondary-btn mod-secondary-btn--external" href="<?php echo $short_map_url; ?>" target="_blank">Google Map</a>
          </div>
        </section>
      </section>
      <?php if(function_exists('aioseo_breadcrumbs')): ?>
        <div class="aioseo-breadcrumbs">
          <span class="aioseo-breadcrumb"><a href="<?php echo esc_url(home_url()); ?>" title="HOME">HOME</a></span>
          <span class="aioseo-breadcrumb-separator">&gt;</span>
          <span class="aioseo-breadcrumb"><a href="<?php echo esc_url(home_url('shop')); ?>" title="Store Information">STORE INFORMATION</a></span>
          <span class="aioseo-breadcrumb-separator">&gt;</span>
          <span class="aioseo-breadcrumb"><?php the_title(); ?></span>
        </div>
      <?php endif; ?>
    <?php endwhile; ?>
  <?php endif; ?>
</div>