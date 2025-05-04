@foreach($variants as $variant)
    <tr class="table-light font-weight-bold">
        <td>{{ $variant->id }}</td>
        <td><img src="{{ $variant->getImage() }}" style="height: 100px" alt=""></td>
        <td>{!! $variant->getPrice() !!}</td>
        <td>
            @foreach($variant->attributeValues as $attrValue)
                @if($attrValue->attribute->slug == 'color')
                    {!! $attrValue->getIcon() !!}
                @endif
            @endforeach
        </td>
        
        {{-- Then display size --}}
        <td>
            @foreach($variant->attributeValues as $attrValue)
                @if($attrValue->attribute->slug == 'size')
                    {!! $attrValue->getIcon() !!}
                @endif
            @endforeach
        </td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.product.variant.galery.view",$variant->id) }}" class="btn btn-sm btn-primary">Galery</a>
            <a href="{{ route("admin.product.variant.edit.view",$variant->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $variant->id }},{{ request('product_id') }})"
                href="#" class="btn btn-sm btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $variant->id }})"
                @if($variant->status == 1) checked @endif
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
        </td>
    </tr>
@endforeach