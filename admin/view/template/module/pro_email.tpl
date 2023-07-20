<?php function mailPreviewPanel($_language, $order_statuses, $mail_custom, $store_id, $token, $mijourl, $languages) { ?>
<div class="mail-preview panel panel-default">
  <div class="panel-heading clearfix">
    <h3 class="panel-title"><i class="fa fa-search"></i> <?php echo $_language->get('text_preview'); ?></h3>
    <div class="pull-right">
      <div class="btn-group" role="group">
        <button type="button" class="btn btn-default preview-refresh"><i class="fa fa-refresh"></i></button>
      </div>
      <div class="btn-group" role="group">
        <button type="button" class="btn btn-default preview-image"><i class="fa fa-picture-o"></i></button>
      </div>
      <div class="btn-group preview-size" role="group">
        <button type="button" class="btn btn-default active" data-size="100%"><i class="fa fa-desktop"></i></button>
        <button type="button" class="btn btn-default" data-size="768px"><i class="fa fa-tablet"></i></button>
        <button type="button" class="btn btn-default" data-size="320px"><i class="fa fa-mobile"></i></button>
      </div>
     
    </div>
    <div class="pull-right">
      <select class="preview-lang form-control" style="width:50px;padding-left:3px;padding-right:0">
        <?php foreach ($languages as $language) { ?>
        <option value="<?php echo $language['language_id']; ?>"><?php echo strtoupper(substr($language['code'], 0, 2)); ?></a></li>
        <?php } ?>
      </select>
    </div>
     <div class="pull-right">
      <select class="preview-type form-control" style="width:200px">
       <optgroup label="<?php echo $_language->get('text_type_customer'); ?>">
        <option value="customer.register"><?php echo $_language->get('text_type_customer.register'); ?></option>
        <option value="customer.approve"><?php echo $_language->get('text_type_customer.approve'); ?></option>
        <option value="customer.forgotten"><?php echo $_language->get('text_type_customer.forgotten'); ?></option>
        <option value="customer.reward"><?php echo $_language->get('text_type_customer.reward'); ?></option>
        <option value="customer.credit"><?php echo $_language->get('text_type_customer.credit'); ?></option>
        <option value="customer.voucher"><?php echo $_language->get('text_type_customer.voucher'); ?></option>
        <option value="sale.contact"><?php echo $_language->get('text_type_sale.contact'); ?></option>
       </optgroup>
       <optgroup label="<?php echo $_language->get('text_type_affiliate'); ?>">
        <option value="affiliate.register"><?php echo $_language->get('text_type_affiliate.register'); ?></option>
        <option value="affiliate.approve"><?php echo $_language->get('text_type_affiliate.approve'); ?></option>
        <option value="affiliate.forgotten"><?php echo $_language->get('text_type_affiliate.forgotten'); ?></option>
        <option value="affiliate.transaction"><?php echo $_language->get('text_type_affiliate.transaction'); ?></option>
       </optgroup>
       <optgroup label="<?php echo $_language->get('text_type_order'); ?>">
        <option value="order.confirm"><?php echo $_language->get('text_type_order.confirm'); ?></option>
        <option value="order.return"><?php echo $_language->get('text_type_order.return'); ?></option>
       </optgroup>
       <optgroup label="<?php echo $_language->get('text_type_orderstatus'); ?>">
        <?php foreach ($order_statuses as $status) { ?>
          <option value="order.update|<?php echo $status['order_status_id']; ?>"><?php echo $status['name']; ?></option>
        <?php } ?>
       </optgroup>
       <optgroup label="<?php echo $_language->get('text_type_admin'); ?>">
        <?php foreach (array('admin.order.confirm', 'admin.customer.register', 'admin.affiliate.register', 'admin.information.contact') as $type) { ?>
          <option value="<?php echo $type; ?>"><?php echo $_language->get('text_type_'.$type); ?></option>
        <?php } ?>
       </optgroup>
       <?php if (!empty($mail_custom)) { ?>
       <optgroup label="<?php echo $_language->get('text_tab_content_4'); ?>">
        <?php foreach ($mail_custom as $type => $custom) { ?>
          <option value="<?php echo $type; ?>"><?php echo $custom['name']; ?></option>
        <?php } ?>
       </optgroup>
       <?php } ?>
    </select>
    </div>
  </div>
  <div class="preview-content">
    <iframe src="index.php?<?php echo $mijourl; ?>route=module/pro_email/preview&store_id=<?php echo $store_id; ?>&<?php echo $token; ?>"></iframe>
  </div>
</div>
<?php } ?>
<?php function imageField($id, $OC_V2, $_language, $thumb, $val, $no_image) { ?>
  <?php if ($OC_V2) { ?>
    <a href="" id="thumb_<?php echo $id; ?>" data-toggle="image" class="img-thumbnail"><img class="imgChangeReload" src="<?php echo $thumb[$id]; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a>
    <input type="hidden" name="proemail_theme[<?php echo $id; ?>]" value="<?php echo $val[$id]; ?>" id="input-image-<?php echo $id; ?>" />
  <?php } else { ?>
  <div class="image" style="text-align:center; float:left;"><img src="<?php echo $thumb[$id]; ?>" alt="" id="thumb_<?php echo $id; ?>" />
  <input type="hidden" name="proemail_theme[<?php echo $id; ?>]" value="<?php echo $val[$id]; ?>" id="proemail_<?php echo $id; ?>" />
  <br />
  </div>
  <div style="margin-left:10px;float:left;"><br /><a onclick="image_upload('proemail_<?php echo $id; ?>', 'thumb_<?php echo $id; ?>');"><?php echo $_language->get('text_browse'); ?></a><br /><br /><a onclick="jQuery('#thumb_<?php echo $id; ?>').attr('src', '<?php echo $no_image; ?>'); jQuery('#proemail_<?php echo $id; ?>').attr('value', '');"><?php echo $_language->get('text_clear'); ?></a></div>
  <?php } ?>
<?php } ?>
<?php function imageRepeat($id, $_language, $val) { $id.= '_repeat'; ?>
  <select name="proemail_theme[<?php echo $id; ?>]" class="form-control changeReload">
    <option value="" <?php if($val[$id] == '') echo 'selected="selected"'; ?>><?php echo $_language->get('text_repeat'); ?></option>
    <option value="repeat-x" <?php if($val[$id] == 'repeat-x') echo 'selected="selected"'; ?>><?php echo $_language->get('text_repeat-x'); ?></option>
    <option value="repeat-y" <?php if($val[$id] == 'repeat-y') echo 'selected="selected"'; ?>><?php echo $_language->get('text_repeat-y'); ?></option>
    <option value="no-repeat" <?php if($val[$id] == 'no-repeat') echo 'selected="selected"'; ?>><?php echo $_language->get('text_no-repeat'); ?></option>
    <option value="top center no-repeat" <?php if($val[$id] == 'top center no-repeat') echo 'selected="selected"'; ?>><?php echo $_language->get('text_no-repeat_center'); ?></option>
  </select>
<?php } ?>
<?php function mailEditorForm($type, $items, $languages, $_language, $from_name_placeholder, $from_email_placeholder, $layouts) { ?>
  <?php $admin = ''; ?>
  <?php $f=1; $row=0; foreach ($items as $key => $item) { ?>
  <?php
    if ($type == 'admin') {
      $admin = 'admin-';
      $type = 'type';
    }
    if ($type == 'status') {
      $key = $item['order_status_id'];
      $extra = '';
      if(true) {
        $extra .= 'tags_qosu,';
      }
      $tags = 'tags,tags_status,'.$extra.'tags_order_cond,tags_order,tags_conditions';
    } else if ($type == 'custom') {
      $tags = 'tags,custom';
    } else {
      $tags = 'tags';
      switch ($key) {
        case 'order.confirm':
        case 'admin.order.confirm':
          $tags .= ',tags_order_cond,tags_order,tags_conditions'; break;
        case 'admin.customer.register':
        case 'customer.register':
        case 'customer.approve':
        case 'customer.deny':
        case 'customer.reward':
          $tags .= ',tags_customer'; break;
        default:
          $tags .= ','.$key;
      }
    }
    ?>
  <div id="tab-<?php echo $admin.$type; ?>-<?php echo $row; ?>" class="tab-pane <?php if($f) echo ' active'; $f=0; ?>">
    <ul class="nav nav-tabs nav-language">
    <?php $f=1; foreach ($languages as $language) { ?>
    <li class="tab-lang-<?php echo $language['language_id']; ?> <?php if($f) echo 'active'; $f=0; ?>"><a data-lang="<?php echo $language['language_id']; ?>" href=".tab-lang-<?php echo $language['language_id']; ?>"><img src="<?php echo $language['image']; ?>" alt=""/> <?php echo $language['name']; ?></a></li>
    <?php } ?>
    </ul>
    <div class="tab-content tab-language">
      <?php $f=1; foreach ($languages as $language) { ?>
      <div class="tab-lang-<?php echo $language['language_id']; ?> tab-pane <?php if($f) echo ' active'; $f=0; ?>">
      <table class="form">
        <tr>
          <td><?php echo $_language->get('entry_from'); ?></td>
          <td class="container-fluid">
            <div class="col-md-6" style="padding-left:0">
            <input type="text" name="proemail_<?php echo $type; ?>[<?php echo $key; ?>][from_name][<?php echo $language['language_id']; ?>]" value="<?php echo isset($item['from_name'][$language['language_id']]) ? $item['from_name'][$language['language_id']] : ''; ?>" class="form-control" placeholder="<?php echo !empty($from_name_placeholder[$language['language_id']]) ? $from_name_placeholder[$language['language_id']] : $from_name_placeholder['default']; ?>"/>
            </div>
            <div class="col-md-6" style="padding-right:0">
            <input type="text" name="proemail_<?php echo $type; ?>[<?php echo $key; ?>][from_email][<?php echo $language['language_id']; ?>]" value="<?php echo isset($item['from_email'][$language['language_id']]) ? $item['from_email'][$language['language_id']] : ''; ?>" class="form-control" placeholder="<?php echo !empty($from_email_placeholder[$language['language_id']]) ? $from_email_placeholder[$language['language_id']] : $from_email_placeholder['default']; ?>"/>
            </div>
          </td>
        </tr>
        <?php if ($admin) { ?>
        <tr>
          <td><?php echo $_language->get('entry_to'); ?></td>
          <td><input type="text" name="proemail_<?php echo $type; ?>[<?php echo $key; ?>][to][<?php echo $language['language_id']; ?>]" value="<?php echo isset($item['to'][$language['language_id']]) ? $item['to'][$language['language_id']] : ''; ?>" class="form-control" placeholder="<?php echo $from_email_placeholder['default']; ?>"/></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $_language->get('entry_subject'); ?></td>
          <td><input type="text" name="proemail_<?php echo $type; ?>[<?php echo $key; ?>][subject][<?php echo $language['language_id']; ?>]" value="<?php echo isset($item['subject'][$language['language_id']]) ? $item['subject'][$language['language_id']] : ''; ?>" class="form-control"/></td>
        </tr>
        <tr>
        <td>
          <button type="button" class="btn btn-default btn-xs info-btn" data-toggle="modal" data-target="#modal-info" data-info="<?php echo $tags; ?>"><i class="fa fa-info"></i></button>
          <?php echo $_language->get('entry_content'); ?>
          <!--<img style="" src="view/pro_email/img/layout_body.png" alt=""/>-->
        </td>
        <td>
          <?php if(defined('JPATH_MIJOSHOP_OC')) {
            $desc = isset($item['content'][$language['language_id']]) ? $item['content'][$language['language_id']] : '';
            echo MijoShop::get('base')->editor()->display("proemail_".$type."[".$key."][content][".$language['language_id']."]", $desc, '97% !important', '320', '50', '11');
           } else { ?>
          <textarea name="proemail_<?php echo $type; ?>[<?php echo $key; ?>][content][<?php echo $language['language_id']; ?>]" id="proemail_<?php echo $type; ?>-<?php echo str_replace('.', '_', $key); ?>-<?php echo $language['language_id']; ?>" class="editorInit" style="height:307px; width:100%"><?php echo isset($item['content'][$language['language_id']]) ? $item['content'][$language['language_id']] : ''; ?></textarea>
          <?php } ?>
        </td>
        </tr>
        <tr>
          <td><?php echo $_language->get('entry_attachment'); ?></td>
          <td>
            <div class="input-group">
              <input type="text" name="proemail_<?php echo $type; ?>[<?php echo $key; ?>][file][<?php echo $language['language_id']; ?>]" value="<?php echo isset($item['file'][$language['language_id']]) ? $item['file'][$language['language_id']] : ''; ?>" placeholder="<?php echo $_language->get('placeholder_file'); ?>" class="form-control fileinput" style="height:35px"/>
              <span class="input-group-btn">
              <button type="button" data-loading-text="<?php echo $_language->get('text_loading'); ?>" class="btn btn-primary button-upload" style="height:35px"><i class="fa fa-upload"></i> <?php echo $_language->get('button_upload'); ?></button>
              </span>
            </div>
          </td>
        </tr>
        <tr>
          <td><?php echo $_language->get('entry_template'); ?></td>
          <td>
            <div>
              <select name="proemail_<?php echo $type; ?>[<?php echo $key; ?>][template][<?php echo $language['language_id']; ?>]" class="form-control">
                <option value=""><?php echo $_language->get('text_layout_default'); ?></option>
                <option value="_" <?php if(isset($item['template'][$language['language_id']]) && $item['template'][$language['language_id']] == '_') echo 'selected'; ?>><?php echo $_language->get('text_layout_opencart'); ?></option>
                <option value="off" <?php if(isset($item['template'][$language['language_id']]) && $item['template'][$language['language_id']] == 'off') echo 'selected'; ?>><?php echo $_language->get('text_no_send'); ?></option>
                <option disabled>--------------------------------------</option>
                <?php foreach ($layouts as $layout) { ?>
                <option value="<?php echo $layout['value']; ?>" <?php if(isset($item['template'][$language['language_id']]) && $item['template'][$language['language_id']] == $layout['value']) echo 'selected'; ?>><?php echo $layout['name']; ?></option>
                <?php } ?>
              </select>
            </div>
          </td>
        </tr>
      </table>
      </div>
      <?php } ?>
    </div>
  </div>
  <?php $row++; } ?>
<?php } ?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<?php if(!empty($style_scoped)) { ?><style scoped><?php echo $style_scoped; ?></style><?php } ?>
<input type="hidden" name="no-image" value="0" />
<div id="modal-info" class="modal <?php if ($OC_V2) echo ' fade'; ?>" tabindex="-1" role="dialog" aria-hidden="true"><span class="modalContent"></span></div>

			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>

  <div class="<?php if($OC_V2) echo 'container-fluid'; ?>">
	<?php if (isset($success) && $success) { ?><div class="alert alert-success success"><i class="fa fa-check-circle"></i> <?php echo $success; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><script type="text/javascript">setTimeout("jQuery('.alert-success').slideUp();",5000);</script><?php } ?>
	<?php if (isset($info) && $info) { ?><div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $info; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
	<?php if (isset($error) && $error) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
    <?php if (isset($error_warning) && $error_warning) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div><?php } ?>
<div class="panel panel-default">
	<div class="panel-heading">
    <div class="pull-right">
      <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
      <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
    </div>
		<h3 class="panel-title"><img src="<?php echo $_img_path; ?>icon_big.png" alt="" style="vertical-align:top;"/> <?php echo $heading_title; ?></h3>
	</div>
	<div class="content panel-body">
  <div id="stores" class="form-inline" <?php if ($OC_V2 && 0) echo 'class="v2"'; ?>>
		<?php echo $_language->get('text_store_select'); ?>
		<select name="store" class="form-control input-sm">
			<?php foreach ($stores as $store) { ?>
			<?php if ($store_id == $store['store_id']) { ?>
			<option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
			<?php } ?>
			<?php } ?>
		</select>
	</div>
		<ul class="nav nav-tabs">
    	<li class="active"><a href="#tab-0" data-toggle="tab" class="tabChangeReload"><i class="fa fa-file-text-o"></i><?php echo $_language->get('text_tab_0'); ?></a></li>
			<li><a href="#tab-1" data-toggle="tab" class="tabChangeReload"><i class="fa fa-eyedropper"></i><?php echo $_language->get('text_tab_1'); ?></a></li>
			<li><a href="#tab-2" data-toggle="tab" class="setContentPreview"><i class="fa fa-pencil"></i><?php echo $_language->get('text_tab_2'); ?></a></li>
			<li><a href="#tab-3" data-toggle="tab"><i class="fa fa-cube"></i><?php echo $_language->get('text_tab_3'); ?></a></li>
			<li><a href="#tab-4" data-toggle="tab"><i class="fa fa-cog"></i><?php echo $_language->get('text_tab_4'); ?></a></li>
			<li><a href="#tab-about" data-toggle="tab"><i class="fa fa-info"></i><?php echo $_language->get('text_tab_about'); ?></a></li>
		</ul>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <input type="hidden" name="proemail_seourl" value="<?php echo (in_array('complete_seo', $installed_modules) || in_array('multilingual_seo', $installed_modules)) ? '1' : ''; ?>">
		<div class="tab-content container-fluid">
       <div class="tab-pane active row" id="tab-0">
       <div class="col-md-6">
        <table class="form">
          <tr>
            <td><?php echo $_language->get('text_status'); ?></td>
            <td>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-power-off"></i></span>
                <input type="text" name="proemail_enabled" value="<?php echo !empty($proemail_enabled); ?>" class="toggler" data-mode="background" data-on-text="<?php echo strip_tags($_language->get('text_enabled')); ?>" data-off-text="<?php echo strip_tags($_language->get('text_disabled')); ?>" data-icons="" />
              </div>
            </td>
          </tr>
          <tr>
            <td><?php echo $_language->get('entry_layout'); ?></td>
            <td><select name="proemail_layout" id="selectize_layouts">
              <option value="<?php echo $proemail_layout; ?>"><?php echo $proemail_layout; ?></option>
            </select></td>
          </tr>
          <tr>
            <td><?php echo $_language->get('entry_color_scheme'); ?></td>
            <td><select name="proemail_color_scheme" id="selectize_colors">
              <option value="<?php echo $_config->get('proemail_color_scheme'); ?>"></option>
            </select></td>
          </tr>
        </table>
        </div>
        <div class="col-md-6">
          <?php echo mailPreviewPanel($_language, $order_statuses, $mail_custom, $store_id, $token, $mijourl, $languages); ?>
        </div>
      </div>
      <div class="tab-pane clearfix" id="tab-1">
      <div class="pull-right">
        <button id="save_scheme" class="btn btn-warning"><?php echo $_language->get('text_save_scheme'); ?></button>
      </div>
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-design-1" data-toggle="tab"><?php echo $_language->get('text_global'); ?></a></li>
          <li><a href="#tab-design-2" data-toggle="tab"><?php echo $_language->get('text_top'); ?></a></li>
          <li><a href="#tab-design-3" data-toggle="tab"><?php echo $_language->get('text_header'); ?></a></li>
          <li><a href="#tab-design-4" data-toggle="tab"><?php echo $_language->get('text_body'); ?></a></li>
          <li><a href="#tab-design-5" data-toggle="tab"><?php echo $_language->get('text_foot'); ?></a></li>
          <li><a href="#tab-design-6" data-toggle="tab"><?php echo $_language->get('text_bottom'); ?></a></li>
        </ul>
        <div class="tab-content clearfix">
          <div class="tab-pane active" id="tab-design-1">
            <table class="form">
              <tr>
                <td class="form-horizontal">
                  <h3><img style="padding-right:15px" src="view/pro_email/img/layout_global.png" alt=""/><?php echo $_language->get('text_global'); ?></h3>
                  
                  <div class="form-group form-inline">
                    <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_layout_width_i'); ?>"><?php echo $_language->get('entry_layout_width'); ?></span></label>
                    <div class="col-sm-4">
                      <input name="proemail_theme[width]" type="text" class="form-control delayChangeReload" value="<?php echo isset($proemail_theme['width']) ? $proemail_theme['width'] : ''; ?>" />
                      <select name="proemail_theme[width_unit]" class="form-control changeReload">
                        <option value="px" <?php if(isset($proemail_theme['width_unit']) && $proemail_theme['width_unit'] == 'px') echo 'selected="selected"'; ?>>px</option>
                        <option value="%" <?php if(isset($proemail_theme['width_unit']) && $proemail_theme['width_unit'] == '%') echo 'selected="selected"'; ?>>%</option>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group  form-inline">
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_logo'); ?></label>
                    <div class="col-sm-4">
                      <?php imageField('logo', $OC_V2, $_language, $thumb, $proemail_theme, $no_image); ?>
                    </div>
                    
                    <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_logo_width_i'); ?>"><?php echo $_language->get('entry_logo_width'); ?></span></label>
                    <div class="col-sm-4">
                      <input name="proemail_theme[logo_width]" type="text" class="form-control delayChangeReload" value="<?php echo isset($proemail_theme['logo_width']) ? $proemail_theme['logo_width'] : ''; ?>" />
                      px
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="color_btn" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_btn'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[btn]" data-target=".button" data-property="background-color" type="text" id="color_btn" class="form-control minicolors" value="<?php echo isset($proemail_color['btn']) ? $proemail_color['btn'] : ''; ?>" />
                    </div>
                    <label for="color_btn_text" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_btn_text'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[btn_text]" data-target=".btn_txt" data-property="color" type="text" id="color_btn_text" class="form-control minicolors" value="<?php echo isset($proemail_color['btn_text']) ? $proemail_color['btn_text'] : ''; ?>" />
                    </div>
                  </div>
                  
                  <div class="form-group  form-inline">
                    <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_btn_radius_i'); ?>"><?php echo $_language->get('entry_btn_radius'); ?></span></label>
                    <div class="col-sm-4">
                      <input name="proemail_theme[btn_radius]" type="text" class="form-control delayChangeReload" value="<?php echo isset($proemail_theme['btn_radius']) ? $proemail_theme['btn_radius'] : ''; ?>" />
                      px
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="color_btn" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_thead'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[thead]" data-target=".invoice thead td" data-property="background-color" type="text" id="color_thead" class="form-control minicolors" value="<?php echo isset($proemail_color['thead']) ? $proemail_color['thead'] : ''; ?>" />
                    </div>
                    <label for="color_btn_text" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_tborder'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[tborder]" data-target=".invoice td" data-property="border-color" type="text" id="color_tborder" class="form-control minicolors" value="<?php echo isset($proemail_color['tborder']) ? $proemail_color['tborder'] : ''; ?>" />
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="color_btn" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_theadtxt'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[theadtxt]" data-target=".invoice thead td" data-property="color" type="text" id="color_theadtxt" class="form-control minicolors" value="<?php echo isset($proemail_color['theadtxt']) ? $proemail_color['theadtxt'] : ''; ?>" />
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="color_bg_page" class="col-sm-2 control-label"><?php echo $_language->get('entry_color'); ?></label>
                    <div class="col-sm-10">
                      <input name="proemail_color[bg_page]" data-target="body, .body" data-property="background-color" type="text" id="color_bg_page" class="form-control minicolors" value="<?php echo isset($proemail_color['bg_page']) ? $proemail_color['bg_page'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_background_image'); ?></label>
                    <div class="col-sm-4">
                      <?php imageField('bg_page', $OC_V2, $_language, $thumb, $proemail_theme, $no_image); ?>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_repeat'); ?></label>
                    <div class="col-sm-4">
                      <?php imageRepeat('bg_page', $_language, $proemail_theme); ?>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
          <div class="tab-pane" id="tab-design-2">
            <table class="form">
              <tr>
                <td class="form-horizontal">
                  <h3><img style="padding-right:15px" src="view/pro_email/img/layout_top.png" alt=""/><?php echo $_language->get('text_top'); ?></h3>
                  
                  <div class="form-group">
                    <label for="color_text_top" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_text'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[text_top]" data-target=".top, .top p" data-property="color" type="text" id="color_text_top" class="form-control minicolors" value="<?php echo isset($proemail_color['text_top']) ? $proemail_color['text_top'] : ''; ?>" />
                    </div>
                    <label for="color_link_top" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_link'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[link_top]" data-target=".top a:not([class])" data-property="color" type="text" id="color_link_top" class="form-control minicolors" value="<?php echo isset($proemail_color['link_top']) ? $proemail_color['link_top'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="top" class="col-sm-2 control-label"><?php echo $_language->get('entry_color'); ?></label>
                    <div class="col-sm-10">
                      <input name="proemail_color[bg_top]" data-target=".top" data-property="background-color" type="text" id="color_bg_top" class="form-control minicolors" value="<?php echo isset($proemail_color['bg_top']) ? $proemail_color['bg_top'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_background_image'); ?></label>
                    <div class="col-sm-4">
                      <?php imageField('bg_top', $OC_V2, $_language, $thumb, $proemail_theme, $no_image); ?>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_repeat'); ?></label>
                    <div class="col-sm-4">
                      <?php imageRepeat('bg_top', $_language, $proemail_theme); ?>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
          <div class="tab-pane" id="tab-design-3">
            <table class="form">
              <tr>
                <td class="form-horizontal">
                  <h3><img style="padding-right:15px" src="view/pro_email/img/layout_header.png" alt=""/><?php echo $_language->get('text_header'); ?></h3>
                  
                  <div class="form-group">
                    <label for="color_text_head" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_text'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[text_head]" data-target=".header, .header p" data-property="color" type="text" id="color_text_head" class="form-control minicolors" value="<?php echo isset($proemail_color['text_head']) ? $proemail_color['text_head'] : ''; ?>" />
                    </div>
                    <label for="color_link_head" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_link'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[link_head]" data-target=".header a:not([class])" data-property="color" type="text" id="color_link_head" class="form-control minicolors" value="<?php echo isset($proemail_color['link_head']) ? $proemail_color['link_head'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="color_bg_header" class="col-sm-2 control-label"><?php echo $_language->get('entry_color'); ?></label>
                    <div class="col-sm-10">
                      <input name="proemail_color[bg_header]" data-target=".header" data-property="background-color" type="text" id="color_bg_header" class="form-control minicolors" value="<?php echo isset($proemail_color['bg_header']) ? $proemail_color['bg_header'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_background_image'); ?></label>
                    <div class="col-sm-4">
                      <?php imageField('bg_header', $OC_V2, $_language, $thumb, $proemail_theme, $no_image); ?>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_repeat'); ?></label>
                    <div class="col-sm-4">
                      <?php imageRepeat('bg_header', $_language, $proemail_theme); ?>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
          <div class="tab-pane" id="tab-design-4">
            <table class="form">
              <tr>
                <td class="form-horizontal">
                  <h3><img style="padding-right:15px" src="view/pro_email/img/layout_body.png" alt=""/><?php echo $_language->get('text_body'); ?></h3>
                  
                  <div class="form-group">
                    <label for="color_text" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_text'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[text]" data-target=".content,.content p,.content td" data-property="color" type="text" id="color_text" class="form-control minicolors" value="<?php echo isset($proemail_color['text']) ? $proemail_color['text'] : ''; ?>" />
                    </div>
                    <label for="color_link" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_link'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[link]" data-target=".content a:not([class])" data-property="color" type="text" id="color_link" class="form-control minicolors" value="<?php echo isset($proemail_color['link']) ? $proemail_color['link'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="color_bg_body" class="col-sm-2 control-label"><?php echo $_language->get('entry_color'); ?></label>
                    <div class="col-sm-10">
                      <input name="proemail_color[bg_body]" data-target=".main" data-property="background-color" type="text" id="color_bg_body" class="form-control minicolors" value="<?php echo isset($proemail_color['bg_body']) ? $proemail_color['bg_body'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_background_image'); ?></label>
                    <div class="col-sm-4">
                      <?php imageField('bg_body', $OC_V2, $_language, $thumb, $proemail_theme, $no_image); ?>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_repeat'); ?></label>
                    <div class="col-sm-4">
                      <?php imageRepeat('bg_body', $_language, $proemail_theme); ?>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
          <div class="tab-pane" id="tab-design-5">
            <table class="form">
              <tr>
                <td class="form-horizontal">
                  <h3><img style="padding-right:15px" src="view/pro_email/img/layout_footer.png" alt=""/><?php echo $_language->get('text_foot'); ?></h3>
                  
                  <div class="form-group">
                    <label for="color_text_foot" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_text'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[text_foot]" data-target=".footer, .footer p" data-property="color" type="text" id="color_text_foot" class="form-control minicolors" value="<?php echo isset($proemail_color['text_foot']) ? $proemail_color['text_foot'] : ''; ?>" />
                    </div>
                    <label for="color_link_foot" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_link'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[link_foot]" data-target=".footer a:not([class])" data-property="color" type="text" id="color_link_foot" class="form-control minicolors" value="<?php echo isset($proemail_color['link_foot']) ? $proemail_color['link_foot'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="color_bg_footer" class="col-sm-2 control-label"><?php echo $_language->get('entry_color'); ?></label>
                    <div class="col-sm-10">
                      <input name="proemail_color[bg_footer]" data-target=".footer" data-property="background-color" type="text" id="color_bg_footer" class="form-control minicolors" value="<?php echo isset($proemail_color['bg_footer']) ? $proemail_color['bg_footer'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_background_image'); ?></label>
                    <div class="col-sm-4">
                      <?php imageField('bg_footer', $OC_V2, $_language, $thumb, $proemail_theme, $no_image); ?>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_repeat'); ?></label>
                    <div class="col-sm-4">
                      <?php imageRepeat('bg_footer', $_language, $proemail_theme); ?>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
          <div class="tab-pane" id="tab-design-6">
            <table class="form">
              <tr>
                <td class="form-horizontal">
                  <h3><img style="padding-right:15px" src="view/pro_email/img/layout_bottom.png" alt=""/><?php echo $_language->get('text_bottom'); ?></h3>
                  <div class="form-group">
                    <label for="color_text_bottom" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_text'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[text_bottom]" data-target=".bottom, .bottom p" data-property="color" type="text" id="color_text_bottom" class="form-control minicolors" value="<?php echo isset($proemail_color['text_bottom']) ? $proemail_color['text_bottom'] : ''; ?>" />
                    </div>
                    <label for="color_link_bottom" class="col-sm-2 control-label"><?php echo $_language->get('entry_color_link'); ?></label>
                    <div class="col-sm-4">
                      <input name="proemail_color[link_bottom]" data-target=".bottom a:not([class])" data-property="color" type="text" id="color_link_bottom" class="form-control minicolors" value="<?php echo isset($proemail_color['link_bottom']) ? $proemail_color['link_bottom'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="bottom" class="col-sm-2 control-label"><?php echo $_language->get('entry_color'); ?></label>
                    <div class="col-sm-10">
                      <input name="proemail_color[bg_bottom]" data-target=".bottom" data-property="background-color" type="text" id="color_bg_bottom" class="form-control minicolors" value="<?php echo isset($proemail_color['bg_bottom']) ? $proemail_color['bg_bottom'] : ''; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_background_image'); ?></label>
                    <div class="col-sm-4">
                      <?php imageField('bg_bottom', $OC_V2, $_language, $thumb, $proemail_theme, $no_image); ?>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo $_language->get('entry_repeat'); ?></label>
                    <div class="col-sm-4">
                      <?php imageRepeat('bg_bottom', $_language, $proemail_theme); ?>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <?php echo mailPreviewPanel($_language, $order_statuses, $mail_custom, $store_id, $token, $mijourl, $languages); ?>
      </div>
      <div class="tab-pane clearfix" id="tab-2">
        <ul class="nav nav-tabs contentTabs">
          <li class="active"><a href="#tab-content-0" data-toggle="tab" class="setContentPreview"><?php echo $_language->get('text_tab_content_0'); ?></a></li>
          <li><a href="#tab-content-1" data-toggle="tab" class="setContentPreview"><?php echo $_language->get('text_tab_content_1'); ?></a></li>
          <li><a href="#tab-content-2" data-toggle="tab" class="setContentPreview"><?php echo $_language->get('text_tab_content_2'); ?></a></li>
          <li><a href="#tab-content-3" data-toggle="tab"><?php echo $_language->get('text_tab_content_3'); ?></a></li>
          <li><a href="#tab-content-4" data-toggle="tab" class="setContentPreview"><?php echo $_language->get('text_tab_content_4'); ?></a></li>
        </ul>
        <div class="tab-content clearfix">
          <div class="tab-pane active" id="tab-content-0">
            <ul class="nav nav-pills nav-stacked col-md-2 menu-types">
              <?php $f=1; $row=0; foreach ($mail_types as $key => $item) { ?>
              <li <?php if($f) echo 'class="active"'; $f=0; ?>><a href="#tab-type-<?php echo $row; ?>" data-type="<?php echo $key; ?>" data-toggle="pill"><?php echo $_language->get('text_type_' . $key); ?></a></li>
              <?php $row++; } ?>
            </ul>
            <div class="tab-content col-md-10">
              <?php mailEditorForm('type', $mail_types, $languages, $_language, $from_name_placeholder, $from_email_placeholder, $layouts); ?>
            </div>
          </div>
          <div class="tab-pane" id="tab-content-1">
            <ul class="nav nav-pills nav-stacked col-md-2 menu-statuses">
              <?php $f=1; $row=0; foreach ($order_statuses as $status) { ?>
              <li <?php if($f) echo 'class="active"'; $f=0; ?>><a href="#tab-status-<?php echo $row; ?>" data-type="order.update|<?php echo $status['order_status_id']; ?>" data-toggle="pill" <?php if(isset($status['color']) && $status['color'] != '000000') { ?>style="color:#<?php echo $status['color']; ?>"<?php } ?>><?php echo $status['name']; ?></a></li>
              <?php $row++; } ?>
            </ul>
            <div class="tab-content col-md-10">
              <?php mailEditorForm('status', $order_statuses, $languages, $_language, $from_name_placeholder, $from_email_placeholder, $layouts); ?>
            </div>
          </div>
          <div class="tab-pane" id="tab-content-2">
            <ul class="nav nav-pills nav-stacked col-md-2 menu-types">
              <?php $f=1; $row=0; foreach ($mail_admin as $key => $item) { ?>
              <li <?php if($f) echo 'class="active"'; $f=0; ?>><a href="#tab-admin-type-<?php echo $row; ?>" data-type="<?php echo $key; ?>" data-toggle="pill"><?php echo $_language->get('text_type_' . $key); ?></a></li>
              <?php $row++; } ?>
            </ul>
            <div class="tab-content col-md-10">
              <?php mailEditorForm('admin', $mail_admin, $languages, $_language, $from_name_placeholder, $from_email_placeholder, $layouts); ?>
            </div>
          </div>
          <div class="tab-pane" id="tab-content-3">
            <ul class="nav nav-tabs nav-language">
            <?php $f=1; foreach ($languages as $language) { ?>
              <li class="tab-lang-<?php echo $language['language_id']; ?> <?php if($f) echo 'active'; $f=0; ?>"><a data-lang="<?php echo $language['language_id']; ?>" href=".tab-lang-<?php echo $language['language_id']; ?>"><img src="<?php echo $language['image']; ?>" alt=""/> <?php echo $language['name']; ?></a></li>
            <?php } ?>
            </ul>
            <div class="tab-content tab-language">
              <?php $f=1; foreach ($languages as $language) { ?>
              <div class="form-horizontal tab-lang-<?php echo $language['language_id']; ?> tab-pane <?php if($f) echo ' active'; $f=0; ?>">
                <?php foreach (array('top', 'header', 'footer', 'bottom') as $type) { ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $_language->get('text_type_common.'.$type); ?><br/>
                  <img style="padding-top:14px;" src="view/pro_email/img/layout_<?php echo $type; ?>.png" alt=""/>
                  </label>
                  <div class="col-sm-10">
                      <?php $desc = isset($proemail_content['common.'.$type]['content'][$language['language_id']]) ? $proemail_content['common.'.$type]['content'][$language['language_id']] : '';
                      if(defined('JPATH_MIJOSHOP_OC')) {
                        echo MijoShop::get('base')->editor()->display("proemail_type[common".$type."][content][".$language['language_id']."]", $desc, '97% !important', '320', '50', '11');
                       } else { ?>
                      <textarea name="proemail_type[common.<?php echo $type; ?>][content][<?php echo $language['language_id']; ?>]" id="proemail_type-common_<?php echo $type; ?>-<?php echo $language['language_id']; ?>" class="editorInit" style="height:86px; width:100%"><?php echo $desc; ?></textarea>
                      <?php } ?>
                  </div>
                </div>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
            <div class="form-group">
              <div class="col-sm-2"></div>
              <div class="col-sm-10 alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $_language->get('text_warning_layout_zones'); ?></div>
            </div>
          </div>
          
          <div class="tab-pane" id="tab-content-4">
            <?php if (empty($mail_custom)) { ?>
              <div style="padding: 30px; margin-bottom: 30px; background-color: #F3F3F3; border-radius:5px;">
                <h3 style="margin-bottom:20px"><?php echo $_language->get('info_title_custom_mail'); ?></h3>
                <?php echo $_language->get('info_msg_custom_mail'); ?>
              </div>
            <?php } else { ?>
            <ul class="nav nav-pills nav-stacked col-md-2 menu-custom">
              <?php $f=1; $row=0; foreach ($mail_custom as $key => $item) { ?>
              <li <?php if($f) echo 'class="active"'; $f=0; ?>><a href="#tab-custom-<?php echo $row; ?>" data-type="<?php echo $key; ?>" data-toggle="pill"><?php echo $item['name']; ?></a></li>
              <?php $row++; } ?>
            </ul>
            <div class="tab-content col-md-10">
              <btn style="position:absolute;right:15px;" class="btn btn-default info-btn pull-right" data-info="custom_mail" data-target="#modal-info" data-toggle="modal" type="button"><i class="fa fa-info"></i>&nbsp;&nbsp;<?php echo $_language->get('text_btn_custom_binder'); ?></btn>
              <?php mailEditorForm('custom', $mail_custom, $languages, $_language, $from_name_placeholder, $from_email_placeholder, $layouts); ?>
            </div>
            <?php } ?>
          </div>
         
        </div>
        
        <div class="contentPreviewDisplay">
        <?php echo mailPreviewPanel($_language, $order_statuses, $mail_custom, $store_id, $token, $mijourl, $languages); ?>
        </div>
		</div>
    <div class="tab-pane" id="tab-3">
			<ul class="nav nav-pills nav-stacked col-md-2">
        <li class="active"><a href="#tab-module-2" data-toggle="pill"><?php echo $_language->get('tab_module_prodad'); ?></a></li>
        <li><a href="#tab-module-1" data-toggle="pill"><?php echo $_language->get('tab_module_invoice'); ?></a></li>
      </ul>
      <div class="tab-content col-md-10">
        <div class="tab-pane form-horizontal" id="tab-module-1">
          <div class="form-group">
            <label class="col-sm-2 control-label" style="padding-top:20px;"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_total_tax_i'); ?>"><?php echo $_language->get('entry_total_tax'); ?></span></label>
            <div class="col-sm-10">
              <input class="switch" type="checkbox"  id="proemail_total_tax" name="proemail_total_tax" value="1" <?php echo !empty($proemail_total_tax) ? 'checked="checked"':''; ?>/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" style="padding-top:20px;"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_customer_comment_i'); ?>"><?php echo $_language->get('entry_customer_comment'); ?></span></label>
            <div class="col-sm-10">
              <input class="switch" type="checkbox"  id="proemail_customer_comment" name="proemail_customer_comment" value="1" <?php echo !empty($proemail_customer_comment) ? 'checked="checked"':''; ?>/>
            </div>
          </div>
          <?php if ($OC_V2) { ?>
           <div class="form-group">
            <label class="col-sm-2 control-label" style="padding-top:20px;"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_custom_fields_i'); ?>"><?php echo $_language->get('entry_custom_fields'); ?></span></label>
            <div class="col-sm-10">
              <?php if (!$custom_fields) { echo $_language->get('entry_custom_fields_empty'); } ?>
              <?php foreach ($custom_fields as $item) { ?>
              <div>
                <span><?php echo $item['name']; ?></span>
                <input class="switch" type="checkbox"  id="proemail_custom_fields_<?php echo $item['custom_field_id']; ?>" name="proemail_custom_fields[]" value="<?php echo $item['custom_field_id']; ?>" <?php echo in_array($item['custom_field_id'], (array) $_config->get('proemail_custom_fields')) ? 'checked="checked"':''; ?>/>
              </div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
        </div>
        <div class="tab-pane active" id="tab-module-2">
          <ul class="nav nav-tabs">
            <?php $f=1; foreach (array('featured','latest', 'bestseller', 'special') as $pad_type) { ?>
            <li class="<?php if($f) echo 'active'; $f=0; ?>"><a href="#tab-prodad-<?php echo $pad_type; ?>" data-toggle="tab"><?php echo $_language->get('tab_prod_ad_'.$pad_type); ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <?php $f=1; foreach (array('featured', 'latest', 'bestseller', 'special') as $pad_type) { ?>
            <div class="tab-pane active form-horizontal" id="tab-prodad-<?php echo $pad_type; ?>">
               <div class="form-group">
                <label class="col-sm-2 control-label" for="input-padlat-width"><?php echo $_language->get('entry_img_size'); ?></label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
                    <input type="text" name="proemail_mod_product[<?php echo $pad_type; ?>][width]" value="<?php echo isset($proemail_mod_product[$pad_type]['width']) ? $proemail_mod_product[$pad_type]['width'] : ''; ?>" placeholder="<?php echo $_language->get('entry_width'); ?>" id="input-padlat-width" class="form-control" />
                  </div>
                </div>
                <div class="col-sm-5">
                  <div style="position:absolute;margin-left:-19px;top:10px;" class="hidden-xs">x</div>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
                    <input type="text" name="proemail_mod_product[<?php echo $pad_type; ?>][height]" value="<?php echo isset($proemail_mod_product[$pad_type]['height']) ? $proemail_mod_product[$pad_type]['height'] : ''; ?>" placeholder="<?php echo $_language->get('entry_height'); ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-padlat-limit"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_item_number_i'); ?>"><?php echo $_language->get('entry_item_number'); ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="proemail_mod_product[<?php echo $pad_type; ?>][limit]" value="<?php echo isset($proemail_mod_product[$pad_type]['limit']) ? $proemail_mod_product[$pad_type]['limit'] : ''; ?>" placeholder="3" id="input-padlat-limit" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-padlat-limit"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_per_row_i'); ?>"><?php echo $_language->get('entry_per_row'); ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="proemail_mod_product[<?php echo $pad_type; ?>][per_row]" value="<?php echo isset($proemail_mod_product[$pad_type]['per_row']) ? $proemail_mod_product[$pad_type]['per_row'] : ''; ?>" placeholder="3" id="input-padlat-limit" class="form-control" />
                </div>
              </div>
              <?php if ($pad_type == 'featured') { ?>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $_language->get('help_product'); ?>"><?php echo $_language->get('entry_product'); ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="prod_adv_autocomp" value="" placeholder="<?php echo $_language->get('entry_product'); ?>" id="input-product" class="form-control" />
                  <div id="featured-product" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php if(!empty($mod_product_ad_products)) foreach ($mod_product_ad_products as $product) { ?>
                    <div id="featured-product<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                      <input type="hidden" name="proemail_mod_product[<?php echo $pad_type; ?>][product][]" value="<?php echo $product['product_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="form-group well">
                <div class="col-sm-2"><i class="fa fa-info fa-2x pull-right"></i></div>
                <div class="col-sm-10"><?php echo $_language->get('info_product_ad_'.$pad_type); ?></div>
              </div>
            </div>
            <?php } ?>

          </div>
        </div>
		</div>
		</div>
    <div class="tab-pane" id="tab-4">
      <ul class="nav nav-pills nav-stacked col-md-2">
        <li class="active"><a href="#tab-config-1" data-toggle="pill"><?php echo $_language->get('tab_config_1'); ?></a></li>
        <li><a href="#tab-config-2" data-toggle="pill"><?php echo $_language->get('tab_config_2'); ?></a></li>
        <li><a href="#tab-config-10" data-toggle="pill"><?php echo $_language->get('tab_config_10'); ?></a></li>
      </ul>
      <div class="tab-content col-md-10">
        <div class="tab-pane active" id="tab-config-1">
          <ul class="nav nav-tabs nav-language">
            <?php $f=1; foreach ($languages as $language) { ?>
            <li class="tab-lang-<?php echo $language['language_id']; ?> <?php if($f) echo 'active'; $f=0; ?>"><a href=".tab-lang-<?php echo $language['language_id']; ?>"><img src="<?php echo $language['image']; ?>" alt=""/> <?php echo $language['name']; ?></a></li>
            <?php } ?>
            </ul>
            <div class="tab-content tab-language">
              <?php $f=1; foreach ($languages as $language) { ?>
              <div class="tab-lang-<?php echo $language['language_id']; ?> tab-pane <?php if($f) echo ' active'; $f=0; ?>">
              <table class="form">
                <tr>
                  <td><?php echo $_language->get('entry_from'); ?></td>
                  <td class="container-fluid">
                    <div class="col-md-6" style="padding-left:0">
                    <input type="text" name="proemail_from_name[<?php echo $language['language_id']; ?>]" value="<?php echo !empty($proemail_from_name[$language['language_id']]) ? $proemail_from_name[$language['language_id']] : ''; ?>" class="form-control" placeholder="<?php echo $from_name_placeholder['default']; ?>"/>
                    </div>
                    <div class="col-md-6" style="padding-right:0">
                    <input type="text" name="proemail_from_email[<?php echo $language['language_id']; ?>]" value="<?php echo !empty($proemail_from_email[$language['language_id']]) ? $proemail_from_email[$language['language_id']] : ''; ?>" class="form-control" placeholder="<?php echo $from_email_placeholder['default']; ?>"/>
                    </div>
                  </td>
                </tr>
              </table>
              </div>
              <?php } ?>
            </div>
        </div>
        <div class="tab-pane form-horizontal" id="tab-config-2">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-padlat-width"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_admin_layout_i'); ?>"><?php echo $_language->get('entry_admin_layout'); ?></span></label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                <select name="proemail_admin_layout" class="form-control">
                  <option value=""><?php echo $_language->get('text_admin_layout_default'); ?></option>
                  <option value="_" <?php if($proemail_admin_layout == '_') echo 'selected'; ?>><?php echo $_language->get('text_layout_opencart'); ?></option>
                  <option disabled>--------------------------------------</option>
                  <?php foreach ($layouts as $layout) { ?>
                  <option value="<?php echo $layout['value']; ?>" <?php if($proemail_admin_layout == $layout['value']) echo 'selected'; ?>><?php echo $layout['name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-padlat-width"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_bcc_forward_i'); ?>"><?php echo $_language->get('entry_bcc_forward'); ?></span></label>
            <div class="col-sm-10">
              <?php if (empty($phpmailer_installed)) { ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $_language->get('error_phpmailer_required'); ?></div><?php } ?>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-mail-forward"></i></span>
                <input type="text" name="proemail_bcc_forward" value="<?php echo isset($proemail_bcc_forward) ? $proemail_bcc_forward : ''; ?>" placeholder="" id="input-padlat-width" class="form-control" <?php if (empty($phpmailer_installed)) echo 'disabled="disabled"'; ?>/>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab-config-10">
          <table class="form">
            <tr>
              <td>
                <button type="button" class="btn btn-default btn-xs info-btn" data-toggle="modal" data-target="#modal-info" data-info="reset_content"><i class="fa fa-info"></i></button>
              <?php echo $_language->get('entry_reset_content'); ?></td>
              <td>
                <button type="button" class="btn btn-warning" id="restoreContent"><i class="fa fa-repeat"></i> <?php echo $_language->get('btn_reset_content'); ?></button>
              </td>
            </tr>
            <?php if ($store_id !== 0) { ?>
            <tr>
              <td>
                <button type="button" class="btn btn-default btn-xs info-btn" data-toggle="modal" data-target="#modal-info" data-info="copy_content"><i class="fa fa-info"></i></button>
              <?php echo $_language->get('entry_copy_content'); ?></td>
              <td>
                <select name="copy_content_from" id="copyContentFrom" class="form-control" style="max-width: 150px;display: inline;margin-right: 10px;">
                  <?php foreach($stores as $store) { ?>
                    <?php if ($store['store_id'] == $store_id) continue; ?>
                      <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                  <?php } ?>
                </select>
                <button type="button" class="btn btn-warning" id="copyContent"><i class="fa fa-clone"></i> <?php echo $_language->get('btn_copy_content'); ?></button>
              </td>
            </tr>
            <?php } ?>
            <?php /* disabled - is not supported anymore by some mail clients
            <tr>
              <td>
              <?php echo $_language->get('entry_inline_images'); ?></td>
              <td>
                <select name="proemail_theme[inline_images]" class="form-control">
                  <option value=""><?php echo $_language->get('value_inline_images_off'); ?></option>
                   <option value="1" <?php if(!empty($proemail_theme['inline_images'])) echo 'selected="selected"'; ?>><?php echo $_language->get('value_inline_images_on'); ?></option>
                </select>
              </td>
            </tr>
            */ ?>
          </table>
        </div>
      </div>
		</div>
    
		<div class="tab-pane" id="tab-about">
      <div class="row">
        <div class="col-md-4">
          <h3><i class="fa fa-info-circle"></i> Extension details</h3>
          <div class="table-responsive">
            <table class="table"><tbody>
              <tr>
                <td>Module</td>
                <td><?php echo strip_tags($heading_title); ?></td>
              </tr>
              <tr>
                <td>Version</td>
                <td><?php echo $module_version; ?> - <?php echo $module_type; ?></td>
              </tr>
            <?php if (!empty($license_info)) { ?>
              <tr>
                <td colspan="2" style="padding:0;">
                  <h3 style="padding-top:40px;margin-bottom:10px;"><i class="fa fa-check-square"></i> Your License</h3>
                </td>
              </tr>
              <tr>
                <td>License holder</td>
                <td><?php echo $license_info['email']; ?></td>
              </tr>
              <tr>
                <td>Registered domain</td>
                <td><?php echo $license_info['website']; ?></td>
              </tr>
              <tr>
                <td>Support expires on</td>
                <td><?php echo date('F d, Y', strtotime($license_info['support_date'])); ?></td>
              </tr>
              <tr>
                <td>Support status</td>
                <td style="vertical-align:middle">
                  <?php if (time() > strtotime($license_info['support_date'])) { ?>
                    <span class="label label-danger" style="font-size:12px">Expired</span>
                  <?php } else { ?>
                    <span class="label label-success" style="font-size:12px"><i class="fa fa-check"></i> Valid</span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="padding:20px 0;">
                <?php if (time() > strtotime($license_info['support_date'])) { ?>
                  <a target="_blank" href="http://geekodev.com/renewal?module=<?php echo $module; ?>&license=<?php echo $license_info['license']; ?>" class="btn btn-success btn-block" style="font-size:14px;"><i class="fa fa-refresh"></i> Renew my license</a>
                  <?php } else { ?>
                  <a target="_blank" href="http://geekodev.com/login" class="btn btn-grey btn-block" style="font-size:14px;"><i class="fa fa-cog"></i> Manage my license</a>
                <?php } ?>
                </td>
              </tr>
            <?php } else { ?>
              <tr><td colspan="2"></td></tr>
            <?php } ?>
            </tbody></table>
          </div>
        </div>
        <div class="col-md-8">
          <h3><i class="fa fa-external-link"></i> Connect with us</h3>
          <div class="row">
            <div class="col-md-12">
              <div class="well text-center">
                <div style="height:80px"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAACXBIWXMAAAsTAAALEwEAmpwYAAA5z2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS41LWMwMTQgNzkuMTUxNDgxLCAyMDEzLzAzLzEzLTEyOjA5OjE1ICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgICAgICAgICB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIgogICAgICAgICAgICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iCiAgICAgICAgICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgICAgICAgICAgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmV4aWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vZXhpZi8xLjAvIj4KICAgICAgICAgPHhtcDpDcmVhdG9yVG9vbD5BZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpPC94bXA6Q3JlYXRvclRvb2w+CiAgICAgICAgIDx4bXA6Q3JlYXRlRGF0ZT4yMDE2LTA2LTEzVDE4OjMyOjA2KzAyOjAwPC94bXA6Q3JlYXRlRGF0ZT4KICAgICAgICAgPHhtcDpNZXRhZGF0YURhdGU+MjAxNi0wNi0xM1QxODozMjowNiswMjowMDwveG1wOk1ldGFkYXRhRGF0ZT4KICAgICAgICAgPHhtcDpNb2RpZnlEYXRlPjIwMTYtMDYtMTNUMTg6MzI6MDYrMDI6MDA8L3htcDpNb2RpZnlEYXRlPgogICAgICAgICA8eG1wTU06SW5zdGFuY2VJRD54bXAuaWlkOjRlN2U2MGY0LTdiYzYtMDY0Ni04ZTJhLThhNWRhNWRlMjEyYjwveG1wTU06SW5zdGFuY2VJRD4KICAgICAgICAgPHhtcE1NOkRvY3VtZW50SUQ+eG1wLmRpZDowMjgzNzFmNC00MzJlLTY5NDctYjk4ZS1hZGJmNTBiZWViMDk8L3htcE1NOkRvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+eG1wLmRpZDowMjgzNzFmNC00MzJlLTY5NDctYjk4ZS1hZGJmNTBiZWViMDk8L3htcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD4KICAgICAgICAgPHhtcE1NOkhpc3Rvcnk+CiAgICAgICAgICAgIDxyZGY6U2VxPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5jcmVhdGVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6MDI4MzcxZjQtNDMyZS02OTQ3LWI5OGUtYWRiZjUwYmVlYjA5PC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE2LTA2LTEzVDE4OjMyOjA2KzAyOjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpPC9zdEV2dDpzb2Z0d2FyZUFnZW50PgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo0ZTdlNjBmNC03YmM2LTA2NDYtOGUyYS04YTVkYTVkZTIxMmI8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTYtMDYtMTNUMTg6MzI6MDYrMDI6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICA8L3JkZjpTZXE+CiAgICAgICAgIDwveG1wTU06SGlzdG9yeT4KICAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9wbmc8L2RjOmZvcm1hdD4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHRpZmY6T3JpZW50YXRpb24+MTwvdGlmZjpPcmllbnRhdGlvbj4KICAgICAgICAgPHRpZmY6WFJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj43MjAwMDAvMTAwMDA8L3RpZmY6WVJlc29sdXRpb24+CiAgICAgICAgIDx0aWZmOlJlc29sdXRpb25Vbml0PjI8L3RpZmY6UmVzb2x1dGlvblVuaXQ+CiAgICAgICAgIDxleGlmOkNvbG9yU3BhY2U+NjU1MzU8L2V4aWY6Q29sb3JTcGFjZT4KICAgICAgICAgPGV4aWY6UGl4ZWxYRGltZW5zaW9uPjYwPC9leGlmOlBpeGVsWERpbWVuc2lvbj4KICAgICAgICAgPGV4aWY6UGl4ZWxZRGltZW5zaW9uPjYwPC9leGlmOlBpeGVsWURpbWVuc2lvbj4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgCjw/eHBhY2tldCBlbmQ9InciPz75HNQxAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAeeSURBVHja5Jt7cBXVHcc/NyEIhA1gJO2oPAQhsUAplFbrM8cOKBWoLzoWaEdbbXOmlbZOp04ftrVlSuuMWgZ1o44tVTRTUSOotRlHFrFIW0FrgEKFxIRHjGBQcqCBhJj+sb9LN8t97I13N+v4/Yfd88r97u9xfr/fOSR6enpIIpFI0F+wHasA+DKwADgPOANIAAeAfwF/BdZoZXblunYvjnEgbDvWSGA18IUAwzcADwI1WpnOjyrhx4H5OU7bA9wJ2NmIx4qw7VjFwLvAoD4usRO4RSvzbBDCBfQ/5n8IsgATgGdsx3rYdqzh2Qb3q4RtxxoEbAHOztOSTcA8rcyW2EnYdqxC4P48kgUYC7xiO9aloUtYpHUuMA2oECIjgE6gWb5+I7AfKAVulO0nDHQAc7Qya/PutGzHOgu4GfgmUEJ8cBiYrpXZmRfCtmNNAX4FzIuJ80uFN4AZVZXtx5MNA/qourcBP+rL/HwikShk9KkzGVFcQUfnAXa31dHR9a53yFTg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" alt="" style="position:relative;top:6px;"/></div>
                <h3>Made by GeekoDev</h3>
                <p>Developed with love and skill.<br/>Check our other great extensions on our website.</p>
                <a href="https://geekodev.com" target="_blank" class="btn btn-lg btn-grey">Visit our website</a>
              </div>
            </div>
          
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="well text-center">
                <div style="height:80px"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD8AAABGCAYAAAB7ckzWAAAACXBIWXMAAAsTAAALEwEAmpwYAABCt2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS41LWMwMTQgNzkuMTUxNDgxLCAyMDEzLzAzLzEzLTEyOjA5OjE1ICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgICAgICAgICAgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iCiAgICAgICAgICAgIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiCiAgICAgICAgICAgIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIgogICAgICAgICAgICB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICAgICAgICAgICB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyI+CiAgICAgICAgIDx4bXA6Q3JlYXRvclRvb2w+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwveG1wOkNyZWF0b3JUb29sPgogICAgICAgICA8eG1wOkNyZWF0ZURhdGU+MjAxOC0xMi0xNFQxNDoyNjowMyswMTowMDwveG1wOkNyZWF0ZURhdGU+CiAgICAgICAgIDx4bXA6TWV0YWRhdGFEYXRlPjIwMTktMDUtMjFUMTE6NTA6MTMrMDI6MDA8L3htcDpNZXRhZGF0YURhdGU+CiAgICAgICAgIDx4bXA6TW9kaWZ5RGF0ZT4yMDE5LTA1LTIxVDExOjUwOjEzKzAyOjAwPC94bXA6TW9kaWZ5RGF0ZT4KICAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9wbmc8L2RjOmZvcm1hdD4KICAgICAgICAgPHhtcE1NOkluc3RhbmNlSUQ+eG1wLmlpZDphMmU2OTE0Yy01MGNkLTU5NDItYWE5OS1lNDhlYWM5YmU4MDU8L3htcE1NOkluc3RhbmNlSUQ+CiAgICAgICAgIDx4bXBNTTpEb2N1bWVudElEPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDpmY2E3ZDJkYy0wNzNkLTRiNDgtOTc3Zi0zNzJiZWJiMzRmYjk8L3htcE1NOkRvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+eG1wLmRpZDpmZGE2ZjBiMC0xZWM4LTM5NDYtYjZiMy1lZjViNzgwNjNlZjk8L3htcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD4KICAgICAgICAgPHhtcE1NOkhpc3Rvcnk+CiAgICAgICAgICAgIDxyZGY6U2VxPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5jcmVhdGVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6ZmRhNmYwYjAtMWVjOC0zOTQ2LWI2YjMtZWY1Yjc4MDYzZWY5PC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE4LTEyLTE0VDE0OjI2OjAzKzAxOjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5zYXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOjhmNDYyYTFiLTljZWYtNDI0Zi1iMGQ2LTE1OTZhYTJiMGZjYjwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxOC0xMi0xNFQxNToxOTozOSswMTowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpPC9zdEV2dDpzb2Z0d2FyZUFnZW50PgogICAgICAgICAgICAgICAgICA8c3RFdnQ6Y2hhbmdlZD4vPC9zdEV2dDpjaGFuZ2VkPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo4NDY1OTc0ZS1iODJmLWZjNGEtODMyNy01Y2Q1YjQ3ODM1MjY8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTgtMTItMTRUMTU6MjE6NDYrMDE6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE5IChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+ZGVyaXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5jb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZzwvc3RFdnQ6cGFyYW1ldGVycz4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPnNhdmVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6ZjU3NWU5YTYtOGM3YS1iYjQwLWE5ZGUtYThjMjIzODQ4NTU3PC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE4LTEyLTE0VDE1OjIxOjQ2KzAxOjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5zYXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOmEyZTY5MTRjLTUwY2QtNTk0Mi1hYTk5LWU0OGVhYzliZTgwNTwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxOS0wNS0yMVQxMTo1MDoxMyswMjowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOlNlcT4KICAgICAgICAgPC94bXBNTTpIaXN0b3J5PgogICAgICAgICA8eG1wTU06RGVyaXZlZEZyb20gcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICA8c3RSZWY6aW5zdGFuY2VJRD54bXAuaWlkOjg0NjU5NzRlLWI4MmYtZmM0YS04MzI3LTVjZDViNDc4MzUyNjwvc3RSZWY6aW5zdGFuY2VJRD4KICAgICAgICAgICAgPHN0UmVmOmRvY3VtZW50SUQ+eG1wLmRpZDpmZGE2ZjBiMC0xZWM4LTM5NDYtYjZiMy1lZjViNzgwNjNlZjk8L3N0UmVmOmRvY3VtZW50SUQ+CiAgICAgICAgICAgIDxzdFJlZjpvcmlnaW5hbERvY3VtZW50SUQ+eG1wLmRpZDpmZGE2ZjBiMC0xZWM4LTM5NDYtYjZiMy1lZjViNzgwNjNlZjk8L3N0UmVmOm9yaWdpbmFsRG9jdW1lbnRJRD4KICAgICAgICAgPC94bXBNTTpEZXJpdmVkRnJvbT4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHRpZmY6T3JpZW50YXRpb24+MTwvdGlmZjpPcmllbnRhdGlvbj4KICAgICAgICAgPHRpZmY6WFJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj43MjAwMDAvMTAwMDA8L3RpZmY6WVJlc29sdXRpb24+CiAgICAgICAgIDx0aWZmOlJlc29sdXRpb25Vbml0PjI8L3RpZmY6UmVzb2x1dGlvblVuaXQ+CiAgICAgICAgIDxleGlmOkNvbG9yU3BhY2U+NjU1MzU8L2V4aWY6Q29sb3JTcGFjZT4KICAgICAgICAgPGV4aWY6UGl4ZWxYRGltZW5zaW9uPjYzPC9leGlmOlBpeGVsWERpbWVuc2lvbj4KICAgICAgICAgPGV4aWY6UGl4ZWxZRGltZW5zaW9uPjcwPC9leGlmOlBpeGVsWURpbWVuc2lvbj4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAg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" alt=""/></div>
                <h3>Get support</h3>
                <p>You have an issue or need help about module usage?<br/>You have some idea or feature request?</p>
                <a href="https://support.geekodev.com" target="_blank" class="btn btn-lg btn-grey">Open a ticket</a>
              </div>
            </div>
            <div class="col-md-6">
              <div class="well text-center">
                <div style="height:80px"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABLCAYAAADNsPFaAAAACXBIWXMAAAsTAAALEwEAmpwYAABERGlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS41LWMwMTQgNzkuMTUxNDgxLCAyMDEzLzAzLzEzLTEyOjA5OjE1ICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgICAgICAgICAgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIgogICAgICAgICAgICB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIKICAgICAgICAgICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgICAgICAgICAgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiCiAgICAgICAgICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICAgICAgICAgICB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyI+CiAgICAgICAgIDx4bXA6Q3JlYXRvclRvb2w+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwveG1wOkNyZWF0b3JUb29sPgogICAgICAgICA8eG1wOkNyZWF0ZURhdGU+MjAxNi0xMi0yMVQyMTowNSswMTowMDwveG1wOkNyZWF0ZURhdGU+CiAgICAgICAgIDx4bXA6TW9kaWZ5RGF0ZT4yMDE5LTA1LTE4VDIxOjA2OjA4KzAyOjAwPC94bXA6TW9kaWZ5RGF0ZT4KICAgICAgICAgPHhtcDpNZXRhZGF0YURhdGU+MjAxOS0wNS0xOFQyMTowNjowOCswMjowMDwveG1wOk1ldGFkYXRhRGF0ZT4KICAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9wbmc8L2RjOmZvcm1hdD4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHBob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4KICAgICAgICAgICAgPHJkZjpCYWc+CiAgICAgICAgICAgICAgIDxyZGY6bGk+eG1wLmRpZDo2NDI2N2M4Mi0wN2JmLWYwNDMtOTQyMS0yMzk3NzliODZjNTU8L3JkZjpsaT4KICAgICAgICAgICAgPC9yZGY6QmFnPgogICAgICAgICA8L3Bob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4KICAgICAgICAgPHhtcE1NOkluc3RhbmNlSUQ+eG1wLmlpZDpiNmNjZWQzYS1hZDQxLTY4NDMtODhhOC0xNjQyZWY2ZTljMTE8L3htcE1NOkluc3RhbmNlSUQ+CiAgICAgICAgIDx4bXBNTTpEb2N1bWVudElEPnhtcC5kaWQ6NjQyNjdjODItMDdiZi1mMDQzLTk0MjEtMjM5Nzc5Yjg2YzU1PC94bXBNTTpEb2N1bWVudElEPgogICAgICAgICA8eG1wTU06T3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6NjQyNjdjODItMDdiZi1mMDQzLTk0MjEtMjM5Nzc5Yjg2YzU1PC94bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpIaXN0b3J5PgogICAgICAgICAgICA8cmRmOlNlcT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+Y3JlYXRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOjY0MjY3YzgyLTA3YmYtZjA0My05NDIxLTIzOTc3OWI4NmM1NTwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxNi0xMi0yMVQyMTowNSswMTowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGltYWdlL3BuZyB0byBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo3YzgwNzlhZi04Zjc5LTkzNGQtYjkwZi05ZWI1NjYwZTk5YjA8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTYtMTItMjJUMDk6NDg6NTgrMDE6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5zYXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOmQ4YTVkOGQ2LTc4ODctNDk0OC1hZTkzLWU5ZTc4YjI0Yzk2ODwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxOS0wNC0yM1QxNTo0NDo0MiswMjowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPmNvbnZlcnRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5mcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvcG5nPC9zdEV2dDpwYXJhbWV0ZXJzPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+ZGVyaXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6cGFyYW1ldGVycz5jb252ZXJ0ZWQgZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZzwvc3RFdnQ6cGFyYW1ldGVycz4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPnNhdmVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6ZjFhMTdkOTUtODQ1NC1lNTQwLThmMTItMDY4ZDBkNTE5NWRiPC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE5LTA0LTIzVDE1OjQ0OjQyKzAyOjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgKFdpbmRvd3MpPC9zdEV2dDpzb2Z0d2FyZUFnZW50PgogICAgICAgICAgICAgICAgICA8c3RFdnQ6Y2hhbmdlZD4vPC9zdEV2dDpjaGFuZ2VkPgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDpiNmNjZWQzYS1hZDQxLTY4NDMtODhhOC0xNjQyZWY2ZTljMTE8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTktMDUtMThUMjE6MDY6MDgrMDI6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICA8L3JkZjpTZXE+CiAgICAgICAgIDwveG1wTU06SGlzdG9yeT4KICAgICAgICAgPHhtcE1NOkRlcml2ZWRGcm9tIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgPHN0UmVmOmluc3RhbmNlSUQ+eG1wLmlpZDpkOGE1ZDhkNi03ODg3LTQ5NDgtYWU5My1lOWU3OGIyNGM5Njg8L3N0UmVmOmluc3RhbmNlSUQ+CiAgICAgICAgICAgIDxzdFJlZjpkb2N1bWVudElEPnhtcC5kaWQ6NjQyNjdjODItMDdiZi1mMDQzLTk0MjEtMjM5Nzc5Yjg2YzU1PC9zdFJlZjpkb2N1bWVudElEPgogICAgICAgICAgICA8c3RSZWY6b3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6NjQyNjdjODItMDdiZi1mMDQzLTk0MjEtMjM5Nzc5Yjg2YzU1PC9zdFJlZjpvcmlnaW5hbERvY3VtZW50SUQ+CiAgICAgICAgIDwveG1wTU06RGVyaXZlZEZyb20+CiAgICAgICAgIDx0aWZmOk9yaWVudGF0aW9uPjE8L3RpZmY6T3JpZW50YXRpb24+CiAgICAgICAgIDx0aWZmOlhSZXNvbHV0aW9uPjcyMDAwMC8xMDAwMDwvdGlmZjpYUmVzb2x1dGlvbj4KICAgICAgICAgPHRpZmY6WVJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOllSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpSZXNvbHV0aW9uVW5pdD4yPC90aWZmOlJlc29sdXRpb25Vbml0PgogICAgICAgICA8ZXhpZjpDb2xvclNwYWNlPjY1NTM1PC9leGlmOkNvbG9yU3BhY2U+CiAgICAgICAgIDxleGlmOlBpeGVsWERpbWVuc2lvbj43MDwvZXhpZjpQaXhlbFhEaW1lbnNpb24+CiAgICAgICAgIDxleGlmOlBpeGVsWURpbWVuc2lvbj43NTwvZXhpZjpQaXhlbFlEaW1lbnNpb24+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8P3hwYWNrZXQgZW5kPSJ3Ij8+F5l64gAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAAF5ElEQVR42uyba4hUVRzAf/fOax/q7K6PXR8rhj0RMbUtUyos7YMEmkUiERTRh0KLIgqiKCEhEIkkI0wi6ENE0AvrQ7uiBj7SzKSXEkGpWGrqXDVdZ2fu6cP5j3ud5525O87seP5wmLlnzj337O/+z/9xzllLKYWRXLENAgPGgDFgDBgDxoAxYAyYxpLw7B3OWOCEQZGrMeuBGw2KXDAK+A242eC4HMzDwDlgH/CSQTIIJgXMEs1ZDRwEVgLtxivB70APcB64HlgngNYDdwPW1QbGmrU94b2+CdgMjM9qdxjoA7YD3wKHgItXExiATmAjcF+R+44C3wF/imb9Ii7/BHCqUcFk5FngRQHlV04KnGMyLR3gtHyeAdJ5pqWSKd0BhAHX57NCwAXp3xuoWtLHKflMe17WWRnLSak7VwkYgFHAU8CTwOQGmin9npd2QDzyfmCTgCwJxvt2lgDLgLuAcQ1qWg4Ba4C3/YLxykhgHjBfPNm0BgS1wpq5PRHUF7cD14qbnw50A1OkjBO7MdzkYDhkQdrVVsrKsogWYJemdhrYI8UrUaBNAHWLvWoWjWuRz3QZg1UCud2TyijPy4lIfZdcj5TnV7KCkAiHbAjbELUHn5Jh0Z+CpAuWVVGElwSOS9ldg7ceB8aKNs8AHgRu8XnvBqtnV4KoDSNCg2AycBRwZgAupHxrT73LcuBd0d5C8j3QEwZQCtIqFwxAaxgiFpxP6TbDHM5H4qY3FUhz/gYWUWr+KcBVEA1BPAaxEKSUrhvGsq1A/TFgrgSouR6jb3a8YI8L9jpEbG17BkR7hqECrcijLfuBxcBf2dl1SSiZ35tCMDIKLWKT0sNLe+YBb2TVbQHmeKEAWD27Euy+LV72ExbudUi6gT3XlZRpwF4g5qn7FHgg73pMJVDI2B4b4lFojQzapDqVbmBrFpT3C0EBsIKcj5m728FCa0syDSm3LrWmDfgBuMZTtwZ4oeiyQ9CDQ7N3Olr1hIhSutSJRCUume6pex5YW+rGwHlMdlxjWbrUCaDeLCiPAR/4ubFqCZ7l0aAayefAnZ7rJcAXfm8ODCbtXh4Q5oNTA7uzUeISJNJdBOwop4PAYNwsILYXRG20ZTXwuHw/AixEr9KVp/FBjO/MHc6lv92mLjzSSvTWD8DPwL2S/5RvO4OMIiVUQvUBZbkHyhbg1kqhBNKYqdscwrJcYdU+uJsD7JTvnwAPBfa2QbSl2YaQVXMoY9CbgADvDAWUiozv5K0OKRdawhCzB6dTjcRGrw5GgFeA14eq47LBDLg6NmkN1UVuZANvicbsG9I4rLMvwT/3lE4kOzc7WBZcTEM8Al0xvSbTqGKnFIzpc4pP4j4HV0F/GsIWdET976MOVwlnXvpoD5yTC+K09TqWpd2wssTYphSMb9G25aLb2GdD8tqYjl4HF1TI44HSCiY1Q1tEFqYGmz8CLBXv0A98BbwH/BdwbLdL0neDBNh7ZA3lwJUAY3X0JnIqldI7YbaE9SkFE5v1FEq6l4zuGPQK2B15+v0DuB/4qcJxrQWeK/DbM55ArqpWvagkXehqgtExPX089ravABSAqRJwdVUwpleLQEG80NKagbGApNIeqCOmV+i4fPrMKNF3K/BymeMZD7zmo906qnx4u2DnaaU9UGeThpS1ybzMZ/+LJJXyK4t9tpsouVD1wXh3yJVMoc4YNIdzjC1lTJGx6A18vzKpjLbdVfdKrhjczBmtlEBpj+gplMctH/PZ/7/oI2d+5UgZbQ9XVWPSCkZHYUqL9jyTmmFKq55CbuGs+WOf/X9NeUc9vvTZ7ihVPkFhK3TANiKs859MUcX3qD8EfizR91lgVZnjOerT+K6gysG3DRpAKquUSIMU+mB0oXXUQ+iF6OMVjGkV8GaR5z4NfFb1AG/UNwkmNGm3PFDZO3gCfSZ4gtiULegzKGcCjm0+8ChwHTAg2fMG4NcrEvma/9SvMPI1YIwYMAaMAWPAGDAGjAFjwBgwBowBY8SAMWAMmCGV/wcAW96kU8ix6wIAAAAASUVORK5CYII=" alt=""/></div>
                <h3>Feedback</h3>
                <p>If you like this module, please consider to leave a comment on module page, or <a href="https://www.opencart.com/index.php?route=account/rating" target="_blank">a rating</a> from your account.</p>
                <a href="https://www.opencart.com/index.php?route=extension/extension/info&extension_id=<?php echo $OCID; ?>" target="_blank" class="btn btn-lg btn-grey">OC module page</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <style type="text/css">
        #tab-about .well p{font-size:13px; min-height:55px}
        #tab-about table td{font-size:13px; padding: 13px 5px;}
        #tab-about table tr td:first-child{font-weight:bold;}
        #tab-about .btn-grey{background: #818181; color: white; border-color: #6b6b6b;}
        #tab-about .btn-grey:hover{background: #646464; color: white; border-color: #727272;}
      </style>
		</div>
		</div>
      </form>
	  </div>
	  </div>
  </div>
</div>
<?php if (version_compare(VERSION, '2.3', '>=')) { ?>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 
<?php } ?>
<script type="text/javascript"><!--
$('.toggler').toggler();
jQuery('input.switch').iToggle({easing:'swing', speed:200});

jQuery('body').on('click','.nav-language  a',function(e){
  e.preventDefault();
  if (!jQuery(this).parent().hasClass('active')) {
    jQuery('.tab-language > .tab-pane, .nav-language > li').removeClass('active');
    jQuery('.tab-language > .tab-pane'+jQuery(this).attr('href')+', .nav-language > li'+jQuery(this).attr('href')).addClass('active');
  }
  return false;
});

jQuery('select[name=store]').change(function(){
	document.location = 'index.php?<?php echo $mijourl; ?>route=module/pro_email&<?php echo $token; ?>&store_id='+jQuery(this).val();
});

jQuery('.minicolors').minicolors({
  theme: 'bootstrap',
  //changeDelay: 100,
  change: function(hex, opacity) {
      jQuery('form > div.tab-content > div.active .mail-preview iframe').contents().find(jQuery(this).attr('data-target')).css(jQuery(this).attr('data-property'), hex);
    }
});

var $selectize_layouts = jQuery('#selectize_layouts').selectize({
grid: true,
labelField: 'name',
valueField: 'value',
options: <?php echo $json_layouts; ?>,
render: {
  option: function(item, escape) {
    return '<div class="select-box">' +
      '<img src="' + item.img + '" alt=""/><div>' + escape(item.name) +
    '</div></div>';
  }
},
onChange: function(value) {
  reloadPreview();
}
});

var $selectize_colors = jQuery('#selectize_colors').selectize({
grid: true,
labelField: 'name',
valueField: 'value',
create:false,
options: <?php echo $color_schemes; ?>,
render: {
  option: function(item, escape) {
    return '<div class="scheme_option">' +
      '<div class="bg" style="background:' + item.scheme.bg_page + '">' +
        '<div class="head" style="background:' + item.scheme.bg_header + ';color:' + item.scheme.text_head + ';"><?php echo $_language->get('text_header'); ?></div>' +
        '<div class="body" style="background:' + item.scheme.bg_body + ';color:' + item.scheme.text + ';">' + 
          '<?php echo $_language->get('text_body'); ?> - <span style="color:' + item.scheme.link + '"><?php echo $_language->get('text_link'); ?></span>' +
          '<br/><div class="button" style="background:' + item.scheme.btn + ';color:' + item.scheme.btn_text + ';"><?php echo $_language->get('text_button'); ?></div>' +
        '</div>' +
        '<div class="foot" style="background:' + item.scheme.bg_footer + ';color:' + item.scheme.text_foot + '"><?php echo $_language->get('text_foot'); ?></div>' +
      '</div>' +
    '</div>';
  },
  item: function(item, escape) {
    return '<div class="scheme_option">' +
      '<span style="background:' + item.scheme.bg_page + '">&nbsp;</span>' +
      '<span style="background:' + item.scheme.bg_header + ';color:' + item.scheme.text_head + '">&nbsp;</span>' +
      '<span style="background:' + item.scheme.bg_body + ';color:' + item.scheme.text + ';">&nbsp;</span>' +
      '<span style="background:' + item.scheme.btn + ';color:' + item.scheme.btn_text + ';">&nbsp;</span>' +
      '</div>';
  },
},
onChange: function(value) {
  item = JSON.parse(value);
  jQuery.each(item, function(field, value) {
    jQuery('input[name="proemail_color['+field+']"]').val(value);
    jQuery('input[name="proemail_color['+field+']"]').trigger('keyup');
  });
  
  //reloadPreview();
}
});

jQuery('.selectize').selectize();

jQuery('body').on('change', '.changeReload', function () {
  reloadPreview();
});

jQuery('body').on('keyup', '.delayChangeReload', function () {
  delay(function(){
    reloadPreview();
  }, 500);
});

var delay = (function(){
  var timer = 0;
  return function(callback, ms){
  clearTimeout (timer);
  timer = setTimeout(callback, ms);
 };
})();
 
jQuery(window).on('load', function(){
  jQuery('.imgChangeReload').on('load', function () {
    reloadPreview();
  });
});

function reloadPreview() {
  jQuery('.preview-content iframe').fadeOut();
  
  <?php if (!$OC_V2 && !defined('JPATH_MIJOSHOP_OC')) { ?>
  for(var instanceName in CKEDITOR.instances){ CKEDITOR.instances[instanceName].updateElement(); }
  <?php } else { ?>
    jQuery('.summernote').each(function(){
    <?php if (version_compare(VERSION, '2.2', '>=')) { ?>
      jQuery(this).val(jQuery(this).summernote('code'));
    <?php } else { ?>
      jQuery(this).val(jQuery(this).code());
    <?php } ?>
    });
  <?php } ?>
  type = jQuery('form > div.tab-content > div.active .preview-type').val();
  lang = jQuery('form > div.tab-content > div.active .preview-lang').val();
  
  // remove unnecessary data
  var formData = jQuery('#form').serializeArray();
  var formData = $('#form').serializeArray().reduce(function(obj, item) {
    obj[item.name] = item.value;
    return obj;
  }, {});
  
  if (type.includes('order.update')) {
    var status_id = type.split('|')[1];
  }
  
  var newFormData = {};

  jQuery.each(formData, function(k, v) {
    if (type.includes('order.update')) {
      var parts = type.split('|');
      var status_id = parts[1];
      
      if (k.includes('proemail_type[')) delete formData[k];
      else if (k.includes('proemail_status[') && !k.includes('proemail_status['+status_id+']')) delete formData[k];
    } else if (type.includes('custom.')) {
      if (k.includes('proemail_type[')) delete formData[k];
      else if (k.includes('proemail_status[')) delete formData[k];
    } else {
      if (k.includes('proemail_type[') && (!k.includes('proemail_type['+type+']') && !k.includes('proemail_type[common.'))) delete formData[k];
      else if (k.includes('proemail_status[')) delete formData[k];
    }
  });
  
  /*
  jQuery.each(formData, function(k, val) {
    //console.log(val.name + val.value);
    
    if (type.includes('order.update')) {
      var parts = type.split('|');
      var status_id = parts[1];
      //list($type, $status_id) = explode('|', $this->request->get['type']);
      
      foreach($data['proemail_status'] as $k => $v) {
        if ($k != $status_id) {
          unset($data['proemail_status'][$k]);
        }
      }
      
      unset($data['proemail_type']);
    } else if (strpos($this->request->get['type'], 'custom.') === 0) {
      unset($data['proemail_status']);
      unset($data['proemail_type']);
    } else {
      foreach($data['proemail_type'] as $k => $v) {
        if ($k != $this->request->get['type'] && !in_array($k, array('common.top','common.header','common.footer','common.bottom'))) {
          unset($data['proemail_type'][$k]);
        }
      }
      
      unset($data['proemail_status']);
    }
    
    foreach($data as $k => $v) {
      if (!in_array($k, array('proemail_layout', 'proemail_color_scheme', 'proemail_theme', 'proemail_color', 'proemail_type', 'proemail_status', 'proemail_custom'))) {
        unset($data[$k]);
      }
    }
  });
  */
  
  formData['no-image'] = jQuery('input[name="no-image"]').val();
  
	jQuery.ajax({
		url: 'index.php?<?php echo $mijourl; ?>route=module/pro_email/previewParams&type='+type+'&lang='+lang+'&<?php echo $token; ?>',
    type:'POST',
		//data: jQuery(formData).serialize() + '&' + jQuery.param({'no-image': jQuery('input[name="no-image"]').val()}),
		data: formData,
		dataType: 'text',
		success: function(data){
      //jQuery('.mail-preview iframe').contents().find('html').html(data);
      //jQuery(target).closest('.mail-preview').find('iframe').attr('src', 'index.php?route=module/pro_email/preview&<?php echo $token; ?>');
      jQuery('form > div.tab-content > div.active .mail-preview iframe').attr('src', 'index.php?<?php echo $mijourl; ?>route=module/pro_email/preview&type='+type+'&store_id=<?php echo $store_id; ?>&<?php echo $token; ?>');
      //jQuery('.preview-refresh i').removeClass('fa-spin');
		}
	});
}

jQuery('#restoreContent').on('click', function (e) {
  e.preventDefault();
  if(confirm('<?php echo $_language->get('text_confirm_restore_content'); ?>')) {
    document.location = 'index.php?<?php echo $mijourl; ?>route=module/pro_email/restore_content&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>';
  }
});

jQuery('#copyContent').on('click', function (e) {
  e.preventDefault();
  let current_store_id = <?php echo $store_id; ?>;
  if(confirm('<?php echo $_language->get('text_confirm_copy_content'); ?>')) {
    let source_store_id = $('#copyContentFrom').val();
    document.location = 'index.php?<?php echo $mijourl; ?>route=module/pro_email/copy_content&<?php echo $token; ?>&source_store_id='+source_store_id+'&to_store_id='+current_store_id;
  }
});

jQuery('#save_scheme').on('click', function (e) {
  e.preventDefault();

  jQuery.ajax({
		url: 'index.php?<?php echo $mijourl; ?>route=module/pro_email/saveColorScheme&<?php echo $token; ?>',
    type:'POST',
		data: jQuery('#form').serialize(),
		dataType: 'text',
		success: function(data){
      alert(data);
		}
	});
});

jQuery('.mail-preview iframe').on('load', function () {
  jQuery('.preview-content iframe').fadeIn();
});

jQuery('.contentTabs li').on('click', function() {
  jQuery('.contentPreviewDisplay').hide();
});

jQuery('.setContentPreview').on('shown.bs.tab', function() {
  if(jQuery('#tab-2 > div.tab-content > div.active li.active a[data-type]').length) {
    jQuery('form > div.tab-content > div.active .preview-type').val(jQuery('#tab-2 > div.tab-content > div.active li.active a[data-type]').attr('data-type'));
    jQuery('.contentPreviewDisplay').show();
    reloadPreview();
  }
});

jQuery('.tabChangeReload').on('shown.bs.tab', function() {
  reloadPreview();
});

jQuery('.menu-types, .menu-statuses, .menu-custom').on('click', 'a', function() {
  jQuery('form > div.tab-content > div.active .preview-type').val(jQuery(this).attr('data-type'));
  reloadPreview();
});

jQuery('body').on('click', 'a[data-lang]', function() {
  jQuery('form > div.tab-content > div.active .preview-lang').val(jQuery(this).attr('data-lang'));
  reloadPreview();
});

jQuery('body').on('change', '.preview-type,.preview-lang', function() {
  reloadPreview();
});

jQuery('body').on('click', '.preview-refresh', function() {
  reloadPreview();
});

jQuery('body').on('click', '.preview-image', function() {
  if (jQuery('input[name="no-image"]').val() == 0) {
    val = '1';
    jQuery(this).css('color', '#aaa');
  } else {
    val = '0';
    jQuery(this).css('color', '#555');
  }
  
  jQuery('input[name="no-image"]').val(val);
  reloadPreview();
});

jQuery('body').on('click', '.preview-size .btn', function() {
  jQuery('.preview-size .btn').removeClass('active');
  jQuery(this).addClass('active');
  jQuery('.mail-preview iframe').animate({width: jQuery(this).attr('data-size')});
});
--></script>
<?php if (!$OC_V2 && !defined('JPATH_MIJOSHOP_OC')) { ?>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<?php } ?>
<!-- order status -->
<?php if (!defined('JPATH_MIJOSHOP_OC')) { ?>
<script type="text/javascript"><!--
jQuery('.editorInit').appear(function() {
var editor = jQuery(this).attr('id');
  <?php if ($OC_V2) { ?>
    <?php if (defined('JOOCART_SITE_URL') && version_compare(VERSION, '3', '<')) { ?>
      //jQuery('#'+editor).summernote({});
      tinyMCE.init({
        selector: '#'+editor,
        plugins : "table link image code hr charmap autolink lists importcss print preview anchor searchreplace visualblocks fullscreen insertdatetime media contextmenu",
        toolbar: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect | bullist numlist | outdent indent | undo redo | link unlink anchor image insertdatetime media hr table | subscript superscript charmap | print preview searchreplace visualblocks code",
        removed_menuitems: "newdocument",
        content_css : "<?php echo JOOCART_SITE_URL; ?>templates/system/css/editor.css",
        file_browser_callback : function (field_name, url, type, win) {
              ocFileManager(field_name, url, type, win);
          },
      });
    <?php } else { ?>
      jQuery('#'+editor).addClass('summernote');
      
      if (editor.search('proemail_type-common') === 0) {
        var summerHeight = 150;
      } else {
        var summerHeight = 300;
      }
      
      <?php if (version_compare(VERSION, '2.2', '>=')) { ?>
        jQuery('#'+editor).summernote({
          disableDragAndDrop: true,
          height: summerHeight,
          emptyPara: '',
          toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'image', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
          ],
          buttons: {
              image: function() {
              var ui = $.summernote.ui;

              // create button
              var button = ui.button({
                contents: '<i class="fa fa-image" />',
                tooltip: $.summernote.lang[$.summernote.options.lang].image.image,
                click: function () {
                  $('#modal-image').remove();
                
                  $.ajax({
                    url: 'index.php?route=common/filemanager&<?php echo $token; ?>',
                    dataType: 'html',
                    beforeSend: function() {
                      $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                      $('#button-image').prop('disabled', true);
                    },
                    complete: function() {
                      $('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
                      $('#button-image').prop('disabled', false);
                    },
                    success: function(html) {
                      $('body').append('<div id="modal-image" class="modal">' + html + '</div>');
                      
                      $('#modal-image').modal('show');
                      
                      $('#modal-image').delegate('a.thumbnail', 'click', function(e) {
                        e.preventDefault();
                        
                        $('#'+editor).summernote('insertImage', $(this).attr('href'));
                        
                        $('#modal-image').modal('hide');
                      });
                    }
                  });						
                }
              });
            
              return button.render();
            }
          }
        });
      <?php } else { /* OC 2.0 - 2.1 */ ?>
        jQuery('#'+editor).summernote({
          height: summerHeight
        });
        
        // Override summernotes image manager
        $('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');
      <?php } ?>
        
    <?php } ?>
  
  <?php } else { ?>
    CKEDITOR.replace(editor, {
      height:'300px',
      filebrowserBrowseUrl: 'index.php?<?php echo $mijourl; ?>route=common/filemanager&<?php echo $token; ?>',
      filebrowserImageBrowseUrl: 'index.php?<?php echo $mijourl; ?>route=common/filemanager&<?php echo $token; ?>',
      filebrowserFlashBrowseUrl: 'index.php?<?php echo $mijourl; ?>route=common/filemanager&<?php echo $token; ?>',
      filebrowserUploadUrl: 'index.php?<?php echo $mijourl; ?>route=common/filemanager&<?php echo $token; ?>',
      filebrowserImageUploadUrl: 'index.php?<?php echo $mijourl; ?>route=common/filemanager&<?php echo $token; ?>',
      filebrowserFlashUploadUrl: 'index.php?<?php echo $mijourl; ?>route=common/filemanager&<?php echo $token; ?>'
    });
  <?php } ?>
});
//--></script> 
<?php } ?>

<script type="text/javascript"><!--
<?php /*
var feed_row = <?php echo count($proemail_feeds)+1; ?>;
function addShipping() {	
	html  = '<div id="tab-feed-' + feed_row + '" class="tab-pane">';
	html += '  <table class="form">';
	html += '    <tr>';
	html += '      <td><?php echo $_language->get('entry_feed_title'); ?></td>';
	html += '      <td><input type="text" name="proemail_feeds[' + feed_row + '][title]" value="" class="form-control"/></td>';
	html += '    </tr>';
	html += '  </table>'; 
	html += '</div>';
	
	jQuery('#tab-0 > .tab-content').append(html);
	
	jQuery('#feed-add').before('<li><a href="#tab-feed-' + feed_row + '" id="shipping-' + feed_row + '" data-toggle="pill"><?php echo $_language->get('text_add_feed'); ?> ' + feed_row + '&nbsp;<i class="fa fa-minus-circle" onclick="jQuery(\'#proemail_feeds a:first\').trigger(\'click\'); jQuery(\'#shipping-' + feed_row + '\').remove(); jQuery(\'#tab-feed-' + feed_row + '\').remove(); return false;"></i></a></li>');
	
	jQuery('#shipping-' + feed_row).trigger('click');
	
	feed_row++;
}
*/ ?>
//--></script> 
<script type="text/javascript"><!--
jQuery('body').on('click', '.info-btn', function() {
  jQuery('#modal-info .modalContent').html('<div style="text-align:center"><img src="view/pro_email/img/loader.gif" alt=""/></div>');
  jQuery('#modal-info .modalContent').load('index.php?<?php echo $mijourl; ?>route=module/pro_email/modal_info&<?php echo $token; ?>', {'info': jQuery(this).attr('data-info')});
});
jQuery('body').on('click', '.modalContent', function(e) {
  if (jQuery(e.target).attr('class') == 'modalContent') {
    jQuery('#modal-info').modal('hide');
  }
});
//--></script> 
<!-- /custom blocks -->
<?php if(!$OC_V2) { ?>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	jQuery('#dialog').remove();
	
	jQuery('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?<?php echo $mijourl; ?>route=common/filemanager&<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	jQuery('#dialog').dialog({
		title: '<?php echo htmlspecialchars($_language->get('text_image_manager'), ENT_QUOTES); ?>',
		close: function (event, ui) {
			if (jQuery('#' + field).attr('value')) {
				jQuery.ajax({
					url: 'index.php?<?php echo $mijourl; ?>route=common/filemanager/image&<?php echo $token; ?>&image=' + encodeURIComponent(jQuery('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						jQuery('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
            reloadPreview();
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
<?php if (defined('JPATH_MIJOSHOP_OC') && !$OC_V2) { ?>
jQuery('select').css("max-height", "");
<?php } ?>
//--></script> 
<?php } ?>
<script type="text/javascript"><!--
$('.button-upload').on('click', function() {
  var file_input = $(this).parent().parent().find('input.fileinput');
  
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
  
	$('#form-upload input[name=\'file\']').trigger('click');
	
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);		
			
			$.ajax({
				url: 'index.php?route=module/pro_email/fileupload&<?php echo $token; ?>',
				type: 'post',		
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,		
				beforeSend: function() {
					$('#button-upload').button('loading');
				},
				complete: function() {
					$('#button-upload').button('reset');
				},	
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}
								
					if (json['success']) {
						alert(json['success']);
						
						//$('input[name=\'filename\']').attr('value', json['filename']);
						file_input.attr('value', json['filename']);
            $('#form-upload').remove();
					}
				},			
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

// featured autocomplete
<?php if (version_compare(VERSION, '2', '>=')) { ?>
$('input[name=\'prod_adv_autocomp\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(item) {
		$('input[name=\'prod_adv_autocomp\']').val('');
		
		$('#featured-product' + item['value']).remove();
		
		$('#featured-product').append('<div id="featured-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="proemail_mod_product[featured][product][]" value="' + item['value'] + '" /></div>');
	}
});
<?php } else { ?>
$('input[name=\'prod_adv_autocomp\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
    $('input[name=\'prod_adv_autocomp\']').val('');
		
		$('#featured-product' + ui.item.value).remove();
		
		$('#featured-product').append('<div id="featured-product' + ui.item.value + '"><i class="fa fa-minus-circle"></i> ' + ui.item.label + '<input type="hidden" name="proemail_mod_product[featured][product][]" value="' + ui.item.value + '" /></div>');
    
		return false;
	}
});
<?php } ?>
$('#featured-product').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script></div> 
<?php if (defined('JPATH_MIJOSHOP_OC') && !$OC_V2) { /*fix for old mijoshop*/ ?>
<style>
input.form-control{display: block; width: 100%!important; height: 34px; padding: 6px 12px; font-size: 14px; line-height: 1.42857; color: #555; background-color: #FFF; background-image: none; border: 1px solid #CCC; border-radius: 4px; box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset; transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;}
.form-inline input.form-control{width: auto!important;}
.form-horizontal .control-label { float: left; width: 160px; padding-top: 5px; text-align: right;}
select{height: 34px; font-size: 14px; line-height: 1.42857; padding: 6px 12px!important; max-height: 34px!important; }
select:-moz-focusring {color:transparent; text-shadow:0 0 0 #000;}
.breadcrumb_oc li{float:left; margin-right:20px; list-style-type:none;}
.breadcrumb_oc{padding-bottom:20px;}
</style>
<?php } ?>
<?php if (defined('JOOCART_SITE_URL')) { ?>
<style>
.modal-body{max-height:600px; overflow:auto;}
input.minicolors{padding-bottom:8px;}
#stores select{height:24px;}
</style>
<?php } ?>
<?php if (version_compare(VERSION, '2', '<')) { ?>
<style>
.cke *{box-sizing:content-box!important;}
</style>
<?php } ?>
<?php echo $footer; ?>