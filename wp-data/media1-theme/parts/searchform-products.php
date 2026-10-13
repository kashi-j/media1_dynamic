<div class="products__search">
  <input id="keyword-search" type="radio" name="products__search-tab" checked>
  <label class="products__search-tab" for="keyword-search">KEYWORD</label>
  <input id="category-search" type="radio" name="products__search-tab">
  <label class="products__search-tab" for="category-search">CATEGORY</label>

  <!-- 商品名で探す -->
  <!-- フリーワード -->
  <div class="products__search-item products__search-item--keyword" id="keyword-search-content">
    <form class="products__search-form" role="search" action="<?php echo esc_url(home_url('/')); ?>" method="get">
      <div class="products__search-inner">
        <input type="hidden" name="post_type" value="products">
        <input class="products__search-input" type="text" name="s" placeholder="<?php if(!is_search()){ echo 'Please enter keyword';} ?>" value="<?php if(is_search()){ echo get_search_query();} ?>">
        <div class="products__search-btn">
          <button class="products__search-submit" type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>">SEARCH</button>
          <a href="<?php echo esc_url(home_url('/products?s=#item-search')); ?>" class="products__search-reset">CLEAR</a>
        </div>
      </div>
    </form>
  </div>
  <!-- カテゴリー -->
  <div class="products__search-item products__search-item--category" id="category-search-content">
    <form class="products__search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
      <div class="products__search-inner">
        <div class="products__search-checkbox checkbox">
          <!-- ポストタイプ指定 -->
          <input type="hidden" name="post_type" value="products">

          <!-- フリーワードは不要のため非表示 -->
          <input type="hidden" class="products__search-input" name="s" value="">

          <!-- カテゴリーのチェックボックス -->
          <?php
            $args = [
              'taxonomy' => 'product_category',
              'hide_empty' => false,
            ];
            $terms = get_terms($args);
            $t_check = filter_input(INPUT_GET,'product_category',FILTER_DEFAULT,["options" => ["default" => []],"flags" => FILTER_REQUIRE_ARRAY]);
            foreach($terms as $term):
              //チェックリスト値の受け渡し
              $checked["product_category"] = [ $term->slug => ""];
              foreach((array)$t_check as $val):
                $checked["product_category"][$val]="checked";
              endforeach;
          ?>
            <label class="checkbox__item">
              <input
              type="checkbox"
              name="product_category[]"
              value="<?php echo $term->slug; ?>"
              <?php echo $checked["product_category"][$term->slug]; ?>
              >
              <span class="checkbox__label"><?php echo $term->name; ?></span>
            </label>
          <?php endforeach; ?>
        </div>
        <div class="products__search-btn">
          <button
          class="products__search-submit"
          type="submit"
          value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>"
          >SEARCH</button>
          <a class="products__search-reset" href="<?php echo esc_url(home_url('/products?s?=#item-search')); ?>">CLEAR</a>
        </div>
      </div>
    </form>
  </div>
</div>
