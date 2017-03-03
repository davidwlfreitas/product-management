<table class="table table-responsive" id="products-table">
    <thead>
        <th>Category</th>
        <th>Lm</th>
        <th>Name</th>
        <th>Free Shipping</th>
        <th>Description</th>
        <th>Price</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{!! $product->category !!}</td>
            <td>{!! $product->lm !!}</td>
            <td>{!! $product->name !!}</td>
            <td>{!! $product->free_shipping !!}</td>
            <td>{!! $product->description !!}</td>
            <td>{!! $product->price !!}</td>
            <td>
                {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('products.show', [$product->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('products.edit', [$product->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
