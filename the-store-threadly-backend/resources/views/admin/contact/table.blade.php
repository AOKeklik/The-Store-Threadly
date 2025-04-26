@foreach($contacts as $contact)
    <tr 
        class="table-light"
        style="@if($contact->is_viewed == 0) font-weight:bolder;color:red; @endif"
    >
        <td>{{ $contact->id }}</td>
        <td>{{ $contact->name }}</td>
        <td>{{ $contact->email }}</td>
        <td class="pt_10 pb_10">
            <a 
                onclick="handlerShowDetail(event,{{ $contact->id }})"
                href="#"  class="btn btn-sm btn-primary"
            ><i class="fa fa-eye"></i></a>
            <a 
                onclick="handlerDelete(event,{{ $contact->id }})"
                href="#" class="btn btn-sm btn-danger"
            ><i class="fa fa-trash"></i></a>
        </td>
    </tr>
@endforeach