@extends('layouts.app')

<script type="text/javascript">
  function importFile(){
      $('#arquivo').trigger('click');
      $('#arquivo').change(function() {
        $('#formFile').submit();
      });
  }
</script>

@section('content')
    <section class="content-header">
        @if (!Auth::guest())
            <h1 class="pull-center" style="text-align: center;">Produtos</h1>
        @else
            <h1 class="pull-left">Produtos</h1>
            <h1 class="pull-right">
              <a name="btnExportXls" class="btn btn-primary pull-right" style="background-color: #228B22; margin: -10px 3px 5px;" href="{{ URL::to('exportExcel/xls') }}">Exportar XLS</a>
            </h1>
            <h1 class="pull-right">
              <a name="btnExportXlsx" class="btn btn-primary pull-right" style="background-color: #228B22; margin: -10px 3px 5px;" href="{{ URL::to('exportExcel/xlsx') }}">Exportar XLSX</a>
            </h1>
            <h1 class="pull-right">
              <a name="btnExportCsv" class="btn btn-primary pull-right" style="background-color: #228B22; margin: -10px 3px 5px;" href="{{ URL::to('exportExcel/csv') }}">Exportar CSV</a>
            </h1>
            <h1 class="pull-right">
              {!! Form::open(['url' => '/importExcel', 'id' => 'formFile', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                 <input type="file" name="arquivo" id="arquivo" style="display: none;" />
                 <a class="btn btn-primary pull-right" name="importFile"
                    style="background-color: #228B22; margin: -10px 3px 5px;"
                    onclick="importFile()"
                    href="#">Importar Planilha
                </a>
                <input type="submit" name="btnSubmit" id="btnSubmit" style="display: none;" />
              {{ Form::close() }}
            </h1>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary" style="border-top-color: #00a65a;">
            <div class="box-body">
                    @include('products.table')
            </div>
        </div>
        @if (Session::has('message'))
          <div align="center">{{ Session::get('message') }}</div>
        @endif
    </div>
@endsection
