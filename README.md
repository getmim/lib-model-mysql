# lib-model-mysql

Adalah driver untuk module `lib-model` untuk database MySQL/MariaDB.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-model-mysql
```

## Konfigurasi

Pada saat mendaftarkan koneksi database pada konfigurasi aplikasi, pastikan
set properti `driver` menjadi `mysql`.

```php
return [
    'libModel' => [
        'connections' => [
            'default' => [
                'driver' => 'mysql',
                'configs' => [
                    [
                        'host'   => 'localhost',
                        'user'   => 'mim',
                        'passwd' => '',
                        'dbname' => 'mim',
                        'port'   => '3306',
                        'socket' => '/tmp/mysql.sock'
                    ],
                    // ...
                ]
            ]
        ]
    ]
];
```

Properti-properti yang bisa diset adalah sebagai berikut:

1. `host` DB Host.
1. `user` User DB untuk koneksi.
1. `passwd` User Password untuk koneksi.
1. `dbname` Nama database yang akan digunakna.
1. `port` Port database host.
1. `socket` Database socket jika menggunakan koneksi socket.

Jika properti tersebut tidak di set, maka nilai default dari php.ini akan
diambil.