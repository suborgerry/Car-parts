<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-pp-express" data-toggle="tooltip" title="<?php echo $language->get('button_save'); ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $language->get('button_cancel'); ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $language->get('heading_title'); ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ( isset( $error_opencartpmg_warning ) ) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_opencartpmg_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $language->get('text_edit'); ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-opencartpmg" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $language->get('entry_status'); ?></label>
            <div class="col-sm-10">
              <select name="opencartpmg_status" id="input-status" class="form-control">
                <?php $enabled_selected = '';
                      $disabled_selected = '';
                      if ($opencartpmg_status) {
                        $enabled_selected = 'selected';
                      } else {
                        $disabled_selected = 'selected';
                      }
                ?>
                <option value="1" <?php echo $enabled_selected; ?> ><?php echo $language->get('text_enabled'); ?></option>
                <option value="0" <?php echo $disabled_selected; ?> ><?php echo $language->get('text_disabled'); ?></option>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-public_key">
              <span data-toggle="tooltip" title="<?php echo $language->get('entry_public_key_help'); ?>">
                <?php echo $language->get('entry_public_key'); ?>
              </span>
            </label>
            <div class="col-sm-10">
              <input type="text" name="opencartpmg_public_key" value="<?php echo $opencartpmg_public_key; ?>" placeholder="<?php echo $language->get('entry_public_key') ?>" id="input-public_key" class="form-control" />
              <?php if ( isset( $error_opencartpmg_public_key ) ) { ?>
                <div class="text-danger"><?php echo $error_opencartpmg_public_key; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-private_key">
              <span data-toggle="tooltip" title="<?php echo $language->get('entry_private_key_help'); ?>">
                <?php echo $language->get('entry_private_key'); ?>
              </span>
            </label>
            <div class="col-sm-10">
              <input type="text" name="opencartpmg_private_key" value="<?php echo $opencartpmg_private_key; ?>" placeholder="<?php echo $language->get('entry_private_key'); ?>" id="input-private_key" class="form-control" />
              <?php if ( isset( $error_opencartpmg_private_key ) ) { ?>
              <div class="text-danger"><?php echo $error_opencartpmg_private_key; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-iframe"><?php echo $language->get('entry_iframe'); ?></label>
            <div class="col-sm-10">
              <select name="opencartpmg_iframe" id="input-iframe" class="form-control">
                <?php $enabled_selected = '';
                      $disabled_selected = '';
                      if ($opencartpmg_iframe) {
                        $enabled_selected = 'selected';
                      } else {
                        $disabled_selected = 'selected';
                      }
                ?>
                <option value="1" <?php echo $enabled_selected; ?> ><?php echo $language->get('text_enabled'); ?></option>
                <option value="0" <?php echo $disabled_selected; ?> ><?php echo $language->get('text_disabled'); ?></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $language->get('entry_order_status_pending_text'); ?></label>
            <div class="col-sm-10">
              <select name="opencartpmg_pending_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $opencartpmg_pending_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $language->get('entry_order_status_completed_text'); ?></label>
            <div class="col-sm-10">
              <select name="opencartpmg_completed_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $opencartpmg_completed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-failed-status"><?php echo $language->get('entry_order_status_failed_text'); ?></label>
            <div class="col-sm-10">
              <select name="opencartpmg_failed_status_id" id="input-order-failed-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $opencartpmg_failed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $language->get('entry_sort_order'); ?></label>
            <div class="col-sm-10">
              <input type="text" name="opencartpmg_sort_order" value="<?php echo $opencartpmg_sort_order; ?>" placeholder="<?php echo $language->get('entry_sort_order'); ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
      </div>
    </div>
    <?php echo $footer; ?>
