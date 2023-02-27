<?php
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;

// Configurações do banco de dados
$db_host = 'localhost';
$db_name = 'space_flight_news';
$db_user = 'root';
$db_pass = '';

// Configurações da API Space Flight News
$api_base_url = 'https://test.spaceflightnewsapi.net/api/v2';
$api_articles_url = $api_base_url . '/articles';

// Cria uma nova instância do cliente GuzzleHttp
$client = new Client();

// Faz uma requisição GET para a API Space Flight News
$response = $client->get($api_articles_url);

// Decodifica o conteúdo JSON da resposta
$data = json_decode($response->getBody(), true);

// Conecta ao banco de dados
$db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

// Itera sobre os dados recebidos e insere no banco de dados
foreach ($data['docs'] as $article_data) {
    $article = new Article();
    $article->featured = $article_data['featured'];
    $article->title = $article_data['title'];
    $article->url = $article_data['url'];
    $article->imageUrl = $article_data['imageUrl'];
    $article->newsSite = $article_data['newsSite'];
    $article->summary = $article_data['summary'];
    $article->publishedAt = $article_data['publishedAt'];
    $article->save();
}

echo "Dados inseridos no banco de dados com sucesso!\n";