<form class="tab-pane fade show active" id="general" role="tabpanel">
    <div class="mb-3 text-end">
        <button onclick="handlerGeneralSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="site_name" class="form-label">Name*</label>
            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ setting('site_name') }}">
            <small data-app-alert="site_name" class="form-text text-danger"></small>
        </div>
        <div class="col-md-6 mb-3">
            <label for="site_email" class="form-label">Email*</label>
            <input type="text" class="form-control" id="site_email" name="site_email" value="{{ setting("site_email") }}">
            <small data-app-alert="site_email" class="form-text text-danger"></small>
        </div>
        <div class="col-md-6 mb-3">
            <label for="site_phone" class="form-label">Phone*</label>
            <input type="text" class="form-control" id="site_phone" name="site_phone" value="{{ setting("site_phone") }}">
            <small data-app-alert="site_phone" class="form-text text-danger"></small>
        </div>
        <div class="col-md-6 mb-3">
            <label for="site_address" class="form-label">Address*</label>
            <input type="text" class="form-control" id="site_address" name="site_address" value="{{ setting("site_address") }}">
            <small data-app-alert="site_address" class="form-text text-danger"></small>
        </div>
        <div class="col-md-12 mb-3">
            <label for="site_copy" class="form-label">Copy*</label>
            <input type="text" class="form-control" id="site_copy" name="site_copy" value="{{ setting("site_copy") }}">
            <small data-app-alert="site_copy" class="form-text text-danger"></small>
        </div>
        <div class="col-md-12 mb-4">
            <label for="site_map" class="form-label">Map</label>
            <textarea id="site_map" name="site_map" class="form-control snote" cols="30" rows="10">{{ setting("site_map") }}</textarea>
            <small data-app-alert="site_map" class="form-text text-danger"></small>
        </div>
    </div>
</form>