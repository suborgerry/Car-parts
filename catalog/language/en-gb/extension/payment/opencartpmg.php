<?php
require_once( DIR_APPLICATION.'../system/library/opencartpmg/OpenCartPMG.php');
\OpenCardPMG\OpenCartPMG::init_core();

$_['text_title'] = \OpenCardPMG\Helper\CoreHelper::get_module_short_info();
$_['opencartpmg_order_status_failed'] = 'Payment failed. Wrong payment cart information';
$_['opencartpmg_order_status_success'] = 'Payment successful';
$_['opencartpmg_order_status_pending'] = 'Awaiting payment';
$_['opencartpmg_order_status_invoice_sent_text'] = 'Requested invoice to email';
$_['opencartpmg_invoice_for_payment'] = 'Invoice for payment #';
?>
