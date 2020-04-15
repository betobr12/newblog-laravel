<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,bmp,png,jpg'
        ]);
        // Form para imagem
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        if (isset($image))
        {
//            Cria um nome exclusivo para imagem
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//            Verifica no diretorio se existe alguma categoria identica
            if (!Storage::disk('public')->exists('category'))
            {
                Storage::disk('public')->makeDirectory('category');
            }
//            edita o tamanho da foto e envia para o diretorio
            $category = Image::make($image)->resize(1600,479)->save(90); //save + qualidade da imagem 90
            Storage::disk('public')->put('category/'.$imagename,$category);

//             Verifica no diretorio se existe alguma categoria identica no slider
            if (!Storage::disk('public')->exists('category/slider'))
            {
                Storage::disk('public')->makeDirectory('category/slider');
            }
            //            edita o tamanho da foto e envia para o diretorio de slide
            $slider = Image::make($image)->resize(500,333)->save(90); //save + qualidade da imagem 90
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);

        } else {
            $imagename = "default.png";
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Categorria salva com sucesso :)' ,'Successo');
        return redirect()->route('admin.category.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'image' => 'mimes:jpeg,bmp,png,jpg'
        ]);
        // Form para imagem
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        $category = Category::find($id);
        if (isset($image))
        {
//            Cria um nome exclusivo para imagem
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//            Verifica no diretorio se existe alguma categoria identica
            if (!Storage::disk('public')->exists('category'))
            {
                Storage::disk('public')->makeDirectory('category');
            }
//            exclui a imagem antiga
            if (Storage::disk('public')->exists('category/'.$category->image))
            {
                Storage::disk('public')->delete('category/'.$category->image);
            }
//            redimensiona e envia a imagem
            $categoryimage = Image::make($image)->resize(1600,479)->save(90);
            Storage::disk('public')->put('category/'.$imagename,$categoryimage);

            //            Verifica no diretorio se existe alguma categoria identica de slide
            if (!Storage::disk('public')->exists('category/slider'))
            {
                Storage::disk('public')->makeDirectory('category/slider');
            }
            //            exclui a imagem antiga do diretorio slide
            if (Storage::disk('public')->exists('category/slider/'.$category->image))
            {
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }
            //            redimensiona a imagem do slide
            $slider = Image::make($image)->resize(500,333)->save(90);
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);

        } else {
            $imagename = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Categoria alterada com sucesso! :)' ,'Successo');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (Storage::disk('public')->exists('category/'.$category->image))
        {
            Storage::disk('public')->delete('category/'.$category->image);
        }

        if (Storage::disk('public')->exists('category/slider/'.$category->image))
        {
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();
        Toastr::success('Categoria excluida com sucesso! :)','Successo');
        return redirect()->back();
    }
}
