<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Sign In'
        ];

        return view('auth/login', $data);
    }

    public function cek_login()
    {
        $rules = [
            'username' => 'required|min_length[2]|max_length[13]',
            'password' => 'required|min_length[2]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->authModel->where('username', $username)->first();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                if ($user['is_active'] == 1) {
                    $sessLogin = [
                        'isLogin' => true,
                        'id' => $user['user_id'],
                        'role' => $user['role']
                    ];

                    session()->set($sessLogin);
                    return redirect()->to('home');
                } else {
                    session()->setFlashdata('error', 'Maaf Akun Anda Dinonaktifkan!');
                    return redirect()->back()->withInput();
                }
            } else {
                session()->setFlashdata('error', 'Password Anda Salah!');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('error', 'Username Tidak Terdaftar');
            return redirect()->to('');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }
}
