@foreach($sliders as $slider)
    <tr class="table-light font-weight-bold">
        <td>{{ $slider->id }}</td>
        <td><img style="height:100px" src="{{ $slider->getImage() }}" alt=""></td>
        <td>{{ $slider->title }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.slider.hero.edit.view",$slider->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $slider->id }})"
                href="#" class="btn btn-sm btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $slider->id }})"
                @if($slider->status == 1) checked @endif
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