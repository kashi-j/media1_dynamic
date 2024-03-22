<!-- お問い合わせ -->
<section class="contact__form">
  <div class="contact__form-inner">
    <a class="mod-text-btn mod-text-btn--black" href="/contact"><span class="mod-text-btn__arrow"></span>Return</a>
    <!-- タイトル -->
    <h1 class="mod-page-title"><span class="mod-page-title__decoration">Contact</span>Inquiry</h1>
    <!-- ステッパー -->
    <div class="contact__form-step">
      <p class="contact__form-status is-done"><span class="contact__form-number">1</span>Input</p>
      <p class="contact__form-status is-active"><span class="contact__form-number">2</span>Confirm</p>
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