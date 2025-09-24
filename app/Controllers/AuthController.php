<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Helpers\Csrf;
use App\Helpers\Flash;
use App\Repositories\UserRepository;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService(new UserRepository());
    }

    public function loginForm(): void
    {
        if (!empty($_SESSION['user'])) $this->redirect('/tasks');
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function registerForm(): void
    {
        if (!empty($_SESSION['user'])) $this->redirect('/tasks');
        $this->view('auth/register', ['title' => 'Register']);
    }

    public function login(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? '')) { http_response_code(419); exit('CSRF failed'); }
        [$ok, $err] = $this->auth->login($_POST['email'] ?? '', $_POST['password'] ?? '');
        if ($ok) {
            Flash::success('Logged in successfully.');
            Logger::info("Login successful for {$_POST['email']}");
            $this->redirect('/tasks');
        } else {
            Logger::info("Login failed for {$_POST['email']}");
            $this->view('auth/login', ['error' => $err, 'title' => 'Login']);
        }
    }

    public function register(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? '')) { http_response_code(419); exit('CSRF failed'); }
        [$ok, $err] = $this->auth->register($_POST['name'] ?? '', $_POST['email'] ?? '', $_POST['password'] ?? '');
        if ($ok) {
            Flash::success('Registered successfully. You can now log in.');
            Logger::info("Registration successful for {$_POST['email']}");
            $this->redirect('/tasks');
        } else {
            Logger::info("Register failed for {$_POST['email']}");
            $this->view('auth/register', ['error' => $err, 'title' => 'Register']);
        }
    }

    public function logout(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? '')) { http_response_code(419); exit('CSRF failed'); }
        $this->auth->logout();
        $this->redirect('/login');
    }
}
