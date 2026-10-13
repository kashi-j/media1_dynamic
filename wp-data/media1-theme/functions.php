<?php

/**************************************
 * 外部ファイル読み込み
 ***************************************/
function my_theme_scripts(){
  wp_enqueue_style('swiper-style', get_theme_file_uri('/assets/css/swiper-bundle.min.css'));
  wp_enqueue_style('style', get_theme_file_uri('/assets/css/style.css'));
  wp_enqueue_style('custom-style', get_theme_file_uri('/assets/css/customize.css'));
  wp_enqueue_script('jquery-script', get_theme_file_uri('/assets/js/jquery-3.7.1.min.js'),null,'1.0',true);
  wp_enqueue_script('swiper-script', get_theme_file_uri('/assets/js/swiper-bundle.min.js'),['jquery-script'],'1.0',true);
  if(is_page(['contact','confirm'])):
    wp_enqueue_script('yubinbango-script','https://yubinbango.github.io/yubinbango/yubinbango.js',['jquery-script'],'1.0',true );
    wp_enqueue_script('contact-script',get_theme_file_uri('/assets/js/contact.js'),['jquery-script'],'1.0',true );
  endif;
  if(is_page(['company'])):
    wp_enqueue_script('chart-script','https://cdn.jsdelivr.net/npm/chart.js',['jquery-script'],'1.0',true );
    wp_enqueue_script('company-script',get_theme_file_uri('/assets/js/company.js'),['jquery-script'],'1.0',true );
  endif;
  if(is_front_page()):
    wp_enqueue_script('gsap-script', get_theme_file_uri('/assets/js/gsap.min.js'),['swiper-script'],'1.0',true);
    wp_enqueue_script('scroll-trigger-script', get_theme_file_uri('/assets/js/ScrollTrigger.min.js'),['gsap-script'],'1.0',true);
    wp_enqueue_script('top-script', get_theme_file_uri('/assets/js/top.js'),['gsap-script'],'1.0',true);
  endif;
  wp_enqueue_script('script', get_theme_file_uri('/assets/js/common.js'),['swiper-script'],'1.0',true);
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

/*****************************
 * theme support
 *****************************/
function my_theme_support() {
  add_theme_support( 'html5', [
    'comment-form',
    'comment-list',
    'search-form',
    'gallery',
    'caption',
    'style',
    'script'
  ] );
  add_theme_support( "post-thumbnails" );
  add_theme_support( 'title-tag' );
  add_theme_support( 'editor-styles' );
  add_theme_support( 'custom-logo' );
  add_theme_support( 'automatic-feed-links' );
  register_nav_menus( [
    'header-navigation' => 'ヘッダー',
    'footer-navigation' => 'フッター',
    'social-links'      => 'SNS',
  ]);
}
add_action( 'after_setup_theme', 'my_theme_support' );

/***************************************
 * wp_nav_menuのliにclass追加
 ***************************************/
function add_additional_class_on_li($classes, $item, $args)
{
  if (isset($args->list_class)) {
    $classes['class'] = $args->list_class;
  }
  return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

/***************************************
 * wp_nav_menuのaにclass追加
 ***************************************/
function add_additional_class_on_a($classes, $item, $args)
{
  if (isset($args->anchor_class)) {
    $classes['class'] = $args->anchor_class;
  }
  return $classes;
}
add_filter('nav_menu_link_attributes', 'add_additional_class_on_a', 1, 3);

/*****************************
 * メインクエリの変更
 *****************************/
function change_set_post($query){
	if(is_admin() || !$query->is_main_query()):
    return;
  endif;
  if($query->is_home()):
    $query->set( 'order', 'DESC' );
    $query->set( 'orderby', 'date' );
    $query->set( 'ignore_sticky_posts', 1 );
  endif;
  if(is_page('shop')):
    $query->set( 'posts_per_page', '-1' ); //サブクエリと揃える
  endif;
  if ($query->is_search()) :
    $post_type = $_GET['post_type'];
    if($post_type == 'shop'):
      $query->set( 'posts_per_page', '-1' ); //サブクエリと揃える
      return;
    endif;
    if($post_type == 'products'):
      $query->set( 'posts_per_page', '20' ); //サブクエリと揃える
      return;
    endif;
	endif;
}
add_action('pre_get_posts','change_set_post');

/***************************************
 * デフォルト投稿タイプのラベル変更
 ***************************************/ 
function change_post_labels($args, $post_type){
  if ('post' == $post_type) {
    $args['labels'] = array(
      'name' => 'お知らせ',
      'singular_name' => 'お知らせ',
    );
  }
  return $args;
}
add_filter('register_post_type_args', 'change_post_labels', 10, 2);

/***************************************
 * デフォルト投稿タイプのタクソノミーのラベル変更
 ***************************************/ 
function change_taxonomy_labels($args, $taxonomy) {
  if ('category' == $taxonomy) {
    $args['labels'] = array(
      'name' => 'お知らせカテゴリー',
      'singular_name' => 'お知らせカテゴリー',
    );
  } elseif ('post_tag' == $taxonomy) {
    $args['labels'] = array(
      'name' => 'お知らせタグ',
      'singular_name' => 'お知らせタグ',
    );
  }
  return $args;
}
add_filter('register_taxonomy_args', 'change_taxonomy_labels', 10, 2);

/***************************************
 * カスタム投稿 リライトして404（SEO対策）
 ***************************************/

// お知らせのカテゴリー
add_filter( 'category_rewrite_rules', '__return_empty_array' );
// お知らせのタグ
add_filter( 'post_tag_rewrite_rules', '__return_empty_array' );


/***************************************
 * カスタムクエリパラメータを追加
 ***************************************/
function add_custom_query_vars($query_vars) {
  $querys = array(
    'category',
    'tags',
    'post_type'
  );
  foreach($querys as $val){
    $query_vars[] = $val;
  }
  return $query_vars;
}
add_filter('query_vars', 'add_custom_query_vars');

/***************************************
 * 検索結果テンプレートのカスタマイズ
 ***************************************/
add_filter('template_include','custom_search_result_template');

function custom_search_result_template($template){
  if ( is_search() ){
    $post_types = get_query_var('post_type');
    foreach ( (array) $post_types as $post_type ){
      $templates[] = "search-{$post_type}.php";
      $templates[] = 'search.php';
      $template = get_query_template('search',$templates);
    }
  }
    return $template;
}

/***************************************
 * 管理画面にウィジェットを追加する
 ***************************************/
function my_widgets_register(){
  $args = [
    'name' => 'トップ-ボトムコンテンツ',
    'id' => 'top-bottom-widgets',
    'before_widget' => '',
    'after_widget' => '',
    'description' => 'トップページの下部コンテンツに表示されます'
  ];
  register_sidebar($args);
}
add_action('widgets_init','my_widgets_register');

/***************************************
 * タグの自動生成無効化
 ***************************************/

function disable_page_wpautop(){
  if(is_page(['contact','confirm','complete'] || is_tax('brand'))){
    remove_filter('the_content','wpautop');
    remove_filter('the_excerpt', 'wpautop');
  }
}
add_action('wp','disable_page_wpautop');

// Contact Form 7の自動pタグ無効
function wpcf7_autop_return_false() {
  return false;
}
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');

/***************************************
 * Contact Form 7 
 * 選択肢をタクソノミーのタームで生成
 ***************************************/
function wpcf7_terms_select($output, $tag, $attr) {
  if ('contact-form-7' === $tag || 'contact-form' === $tag) {
    $id   = '21ea3f5'; // コンタクトフォームの ID
    $name = 'shop-prefectures'; // セレクトボックスの名前
    $tax  = 'area'; // タクソノミーのスラッグ
    if ($id == $attr['id']) {
        $args = [
          'hide_empty' => true,
          'parent' => '0'
        ];
        $terms = get_terms($tax, $args);
        if (!empty($terms) && !is_wp_error($terms)) {
            $options = '<option value="" disabled selected>Region</option>';
            foreach ($terms as $term) {
                $options .= '<option value="' . esc_attr($term->name) . '"' . 'data-area="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
            }
            $output = preg_replace('/(<select .*?name="' . $name . '".*?>)(.*?)(<\/select>)/i', '${1}' . $options . '${3}', $output);
        }
    }
  }
  return $output;
}

add_filter('do_shortcode_tag', 
'wpcf7_terms_select', 10, 3);

/***************************************
 * Contact Form 7 
 * 選択肢をポストタイトルで生成
 ***************************************/
function wpcf7_posts_select($output, $tag, $attr) {
  if ('contact-form-7' === $tag || 'contact-form' === $tag) {
    $id   = '21ea3f5'; // コンタクトフォームの ID
    $name = 'shop-name'; // セレクトボックスの名前
    $tax  = 'area';       // タクソノミーのスラッグ
    if ($id == $attr['id']) {
      $options = '<option value="" disabled selected>Store Name</option>';
      $args = [
        'post_type' => 'shop',
        'posts_per_page' => -1
      ];
      $the_query = new WP_Query($args);
      if ($the_query -> have_posts()) :
        while ($the_query -> have_posts()) :$the_query -> the_post();
          $child_term = get_the_terms( get_the_ID(),'area');
          if(!empty($child_term[0]->parent)):
            $parent_term = get_term( $child_term[0]->parent, 'area');
            $options .= '<option value="' . get_the_title() . '"' . 'data-area="' . $parent_term->slug . '">' . get_the_title() . '</option>';
          endif;
        endwhile;
        wp_reset_postdata();
      endif;
      $output = preg_replace('/(<select .*?name="' . $name . '".*?>)(.*?)(<\/select>)/i', '${1}' . $options . '${3}', $output);
    }
  }
  return $output;
}

add_filter('do_shortcode_tag', 
'wpcf7_posts_select', 10, 3);

/***************************************
 * カスタムHTMLの高さを変更
 ***************************************/

function admin_post_type() {
  global $post_type;
  $tmp_js_url = get_template_directory_uri() . '/assets/js/';
  if($post_type === 'page'){
      wp_enqueue_script(
        'custom_html',$tmp_js_url . 'custom.js',false,false,false
      );
    }
}
add_action( 'admin_enqueue_scripts', 'admin_post_type', 10, 2 );

/***************************************
 * Contactform7 テキストボックス：チェック
 ***************************************/

function custom_wpcf7_validate_text($result,$tag){
  $tag   = new WPCF7_FormTag($tag);
  $name  = $tag->name;
  
  // 姓名
  if ($name === "last-name" || $name === "first-name") {
    $name_text = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';
    
    if (empty($name_text)) {
        $result->invalidate($tag, "お名前を入力してください。");
    }
    else {
      // 文字数制限を追加
      $max_length = 12; // ここで設定した文字数に変更可能
      if (mb_strlen($name_text, 'UTF-8') > $max_length) {
          $result->invalidate($tag, "{$max_length}文字以下で入力してください。");
      }
    }
  }
  
  // 姓名（フリガナ）
  if ($name === "last-name-ruby" || $name === "first-name-ruby") {
    $kana_text = isset($_POST[$name]) ? trim(wp_unslash(strtr((string) $_POST[$name], "\n", " "))) : "";
    if(empty($kana_text)) {
      $result->invalidate($tag,"フリガナを入力してください。" );
    }
    elseif(!preg_match("/^[ア-ヶー]+$/u", $kana_text)) {
      $result->invalidate( $tag,"全角カナで入力してください。");
    }
    else {
      // 文字数制限を追加
      $max_length = 12; // ここで設定した文字数に変更可能
      if (mb_strlen($kana_text, 'UTF-8') > $max_length) {
          $result->invalidate($tag, "{$max_length}文字以下で入力してください。");
      }
    }
  }

  // 郵便番号
  if ( $name == 'your-zipcode') {
    $postal_code = isset( $_POST['your-zipcode'] ) ? trim( $_POST['your-zipcode'] ) : '';
    if(!empty($postal_code)){
      if(!preg_match('/^\d{3}-\d{4}$/', $postal_code )){
        $result->invalidate( $tag, "ハイフン「-」を含む半角数字で入力してください。" );
      }
    }
  }

  // 県名
  if ($name === 'your-region') {
    $name_text = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';
    // 文字数制限を追加県名
    $max_length = 4; // ここで設定した文字数に変更可能
    if (mb_strlen($name_text, 'UTF-8') > $max_length) {
        $result->invalidate($tag, "{$max_length}文字以下で入力してください。");
    }
  }
  
  // 市区町村名
  if ($name === 'your-locality') {
    $name_text = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';
    // 文字数制限を追加県名
    $max_length = 30; // ここで設定した文字数に変更可能
    if (mb_strlen($name_text, 'UTF-8') > $max_length) {
        $result->invalidate($tag, "{$max_length}文字以下で入力してください。");
    }
  }
  
  // 番地・ビル名
  if ($name === 'your-extended') {
    $name_text = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';
    // 文字数制限を追加県名
    $max_length = 30; // ここで設定した文字数に変更可能
    if (mb_strlen($name_text, 'UTF-8') > $max_length) {
        $result->invalidate($tag, "{$max_length}文字以下で入力してください。");
    }
  }

  return $result;
}
add_filter('wpcf7_validate_text', 'custom_wpcf7_validate_text', 11, 2);
add_filter('wpcf7_validate_text*', 'custom_wpcf7_validate_text', 11, 2);

/***************************************
 * Contactform7 mail:チェック
 ***************************************/

function wpcf7_text_validation_filter_extend( $result, $tag ) {
  
  $tag = new WPCF7_FormTag( $tag );
  $name = $tag->name;
  $type = $tag->type;

  $mail = isset( $_POST[$name] ) ? trim( strtr( (string) $_POST[$name], "\n", " " ) ) : '';
  if($name == 'mail' || $name == 'mail-confirm'){
    if(empty($mail)) {
      $result->invalidate($tag,"メールアドレスを入力してください。" );
    }
    else {
      // 文字数制限を追加
      $max_length = 35; // ここで設定した文字数に変更可能
      $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
      if (mb_strlen($value, 'UTF-8') > $max_length) {
          $result->invalidate($tag, "{$max_length}文字以下で入力してください。");
      }
    }  
  }

  if ( 'email' == $type || 'email*' == $type ) {
    if (preg_match('/(.*)-confirm$/', $name, $matches)){
      $target_name = $matches[1];
      if ($_POST[$name] != $_POST[$target_name]) {
        if (method_exists($result, 'invalidate')) {
          $result->invalidate( $tag,"メールアドレスと同じメールアドレスを入力してください");
        }
        else {
          $result['valid'] = false;
          $result['reason'][$name] = 'メールアドレスと同じメールアドレスを入力してください';
        }
      }
      else {
        // 文字数制限を追加
        $max_length = 35; // ここで設定した文字数に変更可能
        $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
        if (mb_strlen($value, 'UTF-8') > $max_length) {
            $result->invalidate($tag, "{$max_length}文字以下で入力してください。");
        }
      }  
    }
  }
  return $result;
}



add_filter( 'wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2 );

/***************************************
 * Contactform7 セレクトボックス
 ***************************************/
function custom_select_validation_filter( $result, $tag ) {
  $tag = new WPCF7_FormTag( $tag );
  $name = $tag->name;
  $value = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';
  
  if ( 'inquiry-type' == $name ) {
    if(empty($value)) {
    $result->invalidate($tag,"お問い合わせ種類を選択してください。");
    }
  }

  return $result;
}

add_filter( 'wpcf7_validate_select', 'custom_select_validation_filter', 20, 2 );
add_filter( 'wpcf7_validate_select*', 'custom_select_validation_filter', 20, 2 );

/***************************************
 * Contactform7 テキストエリア
 ***************************************/
function custom_textarea_validation_filter( $result, $tag ) {
  $tag = new WPCF7_FormTag( $tag );
  $name = $tag->name;
  $value = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';

  if('inquiry-details' == $tag->name){
    if ( empty( $value ) ) {
      $result->invalidate( $tag, "お問い合わせ内容を入力してください。" );
    }
    else {
      // 文字数制限を追加
      $max_length = 213; // ここで設定した文字数に変更可能
      if (mb_strlen($value, 'UTF-8') > $max_length) {
          $result->invalidate($tag, "200文字以下で入力してください。お問い合わせ内容が200文字を超える場合は、info@xxx.co.jpまでお問い合わせください。");
      }
    }
  }
  return $result;
}

add_filter( 'wpcf7_validate_textarea', 'custom_textarea_validation_filter', 20, 2 );
add_filter( 'wpcf7_validate_textarea*', 'custom_textarea_validation_filter', 20, 2 );


/***************************************
 * Contactform7 電話番号
 ***************************************/
function custom_tel_validation_filter( $result, $tag ) {
  $tag = new WPCF7_FormTag( $tag );
  $name = $tag->name;
  $value = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';

  if ($name === 'tel') {
    $name_text = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';
    // 文字数制限を追加県名
    $max_length = 11; // ここで設定した文字数に変更可能
    if (mb_strlen($name_text, 'UTF-8') > $max_length) {
        $result->invalidate($tag, "{$max_length}文字以下で入力してください。");
    }
  }
  return $result;
}

add_filter( 'wpcf7_validate_tel', 'custom_tel_validation_filter', 20, 2 );
add_filter( 'wpcf7_validate_tel*', 'custom_tel_validation_filter', 20, 2 );

?>