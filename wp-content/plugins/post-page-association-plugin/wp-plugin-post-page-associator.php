<?php

/*

Plugin Name: Post Page Associator
Plugin URI: http://dennishoppe.de/wordpress-plugins/post-page-associator
Description: The Post-Page-Associator enables you to attach posts to a page.
Version: 1.3.8
Author: Dennis Hoppe
Author URI: http://DennisHoppe.de

*/


// Please think about a donation
If (Is_File(DirName(__FILE__).'/donate.php')) Include DirName(__FILE__).'/donate.php';


// Support old class name - This Class name is deprecated
If (!Class_Exists('wp_plugin_associate_posts_and_pages')){
Class wp_plugin_associate_posts_and_pages {
  
  Function get_associated_posts($post_id = Null){
    return wp_plugin_post_page_associator::get_associated_posts($post_id);
  }
  
  Function has_associated_posts ($post_id = Null){
    // This function is deprecated
    return wp_plugin_post_page_associator::has_associated_posts($post_id);
  }
  
} // End of Class
} // EndIf


// Plugin Class
If (!Class_Exists('wp_plugin_post_page_associator')){
Class wp_plugin_post_page_associator {
  var $base_url;
  var $the_current_post;

  Function wp_plugin_post_page_associator(){
    // PHP4 Constructor, show PHP4 Warning message to user
    Add_Action('admin_notices', Create_Function('','
      Echo "<div class=\"error\"><p><b>Error: Post-Page-Associator requires PHP5. Your WordPress runs with PHP4.</b></p></div>";
    '));
  }

  Function __construct(){
    // Read base
    $this->base_url = get_bloginfo('wpurl').'/'.Str_Replace("\\", '/', SubStr(RealPath(DirName(__FILE__)), Strlen(ABSPATH)));

    // Get ready to translate
    $this->Load_TextDomain();

    // This Plugin supports post thumbnails
    If (Function_Exists('Add_Theme_Support'))
      Add_Theme_Support('post-thumbnails');       
        
    // Hooks
    Add_Action('admin_menu', Array($this, 'add_options_page'));
    Add_Action('admin_menu', Array($this, 'add_meta_box'));
    Add_Action('save_post', Array($this, 'save_meta_box'));    
    Add_Action('admin_head', Array($this, 'print_admin_header'));    
    Add_Filter('the_content', Array($this, 'filter_content'), 9);    
    Add_Action ('wp_head', Array($this, 'print_header'));
    
    // Shortcodes
    Add_Shortcode('associated_posts', Array($this, 'shortcode'));
  }
  
  Function Load_TextDomain(){
    $locale = Apply_Filters( 'plugin_locale', get_locale(), __CLASS__ );
    load_textdomain (__CLASS__, DirName(__FILE__).'/language/' . $locale . '.mo');
  }
  
  Function t ($text, $context = ''){
    // Translates the string $text with context $context
    If ($context == '')
      return __ ($text, __CLASS__);
    Else
      return _x ($text, $context, __CLASS__);
  }
  
  Function get_option_key(){ return __CLASS__; }
  
  Function get_meta_key(){ return '_' . __CLASS__; }
  
  Function add_options_page (){
    add_submenu_page(
      'options-general.php',
      $this->t('Associated Posts Settings'),
      $this->t('Associated Posts'),
      8,
      __CLASS__,
      Array($this, 'print_options_page_body')
    );
  }

  Function print_options_page_body(){
    ?><div class="wrap">
      <?php screen_icon(); ?>
      <h2><?php Echo $this->t('Associated Posts') ?></h2>
      
      <form method="post" action="">
        
        <?php If (!Empty($_POST) && $this->Save_Options()) : ?>
          <div id="message" class="updated fade"><p><strong><?php _e('Settings saved.') ?></strong></p></div>
        <?php EndIf; ?>
        
        <?php Include DirName(__FILE__).'/options_page.php' ?>
        
        <div style="max-width:600px">
          <?php do_action('donation_message') ?>
        </div>
        
        <p class="submit">
          <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
      </form>

    </div><?php
  }
  
  Function save_options(){
    // If there is no post data we bail out
    If (Empty($_POST)) return False;
    
    // Save options
    Update_Option (self::get_option_key(), stripslashes_deep($_POST));
    
    // Everything is ok =)
    return True;
  }

  Function get_option($key = Null, $default = False){
    $arr_option = (Array) get_option(self::get_option_key());
    If ($key == Null) return $arr_option;
    ElseIf (IsSet ($arr_option[$key])) return $arr_option[$key];
    Else return $default;
  }
  
  Function load_setting($key = Null, $default = False){
    /* This function is deprecated!
       Use $this->get_option() instead.
    */
    Return $this->get_option($key, $default);
  }

  Function add_meta_box(){
    // Add Meta box to pages
    Add_Meta_Box(
      __CLASS__,
      $this->t('Associate posts with this page'),
      Array($this, 'print_meta_box'),
      'page',
      'advanced',
      'high'
    );
  }

  Function print_meta_box(){ Include DirName(__FILE__).'/meta_box.php'; }

  Function find_templates(){
    $arr_template = Array_Merge (
      (Array) Glob ( DirName(__FILE__) . '/templates/*.php' ),
      (Array) Glob ( DirName(__FILE__) . '/templates/*/*.php' ),

      (Array) Glob ( get_stylesheet_directory() . '/*.php' ),
      (Array) Glob ( get_stylesheet_directory() . '/*/*.php' ),

      (Array) Glob ( WP_CONTENT_DIR . '/ppa-templates/*.php' ),
      (Array) Glob ( WP_CONTENT_DIR . '/ppa-templates/*/*.php' )
    );
    
    // Filter to add template files - you can use this filter to add template files to the user interface
    $arr_template = (Array) Apply_Filters('associated_posts_template_files', $arr_template);
    
    // Check if there template files
    If (Empty($arr_template)) return False;
    
    $arr_result = Array();
    ForEach ($arr_template AS $index => $template_file){
      // Check file
      If (!$template_file || !Is_File ($template_file) || !Is_Readable($template_file)) Continue;
      
      // Read meta data from the template
      $arr_properties = get_file_data ($template_file, Array(
        'name' => 'PPA Template',
        'description' => 'Description',
        'author' => 'Author',
        'author_uri' => 'Author URI',
        'author_email' => 'Author E-Mail',
        'version' => 'Version'
      ));
      
      // Check if there is a name for this template
      If ( Empty($arr_properties['name']) && BaseName($template_file) != 'associated-posts.php' ) Continue;
      
      // Add to the result array
      $arr_result[RealPath($template_file)] = $arr_properties;
    }
    
    return $arr_result;
  }
  
  Function get_default_template(){
    $template_file = RealPath(Get_Query_Template( 'associated-posts' ));
    If (!Is_File($template_file))
      $template_file = RealPath(DirName(__FILE__) . '/templates/title-excerpt-thumbnail.php');
    return $template_file;
  }

  
  Function field_name($option_name){
    return __CLASS__ . '[' . $option_name . ']';
  }

  Function save_meta_box($post_id){
    // If this is an autosave we dont care
    If ( Defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    
    // Check if this request came from the edit page section
    If (!IsSet($_POST[ __CLASS__ ])) return False;
    
    // Delete old data
    delete_post_meta($post_id, '_wp_plugin_associate_posts_and_pages');
    
    // Meta data
    $arr_options = (Array) $_POST[ __CLASS__ ];
    
    // Check if the user want to attach posts
    If ( !Empty($arr_options) &&
         !( Empty($arr_options['category']) &&
            Empty($arr_options['tag']) &&
            Empty($arr_options['author']) &&
            Empty($arr_options['post'])
         )
       )
    {
      update_post_meta ($post_id, $this->get_meta_key(), $arr_options);    
    }
    Else {
      delete_post_meta ($post_id, $this->get_meta_key());
    }
    
  }

  Function print_admin_header(){
    If (Is_File(DirName(__FILE__) . '/admin.css')) : ?>
    <link type="text/css" rel="stylesheet" href="<?php Echo HTMLSpecialChars($this->base_url) ?>/admin.css" />
    <?php EndIf;
  }
  
  Function print_header(){
    // Find the template
    $association_data = $this->get_association_data();
    $template_file = $association_data['template'];
    If (!Is_File($template_file)) $template_file = $this->get_default_template();
    
    // If there is no style sheet we bail out
    If (!Is_File(DirName($template_file) . '/' .  BaseName($template_file, '.php') . '.css'))
      return False;    
    
    // Locate the URL of the style sheet
    $style_sheet = get_bloginfo('wpurl') . '/' .
                   Str_Replace("\\", '/', SubStr(RealPath(DirName($template_file)), Strlen(ABSPATH))) . '/' .
                   BaseName($template_file, '.php') . '.css';

    // run the filter for the template file
    $style_sheet = Apply_Filters('associated_posts_style_sheet', $style_sheet);
    
    // Print the stylesheet link
    If ($style_sheet) : ?>
    <link rel="stylesheet" href="<?php Echo HTMLSpecialChars($style_sheet) ?>" type="text/css" />
    <?php EndIf;
  }

  Function shortcode($attr = Null){
    // Convert $attr to an array
    // $attr = (Array) $attr;

    // Print the posts
    return $this->render_associated_posts();    
  }
  
  Function render_associated_posts(){
    // Get the association settings
    If (!$meta = $this->get_association_data())
      return False;
    Else
      $template_file = $meta['template'];
    
    // Uses filter
    $template_file = Apply_Filters('associated_posts_template', $template_file);
    
    // If there is no valid template file we bail out
    If (!Is_File($template_file)) $template_file = $this->get_default_template();

    // Look whats the current post
    If (Is_Object($GLOBALS['post'])) $this->the_current_post = clone $GLOBALS['post'];
    
    // Use the template
    Ob_Start();
    Include $template_file;
    $result = Ob_Get_Contents();
    Ob_End_Clean();
    
    // Restore post data
    If (Is_Object($this->the_current_post)) $GLOBALS['post'] = clone $this->the_current_post;
    Unset ($this->the_current_post);
    setup_postdata($GLOBALS['post']);
    
    // return code
    return $result;
  }
  
  Function has_associated_posts($post_id = Null){
    /*
      This function is deprecated!
      I will remove it in the next releases!
    */

    If (self::get_association_data($post_id))
      return True;
    Else
      return False;
  }
  
  Function get_association_data($post_id = Null){
    // Get the post id
    If ($post_id == Null && Is_Object($GLOBALS['post']))
      $post_id = $GLOBALS['post']->ID;
    ElseIf ($post_id == Null && !Is_Object($GLOBALS['post']))
      return False;
    
    // Read the meta data
    $meta = Array_Merge(
      Array(
        'category_select_mode' => 'or_one',
        'category' => Array(),
        'tag_select_mode' => 'or_one',
        'tag' => Array(),
        'author_select_mode' => 'or',
        'author' => Array(),
        'post' => Array(),
        'post_limit' => '',
        'order_by' => 'date',
        'order' => 'ASC',
        'template' => self::get_default_template()
      ),
      (Array) get_post_meta($post_id, '_wp_plugin_associate_posts_and_pages', True), // Deprecated
      (Array) get_post_meta($post_id, self::get_meta_key(), True)
    );

    // Check if there are assoication meta data
    If ( Empty($meta['category']) &&
         Empty($meta['tag']) &&
         Empty($meta['author']) &&
         Empty($meta['post'])
       )
      Return False;
    Else
      Return $meta;  
  }

  Function get_associated_posts ($post_id = Null){
    // If there is no post_id we try to ready it
    If ($post_id == Null) $post_id = get_the_id();
    
    // If there is even no post_id we bail out
    If (!$post_id) return False;
    
    // read the associated category
    If (!$association = self::get_association_data($post_id))
      return False;
    
    // Filter posts
    $arr_post_category = Array();
    $arr_post_tag = Array();
    $arr_post_author = Array();
    $arr_post = Array();
    
    // By Category
    If (!Empty($association['category']))
      If ($association['category_select_mode'] == 'or_one' || $association['category_select_mode'] == 'and_one')
        $arr_post_category = self::get_post_ids_by_category($association['category'], 'or');
      ElseIf ($association['category_select_mode'] == 'or_all' || $association['category_select_mode'] == 'and_all')
        $arr_post_category = self::get_post_ids_by_category($association['category'], 'and');
    
    // By Tag
    If (!Empty($association['tag']))
      If ($association['tag_select_mode'] == 'or_one' || $association['tag_select_mode'] == 'and_one')
        $arr_post_tag = self::get_post_ids_by_tag($association['tag'], 'or');
      ElseIf ($association['tag_select_mode'] == 'or_all' || $association['tag_select_mode'] == 'and_all')
        $arr_post_tag = self::get_post_ids_by_tag($association['tag'], 'and');

    // By Author
    If (!Empty($association['author']))
      If ($association['author_select_mode'] == 'or' || $association['author_select_mode'] == 'and')
        $arr_post_author = self::get_post_ids_by_author($association['author']);


    // Add to the selected posts
    // Add Categories
    If ($association['category_select_mode'] == 'or_one' || $association['category_select_mode'] == 'or_all')
      $arr_post = Array_Merge ($arr_post, $arr_post_category);
    
    // Add Tags  
    If ($association['tag_select_mode'] == 'or_one' || $association['tag_select_mode'] == 'or_all')
      $arr_post = Array_Merge ($arr_post, $arr_post_tag);

    // Add Author
    If ($association['author_select_mode'] == 'or')
      $arr_post = Array_Merge ($arr_post, $arr_post_author);
      

    // Filter the selected posts 
    // Filter Categories
    If ($association['category_select_mode'] == 'and_one' || $association['category_select_mode'] == 'and_all')
      $arr_post = Array_Intersect ($arr_post, $arr_post_category);

    // Filter Tags
    If ($association['tag_select_mode'] == 'and_one' || $association['tag_select_mode'] == 'and_all')
      $arr_post = Array_Intersect ($arr_post, $arr_post_tag);

    // Filter Author
    If ($association['author_select_mode'] == 'and')
      $arr_post = Array_Intersect ($arr_post, $arr_post_author);
      
    // Add the additional posts
    $arr_post = Array_Merge ($arr_post, (Array) $association['post']);
    
    // There are no posts we have to care about
    If (Empty($arr_post)) return False;

    Return New WP_Query(Array(
      'post__in' => $arr_post,
      'posts_per_page' => $association['post_limit'] == '' ? -1 : IntVal($association['post_limit']),
      'orderby' => $association['order_by'],
      'order' => $association['order'],
      'caller_get_posts' => 1
    ));    
  }
  
  Function get_post_ids_by_category ($arr_category, $operator = 'OR'){
    $arr_category = (Array) $arr_category;
    $operator = StrToLower ($operator);
    $result = Array();
    
    // Get the posts
    If ($operator == 'or'){
      ForEach ($arr_category AS $category){
        $query = New WP_Query(Array(
          'post_type' => 'post',
          'post_status' => 'publish',
          'posts_per_page' => -1,
          'category__in' => $arr_category
        ));
        $result = Array_Merge ($result, self::extract_post_ids($query));
      }
      $result = Array_Unique ($result);
    }
    ElseIf ($operator == 'and'){
      $query = New WP_Query(Array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1,
        'category__and' => $arr_category
      ));
      $result = self::extract_post_ids($query);
    }
    
    return $result;     
  }
  
  Function get_post_ids_by_tag ($arr_tag, $operator = 'OR'){
    $arr_tag = (Array) $arr_tag;
    $operator = StrToLower ($operator);
    $result = Array();
    
    // Get the posts
    If ($operator == 'or'){
      ForEach ($arr_tag AS $tag){
        $query = New WP_Query(Array(
          'post_type' => 'post',
          'post_status' => 'publish',
          'posts_per_page' => -1,
          'caller_get_posts' => 1,
          'tag__in' => $arr_tag
        ));
        $result = Array_Merge ($result, self::extract_post_ids($query));
      }
      $result = Array_Unique ($result);
    }
    ElseIf ($operator == 'and'){
      $query = New WP_Query(Array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1,
          'tag__and' => $arr_tag
      ));
      $result = self::extract_post_ids($query);
    }
    
    return $result;     
  }
  
  Function get_post_ids_by_author($arr_author_id){
    $arr_author_id = (Array) $arr_author_id;
    $result = Array();
    
    // Get all posts by these authors
    ForEach ($arr_author_id AS $author_id){
      $query = New WP_Query(Array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1,
        'author' => $author_id
      ));
      $result = Array_Merge ($result, self::extract_post_ids($query));
    }
    
    // Clean the array
    return Array_Unique ($result);
  }
  
  Function extract_post_ids($wp_query){
    $result = Array();
    
    If ($wp_query && Is_Array($wp_query->posts)){
    ForEach ($wp_query->posts AS $p)
      $result[] = $p->ID;
    }
    
    return $result;
  }
  
  Function filter_content($content){
    // Append the ShortCode to the Content
    If ( StrPos($content, '[associated_posts]') === False && // Avoid double inclusion of the ShortCode
         StrPos($content, '[associated_posts ') === False && // Without closing bracket to find ShortCodes with attributes
         Apply_Filters('associated_posts_auto_append', True) && // You can use this filter to control the auto append feature
         $this->get_option('posts_position') != 'none' && // User can disable the auto append feature
         !post_password_required() // The user isn't allowed to read this page/post
       ){
      
      // Add the ShortCode to the current content
      If ($this->get_option('posts_position') == 'top')
        Return "\r\n[associated_posts]\r\n" . $content;
      Else
        Return $content . "\r\n[associated_posts]\r\n";

    }
    Else
      // the shortcode is already in the content / the filter says no
      Return $content;
  }
  
  Function get_post_thumbnail($post_id = Null, $size = 'thumbnail'){
    /* Return Value: An array containing:
         $image[0] => attachment id
         $image[1] => url
         $image[2] => width
         $image[3] => height
    */
    If ($post_id == Null) $post_id = get_the_id();
    
    If (Function_Exists('get_post_thumbnail_id') && $thumb_id = get_post_thumbnail_id($post_id) )
      return Array_Merge ( Array($thumb_id), (Array) wp_get_attachment_image_src($thumb_id, $size) );
    ElseIf ($arr_thumb = self::get_post_attached_image($post_id, 1, 'rand', $size))
      return $arr_thumb[0];
    Else
      return False;
  }

  Function get_post_attached_image($post_id = Null, $number = 1, $orderby = 'rand', $image_size = 'thumbnail'){
    If ($post_id == Null) $post_id = get_the_id();
    $number = IntVal ($number);
    $arr_attachment = get_posts (Array( 'post_parent'    => $post_id,
                                        'post_type'      => 'attachment',
                                        'numberposts'    => $number,
                                        'post_mime_type' => 'image',
                                        'orderby'        => $orderby ));
    
    // Check if there are attachments
    If (Empty($arr_attachment)) return False;
    
    // Convert the attachment objects to urls
    ForEach ($arr_attachment AS $index => $attachment){
      $arr_attachment[$index] = Array_Merge ( Array($attachment->ID), (Array) wp_get_attachment_image_src($attachment->ID, $image_size));
      /* Return Value: An array containing:
           $image[0] => attachment id
           $image[1] => url
           $image[2] => width
           $image[3] => height
      */
    }
    
    return $arr_attachment;
  }

  Function get_authors(){    
    $arr_author = Array();
    
    ForEach ( (Array) get_author_user_ids() AS $author_id)
      $arr_author[] = get_userdata( $author_id );
    
    If (Empty($arr_author))
      return False;
    Else
      return $arr_author;
  }
  
  Function get_all_posts(){
    $post_query = new WP_Query(Array(
      'post_type' => 'post',
      'posts_per_page' => -1,
      'category_name'=>'video',
      'post_status' => 'publish',
      'caller_get_posts' => 1
    ));
    
    return $post_query->posts;
  }

} /* End of Class */
New wp_plugin_post_page_associator();
} /* End of If-Class-Exists-Condition */
/* End of File */