@foreach($coupons as $coupon)
    <tr class="table-light font-weight-bold">
        <td>{{ $coupon->id }}</td>
        <td>{{ $coupon->code }}</td>
        <td>{{ $coupon->getExpireDate() }}</td>
        <td>{{ $coupon->getDiscount() }}</td>
        <td class="pt_10 pb_10">
            <a href="{{ route("admin.coupon.edit.view",$coupon->id) }}" class="btn btn-primary">Edit</a>
            <a 
                onclick="handlerDelete(event,{{ $coupon->id }})"
                href="#" class="btn btn-danger"
            >Delete</a>
            <input 
                onchange="handlerChange(event,{{ $coupon->id }})"
                @if($coupon->status == 1) checked @endif
                type="checkbox" data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger" name="" value="Yes">
        </td>
    </tr>
@endforeach