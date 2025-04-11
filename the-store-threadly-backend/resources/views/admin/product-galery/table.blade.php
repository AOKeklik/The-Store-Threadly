@foreach($galeries as $galery)
    <tr class="table-light font-weight-bold">
        <td>{{ $galery->id }}</td>
        <td><img src="{{ $galery->image() }}" style="height: 100px" alt=""></td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.product.galery.edit.view",$galery->id) }}" class="btn btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $galery->id }},{{ request('product_id') }})"
                href="#" class="btn btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $galery->id }})"
                @if($galery->status == 1) checked @endif
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