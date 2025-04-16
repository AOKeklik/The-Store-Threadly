@foreach($variantGaleries as $variantGalery)
    <tr class="table-light font-weight-bold">
        <td>{{ $variantGalery->id }}</td>
        <td><img src="{{ $variantGalery->getImage() }}" style="height: 100px" alt=""></td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.product.variant.galery.edit.view",$variantGalery->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $variantGalery->id }},{{ request('variant_id') }})"
                href="#" class="btn btn-sm btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $variantGalery->id }})"
                @if($variantGalery->status == 1) checked @endif
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