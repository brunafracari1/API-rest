<?php

require __DIR__.'/../../vendor/autoload.php';

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

$client = new Client([
    'base_uri' => 'https://spaceflightnewsapi.net/api/v2/',
]);

$response = $client->request('GET', 'articles');

$articles = json_decode($response->getBody(), true);

foreach ($articles['docs'] as $article) {
    DB::table('articles')->updateOrInsert(
        ['id' => $article['_id']],
        [
            'title' => $article['title'],
            'url' => $article['url'],
            'imageUrl' => $article['imageUrl'],
            'summary' => $article['summary'],
            'publishedAt' => $article['publishedAt'],
            'updatedAt' => $article['updatedAt'],
        ]
    );
}

echo 'Articles updated successfully!' . PHP_EOL;