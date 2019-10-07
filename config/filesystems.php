<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'gcs' => [
            'driver' => 'gcs',
            'project_id' => env('GOOGLE_CLOUD_PROJECT_ID', 'your-project-id'),
            'key_file' => [
                'type' => env('GOOGLE_CLOUD_ACCOUNT_TYPE'),
                'private_key_id' => env('GOOGLE_CLOUD_PRIVATE_KEY_ID'),
                'private_key' => str_replace("\\n", "\n", env('GOOGLE_CLOUD_PRIVATE_KEY')),
                //'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCk7/SKqlo5It4A\nMQk5wXzJc66FBOn9yIBuHZ5H73DzgRuhJnZbgZ3Lwx6fGFLed3KfKacL/rIVDDaQ\n3cj8yyitE/cmPgG1dZ5u09LyxrVYXAleYFD+SSi6OUGFGgMmVq1kGG2xlK5E4uKF\nLCa3HcFjA7XoBW0dZN+uEykqwMwvHQOvSky+61JmCO6eSEypQNQKjfktLmK5dEKW\nKXTd99E4zWUZZSaZH1LdPBvx+//E91/l/MluKwS3Xtm9RLDrHsrVNFRa2CvHGl2e\njUpf98+wuJs6Hsg942Eq2SPwFOOiV29Yu7JmlKiNko7+s1dRNQlRgGHN9lIXx9sO\n6+yRUlJDAgMBAAECggEACPfFs2cWchYukpLCo6dHjP8t4AGnugAVgOc6B0NCQEXR\ne25HRSvDqU6PSFXe5kWsWnG9/sL3FSSNhaGUH1qUeESmTX1VmR4vYmtArv6VjEZa\nJA2B7zGJy1ui76+9uBntDOI0efv8NbajBlv43D/77HxJKbe8emVVBsv36GEvOOh5\nORxQQVR3V5sAQEknG81Oinv8h2OZocCZk4TNd+Vj5GDCLHFegouxaouwmwkEnglF\nzJyqAUBmZ1Lfdl48ahlpfxMMqhBVX8ToPysdyo7f0vP9HlBFC8n1AaZCUlwkesAa\nWGhnjUqETwymWwon0ZVOhTi0tbYQViuQA8vQl9byUQKBgQDbm9TcQPfg6wpGwZmE\n+4sne8IsLaYCuzZEhvb35/tjDyPsYak3SvGO4nh1VjmE11Q+grQvfZ1qVhJW91Jv\n5wseLgpH4GkxwkHBuV72mj9/TCu/WMyyJFjlIfgXO/Wh7wky2vD4VgGmBzrmHWVM\n70Q8BN2HrtxDiwrZYLBkH+icNQKBgQDARN881rJmsulmiUrFNxdbDhyTO8aQv8Un\nMV4Aepga47xyQucRXXFZNDT759gnXwNdHxhsHCgXBfd8/AqsFegF5Q22qnLZQE/R\nrRfwacLfFcapztRDgA969hvqOPM6f/fNbvx+K3BERKg23SYtjnNC2B1fetA/Mcri\nBSBxt7VTlwKBgCsrd+2QK+of6hY8qoQUuqcZUfNDSfYRfTp9WYEkLiur50Dpdc0z\nw0Z2SH2wZIAzoBDluqv3QoGLx/EmjyMGRQ46uLSmbadla228leleKwtIGvVzbFG8\niWkJg251z/R0O9euaF448fwEQdTIhIhaJIyz3CR3AD+azpgqxKH6D8zdAoGATqUd\nRy5uxNFT5SwtWGQDeqxYBeWCgDzg8PohgEKlKwKSV46EI7c8IQfY0F1yLhCQOKv6\nemY+A8TeCdKyrtc7FAYwSNKJrdG/lH2f+CfanRO0Mks2yfF844f9vR3UZ85mVzKZ\ntyYfgt0ujVqCPkoxXVs3EJIU0nSUj0UXk0xYsDsCgYBEyciYnagkglqelTooNJOS\nKHTBg+/pzxw4DvFwY7vSJkos6Xx1pAIpfo9Zu/wl5J9jXKUHXt0xjnlby2ALzevA\n7cW8YIVSlZ7b5kVk2bA45B3oPVUhETTeZWM4NE+ue5/GhCp6uigNMZ3dd1KDF5gu\nzkFokQG/HEFMdpXWz9f8Sg==\n-----END PRIVATE KEY-----\n",
                'client_email' => env('GOOGLE_CLOUD_CLIENT_EMAIL'),
                'client_id' => env('GOOGLE_CLOUD_CLIENT_ID'),
                'auth_uri' => env('GOOGLE_CLOUD_AUTH_URI'),
                'token_uri' => env('GOOGLE_CLOUD_TOKEN_URI'),
                'auth_provider_x509_cert_url' => env('GOOGLE_CLOUD_AUTH_PROVIDER_CERT_URL'),
                'client_x509_cert_url' => env('GOOGLE_CLOUD_CLIENT_CERT_URL'),
            ],
            'bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET', 'your-bucket'),
            'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX', null),
            'storage_api_uri' => env('GOOGLE_CLOUD_STORAGE_API_URI', null),
            'visibility' => 'public'
        ],
    ],

];
