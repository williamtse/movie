<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=haokanxs',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                //我用的是QQ 的代理，所以这里是 QQ 的配置信息
                'host' => 'smtp.163.com',
                'port' => 25,
//                'encryption' => 'tcp',
                //这部分信息不应该公开，所以后期会由数据库中拿取
                'username' => '15985907714@163.com',
                'password' => 'I3H582HUJH5TW',
            ],
            //发送的邮件信息配置
            'messageConfig' => [
                'charset' => 'utf-8',
            ],
        ],
    ],
];
