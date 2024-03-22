<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <?php wp_head(); ?>
</head>
<body id="pageTop"

  <?php
    if(is_front_page()):
      body_class('top page');
    elseif(is_home()):
      body_class('news page');
    elseif(is_singular('post')):
      body_class('news-detail page');
    elseif(is_page('shop')):
      body_class('shop page');
    elseif(is_singular('shop')):
      body_class('shop-detail page');
    elseif(is_page('products')):
      body_class('products page');
    elseif(is_singular('products')):
      body_class('products-detail item page');
    elseif(is_tax('brand')):
      body_class('products-detail brand page');
    elseif(is_page('online-shop')):
      body_class('online page');
    elseif(is_page('privacypolicy')):
      body_class('privacy page');
    elseif(is_page('terms')):
      body_class('terms page');
    elseif(is_page('error')):
      body_class('error page');
    elseif(is_page('business_information')):
      body_class('info page');
    elseif(is_page('contact')):
      body_class('contact page');
    elseif(is_page('confirm')):
      body_class('contact confirm page');
    elseif(is_page('comp')):
      body_class('contact comp page');   
    elseif(is_page('')):
      body_class('feature page');
    // 検索結果
    elseif(is_search()):
      $post_type = $_GET['post_type'];
      if($post_type == 'products'):
      body_class('products page');
      endif;
      if($post_type == 'shop'):
      body_class('shop page');
      endif;
    else:
      body_class();
    endif;
  ?>
>

  <?php wp_body_open(); ?>

  <!-- .header -->
  <header class="header">
    <div class="header__inner">
      <div class="header__logo">
        <a class="header__logo-link" href="<?php echo esc_url(home_url()); ?>">
          <picture>
            <source srcset="https://placehold.jp/24/cccccc/ffffff/198x30.png?text=Site Name" media="(max-width: 1280px)">
            <source srcset="https://placehold.jp/24/cccccc/ffffff/198x30.png?text=Site Name" media="(min-width: 1280px)">
            <img src="https://placehold.jp/24/cccccc/ffffff/198x30.png?text=Site Name" width="157" height="50" alt="Site Name">
          </picture>
        </a>
      </div>
      <div class="header__nav-wrapper">
        <nav class="header__nav">
          <p class="header__list-title">MENU</p>
          
          <!-- ナビメニュー -->
          <?php
            $args = [
              'theme_location' => 'header-navigation',
              'container'       => '',
              'container_class' => '',
              'menu_class' => 'header__list',
              'menu_id' => 'header__list',
              'list_class' => 'header__item', // liタグへclass追加
              'anchor_class' => 'header__link', // aタグへclass追加
              'link_before' => '<span class="header__link-underline">',
              'link_after' => '</span>'
            ];
            wp_nav_menu($args);
          ?>

          <p class="header__list-title">SNS</p>
          <ul class="header__sns">
            <li class="header__sns-item">
              <a href="#" class="header__sns-link">
                <img src="<?php echo esc_url(get_theme_file_uri('assets/img/common/icon_insta.svg')); ?>" alt="Instagram" width="40" height="40">
              </a>
            </li>
            <li class="header__sns-item">
              <a href="#" class="header__sns-link">
                <img src="<?php echo esc_url(get_theme_file_uri('assets/img/common/icon_twitter.svg')); ?>" alt="twitter" width="40" height="40">
              </a>
            </li>
          </ul>
        </nav>
        <button class="header__menu js-trigger-btn" type="button">
          <div class="header__menu-trigger">
            <span></span>
            <p class="header__menu-text">MENU</p>
          </div>
        </button>
      </div>
    </div>
  </header>
  <!-- /.header -->