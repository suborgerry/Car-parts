<?php
require_once( DIR_APPLICATION.'../system/library/opencartpmg/OpenCartPMG.php');
\OpenCardPMG\OpenCartPMG::init_core();

// Heading
$_['heading_title'] = \OpenCardPMG\Helper\CoreHelper::get_module_name();
$_['text_edit'] = 'Изменить настройки';

// Text
$_['text_payment'] = 'Платеж';
$_['text_opencartpmg'] = '<img src="view/image/payment/logo.png" 
                            alt="'.\OpenCardPMG\Helper\CoreHelper::get_module_name().'" 
                            title="'.\OpenCardPMG\Helper\CoreHelper::get_module_name().'" 
                            style="border: 1px solid #EEEEEE; max-height: 25px;">';
$_['text_success'] = 'Вы успешно изменили настройки модуля';
$_['text_pay'] = \OpenCardPMG\Helper\CoreHelper::get_module_short_info();
$_['text_card'] = 'Кредитная карта';

// Entry
$_['entry_public_key'] = 'Открытый ключ';
$_['entry_private_key'] = 'Секретный ключ';
$_['entry_iframe'] = 'Использовать iframe';
$_['entry_public_key_help'] = 'Обратитесь к менеджеру вашего платежного шлюза, чтобы получить его';
$_['entry_private_key_help'] = $_['entry_public_key_help'];

$_['entry_order_status_pending_text'] = 'Статус “В ожидании”';
$_['entry_order_status_completed_text'] = 'Статус “Завершено”';
$_['entry_order_status_failed_text'] = 'Статус “Ошибка”';
$_['entry_order_status_failed'] = 'Статус заказа “Ошибка”';

$_['entry_status'] = 'Статус';
$_['entry_sort_order'] = 'Порядок сортировки';
$_['entry_geo_zone'] = 'Географическая зона';

// Error
$_['error_public_key'] = 'Публичный ключ обязателен!';
$_['error_private_key'] = 'Приватный ключ обязателен!';
$_['error_permission'] = 'Внимание: У вас нет прав для изменения настроек модуля оплаты!';
?>
