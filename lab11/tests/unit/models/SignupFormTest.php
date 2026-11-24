<?php

declare(strict_types=1);

namespace tests\unit\models;

use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use PHPUnit\Framework\TestCase;
use Yii;
use yii\db\Connection;

class SignupFormTest extends TestCase
{
    private Connection $previousDb;
    private Connection $testDb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->previousDb = Yii::$app->get('db');
        $this->testDb = new Connection(['dsn' => 'sqlite::memory:']);
        Yii::$app->set('db', $this->testDb);

        require_once Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'migrations'
            . DIRECTORY_SEPARATOR . 'm260000_000003_create_user_table.php';
        (new \m260000_000003_create_user_table(['db' => $this->testDb]))->safeUp();
    }

    protected function tearDown(): void
    {
        Yii::$app->set('db', $this->previousDb);
        $this->testDb->close();

        parent::tearDown();
    }

    public function testRequiredFieldsAndInputFormatsAreValidated(): void
    {
        $empty = new SignupForm();
        self::assertFalse($empty->validate());
        self::assertArrayHasKey('username', $empty->getErrors());
        self::assertArrayHasKey('email', $empty->getErrors());
        self::assertArrayHasKey('password', $empty->getErrors());
        self::assertArrayHasKey('confirmPassword', $empty->getErrors());

        $invalid = new SignupForm([
            'username' => 'ab',
            'email' => 'not-an-email',
            'password' => 'short',
            'confirmPassword' => 'different',
        ]);
        self::assertFalse($invalid->validate());
        self::assertArrayHasKey('username', $invalid->getErrors());
        self::assertArrayHasKey('email', $invalid->getErrors());
        self::assertArrayHasKey('password', $invalid->getErrors());
        self::assertArrayHasKey('confirmPassword', $invalid->getErrors());

        $invalidUsername = new SignupForm([
            'username' => 'invalid username!',
            'email' => 'valid@example.com',
            'password' => 'strong-password-123',
            'confirmPassword' => 'strong-password-123',
        ]);
        self::assertFalse($invalidUsername->validate());
        self::assertArrayHasKey('username', $invalidUsername->getErrors());

        $longUsername = new SignupForm([
            'username' => str_repeat('u', 51),
            'email' => 'long@example.com',
            'password' => 'strong-password-123',
            'confirmPassword' => 'strong-password-123',
        ]);
        self::assertFalse($longUsername->validate());
        self::assertArrayHasKey('username', $longUsername->getErrors());
    }

    public function testArrayInputIsRejectedWithoutTypeErrors(): void
    {
        $signup = new SignupForm([
            'username' => ['invalid'],
            'email' => ['invalid'],
            'password' => ['invalid'],
            'confirmPassword' => ['invalid'],
        ]);
        self::assertFalse($signup->validate());

        $login = new LoginForm([
            'login' => ['invalid'],
            'password' => ['invalid'],
        ]);
        self::assertFalse($login->validate());
    }

    public function testRegistrationStoresHashedPasswordAndUniqueAccount(): void
    {
        $form = new SignupForm([
            'username' => '  Тестовий_користувач ',
            'email' => '  TEST@example.com ',
            'password' => 'strong-password-123',
            'confirmPassword' => 'strong-password-123',
        ]);

        $user = $form->signup();

        self::assertInstanceOf(User::class, $user);
        self::assertSame('Тестовий_користувач', $user->username);
        self::assertSame('test@example.com', $user->email);
        self::assertNotSame('strong-password-123', $user->password_hash);
        self::assertTrue($user->validatePassword('strong-password-123'));
        self::assertSame(User::STATUS_ACTIVE, (int)$user->status);

        $login = new LoginForm([
            'login' => 'TEST@example.com',
            'password' => 'strong-password-123',
        ]);
        self::assertTrue($login->validate());
    }

    public function testDuplicateUsernameAndEmailAreRejected(): void
    {
        $first = new SignupForm([
            'username' => 'unique_user',
            'email' => 'unique@example.com',
            'password' => 'strong-password-123',
            'confirmPassword' => 'strong-password-123',
        ]);
        self::assertNotNull($first->signup());

        $duplicateUsername = new SignupForm([
            'username' => 'unique_user',
            'email' => 'another@example.com',
            'password' => 'strong-password-123',
            'confirmPassword' => 'strong-password-123',
        ]);
        self::assertNull($duplicateUsername->signup());
        self::assertArrayHasKey('username', $duplicateUsername->getErrors());

        $duplicateEmail = new SignupForm([
            'username' => 'another_user',
            'email' => 'unique@example.com',
            'password' => 'strong-password-123',
            'confirmPassword' => 'strong-password-123',
        ]);
        self::assertNull($duplicateEmail->signup());
        self::assertArrayHasKey('email', $duplicateEmail->getErrors());

        self::assertSame(1, (int)User::find()->count());
    }

    public function testLoginRejectsIncorrectPassword(): void
    {
        $signup = new SignupForm([
            'username' => 'login_user',
            'email' => 'login@example.com',
            'password' => 'strong-password-123',
            'confirmPassword' => 'strong-password-123',
        ]);
        self::assertNotNull($signup->signup());

        $login = new LoginForm([
            'login' => 'login_user',
            'password' => 'wrong-password',
        ]);

        self::assertFalse($login->validate());
        self::assertArrayHasKey('password', $login->getErrors());
    }

    public function testLoginRejectsPasswordOverTheHashAlgorithmByteLimit(): void
    {
        $login = new LoginForm([
            'login' => 'user@example.com',
            'password' => str_repeat('ї', 37),
        ]);

        self::assertFalse($login->validate());
        self::assertArrayHasKey('password', $login->getErrors());
    }

    public function testPasswordCannotExceedHashAlgorithmByteLimit(): void
    {
        $form = new SignupForm([
            'username' => 'long_password_user',
            'email' => 'long@example.com',
            'password' => str_repeat('ї', 37),
            'confirmPassword' => str_repeat('ї', 37),
        ]);

        self::assertFalse($form->validate());
        self::assertArrayHasKey('password', $form->getErrors());
    }
}