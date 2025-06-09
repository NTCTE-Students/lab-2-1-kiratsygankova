<?php

   namespace App\Http\Controllers;

   use App\Models\Category;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Cache;

   class CategoryController extends Controller
   {
       public function __construct()
       {
           $this->middleware('auth');
           $this->middleware('admin')->except(['index', 'show']);
       }

       public function index()
       {
           // Используем пагинацию вместо загрузки всех категорий
           $categories = Cache::remember('categories_page_' . request('page', 1), 60, fn () => Category::paginate(10));
           return view('categories.index', compact('categories'));
       }

       public function create()
       {
           return view('categories.create');
       }

       public function store(Request $request)
       {
           $request->validate([
               'name' => 'required|max:255',
               'description' => 'nullable|string',
           ]);

           Category::create($request->only(['name', 'description']));

           // Очищаем кэш категорий после создания
           Cache::forget('categories_page_1');

           return redirect()->route('categories.index')->with('success', 'Категория создана');
       }

       public function show(Category $category)
       {
           // Ленивая загрузка статей с пагинацией
           $category->load(['articles' => fn ($query) => $query->paginate(10)]);
           return view('categories.show', compact('category'));
       }

       public function edit(Category $category)
       {
           return view('categories.edit', compact('category'));
       }

       public function update(Request $request, Category $category)
       {
           $request->validate([
               'name' => 'required|max:255',
               'description' => 'nullable|string',
           ]);

           $category->update($request->only(['name', 'description']));

           // Очищаем кэш категорий после обновления
           Cache::forget('categories_page_1');

           return redirect()->route('categories.index')->with('success', 'Категория обновлена');
       }

       public function destroy(Category $category)
       {
           $category->delete();

           // Очищаем кэш категорий после удаления
           Cache::forget('categories_page_1');

           return redirect()->route('categories.index')->with('success', 'Категория удалена');
       }
   }
