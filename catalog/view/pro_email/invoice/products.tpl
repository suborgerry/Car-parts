<?php
/******** CUSTOMIZATIONS HERE ********/
 
  # Set displayed columns here
  # Available columns: product_id, image, product, sku, upc, ean, mpn, isbn, model, location, description, weight, quantity, price, price_tax, tax, tax_total, tax_rate
  $columns = array('image', 'product', 'quantity');

  # Set available product details here (appears below the product)
  # Available values: quantity, model, option, reward
  $product_details = array('model', 'option');
 
/******** END CUSTOMIZATIONS ********/
?>
<style>
.invoice {
	border-collapse: collapse;
	width: 100%;
	margin: 15px 0;
}
.invoice td {
  line-height:16px;
  font-size:12px;
	padding: 7px;
	border: 1px solid <?php echo !empty($color['tborder']) ? $color['tborder'] : '#ddd'; ?>;
}
.invoice thead td {
	background-color: <?php echo !empty($color['thead']) ? $color['thead'] : '#efefef'; ?>;
	color: <?php echo !empty($color['theadtxt']) ? $color['theadtxt'] : '#444'; ?>;
	font-weight: bold;
}
.invoice tbody td {
	vertical-align: top;
}
</style>
<table class="invoice">
  <thead>
    <tr>
  <?php 
  $mobileColumns = 0;
  foreach ($columns as $col) { ?>
    <td <?php if(!in_array($col, array('image', 'product', 'price','total'))){ ?>class="hide_mobile"<?php } else {$mobileColumns++;} ?>><?php echo $language->get('column_'.$col); ?></td>
  <?php } ?>
      <td width="70"><?php if ($config->get('pdf_invoice_total_tax')) { echo $language->get('column_total_tax'); } else { echo $language->get('column_total'); } ?></td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $product) { ?>
    <tr>
  <?php foreach ($columns as $col) { ?>
    <td class="<?php if(in_array($col, array('weight', 'quantity', 'price', 'tax', 'tax_rate', 'tax_total', 'price_tax', 'total'))){ ?>right <?php } ?><?php if(!in_array($col, array('image', 'product', 'price','total'))){ ?>hide_mobile<?php } ?>" <?php if(in_array($col, array('image', 'quantity'))){ ?>style="width:1px"<?php } ?>>
      <?php if($col == 'product'){ ?>
        <?php if(in_array('quantity', $product_details)){echo $product['quantity'].' x ';} ?><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) {
         if (!isset($option['type']) || !in_array($option['type'], $product_details)) continue;
        ?>
        <br />
        &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?>
      <?php }elseif($col == 'image'){ ?>
        <a href="<?php echo $product['href'] ?>" target="_blank"><img src="<?php echo $product['image'] ?>" alt="" style="max-width:none"/></a>
      <?php }else{ ?>
        <?php echo isset($product[$col]) ? $product[$col] : ''; ?>
      <?php } ?>
    </td>
  <?php } ?>
      <td class="right"><?php echo $product['total_tax']; ?></td>
    </tr>
    <?php } ?>
    <?php if(isset($vouchers)) foreach ($vouchers as $voucher) { ?>
    <tr>
  <?php foreach ($columns as $col) { ?>
    <?php if($col == 'product'){ ?>
      <td><?php echo $voucher['description']; ?></td>
    <?php }elseif($col == 'quantity'){ ?>
      <td class="right">1</td>
    <?php }elseif($col == 'price'){ ?>
      <td class="right"><?php echo $voucher['amount']; ?></td>
    <?php }else{ ?>
      <td></td>
    <?php } ?>
  <?php } ?>
      <td class="right"><?php echo $voucher['amount']; ?></td>
    </tr>
    <?php } ?>
      <?php /*foreach ($totals as $total) { ?>
      <tr>
        <td colspan="<?php echo $mobileColumns; ?>" class="right show_mobile_td"><b><?php echo $total['title']; ?>:</b></td>
        <td colspan="<?php echo count($columns); ?>" class="right hide_mobile"><b><?php echo $total['title']; ?>:</b></td>
        <td class="right"><?php echo $total['text']; ?></td>
      </tr>
      <?php }*/ ?>
    </tbody>
  </table>
  <table class="invoice">
    <thead>
      <tr>
        <td colspan="2" class="right"><?php echo $language->get('column_total'); ?></td>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($totals as $total) { ?>
    <tr>
        <td class="right"><b><?php echo $total['title']; ?>:</b></td>
      <td class="right"><?php echo $total['text']; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>