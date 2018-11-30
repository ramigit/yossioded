<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function aef21_add_extra_attachment_fields_admin_enqueue($hook) {
    if ( !current_user_can( 'manage_options' ) )  {
  		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  	}
    global $page_hook_suffix;

    if( $hook != $page_hook_suffix )
        return;
    wp_register_style('options_page_style', plugins_url('css/options_style.css',__FILE__),'','1.1');
    wp_enqueue_style('options_page_style');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
    wp_enqueue_script('my_script', plugins_url('js/attachement-extra-fields.js',__FILE__), array ( 'jquery' ), 1.1, true);
}
add_action( 'admin_enqueue_scripts', 'aef21_add_extra_attachment_fields_admin_enqueue' );


function aef21_add_extra_attachment_fields_plugin_options() {

  if ( !current_user_can( 'manage_options' ) )  {
  	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }


  global $_POST;
  global $wpdb;
  global $fetch_ef_sql;

  $results = $wpdb->get_results($fetch_ef_sql) ;
  $error_notice = array();

  //Update extra field options
  if(isset($_POST['submit_form_block']))
  {
    //Nonce Check
    check_admin_referer( 'edit-field_'.$option['id']);

    if(!is_numeric($_POST['option_id']))
    { wp_die( __( 'Hacking attempt  blocked.' ) );}

    $option['id'] = intval($_POST['option_id']);
    $option['field-label'] = sanitize_text_field( $_POST['field-label'] );
    $option['slug'] = sanitize_text_field( $_POST['slug'] );
    $option['input-type'] = intval($_POST['input-type']);;
    $option['help-text'] = sanitize_text_field( $_POST['help-text'] );
    $option['ordering'] = intval($_POST['ordering']);
    $option['required'] = intval($_POST['required']);
    $option['enabled'] = intval($_POST['enabled']);



    if (empty(trim($option['field-label'])))
    {$error_notice[$option['id']]['field-label']= "Title cannot be empty.";}

    if (strstr($option['slug']," "))
    {$error_notice[$option['id']]['slug']= "No spaces are allowed in slug.";}
    elseif(empty(trim($option['slug'])))
    {$error_notice[$option['id']]['slug']= "Slug cannot be empty.";}

    $slug_sql = "SELECT * FROM `".$wpdb->attachment_extra_fields_table."` where slug ='".$option['slug']."'";
    $wpdb->get_results($slug_sql) ;
    if($wpdb->num_rows>=2)
    {
      $error_notice[$option['id']]['slug']= "This slug already exists! Please try another one.";
    }

    //If no errors update database;
    if (count($error_notice[$option['id']])==0)
    {
      $sql = 'UPDATE `'.$wpdb->attachment_extra_fields_table.'`
              SET `field-label`= "'.$option['field-label'].'",
              `slug`= "'.$option['slug'].'",
              `input-type`= "'.$option['input-type'].'",
              `help-text`= "'.$option['help-text'].'",
              `ordering`= "'.$option['ordering'].'",
              `required`= "'.$option['required'].'",
              `enabled`= "'.$option['enabled'].'"
              WHERE id = "'.$option['id'].'"';

      $query_result[$option['id']] = $wpdb->query($sql);
    }
  }


  //Delete field
  if(isset($_POST['delete_form_block']))
  {
    $option['id'] = intval($_POST['option_id']);
    //Nonce Check
    check_admin_referer( 'edit-field_'.$option['id']);
    
    $wpdb->delete( $wpdb->attachment_extra_fields_table, array( 'ID' => $option['id'] ) );
    $results = $wpdb->get_results($fetch_ef_sql) or die(mysql_error());
  }

  //Create new field
  if(isset($_POST['submit_new_field']))
  {
    //Nonce Check
    check_admin_referer( 'eaf_insert_field');

    $new_option['field-label'] = sanitize_text_field( $_POST['field-label'] );
    $new_option['slug'] = sanitize_text_field( $_POST['slug'] );
    $new_option['input-type'] = intval($_POST['input-type']);;
    $new_option['help-text'] = sanitize_text_field( $_POST['help-text'] );
    $new_option['ordering'] = intval($_POST['ordering']);
    $new_option['required'] = intval($_POST['required']);
    $new_option['enabled'] = intval($_POST['enabled']);



    if (empty(trim($new_option['field-label'])))
    {$new_error_notice['field-label']= "Title cannot be empty.";}

    if (strstr($new_option['slug']," "))
    {$new_error_notice['slug']= "No spaces are allowed in slug.";}
    elseif(empty(trim($new_option['slug'])))
    {$new_error_notice['slug']= "Slug cannot be empty.";}

    $slug_sql = "SELECT * FROM `".$wpdb->attachment_extra_fields_table."` where slug ='".$new_option['slug']."'";
    $wpdb->get_results($slug_sql) ;
    if($wpdb->num_rows>=1)
    {
      $new_error_notice['slug']= "This slug already exists! Please try another one.";
    }


    //If no errors update database;
    if (count($new_error_notice)==0)
    {

      $data = array(
        'field-label' => $new_option['field-label'],
        'slug'        => $new_option['slug'],
        'input-type'  => $new_option['input-type'],
        'help-text'   => $new_option['help-text'],
        'ordering'    => $new_option['ordering'],
        'required'    => $new_option['required'],
        'enabled'     => $new_option['enabled']
      );

      $wpdb->insert($wpdb->attachment_extra_fields_table, $data);
      $results = $wpdb->get_results($fetch_ef_sql) or die(mysql_error());
      unset($new_option);
    }
  }

  ?>
  <div class="wrap">
  <h1><?php echo __('Extra Attachment Fields');?></h1>
  <div class="attachment-fields-description">
    <p><?php echo __("Add custom extra fields to media in media library. Create new fields or edit the existing ones. Ordering by 'Order' descending, 'Title' ascending.") ;?>
    </p>
  </div>
  <?php
  foreach($results as $result)
  {
    if (count($error_notice) >= 1)
    {
      if (count($error_notice[$result->id])>=1)
      {$has_error=1;}
      else{$has_error = 0;}
    }else{$has_error=0; $error_notice[$result->id] = array();}

    $form_post_to = $_SERVER['PHP_SELF']. "?" . $_SERVER['QUERY_STRING']; ?>
    <form method="post" action="<?php echo $form_post_to; ?>" class='aef21-form-block <?php if ($has_error==1){ echo "has-error";} ?>'>
      <?php $nonce = wp_nonce_field( 'edit-field_'.$result->id );
      ?>
      <input type="hidden" name='option_id' value = "<?php echo $result->id;?>" />
      <?php echo $nonce; ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row"><?php echo __('Title');?></th>
          <th scope="row" class="<?php if (!empty(trim($error_notice[$result->id]['slug']))){echo "th-error";} ?>"><?php echo __('Slug');?></th>
          <th scope="row"><?php echo __('Input Type');?></th>
          <th scope="row"><?php echo __('Help Text');?></th>
          <th scope="row"><?php echo __('Order');?></th>
          <th scope="row"><?php echo __('Required?');?></th>
          <th scope="row" class="enabled-highlight"><?php echo __('Enabled?');?></th>
          <th scope="row" class="grey-light">(<?php echo __('ID: ')." ".$result->id; ?>)</th>
        </tr>
        <tr valign='top'>
          <td  class='twenty-five-percent'><input type="text" name='field-label'  class="<?php
            if   (!empty(trim($error_notice[$result->id]['field-label']))){echo "is-the-error";} ?>"
            value = "<?php
            if ($option['id'] == $result->id){ echo $option['field-label'];}
            else{ echo $result->{'field-label'};}?>"
            />
          </td>
          <td  class='fifteen-percent'>
            <input type="text" name='slug' class="<?php if (!empty(trim($error_notice[$result->id]['slug']))){echo "is-the-error";} ?>" value = "<?php
            if ($option['id'] == $result->id){ echo $option['slug'];}
            else{ echo $result->{'slug'};}?>" />
          </td>
          <td>
            <select name="input-type">
              <?php
              if ($option['id'] == $result->id){ $selected_value = $option['input-type'];}
              else {$selected_value = $result->{'input-type'};}
              ?>
             <option value="1" <?php if ($selected_value==1){echo " selected ";} ?> >Text</option>
             <option value="2" <?php if ($selected_value==2){echo " selected ";} ?> >TextArea</option>
             <option value="3" <?php if ($selected_value==3){echo " selected ";} ?> >CheckBox</option>
            </select>
          </td>
          <td  class='twenty-five-percent'>
            <input type="text" name='help-text' value = "<?php if ($option['id'] == $result->id){ echo $option['help-text'];}
              else{ echo $result->{'help-text'};}?>" /></td>
          <td >
            <input type="text" size='2' name='ordering' value = "<?php if ($option['id'] == $result->id){ echo $option['ordering'];}
              else{ echo $result->{'ordering'};}?>" />
          </td>
          <td>
            <select name="required">
              <?php
              if ($option['id'] == $result->id){ $selected_value = $option['required'];}
              else {$selected_value = $result->{'required'};}
              ?>
             <option value="0" <?php if ($selected_value==0){echo " selected ";} ?>>No</option>
             <option value="1" <?php if ($selected_value==1){echo " selected ";} ?>>Yes</option>
            </select>
          </td>
          <td>
            <select name="enabled" >
              <?php
              if ($option['id'] == $result->id){ $selected_value = $option['enabled'];}
              else {$selected_value = $result->{'enabled'};}
              ?>
             <option value="0"  class="fa fa-minus-square-o" <?php if ($selected_value==0){echo " selected ";} ?>> No</option>
             <option value="1"  class="fa fa-check-square-o" <?php if ($selected_value==1){echo " selected ";} ?>> Yes</option>
            </select>
          </td>
          <td>
            <?php submit_button('Save', 'primary','submit_form_block',true,array('id'=>'sumbit-form-block-'.$result->id)); ?>
          </td>
        </tr>
        <?php if ($has_error==1)
        { ?>
          <tr>
            <td colspan="8">
              <ul class="error-list">
                <?php foreach($error_notice[$result->id] as $error)
                {
                  echo "<li>".$error."</li>";
                } ?>
              </ul>

            </td>
          </tr>
        <?php } ?>
        <tr>
          <td class="delete-notice">
            <?php submit_button('Delete this field', 'delete-button','delete_form_block',true,array('id'=>'delete-form-block-'.$result->id)); ?>
          </td>
        </tr>
        <?php if ($query_result[$result->id])
        { ?>
          <tr>
            <td colspan="8">
              <h3>Saved</h3>
            </td>
          </tr>
        <?php } ?>
      </table>

    </form>
    <?php

  }
  unset($result);

  ?>
  <hr />
  <h2 id='new-attachment-header'><?php echo __('Create a new attachment field');?></h2>
  <?php
  //Check if errors exist
  if (count($new_error_notice)>=1)
  {$has_error=1;}
  else{$has_error = 0;}
  ?>
  <form method="post"  class='aef21-form-block <?php if ($has_error==1){ echo "has-error";} ?> new-field' action="#new-attachment-header" >
    <div class="attachment-fields-description">
      <p><?php echo __("Create a new field for your media.") ;?>
      </p>
    </div>
    <?php $nonce = wp_nonce_field( 'eaf_insert_field');   ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row" class="<?php if (!empty(trim($new_error_notice['field-label']))){echo "th-error";} ?>"><?php echo __('Title');?> <span class='red-star'>*</span></th>
        <th scope="row" class="<?php if (!empty(trim($new_error_notice['slug']))){echo "th-error";} ?>"><?php echo __('Slug');?>  <span class='red-star'>*</span></th>
        <th scope="row"><?php echo __('Input Type');?> <span class='red-star'>*</span></th>
        <th scope="row"><?php echo __('Help Text');?></th>
        <th scope="row"><?php echo __('Order');?></th>
        <th scope="row"><?php echo __('Required');?></th>
        <th scope="row" class="enabled-highlight"><?php echo __('Enabled?');?></th>
        <th scope="row"><?php echo __('');?></th>
      </tr>
      <tr valign='top'>
        <td  class='twenty-five-percent'><input type="text" name='field-label'  class="<?php
          if   (!empty(trim($new_error_notice['field-label']))){echo "is-the-error";} ?>"
          value = "<?php
          if (isset($new_option['field-label'])){ echo $new_option['field-label'];}
          ?>"
          />
        </td>
        <td  class='fifteen-percent'>
          <input type="text" name='slug' class="<?php if (!empty(trim($new_error_notice['slug']))){echo "is-the-error";} ?>" value = "<?php if (isset($new_option['slug'])){ echo $new_option['slug'];}?>" />
        </td>
        <td>
          <select name="input-type">
            <?php
            if (isset($new_option['input-type'])){ $selected_value = $new_option['input-type'];}
            ?>
           <option value="1" <?php if ($selected_value==1){echo " selected ";} ?> >Text</option>
           <option value="2" <?php if ($selected_value==2){echo " selected ";} ?> >TextArea</option>
           <option value="3" <?php if ($selected_value==3){echo " selected ";} ?> >CheckBox</option>
          </select>
        </td>
        <td  class='twenty-five-percent'>
          <input type="text" name='help-text' value = "<?php if (isset($new_option['help-text'])){ echo $new_option['help-text'];}
            ?>" /></td>
        <td >
          <input type="text" size='2' name='ordering' value = "<?php if (isset($new_option['ordering'])){ echo $new_option['ordering'];}
            else{ echo '0';}?>" />
        </td>
        <td>
          <select name="required">
            <?php
            if (isset($new_option['required'])){ $selected_value = $new_option['required'];}
            else {$selected_value = $result->{'required'};}
            ?>
           <option value="0" <?php if ($selected_value==0){echo " selected ";} ?>>No</option>
           <option value="1" <?php if ($selected_value==1){echo " selected ";} ?>>Yes</option>
          </select>
        </td>
        <td>
          <select name="enabled">
            <?php
            if (isset($new_option['enabled'])){ $selected_value = $new_option['enabled'];}
            else {$selected_value = $result->{'enabled'};}
            ?>
           <option value="0" <?php if ($selected_value==0){echo " selected ";} ?>>No</option>
           <option value="1" <?php if ($selected_value==1){echo " selected ";} ?>>Yes</option>
          </select>
        </td>

      </tr>
      <?php if ($has_error==1)
      { ?>
        <tr>
          <td colspan="8">
            <ul class="error-list">
              <?php foreach($new_error_notice as $error)
              {
                echo "<li>".$error."</li>";
              } ?>
            </ul>

          </td>
        </tr>

      <?php } ?>
      <tr>
        <td>
            <?php submit_button('Save', 'button-primary','submit_new_field',true,array('id'=>'sumbit-new-field-'.$result->id)); ?>
        </td>
        <td>
          <span class="red-star">*</span> Mandatory fields
        </td>
      </tr>

    </table>

  </form>


</div>
<?php } ?>
