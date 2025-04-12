@foreach($attributes as $attr)
    <tr class="table-light font-weight-bold">
        <td>{{ $attr->id }}</td>
        <td>{{ $attr->name }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.attribute.edit.view",$attr->id) }}" class="btn btn-primary">Edit</a>
            <a 
                onclick="handlerParentDelete(event,{{ $attr->id }})"
                href="#" class="btn btn-danger"
            >Delete</a>
        </td>
    </tr>
    @foreach($attr->attributeValues as $val)
        <tr>
            {{-- <td>{{ $loop->iteration }}</td> --}}
            <td>{{ $val->id }}</td>
            <td>{!! $val->getIcon() !!} {{ $val->value }}</td>
            <td>
                <a href="{{ route("admin.attribute.value.edit.view",$val->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerChildDelete(event,{{$attr->id }},{{ $val->id }})"
                href="#" class="btn  btn-sm btn-danger" onClick="return confirm('Are you sure?');"
            >Delete</a>
            </td>
        </tr>
    @endforeach
@endforeach