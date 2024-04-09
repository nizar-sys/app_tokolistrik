<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BarangMasukModel;
use App\Controllers\BaseController;
use App\Models\DataBarangModel;
use App\Models\KategoriModel;
use App\Models\MerkModel;
use App\Models\RakModel;

class ProfileController extends BaseController
{
    protected $barangModel;
    protected $barangMasukModel;
    protected $merModel;
    protected $kategoriModel;
    protected $authModel;
    protected $rakModel;

    public function __construct()
    {
        $this->barangModel = new DataBarangModel();
        $this->barangMasukModel = new BarangMasukModel();
        $this->kategoriModel = new KategoriModel();
        $this->merModel = new MerkModel();
        $this->authModel = new UserModel();
        $this->rakModel = new RakModel();
    }

    public function index()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Profile',
            'account' => $this->authModel->getUser(session()->get('id')),
        ];

        return view('profile/index', $data);
    }

    public function changePassword()
    {
        $account = $this->authModel->getUser(session()->get('id'));

        $rules = [
            'new_password' => [
                'label' => 'New Password',
                'rules' => 'required|min_length[5]|matches[retype_new_password]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'min_length' => 'Panjang {field} minimal harus {param} karakter.',
                    'matches' => 'Form {field} tidak cocok dengan Form {param}.'
                ]
            ],
            'retype_new_password' => [
                'label' => 'Retype New Password',
                'rules' => 'required|min_length[5]|matches[new_password]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'min_length' => 'Panjang {field} minimal harus {param} karakter.',
                    'matches' => 'Form {field} tidak cocok dengan Form {param}.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $new_password = $this->request->getVar('new_password');

        $passwordOld = $account->password;
        if (password_verify($new_password, $passwordOld)) {
            session()->setFlashdata('error', 'Dilarang Menggunakan Password Sebelumnya.');
            return redirect()->to('profile');
        } else {
            $this->authModel->save([
                'user_id' => session()->get('id'),
                'password' => password_hash($new_password, PASSWORD_DEFAULT),
            ]);

            session()->setFlashdata('success', 'Password Berhasil Diubah.');
            return redirect()->to('profile');
        }
    }

    public function ubahProfile()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Profile',
            'account' => $this->authModel->getUser(session()->get('id')),
        ];

        return view('profile/ubahprofile', $data);
    }

    public function changeProfile()
    {
        $account = $this->authModel->getUser(session()->get('id'));

        $rules = [
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'min_length' => 'Panjang {field} minimal harus {param} karakter.',
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'min_length' => 'Panjang {field} minimal harus {param} karakter.',
                ]
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'min_length' => 'Panjang {field} minimal harus {param} karakter.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $nama_lengkap = $this->request->getVar('nama_lengkap');
        $alamat = $this->request->getVar('alamat');
        $tanggal_lahir = $this->request->getVar('tanggal_lahir');
        $email = $this->request->getVar('email');

        $this->authModel->save([
            'user_id' => session()->get('id'),
            'nama_lengkap' => $nama_lengkap,
            'alamat' => $alamat,
            'tanggal_lahir' => $tanggal_lahir,
            'email' => $email,
        ]);

        session()->setFlashdata('success', 'Data Berhasil Diperbaharui.');
        return redirect()->to('profile');
    }

    public function ubahPicture()
    {
        $data = [
            'barangMenipis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok <= tb_barang.stok_alert AND tb_barangmasuk.stok > 0')->orderBy('tb_barangmasuk.stok', 'ASC')->asObject()->findAll(),
            'barangHabis' => $this->barangMasukModel->join('tb_suppliers', 'tb_barangmasuk.supplier_id = tb_suppliers.supplier_id')->join('tb_barang', 'tb_barangmasuk.barang_id = tb_barang.barang_id')->where('tb_barangmasuk.stok = 0')->asObject()->findAll(),
            'title' => 'Profile',
            'account' => $this->authModel->getUser(session()->get('id')),
        ];

        return view('profile/ubahpicture', $data);
    }

    public function changePicture()
    {
        $account = $this->authModel->getUser(session()->get('id'));

        $rulesAvatar = $this->request->getFile('avatar');

        if ($rulesAvatar->getError() == 4) {
            $rulesAO = 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]';
        } else {
            $rulesAO = 'max_size[avatar,1024]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]';
        }

        $rules = [
            'avatar' => [
                'label' => 'Picture Avatar',
                'rules' => $rulesAO,
                'errors' => [
                    'max_size' => 'Ukuran {field} terlalu besar.',
                    'is_image' => 'Yang anda pilih bukan gambar'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $fileAvatar = $this->request->getFile('avatar');

        // cek gambar, apakah tetap gambar lama
        if ($fileAvatar->getError() == 4) {
            $namaAvatar = $this->request->getVar('avatarOld');
        } else {
            // generate nama file random
            $namaAvatar = $fileAvatar->getRandomName();
            // pindahkan gambar
            $fileAvatar->move('assets/img/avatars', $namaAvatar);
            // hapus file lama
            if ($this->request->getVar('avatarOld') != 'user-default.png') {
                // hapus gambar
                unlink('assets/img/avatars/' . $this->request->getVar('avatarOld'));
            }
        }

        $this->authModel->save([
            'user_id' => session()->get('id'),
            'avatar' => $namaAvatar,
        ]);

        session()->setFlashdata('success', 'Picture Avatar Berhasil Diubahkan.');
        return redirect()->to('profile');
    }
}
