<!-- よくある質問 -->
<div class="contact__inner page__inner">
  <h1 class="mod-page-title"><span class="mod-page-title__decoration">FAQ</span>Q & A</h1>
  <section class="contact__faq">
    <?php
      $args = [
        'taxonomy' => 'faq_category',
        'hide_empty' => true
      ];
      $terms = get_terms($args);
    ?>
    <?php foreach($terms as $term): ?>  
      <!-- 商品 -->
      <dl class="contact__faq-content">
        <dt class="contact__faq-category js-faq-trigger"><?php echo $term->name; ?></dt>
        <dd class="contact__faq-description">
          <?php
            $args = [
              'post_type' => 'faq',
              'tax_query' => [[
                'taxonomy' => 'faq_category',
                'field' => 'slug',
                'terms' => $term->slug
              ]
              ],
              'post_per_page' => -1
            ];

            $the_query = new WP_Query($args);
          ?>
          <?php if ($the_query -> have_posts()) : ?>
            <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
              <dl class="contact__faq-item">
                <dt class="contact__faq-item-q"><?php the_title(); ?></dt>
                <dd class="contact__faq-item-a">
                <?php the_content(); ?>
                </dd>
              </dl>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          <?php endif; ?>
        </dd>
      </dl>
    <?php endforeach; ?>
  </section>
</div>

<!-- お問い合わせ -->
<section class="contact__form">
  <div class="contact__form-inner">
    <!-- タイトル -->
    <h1 class="mod-page-title"><span class="mod-page-title__decoration">Contact</span>Inquiry</h1>

    <!-- ステッパー -->
    <div class="contact__form-step">
      <p class="contact__form-status is-active"><span class="contact__form-number">1</span>Input</p>
      <p class="contact__form-status"><span class="contact__form-number">2</span>Confirm</p>
      <p class="contact__form-status"><span class="contact__form-number">3</span>Complete</p>
    </div>

    <!-- フォーム -->
    <div class="form">
      <!-- ショートコード -->
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) :the_post(); ?>
          <?php the_content(); ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
    <?php if( function_exists( 'aioseo_breadcrumbs' )): ?>
      <div class="contact__breadcrumbs">
        <div class="aioseo-breadcrumbs">
          <span class="aioseo-breadcrumb"><a href="/" title="HOME">HOME</a></span>
          <span class="aioseo-breadcrumb-separator">&gt;</span>
          <span class="aioseo-breadcrumb">Contact</span>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>