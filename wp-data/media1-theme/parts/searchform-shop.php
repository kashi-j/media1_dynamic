<div class="shop__search-box js-scroll-up">
  <form action="<?php echo esc_url(home_url('/')); ?>" class="shop__search-form" method="get">

    <!-- ポストタイプ指定 -->
    <input type="hidden" name="post_type" value="shop">

    <!-- フリーワードは不要のため非表示 -->
    <input type="hidden" class="" name="s" value="">

    <!-- 都道府県 -->
    <div class="shop__search-form-item">
      <label for="shop__search-form-prefecture">Search by prefecture</label>
      <div class="shop__search-form-select">
        <select name="prefecture">
          <option value="">Please select</option>
          <?php
            $args = [
              'taxonomy'   => 'area',
              'hide_empty' => true,
              'parent'     => '0',
            ];
            $terms = get_terms($args);
          ?>
          <?php foreach($terms as $term): ?>
            <!-- エリア -->
            <optgroup label="<?php echo $term->name; ?>">
              <?php
                $args = [
                  'taxonomy'   => 'area',
                  'hide_empty' => true,
                  'parent' => $term->term_id
                ];
                $term_children = get_terms($args);
                $r_tax = filter_input(INPUT_GET,"prefecture");
                var_dump($r_tax);
                ?>
              <?php
                foreach($term_children as $term_child):
                  $selected["prefecture"] = [ $term_child->slug => "" ];
                  $selected["prefecture"][$r_tax?:""]="selected";
              ?>
                <option
                  value="<?php echo $term_child->slug; ?>"
                  <?php echo $selected["prefecture"][$term_child->slug]; ?>
                >
                  <?php echo $term_child -> name; ?>
                </option>
              <?php endforeach; ?>
            </optgroup>
          <?php endforeach;?>
        </select>
      </div>
    </div>

    <!-- 取り扱い商品 -->
    <div class="shop__search-form-item">
      <label class="shop__search-form-label">Products handled<span class="label-note">※Multiple selection possible</span></label>
      <div class="shop__search-form-wrapper">
        <?php
          $args = [
            'taxonomy' => 'products_handled',
            'hide_empty' => false,
          ];
          $t_check = filter_input(INPUT_GET,'shop_handled_type',FILTER_DEFAULT,["options" => ["default" => []],"flags" => FILTER_REQUIRE_ARRAY]);
          $terms = get_terms($args);
          foreach($terms as $term):
            //チェックリスト値の受け渡し
            $checked["products_handled"] = [ $term->slug => ""];
            foreach((array)$t_check as $val):
              $checked["products_handled"][$val]="checked";
            endforeach;
            $term_info = $args['taxonomy'] . '_' . $term->term_id ;
            $products_handled_icon = get_field('icon_image', $term_info);
        ?>
          <label class="checkbox">
            <input
            type="checkbox"
            name="shop_handled_type[]"
            value="<?php echo $term->slug; ?>"
            <?php echo $checked["products_handled"][$term->slug]; ?>
            >
            <div class="checkbox__wrapper">
              <img class="checkbox__img" src="<?php echo $products_handled_icon; ?>" alt="<?php echo $term->name; ?>" width="32" height="32">
              <span class="checkbox__name"><?php echo $term->name; ?></span>
            </div>
          </label>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 対面販売 -->
    <div class="shop__search-form-item">
      <label class="shop__search-form-label">Services handled<span class="label-note">※Multiple selection possible</span></label>
      <div class="shop__search-form-wrapper">

        <?php
          $args = [
            'taxonomy' => 'counter_selling',
            'hide_empty' => false,
          ];
          $t_check = filter_input(INPUT_GET,'shop_counter_selling',FILTER_DEFAULT,["options" => ["default" => []],"flags" => FILTER_REQUIRE_ARRAY]);
          $terms = get_terms($args);
          foreach($terms as $term):
            //チェックリスト値の受け渡し
            $checked["counter_selling"] = [ $term->slug => ""];
            foreach((array)$t_check as $val):
              $checked["counter_selling"][$val]="checked";
            endforeach;
            $term_info = $args['taxonomy'] . '_' . $term->term_id ;
            $products_handled_icon = get_field('counter_selling_icon', $term_info);
        ?>
          <label class="checkbox">
            <input
              type="checkbox"
              name="shop_counter_selling[]"
              value="<?php echo $term->slug; ?>"
              <?php echo $checked["counter_selling"][$term->slug]; ?>
            >
            <div class="checkbox__wrapper">
              <img class="checkbox__img" src="<?php echo $products_handled_icon; ?>" alt="" width="32" height="32">
              <span class="checkbox__name">
                <?php
                  if($term->slug == 'none'):
                    echo $term->name;
                  else:
                    echo $term->name . '';
                  endif;
                ?>
              </span>
            </div>
          </label>
        <?php  endforeach; ?>
      </div>
    </div>

    <!-- 検索 -->
    <button
    type="submit"
    class="shop__search-btn"
    id="js-search-btn"
    value="<?php echo esc_attr_x( 'Search', 'submit button'); ?>">
    Search</button>
  </form>
</div>