@foreach($attributes as $attr)
    <tr class="table-light font-weight-bold">
        <td>{{ $attr->id }}</td>
        <td>{{ $attr->name }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.attribute.edit.view",[$attr->id]) }}" class="btn btn-primary">Edit</a>
            <a 
                data-app-btn="attribute-delete" 
                data-attribute-id="{{ $attr->id }}" 
                href="#" class="btn btn-danger" onClick="return confirm('Are you sure?');"
            >Delete</a>
        </td>
    </tr>
    @foreach($attr->values as $val)
        <tr>
            {{-- <td>{{ $loop->iteration }}</td> --}}
            <td>{{ $val->id }}</td>
            <td>{!! $val->icon() !!} {{ $val->value }}</td>
            <td>
                <a href="{{ route("admin.attribute.value.edit.view",[$val->id]) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                data-app-btn="attribute-child-delete" 
                data-attribute-id="{{$attr->id }}" 
                data-attribute-child-id="{{ $val->id }}" 
                href="#" class="btn  btn-sm btn-danger" onClick="return confirm('Are you sure?');"
            >Delete</a>
            </td>
        </tr>
    @endforeach
@endforeach