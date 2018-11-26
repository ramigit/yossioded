<h3><?php Echo $this->t('Position') ?></h3>
<!-- DO NOT SHOW ASSOCIATED POST AUTOMATICALLY (last option checked as deafult)
<p>
<input type="radio" name="posts_position" value="bottom" <?php checked($this->get_option('posts_position', 'bottom'), 'bottom') ?>/>
<?php Echo $this->t('Append the associated posts to the pages content.'); ?>
</p>
<p>
<input type="radio" name="posts_position" value="top" <?php checked($this->get_option('posts_position'), 'top') ?>/>
<?php Echo $this->t('Prepend the associated posts to the pages content.'); ?>
</p>
<p>
<input type="radio" name="posts_position" value="none" <?php checked($this->get_option('posts_position'), 'none') ?>/>
<?php Echo $this->t('<b>Do not</b> show the associated posts to the pages automatically. (In this case you have to add the short code manually.)'); ?>
</p>
-->
<p>
<input type="radio" name="posts_position" value="none" checked /><?php Echo $this->t('<b>Do not</b> show the associated posts to the pages automatically. (In this case you have to add the short code manually.)'); ?>
</p>

<h3><?php Echo $this->t('Templates') ?></h3>
<ol>
  <?php ForEach ( $this->find_templates() AS $file => $properties ) : ?>
  <li>
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
    <?php If ($properties['description']) : ?><br /><?php Echo $properties['description']; Endif; ?><br />
    <small><?php PrintF($this->t('Found in <em>%s</em>.'), $file) ?></a></small>
  </li>
  <?php EndForEach; ?>
</ol>

<!-- SHOW ONLY FULL CONTENT (last option checked as deafult)
<p>
<input type="radio" name="show_content" value="none" <?php checked($this->get_option('show_content', 'none'), 'none'); ?>/>
<?php Echo $this->t('Do not show any text of the associated posts. (Only the title with link to the post.)'); ?>
</p>

<p>
<input type="radio" name="show_content" value="excerpt" <?php checked($this->get_option('show_content'), 'excerpt') ?>/>
<?php Echo $this->t('Show an excerpt of the associated posts.'); ?>
</p>

<p>
<input type="checkbox" name="show_thumbnail" value="yes" <?php checked($this->get_option('show_thumbnail'), 'yes') ?>/>
<?php Echo $this->t('Show a post thumbnail of the associated posts.'); ?>
</p>

<p>
<input type="radio" name="show_content" value="content" <?php checked($this->get_option('show_content'), 'content') ?>/>
<?php Echo $this->t('Show the full text of the associated posts.'); ?>
</p>
-->
<p>
<input type="radio" name="show_content" value="content" checked />
<?php Echo $this->t('Show the full text of the associated posts.'); ?>
</p>


<!-- HIDE ALL THIS STUFF (checked as deafult)
<h3><?php Echo $this->t('Miscellaneous') ?></h3>
<p>
<input type="checkbox" name="hide_premium_banner" value="yes" <?php Checked($this->get_option('hide_premium_banner'), 'yes'); ?>/>
<?php Echo $this->t('Please hide the Associated Posts Pro banner. Of course I will buy it.'); ?> <small>;)</small>
</p>

<p>
<a href="http://wpplugins.com/plugin/247/associated-posts-pro/" target="_blank">
  <img src="<?php Echo $this->base_url ?>/premiumbanner.png"
       alt="<?php Echo $this->t('Buy the Pro-Version') ?>"
       title="<?php Echo $this->t('Buy the Pro-Version') ?>" />
</a>
</p>
-->
<p>
<input type="checkbox" name="hide_premium_banner" value="yes" Checked />
<?php Echo $this->t('Please hide the Associated Posts Pro banner. Of course I will buy it.'); ?> <small>;)</small>
</p>
