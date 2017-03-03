@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Produto
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary" style="border-top-color: #00a65a;">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch']) !!}

                        @include('products.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
