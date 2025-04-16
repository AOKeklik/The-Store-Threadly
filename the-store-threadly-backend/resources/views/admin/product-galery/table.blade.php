@foreach($galeries as $galery)
    <tr class="table-light font-weight-bold">
        <td>{{ $galery->id }}</td>
        <td><img src="{{ $galery->getImage() }}" style="height: 100px" alt=""></td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.product.galery.edit.view",$galery->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $galery->id }},{{ request('product_id') }})"
                href="#" class="btn btn-sm btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $galery->id }})"
                @if($galery->status == 1) checked @endif
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