<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserLoginTest extends TestCase
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

			// Register Super Admin
			$this->visit('/register')
	    		 ->type('David Freitas', 'name')
	    		 ->type('test@example.com', 'email')
	    		 ->type('12345678', 'password')
	    		 ->type('12345678', 'password_confirmation')
	    		 ->press('Register')
	    		 ->seePageIs('/home');
    }

	/**
     * Test Login Page.
     *
     * @return void
     */
    public function testLoginPage()
    {
		    $this->visit('/login')
             ->seePageIs('/home');
    }

	/**
     * Test Login.
     *
     * @return void
     */
    public function testLoginRequiredFields()
    {
        $this->visit('/logout')
			       ->seePageIs('/home')
			       ->click('Login')
			       ->type('', 'email')
             ->type('', 'password')
             ->press('Sign In')
             ->see('The email field is required')
             ->see('The password field is required');
    }

	/**
     * Test Login Page.
     *
     * @return void
     */
    public function testLogin()
    {
    		$this->visit('/login')
             ->seePageIs('/home')
      			 ->visit('/logout')
      			 ->seePageIs('/home')
      			 ->click('Login')
      			 ->see('Sign in to start your session')
      			 ->type('test@example.com', 'email')
      			 ->type('12345678', 'password')
      			 ->press('Sign In')
      			 ->seePageIs('/home')
      			 ->see('David Freitas');
    }
}
