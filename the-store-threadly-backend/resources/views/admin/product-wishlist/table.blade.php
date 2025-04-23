@foreach($wishlists as $wishlist)
    <tr class="table-light font-weight-bold">
        <td>{{ $wishlist->id }}</td>
        <td>{{ $wishlist->user->name }}</td>
        <td>{{ $wishlist->product->slug }}</td>
        <td class="pt_10 pb_10">
            <a 
                onclick="handlerDelete(event, {{ $wishlist->id }})"
                href="#" class="btn btn-lg btn-danger"
            >Delete</a>
        </td>
    </tr>
@endforeach