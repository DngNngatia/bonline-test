@extends('app')
@section('content')
    <div class="flex flex-col w-full py-10">
        <h1 class="text-xl font-bold">Edit a Product</h1>
        @if(session('error'))
            <span class="text-red-600">{{session('message')}}</span>
        @endif
        <form method="POST" action="{{route('products.update',['product' => $product])}}" class="flex flex-col space-y-5 max-w-5xl">
           @method('PUT')
            @csrf
            <div class="flex flex-col space-y-3">
                <label for="name">Product Name</label>
                <input value="{{$product->name}}" type="text" placeholder="Name" name="name" id="name"
                       class="outline-none border border-gray-200 py-2 px-2 rounded" required/>
            </div>
            <div class="flex flex-col space-y-3">
                <label for="product_sku_id">Product Sku</label>
                <select name="product_sku_id" id="product_sku_id"
                        class="outline-none border border-gray-200 py-2 px-2 rounded" required>
                    <option value="" disabled>Select an option</option>
                    @foreach($product_skus as $product_sku)
                        <option value="{{$product_sku->id}}">{{$product_sku->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col space-y-3">
                <label for="price">Product Price</label>
                <input value="{{$product->price}}" type="number" placeholder="Price" name="price" id="price" required
                       class="outline-none border border-gray-200 py-2 px-2 rounded"/>
            </div>
            <button type="submit" class="max-w-fit px-5 py-2 bg-blue-500 text-white rounded">
                Update Product
            </button>
        </form>
    </div>
@endsection
