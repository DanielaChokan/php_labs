<?php
class SmsService
{
    public function setRecipient($recipient)
    {
        echo "Recipient set to: $recipient<br>";
    }
    public function setMessage($message)
    {
        echo "Message set: $message<br>";
    }
    public function sendText()
    {
        echo "I sent a SMS<br>";
    }
}

interface NotificationInterface
{
    public function setData($data);
    public function sendNotification();
}

class SmsAdapter implements NotificationInterface
{
    protected $_data;

    public function setData($data)
    {
        $this->_data = $data;
    }

    public function sendNotification()
    {
        $smsClient = new SmsService();
        $smsClient->setRecipient($this->_data['recipient']);
        $smsClient->setMessage($this->_data['message']);

        if (isset($this->_data['time'])) {
            echo "<i>Message scheduled for: " . $this->_data['time'] . "</i><br>";
        }

        $smsClient->sendText();
    }
}

interface INotificationManager
{
    public function sendNotification($type = '', $data);
}

class NotificationManager implements INotificationManager
{
    public function sendNotification($type = '', $data)
    {
        switch ($type) {
            case "sms":
                $notification = new SmsAdapter();
                break;
            default:
                echo "error";
                return false;
        }
        $notification->setData($data);
        $notification->sendNotification();
    }
}

$array = [
    "recipient" => "+380991234567",
    "message" => "This is a scheduled SMS",
    "time" => "2026-11-13 10:00:00"
];

$manager = new NotificationManager();
$manager->sendNotification("sms", $array);
?>