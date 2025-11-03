<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$clients = App\Models\Client::all(['id', 'name', 'logo_path']);

foreach ($clients as $client) {
    echo "ID: {$client->id}\n";
    echo "Name: {$client->name}\n";
    echo "Logo Path: {$client->logo_path}\n";
    echo "Logo URL: {$client->logo_url}\n";
    echo "---\n";
}
