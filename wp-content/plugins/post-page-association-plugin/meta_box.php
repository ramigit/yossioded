<?php $meta = $this->get_association_data() ?>

<div id="association-selection">  
<!-- REMOVE ALL THOSE OPTIONS, ONLY LEAVE THE "SELECT BY NAME OPTION"
  <h4><?php Echo $this->t('Select posts by category') ?></h4>
  <p class="selection-mode">
    <?php Echo $this->t('Selection mode:') ?>
    <select name="<?php Echo $this->Field_Name('category_select_mode') ?>">
      <option value="or_one" <?php Selected($meta['category_select_mode'], 'or_one') ?> ><?php Echo $this->t('Add to my selection: All posts which are at least in one of these categories.') ?></option>
      <option value="and_one" <?php Selected($meta['category_select_mode'], 'and_one') ?> ><?php Echo $this->t('Filter my selection: Only posts which are at least in one of these categories.') ?></option>
      <option value="or_all" <?php Selected($meta['category_select_mode'], 'or_all') ?> ><?php Echo $this->t('Add to my selection: All posts which are in all of these categories.') ?></option>
      <option value="and_all" <?php Selected($meta['category_select_mode'], 'and_all') ?> ><?php Echo $this->t('Filter my selection: Only posts which are in all of these categories.') ?></option>
      <option value="" <?php Selected($meta['category_select_mode'], '') ?> ><?php Echo $this->t('Do not care about categories.') ?></option>
    </select>
  </p>
  <p class="select-category">
  <?php ForEach ( get_categories(Array('hide_empty' => False)) AS $category ) : ?>
  <span class="option category">
    <input type="checkbox" name="<?php Echo $this->Field_Name('category') ?>[]" value="<?php Echo $category->cat_ID ?>" <?php Checked(Array_Search($category->cat_ID, (Array) $meta['category']) !== False) ?> />
    <?php Echo $category->cat_name ?>
  </span>
  <?php EndForEach; ?>
  </p>
  
  <h4><?php Echo $this->t('Select posts by tag') ?></h4>
  <p class="selection-mode">
    <?php Echo $this->t('Selection mode:') ?>
    <select name="<?php Echo $this->Field_Name('tag_select_mode') ?>">
      <option value="or_one" <?php Selected($meta['tag_select_mode'], 'or_one') ?> ><?php Echo $this->t('Add to my selection: All posts which are tagged with at least one of these tags.') ?></option>
      <option value="and_one" <?php Selected($meta['tag_select_mode'], 'and_one') ?> ><?php Echo $this->t('Filter my selection: Only posts which are tagged with at least one of these tags.') ?></option>
      <option value="or_all" <?php Selected($meta['tag_select_mode'], 'or_all') ?> ><?php Echo $this->t('Add to my selection: All posts which are tagged with all of these tags.') ?></option>
      <option value="and_all" <?php Selected($meta['tag_select_mode'], 'and_all') ?> ><?php Echo $this->t('Filter my selection: Only posts which are tagged with all of these tags.') ?></option>
      <option value="" <?php Selected($meta['tag_select_mode'], '') ?> ><?php Echo $this->t('Do not care about tags.') ?></option>
    </select>
  </p>
  <p class="select-tag">
  <?php ForEach ( get_tags(Array('hide_empty' => False)) AS $tag ) : ?>
  <span class="option tag">
    <input type="checkbox" name="<?php Echo $this->Field_Name('tag') ?>[]" value="<?php Echo $tag->term_id ?>" <?php Checked(Array_Search($tag->term_id, (Array) $meta['tag']) !== False) ?> />
    <?php Echo $tag->name ?>
  </span>
  <?php EndForEach; ?>
  </p>
  
  
  <h4><?php Echo $this->t('Select posts by author') ?></h4>
  <p class="selection-mode">
    <?php Echo $this->t('Selection mode:') ?>
    <select name="<?php Echo $this->Field_Name('author_select_mode') ?>">
      <option value="or" <?php Selected($meta['author_select_mode'], 'or') ?> ><?php Echo $this->t('Add to my selection: All posts by these authors.') ?></option>
      <option value="and" <?php Selected($meta['author_select_mode'], 'and') ?> ><?php Echo $this->t('Filter my selection: Only posts by these authors.') ?></option>
      <option value="" <?php Selected($meta['author_select_mode'], '') ?> ><?php Echo $this->t('Do not care about authors.') ?></option>
    </select>
  </p>
  <p class="select-author">
  <?php ForEach ( (Array) $this->get_authors() AS $author ) : ?>
  <span class="option author">
    <input type="checkbox" name="<?php Echo $this->Field_Name('author') ?>[]" value="<?php Echo $author->ID ?>" <?php Checked(Array_Search($author->ID, (Array) $meta['author']) !== False) ?> />
    <?php Echo $author->display_name ?>
  </span>
  <?php EndForEach; ?>
  </p>  
-->
  <h4><?php Echo $this->t('Select posts by name (Choose from the list below. You can only choose one post)') ?></h4>
  <p class="select-post">
  <?php ForEach ($this->get_all_posts() AS $p) : ?>
  <span class="option-long">
    <input type="checkbox" name="<?php Echo $this->Field_Name('post') ?>[]" value="<?php Echo $p->ID ?>" <?php Checked(Array_Search($p->ID, (Array) $meta['post']) !== False) ?> />
    <?php Echo ($p->post_title != '') ? $p->post_title : '<i>'.SPrintF($this->t('Post %s (Without title)'), $p->ID).'</i>' ?>
  </span>
  <?php EndForEach; ?>
  </p>
  
<!-- DEAFULT VALUES FOR SETTINGS -->  
  <h4><?php _e('Settings') ?></h4>
  
  <p class="number-of-posts">
    <?php Echo $this->t('Number of posts:') ?> <input type="text" name="<?php Echo $this->Field_name('post_limit') ?>" value="1" size="4" /> 
  </p>
<!--
  <p class="offset">
    <?php Echo $this->t('Offset:') ?> <input type="text" name="<?php Echo $this->Field_name('offset') ?>" value="<?php Echo HTMLSpecialChars($meta['offset']) ?>" size="4" disabled="disabled" /> (<?php Echo $this->t('Leave blank to start with the first post.') ?>)<br />
    <small>(<?php PrintF ($this->t('This feature is only available in <a href="%s" target="_blank">Associated Posts Pro</a>.'), 'http://wpplugins.com/plugin/247/associated-posts-pro/') ?>)</small>
  </p>
 
  <p class="posts-per-page">
    <?php Echo $this->t('Posts per page:') ?> <input type="text" name="<?php Echo $this->Field_name('posts_per_page') ?>" value="<?php Echo HTMLSpecialChars($meta['posts_per_page']) ?>" size="4" disabled="disabled" /> (<?php Echo $this->t('Leave blank to show all posts on one page.') ?>)<br />
    <small>(<?php PrintF ($this->t('This feature is only available in <a href="%s" target="_blank">Associated Posts Pro</a>.'), 'http://wpplugins.com/plugin/247/associated-posts-pro/') ?>)</small>
  </p>
 
  
  <p class="order-by">
    <?php Echo $this->t('Order posts by:') ?>
    <select name="<?php Echo $this->Field_Name('order_by') ?>">
      <option value="date" <?php Selected($meta['order_by'], 'date') ?> ><?php _e('Date') ?></option>
      <option value="author" <?php Selected($meta['order_by'], 'author') ?> ><?php _e('Author') ?></option>
      <option value="title" <?php Selected($meta['order_by'], 'title') ?> ><?php _e('Title') ?></option>
      <option value="modified" <?php Selected($meta['order_by'], 'modified') ?> ><?php _e('Last Modified') ?></option>
      <option value="rand" <?php Selected($meta['order_by'], 'rand') ?> ><?php _e('Random') ?></option>
    </select>
  </p>
   
  <p class="order">
    <?php Echo $this->t('Order:') ?>
    <select name="<?php Echo $this->Field_Name('order') ?>">
      <option value="DESC" <?php Selected($meta['order'], 'DESC') ?> ><?php Echo $this->t('Descending') ?></option>
      <option value="ASC" <?php Selected($meta['order'], 'ASC') ?> ><?php Echo $this->t('Ascending') ?></option>
    </select>
  </p>
--> 
  <?php If(!$this->get_option('hide_premium_banner')) : ?>
  <h4><?php Echo $this->t('Buy the Pro-Version') ?></h4>
  <p>
    <a href="http://wpplugins.com/plugin/247/associated-posts-pro/" target="_blank">
      <img src="<?php Echo $this->base_url ?>/premiumbanner.png"
           alt="<?php Echo $this->t('Buy the Pro-Version') ?>"
           title="<?php Echo $this->t('Buy the Pro-Version') ?>" />
    </a>
  </p>
  <?php EndIf; ?>
<!-- DO NOT SHOW THIS OPTION IN THE  ADMIN UI
  <h4><?php Echo $this->t('Template') ?></h4>
  <div class="template">
  	<?php $my_template = (Array) Apply_Filters('associated_posts_template_files', $my_template);?>
    <?php ForEach ( $this->find_templates($my_template) AS $file => $properties ) : ?>
    <p>
      <input type="radio" name="<?php Echo $this->Field_Name('template') ?>" value="<?php Echo HTMLSpecialChars($file) ?>" <?php Checked($meta['template'], $file) ?> />
      <?php If (Empty($properties['name'])) : ?>
        <em><?php Echo $file ?></em>
      <?php Else : ?>
        <strong><?php Echo $properties['name'] ?></strong>
      <?php EndIf; ?>
      <?php If ($properties['version']) : ?> (<?php Echo $properties['version'] ?>)<?php Endif; ?>
      <?php If ($properties['author'] && !$properties['author_uri'] ) : ?>
        <?php Echo $this->t('by') ?> <?php Echo $properties['author'] ?>
      <?php ElseIf ($properties['author'] && $properties['author_uri'] ) : ?>
        <?php Echo $this->t('by') ?> <a href="<?php Echo $properties['author_uri'] ?>" target="_blank"><?php Echo $properties['author'] ?></a>
      <?php Endif; ?>
      <?php If ($properties['description']) : ?><br /><?php Echo $properties['description']; Endif; ?>
    </p>
    <?php EndForEach; ?>
  </div>
-->
</div>
