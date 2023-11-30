@extends('app')
@section('content')
    <div class="flex flex-col w-full py-10 space-y-2">
        <div class="flex flex-row w-full space-x-2 justify-between">
            <h1>Products List ({{$products->total()}})</h1>
            <a href="{{url('/products/create')}}" class="bg-blue-500 max-w-fit px-4 py-2 rounded text-white">
                Create Product
            </a>
        </div>
        @if($products->total() > 0)
            <ul class="flex flex-col w-full space-y-3">
                @foreach($products as $product)
                    <a href="{{url('/products/'.$product->id)}}" class="flex flex-col w-full shadow border rounded px-5 py-2">
                        <h1 class="font-bold text-lg">{{$product->name}}</h1>
                        <h3> {{$product->sku->name}} @ {{$product->price}}</h3>
                    </a>
                @endforeach
            </ul>
        @else
            <div class="flex flex-col w-full items-center justify-center h-32">
                <span>No products found!</span>
            </div>
        @endif
        {{$products->links()}}
    </div>
@endsection
