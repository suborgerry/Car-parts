<?php
class ControllerProductCheckMail extends Controller
{
    public function mailCheckAvailability()
    {
        // Получаем значения столбца productid из вашей таблицы базы данных
        $productIds = array();
        $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_notification");
        if ($query->num_rows > 0) {
            foreach ($query->rows as $row) {
                $productIds[] = "'" . $row['product_id'] . "'";
            }
        }

        if (empty($productIds)) {
            // Если список product_id пуст, отправляем false
            $response = array('available' => false);
        } else {
            // Подключаемся к сторонней базе данных
            $externalDbHostname = 'sql446.your-server.de';
            $externalDbUsername = 'protune_1';
            $externalDbPassword = 'AQQ6JNrrMELP6n1K';
            $externalDbDatabase = 'protune_cm';
            $externalDbPort = '3306';

            $externalDb = new mysqli($externalDbHostname, $externalDbUsername, $externalDbPassword, $externalDbDatabase, $externalDbPort);

            if ($externalDb->connect_error) {
                die("Connection to external database failed: " . $externalDb->connect_error);
            }

            // Формируем список product_id для использования в запросе
            $productIdsList = implode(',', $productIds);

            // Выполняем запрос к сторонней базе данных для получения значений PKEY, AVAILABLE_VIEW, BRAND_VIEW и PRICE_LOADED
            $externalDbQuery = "SELECT PKEY, AKEY, AVAILABLE_VIEW, BRAND_VIEW, PRICE_LOADED, CURRENCY FROM CM_PRICES WHERE AVAILABLE_VIEW > 0 AND PKEY IN (" . $productIdsList . ")";
            $externalDbResult = $externalDb->query($externalDbQuery);
            if ($externalDbResult->num_rows > 0) {
                $productIdsS = array();
                foreach ($externalDbResult as $row) {
                    $productIdsS[] = "'" . $row['PKEY'] . "'";
                };

                $productIdsListS = implode(',', $productIdsS);

                // Выполняем запрос к базе данных OpenCart для получения email-адресов с соответствующими product_id
                $emailsDbQuery = "SELECT email FROM " . DB_PREFIX . "product_notification WHERE product_id IN (" . $productIdsListS . ")";
                $emailsQuery = $this->db->query($emailsDbQuery);
                $emails = array();

                if ($emailsQuery->num_rows > 0) {
                    foreach ($emailsQuery->rows as $emailRow) {
                        $emails[] = $emailRow['email'];
                    };
                };

                foreach ($externalDbResult as $row) {
                    $pkey = $row['PKEY'];
                    $akey = $row['AKEY'];
                    $availableView = $row['AVAILABLE_VIEW'];
                    $brandView = $row['BRAND_VIEW'];
                    $priceLoaded = $row['PRICE_LOADED'];
                    $currency = $row['CURRENCY'];

                    if (count($emails) > 0) {

                        // Отправляем письма с информацией на полученные адреса
                        foreach ($emails as $email) {
                            $subject = 'Your product from autoparts.fun is available!';
                            $message = 'Name: ' . $pkey . "\n";
                            $message .= 'Quantity: ' . $availableView . "\n";
                            $message .= 'Price: ' . $priceLoaded . ' ' . $currency . "\n";
                            $message .= 'Product Link: ' . HTTP_SERVER . 'carparts/product/' . $brandView . '/' . $akey;

                            // mail($email, $subject, $message);

                            $deleteDbQuery = "DELETE FROM " . DB_PREFIX . "product_notification WHERE product_id = '" . $pkey . "'";

                            $emailsQuery = $this->db->query($deleteDbQuery);
                        };
                    }
                }
            }

            $externalDb->close();
        }

        // Отправляем JSON-ответ
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }
}
