<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\httpclient\Client;

class SmsComponent extends Component
{
    public $apiKey;
    public $apiUrl;
    public $sender;
    public $testMode;

    public function init(): void
    {
        parent::init();

        if (empty($this->apiKey)) {
            throw new \Exception('SMS API key is not set');
        }
        
        if (empty($this->apiUrl)) {
            throw new \Exception('SMS API URL is not set');
        }
        
        if (empty($this->sender)) {
            throw new \Exception('SMS sender is not set');
        }
        
        if ($this->testMode === null) {
            $this->testMode = true; // Default to test mode if not set
        }
    }

    public function sendSms($phone, $message): bool
    {
        if (empty($phone) || empty($message)) {
            return false;
        }

        $phone = $this->formatPhone($phone);
        if (!$phone) {
            return false;
        }

        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($this->apiUrl)
            ->setData([
                'send' => $message,
                'to' => $phone,
                'apikey' => $this->apiKey,
                'from' => $this->sender,
                'format' => 'json',
                'test' => $this->testMode ? '1' : '0'
            ])
            ->send();

        if ($response->isOk) {
            $data = $response->data;

            if (isset($data['error'])) {
                Yii::error('SMS Error: ' . $data['error']['description_ru'], 'sms');
                return false;
            }

            if (isset($data['send']) && is_array($data['send'])) {
                $result = $data['send'][0];
                if ($result['status'] == '0') {
                    Yii::info('SMS sent successfully to ' . $phone, 'sms');
                    return true;
                }
            }
        }

        Yii::error('SMS sending failed for ' . $phone, 'sms');
        return false;
    }

    private function formatPhone($phone): ?string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) == 10 && substr($phone, 0, 1) == '9') {
            return '7' . $phone;
        }

        if (strlen($phone) == 11 && substr($phone, 0, 1) == '8') {
            return '7' . substr($phone, 1);
        }

        if (strlen($phone) == 11 && substr($phone, 0, 1) == '7') {
            return $phone;
        }

        return false;
    }
}
