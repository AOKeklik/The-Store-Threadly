@extends("admin.layout.app")
@section("title", "Setting")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Setting</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Dashboard</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="settingTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-toggle="tab" data-target="#general" type="button" role="tab">General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="image-tab" data-toggle="tab" data-target="#image" type="button" role="tab">Images</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="link-tab" data-toggle="tab" data-target="#link" type="button" role="tab">Links</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="settingTabsContent">
                        <!-- General Settings -->
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
                                <div class="col-md-6 mb-3">
                                    <label for="site_delivery_charge" class="form-label">Delivery*</label>
                                    <input type="text" class="form-control" id="site_delivery_charge" name="site_delivery_charge" value="{{ setting("site_delivery_charge") }}">
                                    <small data-app-alert="site_delivery_charge" class="form-text text-danger"></small>
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
                                <div class="col-md-6 mb-3">
                                    <label for="site_copy" class="form-label">Copy*</label>
                                    <input type="text" class="form-control" id="site_copy" name="site_copy" value="{{ setting("site_copy") }}">
                                    <small data-app-alert="site_copy" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </form>

                        {{-- Images --}}
                        <form class="tab-pane fade" id="image" role="tabpanel">
                            <div class="mb-3 text-end">
                                <button onclick="handlerImageSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <img style="max-width: 250px" src="{{ asset("uploads/setting") }}/{{ setting("site_favicon") }}" alt="">
                                </div>
                                <label for="site_favicon" class="form-label">Favicon*</label>
                                <input onchange="handlerChangeImage(event)" class="form-control" type="file" id="site_favicon" name="site_favicon">
                                <small data-app-alert="site_favicon" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <img style="max-width: 250px" src="{{ asset("uploads/setting") }}/{{ setting("site_logo") }}" alt="">
                                </div>
                                <label for="site_logo" class="form-label">Logo*</label>
                                <input onchange="handlerChangeImage(event)" class="form-control" type="file" id="site_logo" name="site_logo">
                                <small data-app-alert="site_logo" class="form-text text-danger"></small>
                            </div>
                        </form>

                        {{-- Links --}}
                        <form class="tab-pane fade" id="link" role="tabpanel">
                            <div class="mb-3 text-end">
                                <button onclick="handlerLinkSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="mb-3">
                                <label for="link_facebook" class="form-label">Faceboo*</label>
                                <input type="text" class="form-control" id="link_facebook" name="link_facebook" value="{{ setting("link_facebook") }}">
                                <small data-app-alert="link_facebook" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="link_linkedin" class="form-label">Linkedin*</label>
                                <input type="text" class="form-control" id="link_linkedin" name="link_linkedin" value="{{ setting("link_linkedin") }}">
                                <small data-app-alert="link_linkedin" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="link_twitter" class="form-label">Twitter*</label>
                                <input type="text" class="form-control" id="link_twitter" name="link_twitter" value="{{ setting("link_twitter") }}">
                                <small data-app-alert="link_twitter" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="link_instagram" class="form-label">Instagram*</label>
                                <input type="text" class="form-control" id="link_instagram" name="link_instagram" value="{{ setting("link_instagram") }}">
                                <small data-app-alert="link_instagram" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="link_youtube" class="form-label">Youtube*</label>
                                <input type="text" class="form-control" id="link_youtube" name="link_youtube" value="{{ setting("link_youtube") }}">
                                <small data-app-alert="link_youtube" class="form-text text-danger"></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push("scripts")
    <script>
        function handlerChangeImage (e) {
            $(e.target)
                .closest("div")
                .find("img")
                .attr("src",URL.createObjectURL(e.target.files[0]))
        }

        async function handlerGeneralSubmit (e) {
            try {
                e.preventDefault()

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitFrom({url:"{{ route('admin.setting.general.update') }}",formData})

                await showNotification(submit)
                resetForm(form)
            }catch(err){
                await showFormErrorMessages(err)
                await showNotification(err)
                redirect(err)
            }finally{
                hideOverlay()
            }
        }

        async function handlerImageSubmit (e) {
            try {
                e.preventDefault()

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitFrom({url:"{{ route('admin.setting.image.update') }}",formData})

                await showNotification(submit)
                resetForm(form)
            }catch(err){
                await showFormErrorMessages(err)
                await showNotification(err)
                redirect(err)
            }finally{
                hideOverlay()
            }
        }

        async function handlerLinkSubmit (e) {
            try {
                e.preventDefault()

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitFrom({url:"{{ route('admin.setting.link.update') }}",formData})

                await showNotification(submit)
                resetForm(form)
            }catch(err){
                await showFormErrorMessages(err)
                await showNotification(err)
                redirect(err)
            }finally{
                hideOverlay()
            }
        }


        async function submitFrom({ url, formData = null, delayMs = 1000 }) {
            try {
                await showOverlay();
                if (delayMs) await delay(delayMs)

                const result = await $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                })

                return result
            } catch (err) {
                errorHandler(err)
            }
        }

        function errorHandler (err) {
            if (err.status === 422)
                    throw { form_message: err.responseJSON.message }

            throw { 
                error_message: err.responseJSON.message, 
                ...(err.responseJSON?.redirect && { redirect: err.responseJSON.redirect })
            }
        }
        
        async function uptdateCSRFToken() {
            try {
                const res = await $.get("{{ route('csrf.token.refresh') }}")
                return res.token
            } catch (error) {
                throw { message: "Failed to get CSRF token." }
            }
        }

        function showNotification(res){
            console.log(res)
            if(!res?.error_message && !res?.message) return

            iziToast.show({
                title: res?.error_message || res?.message,
                position: "topRight",
                color: res?.error_message
                ? "red" 
                : "green"
            })
        }

        function showOverlay(){
            $('.overlay-container').removeClass('d-none')
            $('.overlay').addClass('active')
        }

        function hideOverlay(){
            $('.overlay-container').addClass('d-none');
            $('.overlay').removeClass('active')
        }

        function delay(ms) {
            return new Promise(resolve => setTimeout(resolve, ms))
        }

        function resetForm(form) {
            $("[data-app-alert]").prev().removeClass("is-invalid")
            $(form).find("[data-app-alert]").html("")
        }

        async function redirect(res) {
            // console.log(res);
            if (!res?.redirect) return

            await delay(1000)
            window.location.href = res.redirect
        }

        function showFormErrorMessages(res) {
            // console.log(res)
            if(!res.form_message) return 

            $("[data-app-alert]").html("")
            $("[data-app-alert]").prev().removeClass("is-invalid")

            Object.keys(res.form_message).forEach(key => {
                const message = res.form_message[key][0]
                $("[data-app-alert="+key+"]").html(message)
                $("[data-app-alert="+key+"]").prev().addClass("is-invalid")
            })
        }

        function reloadJqueryPlugins () {
            $('.datatable').DataTable()

            $('[data-toggle="toggle"]').each(function () {
                const $toggle = $(this)
                $toggle.bootstrapToggle()
            })
        }
    </script>
@endpush