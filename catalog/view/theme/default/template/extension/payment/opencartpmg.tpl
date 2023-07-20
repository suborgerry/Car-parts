
<?php if( isset( $src ) ){ ?>
  <form action="<?=$action;?>" method="get">
    <fieldset id="payment">
      <iframe src="<?=$src;?>" height="500" frameborder="0" style="width:100%"></iframe>
    </fieldset>
  </form>
<?php } ?>

<?php if( isset( $redirect ) ){ ?>
  <form action="<?=$action;?>" method="get">
    <div class="buttons">
      <div class="pull-right">
        <input type="submit" id="payment" onclick="window.location='<?=$action;?>';return false;" value="<?=$language->get('button_confirm');?>" class="btn btn-primary button" />
      </div>
    </div>
  </form>
<?php } ?>


<?php if( isset( $url ) && !empty($url) ) { ?>
  <script type="text/javascript">
    var url = "<?=$url;?>";

    if (window.top) {
      window.top.location = url;
    } else {
      window.location = url;
    }
  </script>
<?php } ?>