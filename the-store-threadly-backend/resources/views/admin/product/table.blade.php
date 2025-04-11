@foreach($products as $product)
    <tr class="table-light font-weight-bold">
        <td>{{ $product->id }}</td>
        <td>
            <img style="height: 100px" src="{{ $product->image() }}" alt="">
        </td>
        <td>{{ $product->title }}</td>
        <td>{{ $product->stock() }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.product.variant.view",[$product->id]) }}" class="btn btn-sm btn-primary">Variant</a>
            <a href="{{ route("admin.product.galery.view",[$product->id]) }}" class="btn btn-sm btn-primary">Galeria</a>
            <a href="{{ route("admin.product.edit.view",[$product->id]) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event, {{ $product->id }})" 
                data-product-id="{{ $product->id }}" 
                href="#" class="btn btn-sm btn-danger" onClick="return confirm('Are you sure?');"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $product->id }})"
                @if($product->status == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Yes" 
                data-off="No" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                data-size="small"
                value="Yes"
            >
        </td>
    </tr>
@endforeach