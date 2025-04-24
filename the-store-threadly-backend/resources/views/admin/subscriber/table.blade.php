@foreach($subscribers as $subscriber)
    <tr class="table-light font-weight-bold">
        <td>{{ $subscriber->id }}</td>
        <td>{{ $subscriber->ip }}</td>
        <td>{{ $subscriber->email }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.subscriber.edit.view",$subscriber->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $subscriber->id }})"
                href="#" class="btn btn-sm btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $subscriber->id }},'status')"
                @if($subscriber->status == 1) checked @endif
                type="checkbox" 
                data-toggle="toggle" 
                data-on="Status" 
                data-off="Status" 
                data-onstyle="success" 
                data-offstyle="danger" 
                name="" 
                value="Yes"
                data-size="small"
            >
        </td>
    </tr>
@endforeach