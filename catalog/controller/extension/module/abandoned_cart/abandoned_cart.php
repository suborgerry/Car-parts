<?php
class ControllerExtensionModuleAbandonedCart extends Controller
{
    private $error = array();

    public function index()
    {
        // Установите заголовок административной панели
        $this->document->setTitle('Настройки напоминаний об оставленной корзине');

        // Загрузите языковой файл модуля
        $this->load->language('extension/module/abandoned_cart');

        // Проверьте, является ли текущий пользователь администратором
        if (!$this->user->hasPermission('modify', 'extension/module/abandoned_cart')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        // Если форма отправлена, сохраните настройки
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->load->model('setting/setting');
            $this->model_setting_setting->editSetting('module_abandoned_cart', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/extension', 'type=module', true));
        }

        // Загрузите значения настроек модуля
        $data['module_abandoned_cart_status'] = $this->config->get('module_abandoned_cart_status');
        $data['module_abandoned_cart_reminder_1'] = $this->config->get('module_abandoned_cart_reminder_1');
        $data['module_abandoned_cart_reminder_2'] = $this->config->get('module_abandoned_cart_reminder_2');

        // Вывод сообщений об ошибках и успешных операциях
        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $data['success'] = isset($this->session->data['success']) ? $this->session->data['success'] : '';

        // Определение Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/abandoned_cart', 'user_token=' . $this->session->data['user_token'], true)
        );

        // Установите ссылку "Сохранить"
        $data['action'] = $this->url->link('extension/module/abandoned_cart', 'user_token=' . $this->session->data['user_token'], true);

        // Установите ссылку "Отмена"
        $data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        // Загрузите шаблон
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // Отображение шаблона
        $this->response->setOutput($this->load->view('extension/module/abandoned_cart', $data));
    }

    protected function validate()
    {
        // Проверьте, имеет ли текущий пользователь право на изменение настроек модуля
        if (!$this->user->hasPermission('modify', 'extension/module/abandoned_cart')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
