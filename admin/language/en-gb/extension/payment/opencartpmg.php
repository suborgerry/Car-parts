<?php
require_once( DIR_APPLICATION.'../system/library/opencartpmg/OpenCartPMG.php');
\OpenCardPMG\OpenCartPMG::init_core();

// Heading
$_['heading_title'] = \OpenCardPMG\Helper\CoreHelper::get_module_name();
$_['text_edit'] = 'Edit configuration';

// Text
$_['text_payment'] = 'Payment';
$_['text_opencartpmg'] = '<img src="view/image/payment/logo.png" 
                            alt="'.\OpenCardPMG\Helper\CoreHelper::get_module_name().'" 
                            title="'.\OpenCardPMG\Helper\CoreHelper::get_module_name().'" 
                            style="border: 1px solid #EEEEEE; max-height: 25px;">';
$_['text_success'] = 'Settings updated';
$_['text_pay'] = \OpenCardPMG\Helper\CoreHelper::get_module_short_info();
$_['text_card'] = 'Credit Card';

// Entry
$_['entry_public_key'] = 'Public key';
$_['entry_private_key'] = 'Secret key';
$_['entry_iframe'] = 'Use iframe';
$_['entry_public_key_help'] = 'Contact your gateway manager to obtain it';
$_['entry_private_key_help'] = $_['entry_public_key_help'];

$_['entry_order_status_pending_text'] = 'Pending Status';
$_['entry_order_status_completed_text'] = 'Completed Status';
$_['entry_order_status_failed_text'] = 'Failed Status';
$_['entry_order_status_failed'] = 'Order Status Failed';

$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Ordering';
$_['entry_geo_zone'] = 'Geo Zone';

// Error
$_['error_public_key'] = 'Public key is empty!';
$_['error_private_key'] = 'Private key is empty!';
$_['error_permission'] = 'Warning: You do not have permission to modify the payment module!';
?>
