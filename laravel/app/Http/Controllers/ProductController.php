<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(){
        $products = DB::table('products')->get(); //->where('price','>','3')->get(); -->Clausula where que filtra por los productos con precio mayor de 3
        return view('products.index', compact('products'));
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){
        $newProduct = new Product;
        $newProduct -> description = $request->input('description');
        $newProduct -> price = $request->input('price');
        $newProduct->save();
        return redirect()->route('products.index')->with('info', 'Producto insertado correctamente');
    }

    public function destroy($id){
        $product=Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('info', 'Producto eliminado exitosamente');
    }

    public function edit($id){
        $product=Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id){
        $product=Product::findOrFail($id);
        $product->description=$request->input('description');
        $product->price=$request->input('price');
        $product->save();
        return redirect()->route('products.index')->with('info', 'Producto modificado correctamente');
    }

    public function updatedActivity(){
        $text = 'Aquí adjunta lo quieras enviar.';

        \Telegram::sendMessage([
        'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
        'parse_mode' => 'HTML',
        'text' => $text
        ]);
    }
}
