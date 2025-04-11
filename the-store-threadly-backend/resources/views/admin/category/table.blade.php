@foreach($categories as $cat)
    <tr class="table-light font-weight-bold">
        <td>{{ $cat->id }}</td>
        <td>{{ $cat?->parent->name ?? "-" }}</td>
        <td>{{ $cat->name }}</td>
        <td>{{ $cat->slug }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.category.edit.view",$cat->id) }}" class="btn btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $cat->id }})"
                href="#" class="btn btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $cat->id }})"
                @if($cat->status == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Yes" 
                data-off="No" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                value="Yes"
            >
        </td>
    </tr>
@endforeach