@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Produto
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary" style="border-top-color: #00a65a;">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('products.show_fields')
                    <a href="{!! route('products.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
