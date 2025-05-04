<form class="tab-pane fade show" id="ecommerce" role="tabpanel">
    <div class="mb-3 text-end">
        <button onclick="handlerEcommerceSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="site_delivery_free_threshold" class="form-label">Free Threshold*</label>
            <input type="text" class="form-control" id="site_delivery_free_threshold" name="site_delivery_free_threshold" value="{{ setting("site_delivery_free_threshold") }}">
            <small data-app-alert="site_delivery_free_threshold" class="form-text text-danger"></small>
        </div>
        <div class="col-md-6 mb-3">
            <label for="site_delivery_free_threshold" class="form-label">Code amount*</label>
            <input type="text" class="form-control" id="site_delivery_code_amount" name="site_delivery_code_amount" value="{{ setting("site_delivery_code_amount") }}">
            <small data-app-alert="site_delivery_code_amount" class="form-text text-danger"></small>
        </div>
        <div class="col-md-6 mb-3">
            <label for="site_currency_icon" class="form-label">Currency*</label>
            <select class="form-control select2" id="site_currency_icon" name="site_currency_icon">
                <option value=""></option>
                @foreach(config("list_currency") as $key=>$val)
                    <option @if(setting("site_currency_icon") == $val) selected @endif value="{{ $val }}">{{ $val }}</option>
                @endforeach
            </select>
            <small data-app-alert="site_currency_icon" class="form-text text-danger"></small>
        </div>
        <div class="col-md-6 mb-3">
            <label for="site_currency_icon_position" class="form-label">Currency Position*</label>
            <select class="form-control select2" id="site_currency_icon_position" name="site_currency_icon_position">
                <option value=""></option>
                @foreach(["left","right"] as $val)
                    <option @if(setting("site_currency_icon_position") == $val) selected @endif value="{{ $val }}">{{ strtoupper($val) }}</option>
                @endforeach
            </select>
            <small data-app-alert="site_currency_icon_position" class="form-text text-danger"></small>
        </div>
    </div>
</form>