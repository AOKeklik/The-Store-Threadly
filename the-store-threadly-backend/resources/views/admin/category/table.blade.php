@foreach($categories as $cat)
    <tr class="table-light font-weight-bold">
        <td>{{ $cat->id }}</td>
        <td>
            <span style="margin-left: {{ $cat->depth * 20 }}px;">
                @if($cat->depth > 0)
                    └─
                @endif
                {{ $cat->name }}
            </span>
        </td>
        <td>{{ $cat->slug }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.category.edit.view",$cat->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $cat->id }})"
                href="#" class="btn btn-sm btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $cat->id }})"
                @if($cat->status == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Status" 
                data-off="Status" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                value="Yes"
                data-size="small"
            >
        </td>
    </tr>
@endforeach