<?php


/*
PPA Template: video
Description: This template shows the title and the full content for each associated post.
Version: 1.0
Author: K
Author URI: http://bycoyote.com
*/


If ( $association_query = $this->get_associated_posts() ) : ?>
  <div class="associated-posts">  
  <?php While ($association_query->have_posts()) : $association_query->the_post(); ?>
  <div class="associated-post">
    <div class="post-content"><?php the_content() ?></div>
    <div class="clear"></div>
  </div>
  <?php EndWhile; ?>
  </div>
<?php EndIf;
/* End of File */