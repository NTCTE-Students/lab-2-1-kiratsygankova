<?php

   namespace App\Http\Controllers;

   use App\Models\Article;
   use App\Models\Category;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\Cache;

   class ArticleController extends Controller
   {
       public function __construct()
       {
           $this->middleware('auth')->except(['index', 'show']);
           $this->middleware('admin')->only(['destroy']);
       }

       public function index(Request $request)
       {
           $categoryId = $request->query('category');
           $search = $request->query('search');

           $articles = Cache::remember('articles_page_' . request()->page, 60, function () use ($categoryId, $search) {
               $query = Article::with('categories', 'user')->latest();

               if ($categoryId) {
                   $query->whereHas('categories', function ($q) use ($categoryId) {
                       $q->where('categories.id', $categoryId);
                   });
               }

               if ($search) {
                   $query->where(function ($q) use ($search) {
                       $q->where('title', 'like', "%$search%")
                         ->orWhere('content', 'like', "%$search%");
                   });
               }

               return $query->paginate(10);
           });

           $categories = Cache::remember('categories', 60, fn () => Category::all());

           return view('articles.index', compact('articles', 'categories'));
       }

       public function create()
       {
           $categories = Category::all();
           return view('articles.create', compact('categories'));
       }

       public function store(Request $request)
       {
           $request->validate([
               'title' => 'required|max:255',
               'content' => 'required',
               'categories' => 'required|array',
           ]);

           $article = Article::create([
               'title' => $request->title,
               'content' => $request->content,
               'user_id' => Auth::id(),
           ]);

           $article->categories()->attach($request->categories);

           return redirect()->route('articles.index')->with('success', 'Статья создана');
       }

       public function show(Article $article)
       {
           $article->load('categories', 'user');
           return view('articles.show', compact('article'));
       }

       public function edit(Article $article)
       {
           if (Auth::id() !== $article->user_id && !Auth::user()->is_admin) {
               return redirect()->route('articles.index')->with('error', 'Доступ запрещён');
           }

           $categories = Category::all();
           return view('articles.edit', compact('article', 'categories'));
       }

       public function update(Request $request, Article $article)
       {
           if (Auth::id() !== $article->user_id && !Auth::user()->is_admin) {
               return redirect()->route('articles.index')->with('error', 'Доступ запрещён');
           }

           $request->validate([
               'title' => 'required|max:255',
               'content' => 'required',
               'categories' => 'required|array',
           ]);

           $article->update([
               'title' => $request->title,
               'content' => $request->content,
           ]);

           $article->categories()->sync($request->categories);

           return redirect()->route('articles.index')->with('success', 'Статья обновлена');
       }

       public function destroy(Article $article)
       {
           $article->delete();
           return redirect()->route('articles.index')->with('success', 'Статья удалена');
       }
   }
