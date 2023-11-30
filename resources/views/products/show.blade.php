@extends('app')
@section('content')
    <div class="flex flex-col py-10">
        <div class="flex flex-col w-full shadow border rounded px-5 py-2 space-y-2 ">
            <h1 class="font-bold text-lg">{{$product->name}}</h1>
            <h3> {{$product->sku->name}} @ {{$product->price}}</h3>
            <a href="{{url("products/{$product->id}/edit")}}" class="bg-blue-500 py-2 px-4 text-white max-w-fit rounded">
                Edit Product
            </a>
        </a>
    </div>
@endsection
