<?php
require_once( DIR_APPLICATION.'../system/library/opencartpmg/OpenCartPMG.php');
\OpenCardPMG\OpenCartPMG::init_core();

$_['text_title'] = \OpenCardPMG\Helper\CoreHelper::get_module_short_info('ru');

$_['opencartpmg_order_status_failed'] = 'ОШИБКА: платеж обработки платежа. Возможно недостаточно средств либо не неправильные реквизиты карты.';
$_['opencartpmg_order_status_success'] = 'Заказ оплачен';
$_['opencartpmg_order_status_pending'] = 'Ожидается платёж';
$_['opencartpmg_order_status_invoice_sent_text'] = 'Счёт запрошен на e-mail';
$_['opencartpmg_invoice_for_payment'] = 'Счет на оплату #';
?>
