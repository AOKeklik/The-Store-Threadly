@foreach($variants as $variant)
    <tr class="table-light font-weight-bold">
        <td>{{ $variant->id }}</td>
        <td><img src="{{ $variant->image() }}" style="height: 100px" alt=""></td>
        <td>{!! $variant->price() !!}</td>
        <td>{!! $variant->getAttributeValueByAttributeId(9)->icon() !!}</td>
        <td>{!! $variant->getAttributeValueByAttributeId(12)->icon() !!}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.product.variant.edit.view",$variant->id) }}" class="btn btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $variant->id }},{{ request('product_id') }})"
                href="#" class="btn btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $variant->id }})"
                @if($variant->status == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Yes" 
                data-off="No" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                data-size="medium"
                value="Yes"
            >
        </td>
    </tr>
@endforeach