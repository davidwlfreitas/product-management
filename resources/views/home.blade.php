@extends('layouts.product')

@section('content')
<!--div class="container">
    <div class="row">

      <div style="margin-top: 250px" align="center">A base de produtos está vazia.</div>

    </div>
</div-->
<section class="content-header">
    <h1 class="pull-left">Produtos</h1>
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
              
        </div>
    </div>
</div>
@endsection
