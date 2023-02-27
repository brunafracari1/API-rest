<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    //função para listar todos os arquivos
    public function index(){
        $articles = Article::all();
        return response()->json($articles,200);
    }

    // Função para obter um artigo específico
    public function show($id)
    {
        $article = Article::table('articles')->findOrFail($id);
        return response()->json($article, 200);
    }

    // Função para adicionar um novo artigo
    public function store(Request $request)
    {
        $rules = [
            'featured' => 'boolean',
            'title' => 'required|string|max:255',
            'url' => 'required|string',
            'imageUrl' => 'required|string',
            'newsSite' => 'required|string|max:255',
            'summary' => 'required|string',
            'publishedAt' => 'required|string',
            'launches_id' => 'required|exists:launches,id',
            'events_id' => 'required|exists:events,id'
        ];
    
        $validatedData = $request->validate($rules);
    
        $article = new Article;
        $article->featured = $validatedData['featured'] ?? false;
        $article->title = $validatedData['title'];
        $article->url = $validatedData['url'];
        $article->imageUrl = $validatedData['imageUrl'];
        $article->newsSite = $validatedData['newsSite'];
        $article->summary = $validatedData['summary'];
        $article->publishedAt = $validatedData['publishedAt'];
        $article->launches_id = $validatedData['launches_id'];
        $article->events_id = $validatedData['events_id'];
        $article->save();
    
        return response()->json(['message' => 'Article created successfully', 'article' => $article], 201);
    }
    
    // Função para atualizar um artigo existente
    public function update(Request $request, $id)
{
    // Procura o artigo no banco de dados pelo ID
    $article = Article::findOrFail($id);

    // Define as regras de validação dos dados recebidos
    $rules = [
        'featured' => 'boolean',
        'title' => 'required|string|max:255',
        'url' => 'required|string|max:255',
        'imageUrl' => 'required|string|max:255',
        'newsSite' => 'required|string|max:255',
        'summary' => 'required|string',
        'publishedAt' => 'required|string|max:255'
    ];

    // Valida os dados recebidos
    $this->validate($request, $rules);

    // Atualiza o artigo no banco de dados com os novos dados recebidos
    $article->update([
        'featured' => $request->input('featured', false),
        'title' => $request->input('title'),
        'url' => $request->input('url'),
        'imageUrl' => $request->input('imageUrl'),
        'newsSite' => $request->input('newsSite'),
        'summary' => $request->input('summary'),
        'publishedAt' => $request->input('publishedAt')
    ]);

    // Retorna a resposta de sucesso
    return response()->json([
        'message' => 'Artigo atualizado com sucesso!'
    ], 200);
}

    // Função para deletar um artigo existente
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(null, 204);
    }
    

}
