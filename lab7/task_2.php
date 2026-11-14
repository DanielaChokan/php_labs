<?php
abstract class PaymentHandler
{
    protected $nextHandler;

    public function setNext(PaymentHandler $handler)
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    abstract public function pay($amount);
}

class MainAccountHandler extends PaymentHandler
{
    private $balance = 500; // Баланс основного рахунку

    public function pay($amount)
    {
        if ($this->balance >= $amount) {
            echo "Покупка на суму $amount успішно оплачена з Основного рахунку.<br>";
        } elseif ($this->nextHandler) {
            echo "На Основному рахунку недостатньо коштів. Перевірка кредитної картки...<br>";
            $this->nextHandler->pay($amount);
        }
    }
}

class CreditCardHandler extends PaymentHandler
{
    private $creditLimit = 2000; // Ліміт кредитки

    public function pay($amount)
    {
        if ($this->creditLimit >= $amount) {
            echo "Покупка на суму $amount успішно оплачена з Кредитної картки.<br>";
        } elseif ($this->nextHandler) {
            $this->nextHandler->pay($amount);
        } else {
            echo "Оплату відхилено внаслідок недостатньої кількості коштів на обох рахунках.<br>";
        }
    }
}

class DeclineHandler extends PaymentHandler
{
    public function pay($amount)
    {
        echo "Оплату відхилено внаслідок недостатньої кількості коштів на обох рахунках.<br>";
    }
}

$mainAccount = new MainAccountHandler();
$creditCard = new CreditCardHandler();
$decline = new DeclineHandler();

$mainAccount->setNext($creditCard)->setNext($decline);

echo "<b>Спроба 1: Покупка на 300 (має списати з основного)</b><br>";
$mainAccount->pay(300);

echo "<br><b>Спроба 2: Покупка на 1500 (має списати з кредитки)</b><br>";
$mainAccount->pay(1500);

echo "<br><b>Спроба 3: Покупка на 3000 (має бути відхилено)</b><br>";
$mainAccount->pay(3000);
?>