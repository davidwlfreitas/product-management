<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserWithoutLoginTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	/**
     * Basic setup before testing
     *
     * @return void
     */
    public function setUp()
    {
		parent::setUp();
    		// Generate Seeds
    		$this->artisan('db:seed');
    }

	/**
     * Test Register Page.
     *
     * @return void
     */
    public function testRegisterPage()
    {
        $this->visit('/register')
            ->see('Register a new membership');
    }

	/**
     * Test required fields on registration page.
     *
     * @return void
     */
    public function testRequiredFieldsOnRegistrationPage()
    {
        $this->visit('/register')
            ->press('Register')
            ->see('The name field is required')
            ->see('The email field is required')
            ->see('The password field is required');
    }

	/**
     * Test Registration
     *
     * @return void
     */
    public function testRegistration()
    {
        $this->visit('/register')
            ->see('Register a new membership')
			->type('David Freitas', 'name')
			->type('test@example.com', 'email')
			->type('12345678', 'password')
			->type('12345678', 'password_confirmation')
			->press('Register')
			->seePageIs('/home')
			->visit('/logout')
			->seePageIs('/home')
			->click('Login')
			->type('test@example.com', 'email')
			->type('12345678', 'password')
			->press('Sign In')
			->seePageIs('/home');
    }

	/**
     * Test Password reset Page.
     *
     * @return void
     */
    public function testPasswordResetPage()
    {
        $this->visit('/password/reset')
            ->see('Enter Email to reset password');
    }

	/**
     * Test send password reset user not exists.
     *
     * @return void
     */
    public function testSendPasswordResetUserNotExists()
    {
        $this->visit('password/reset')
             ->type('notexistingemail@gmail.com', 'email')
             ->press('Send Password Reset Link')
             ->see("We can't find a user with that e-mail address.");
    }
}
