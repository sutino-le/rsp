<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelCekKtp;
use App\Models\ModelLevel;
use App\Models\ModelUser;
use Config\Services;

class AdmAuth extends BaseController
{
    public function login()
    {
        return view('admauth/login');
    }

    public function daftar()
    {
        return view('admauth/daftar');
    }

    public function reset()
    {
        return view('admauth/reset');
    }

    // form daftar akun
    function daftarsimpan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'usernama' => [
                    'rules'     => 'required',
                    'label'     => 'Nama',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'userktp' => [
                    'rules'     => 'required|min_length[16]|max_length[16]',
                    'label'     => 'Nomor KTP',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong',
                        'min_length'    => '{field} harus 16 digit',
                        'max_length'    => '{field} harus 16 digit',
                    ]
                ],
                'userid' => [
                    'rules'     => 'required',
                    'label'     => 'User ID/Email',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'userpassworda' => [
                    'rules'     => 'required',
                    'label'     => 'Password',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
                'userpasswordb' => [
                    'rules'     => 'required',
                    'label'     => 'Password',
                    'errors'    => [
                        'required'      => '{field} tidak boleh kosong'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errUserNama'       => $validation->getError('usernama'),
                        'errUserKtp'        => $validation->getError('userktp'),
                        'errUserID'         => $validation->getError('userid'),
                        'errUserPasswordA'  => $validation->getError('userpassworda'),
                        'errUserPasswordB'  => $validation->getError('userpasswordb'),
                    ]
                ];
            } else {
                $usernama       = $this->request->getPost('usernama');
                $userid         = $this->request->getPost('userid');
                $userpassworda  = $this->request->getPost('userpassworda');
                $userpasswordb  = $this->request->getPost('userpasswordb');

                $modelUser = new ModelUser();

                $cekData = $modelUser->find($userid);
                if ($cekData > 0) {
                    $json = [
                        'error' => [
                            'errUserID'     => 'Email sudaf terdaftar'
                        ]
                    ];
                } else if ($userpassworda != $userpasswordb) {
                    $json = [
                        'error' => [
                            'errUserPasswordB'     => 'Password tidak sama'
                        ]
                    ];
                } else {

                    $userktp        = $this->request->getPost('userktp');
                    $modelCekKtp = new ModelCekKtp();
                    $cekKtp = $modelCekKtp->find($userktp);

                    if ($cekKtp > 0) {
                        $json = [
                            'error' => [
                                'errUserKtp'     => 'Nomor KTP Sudah ada'
                            ]
                        ];
                    } else {
                        $modelUser = new ModelUser();
                        $modelUser->insert([
                            'userid'            => $userid,
                            'usernama'          => $usernama,
                            'userktp'           => $userktp,
                            'userpassword'      => sha1($userpassworda),
                            'userlevel'         => 2,
                            'userverify'        => 'Progres'
                        ]);

                        if ($modelUser) {
                            $json = [
                                'sukses' => 'Anda berhasil mendaftar! silahkan login'
                            ];
                        } else {
                            $json = [
                                'gagal' => 'Anda gagal mendaftar'
                            ];
                        }
                    }
                }
            }



            echo json_encode($json);
        }
    }

    // form login
    function cekUser()
    {

        $userid = $this->request->getPost('userid');
        $userpassword = $this->request->getPost('userpassword');



        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'userid' => [
                'rules'     => 'required',
                'label'     => 'User ID/Email',
                'errors'    => [
                    'required'      => '{field} tidak boleh kosong'
                ]
            ],
            'userpassword' => [
                'rules'     => 'required',
                'label'     => 'Password',
                'errors'    => [
                    'required'      => '{field} tidak boleh kosong'
                ]
            ],
        ]);

        if (!$valid) {
            $sessError = [
                'userid'     => $validation->getError('userid'),
                'userpassword'   => $validation->getError('userpassword')
            ];

            session()->setFlashdata($sessError);
            return redirect()->to(site_url('admauth/login'))->withInput()->with('validation', $validation);
        } else {
            $modelUser  = new ModelUser();

            $cekUserLogin = $modelUser->find($userid);
            if ($cekUserLogin == null) {
                $sessError = [
                    'userid'     => 'Email / Password anda salah...',
                ];

                session()->setFlashdata($sessError);
                return redirect()->to(site_url('admauth/login'))->withInput()->with('validation', $validation);
            } else {
                $passwordUser = $cekUserLogin['userpassword'];

                if (sha1($userpassword) == $passwordUser) {
                    //lanjutkan
                    $levelid = $cekUserLogin['userlevel'];

                    $modelLevel = new ModelLevel();
                    $cekLevel = $modelLevel->find($levelid);

                    $simpan_session = [
                        'userid'    => $userid,
                        'usernama'  => $cekUserLogin['usernama'],
                        'levelnama'  => $cekLevel['levelnama'],
                        'levelid'   => $levelid,
                    ];
                    session()->set($simpan_session);

                    return redirect()->to('/AdmHome/index')->withInput()->with('validation', $validation);
                } else {
                    $sessError = [
                        'userpassword'     => 'Email / Password anda salah...',
                    ];

                    session()->setFlashdata($sessError);
                    return redirect()->to(site_url('admauth/login'))->withInput()->with('validation', $validation);
                }
            }
        }
    }

    // untuk logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admauth/login');
    }
}