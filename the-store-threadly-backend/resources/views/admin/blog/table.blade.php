@foreach($blogs as $blog)
    <tr class="table-light font-weight-bold">
        <td>{{ $blog->id }}</td>
        <td><img style="height:100px" src="{{ $blog->getImage() }}" alt=""></td>
        <td>{{ $blog->category->name }}</td>
        <td>{{ $blog->title }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.blog.edit.view",$blog->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $blog->id }})"
                href="#" class="btn btn-sm btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $blog->id }},'status')"
                @if($blog->status == 1) checked @endif
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