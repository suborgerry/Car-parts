<?php
require_once( DIR_APPLICATION.'../system/library/opencartpmg/OpenCartPMG.php');
\OpenCardPMG\OpenCartPMG::init_core();

// Heading
$_['heading_title'] = \OpenCardPMG\Helper\CoreHelper::get_module_name();
$_['text_edit'] = 'Rediģēt konfigurāciju';

// Text
$_['text_payment'] = 'Maksājums';
$_['text_opencartpmg'] = '<img src="view/image/payment/logo.png" 
                                alt="'.\OpenCardPMG\Helper\CoreHelper::get_module_name().'" 
                                title="'.\OpenCardPMG\Helper\CoreHelper::get_module_name().'" 
                                style="border: 1px solid #EEEEEE; max-height: 25px;">';
$_['text_success'] = 'Iestatījumi ir atjaunināti';
$_['text_pay'] = \OpenCardPMG\Helper\CoreHelper::get_module_short_info();
$_['text_card'] = 'Kredītkarte';

// Entry
$_['entry_public_key'] = 'Publiskā atslēga';
$_['entry_private_key'] = 'Slepenā atslēga';
$_['entry_iframe'] = 'Izmantojiet iframe';
$_['entry_public_key_help'] = 'Sazinieties ar jūsu klienta pārvaldnieku lai to dabūtu';
$_['entry_private_key_help'] = $_['entry_public_key_help'];

$_['entry_order_status_pending_text'] = 'Gaida statusu';
$_['entry_order_status_completed_text'] = 'Pabeigts statuss';
$_['entry_order_status_failed_text'] = 'Neizdevās statuss';
$_['entry_order_status_failed'] = 'Pasūtījuma statuss neizdevās';

$_['entry_status'] = 'Statuss';
$_['entry_sort_order'] = 'Kārtošanas kārtība';
$_['entry_geo_zone'] = 'Ģeogrāfiskā zona';

// Error
$_['error_public_key'] = 'Publiskā atslēga ir tukša!';
$_['error_private_key'] = 'Privātā atslēga ir tukša!';
$_['error_permission'] = 'Brīdinājums: Jums nav atļaujas modificēt maksājumu moduli!';
?>
