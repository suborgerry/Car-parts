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

<?php if ($order_comment) { ?>
<table class="invoice">
  <thead><tr><td><?php echo $language->get('text_instruction'); ?></td></tr></thead>
  <tbody><tr><td><?php echo $order_comment; ?></td></tr></tbody>
</table>
<?php } ?>
<?php if ($comment) { ?>
<table class="invoice">
  <thead><tr><td><?php echo $language->get('text_customer_comment'); ?></td></tr></thead>
  <tbody><tr><td><?php echo $comment; ?></td></tr></tbody>
</table>
<?php } ?>