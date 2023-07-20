<?php
class ControllerProductProduct extends Controller
{
    public function notify()
    {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $product_id = $this->request->post['product_id'];
            $email = $this->request->post['email'];

            // Проверяем, есть ли уже запись об этом пользователе и продукте
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_notification WHERE product_id = '" . (int) $product_id . "' AND email = '" . $this->db->escape($email) . "'");

            if ($query->num_rows == 0) {
                // Добавляем новую запись в таблицу уведомлений
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_notification SET product_id = '" . (int) $product_id . "', email ='" . $this->db->escape($email) . "'");

                // Отправляем подтверждение пользователю
                $this->response->setOutput('Вы будете уведомлены, когда товар появится в наличии.');
            } else {
                // Пользователь уже подписан на уведомления
                $this->response->setOutput('Вы уже подписаны на уведомления о наличии товара.');
            }
        }
    }
}