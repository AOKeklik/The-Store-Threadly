@foreach($deliveries as $delivery)
    <tr class="table-light font-weight-bold">
        <td>{{ $delivery->id }}</td>
        <td>{{ $delivery->company }}</td>
        <td>{{ $delivery->type }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.delivery.edit.view",$delivery->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $delivery->id }})"
                href="#" class="btn btn-sm btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $delivery->id }},'code')"
                @if($delivery->code == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Code" 
                data-off="Code" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="status" 
                value="Yes"
                data-size="small"
            >
            <input 
                onchange="handlerChange(event,{{ $delivery->id }},'status')"
                @if($delivery->status == 1) checked @endif
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