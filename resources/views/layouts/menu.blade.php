
<li class="{{ Request::is('products*') ? 'active' : '' }}">
  <a onclick="importFile()" href="#"><i class="fa fa-edit"></i><span>Importar Planilha</span></a>
  {!! Form::open(['style' => 'display: none;', 'url' => '/importExcel', 'id' => 'formFile', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <input type="file" name="arquivo" id="arquivo" style="display: none;" />
  {{ Form::close() }}
</li>

<li class="{{ Request::is('products*') ? 'active' : '' }}">
  <a href="{{ URL::to('exportExcel/xls') }}"><i class="fa fa-edit"></i><span>Exportar XLS</span></a>
</li>

<li class="{{ Request::is('products*') ? 'active' : '' }}">
  <a href="{{ URL::to('exportExcel/xlsx') }}"><i class="fa fa-edit"></i><span>Exportar XLSX</span></a>
</li>

<li class="{{ Request::is('products*') ? 'active' : '' }}">
  <a href="{{ URL::to('exportExcel/csv') }}"><i class="fa fa-edit"></i><span>Exportar CSV</span></a>
</li>
