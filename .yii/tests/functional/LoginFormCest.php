<?php

class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Авторизация', 'title');

    }
    
    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Логин или e-mail – обязательное поле');
        $I->see('Пароль – обязательное поле');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Неверный логин или пароль');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'admin',
        ]);
        $I->see('Blacklist 66');
//        $I->dontSeeElement('form#login-form');
    }
	
	// demonstrates `amLoggedInAs` method
	public function internalLoginById(\FunctionalTester $I)
	{
		$I->amLoggedInAs(1);
		$I->amOnPage('/');
		$I->see('Выйти');
	}
	
	// demonstrates `amLoggedInAs` method
	public function internalLoginByInstance(\FunctionalTester $I)
	{
		$I->amLoggedInAs(\app\models\User::findByUsername('admin'));
		$I->amOnPage('/');
		$I->see('Выйти');
	}
	
}