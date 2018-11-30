<?php
if ( ! function_exists( 'aef21_create_field' ) )
{
  function aef21_create_field($post, $result)
  {
    //var_dump($post);
    //If it is textarea field
    if ($result->{'input-type'}==2)
    {
      $html = '<textarea class="aef21-field aef21-textarea-field widefat"
                name="attachments['.($post->ID).']['.$result->{'slug'}.']"
                id="attachments-'.$post->ID.'-'.$result->{'slug'}.'" aria-required="true">'.get_post_meta( $post->ID, $result->slug, true ).'</textarea>';

    }
    elseif ($result->{'input-type'}==3)
    {
      $checked = get_post_meta( $post->ID, $result->slug, true ) ? 'checked="checked"' : '';

      $html = '<input type="checkbox"  class="aef21-field aef21-checkbox-field widefat"
              name="attachments['.($post->ID).']['.$result->{'slug'}.']"
              id="attachments-'.$post->ID.'-'.$result->{'slug'}.'"
               '.$checked.' >';
              // exit;
    }
    else
    {
      //var_dump($result);
      $html = '<input type="text" class="aef21-field aef21-input-field widefat" name="attachments['.($post->ID).']['.$result->{'slug'}.']"
              id="attachments-'.$post->ID.'-'.$result->{'slug'}.'"
              value="'.get_post_meta( $post->ID, $result->slug, true ).'" />';
    }

    return $html;
  }
}
?>
