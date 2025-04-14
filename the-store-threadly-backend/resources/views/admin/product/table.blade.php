@foreach($products as $product)
    <tr class="table-light font-weight-bold">
        <td>{{ $product->id }}</td>
        <td>
            <img style="height: 100px" src="{{ $product->getImage() }}" alt="">
        </td>
        <td>{{ $product->title }}</td>
        <td>{{ $product->getStock() }}</td>
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
                onchange="handlerChange(event,{{ $product->id }},'status')"
                @if($product->status == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Status" 
                data-off="Status" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                data-size="small"
                value="Yes"
            >
            <input 
                onchange="handlerChange(event,{{ $product->id }},'is_new')"
                @if($product->is_new == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="New" 
                data-off="New" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                data-size="small"
                value="Yes"
            >
            <input 
                onchange="handlerChange(event,{{ $product->id }},'is_featured')"
                @if($product->is_featured == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Featured" 
                data-off="Featured" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                data-size="small"
                value="Yes"
            >
            <input 
                onchange="handlerChange(event,{{ $product->id }},'is_bestseller')"
                @if($product->is_bestseller == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Bestseller" 
                data-off="Bestseller" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                data-size="small"
                value="Yes"
            >
        </td>
    </tr>
@endforeach