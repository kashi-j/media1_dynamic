<section class="contact__form">
  <div class="contact__form-inner contact__form-inner--comp">
    <h1 class="contact__form-title-comp">Complete</h1>
    <div class="contact__form-step">
      <p class="contact__form-status is-done"><span class="contact__form-number">1</span>Input</p>
      <p class="contact__form-status is-done"><span class="contact__form-number">2</span>Confirm</p>
      <p class="contact__form-status is-active"><span class="contact__form-number">3</span>Complete</p>
    </div>
    <p class="contact__form-text-comp">
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) :the_post(); ?>
          <?php the_content(); ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </p>
    <a class="mod-secondary-btn mod-secondary-btn--back" href="/">Return to TOP</a>
    <div class="contact__breadcrumbs">
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
  </div>
</section>