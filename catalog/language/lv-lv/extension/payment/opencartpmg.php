<?php
require_once( DIR_APPLICATION.'../system/library/opencartpmg/OpenCartPMG.php');
\OpenCardPMG\OpenCartPMG::init_core();

$_['text_title'] = \OpenCardPMG\Helper\CoreHelper::get_module_short_info('lv');
$_['opencartpmg_order_status_failed'] = 'KĻŪDA: maksājums tika saņemts, taču pasūtījuma pārbaude neizdevās';
$_['opencartpmg_order_status_success'] = 'Maksājums veiksmīgs';
$_['opencartpmg_order_status_pending'] = 'Gaida samaksu';
$_['opencartpmg_order_status_invoice_sent_text'] = 'Pieprasīts rēķins uz e-pastu';
$_['opencartpmg_invoice_for_payment'] = 'Maksājuma rēķins #';
?>
