@extends("admin.layout.app")
@section("title", "Page")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Page</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Dashboard</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="settingTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="about-tab" data-toggle="tab" data-target="#about" type="button" role="tab">About</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="terms-tab" data-toggle="tab" data-target="#terms" type="button" role="tab">Terms</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="privacy-tab" data-toggle="tab" data-target="#privacy" type="button" role="tab">Privacy</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cookies-tab" data-toggle="tab" data-target="#cookies" type="button" role="tab">Cookies</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="refunds-tab" data-toggle="tab" data-target="#refunds" type="button" role="tab">Refunds</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="settingTabsContent">
                        <!-- About -->
                        <form class="tab-pane fade show active" id="about" role="tabpanel">
                            <input type="hidden" name="type" id="type" value="about">
                            <div class="mb-3 d-flex justify-content-end">
                                <button onclick="handlerPageSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <img src="{{ $about->getImage() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="image">Image</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="image" name="image">
                                        <small data-app-alert="image" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <img src="{{ $about->getCover() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="cover">Cover</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="cover" name="cover">
                                        <small data-app-alert="cover" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label">Type*</label>
                                            <input type="text" class="form-control" id="type" name="type" value="{{ $about->type }}">
                                            <small data-app-alert="type" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Title*</label>
                                            <input onchange="handlerChangeValue(event)" type="text" class="form-control" id="title" name="title" value="{{ $about->title }}">
                                            <small data-app-alert="title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">Slug*</label>
                                            <input type="text" class="form-control" id="slug" name="slug" readonly disabled value="{{ $about->slug }}">
                                            <small data-app-alert="slug" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="seo_title" class="form-label">Seo Title</label>
                                            <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ $about->seo_title }}">
                                            <small data-app-alert="seo_title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="seo_desc" class="form-label">Seo Desc</label>
                                            <textarea id="seo_desc" name="seo_desc" class="form-control" cols="30" rows="10">{{ $about->seo_desc }}</textarea>
                                            <small data-app-alert="seo_desc" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="desc" class="form-label">Desc</label>
                                            <textarea id="desc" name="desc" class="form-control snote" cols="30" rows="10">{{ $about->desc }}</textarea>
                                            <small data-app-alert="desc" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Terms -->
                        <form class="tab-pane fade show" id="terms" role="tabpanel">
                            <input type="hidden" name="type" id="type" value="terms">
                            <div class="mb-3 d-flex justify-content-end">
                                <button onclick="handlerPageSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <img src="{{ $terms->getImage() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="image">Image</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="image" name="image">
                                        <small data-app-alert="image" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <img src="{{ $terms->getCover() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="cover">Cover</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="cover" name="cover">
                                        <small data-app-alert="cover" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label">Type*</label>
                                            <input type="text" class="form-control" id="type" name="type" value="{{ $terms->type }}">
                                            <small data-app-alert="type" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Title*</label>
                                            <input onchange="handlerChangeValue(event)" type="text" class="form-control" id="title" name="title" value="{{ $terms->title }}">
                                            <small data-app-alert="title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">Slug*</label>
                                            <input type="text" class="form-control" id="slug" name="slug" readonly disabled value="{{ $terms->slug }}">
                                            <small data-app-alert="slug" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="seo_title" class="form-label">Seo Title</label>
                                            <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ $terms->seo_title }}">
                                            <small data-app-alert="seo_title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="seo_desc" class="form-label">Seo Desc</label>
                                            <textarea id="seo_desc" name="seo_desc" class="form-control" cols="30" rows="10">{{ $terms->seo_desc }}</textarea>
                                            <small data-app-alert="seo_desc" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="desc" class="form-label">Desc</label>
                                            <textarea id="desc" name="desc" class="form-control snote" cols="30" rows="10">{{ $terms->desc }}</textarea>
                                            <small data-app-alert="desc" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Privacy -->
                        <form class="tab-pane fade show" id="privacy" role="tabpanel">
                            <input type="hidden" name="type" id="type" value="privacy">
                            <div class="mb-3 d-flex justify-content-end">
                                <button onclick="handlerPageSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <img src="{{ $privacy->getImage() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="image">Image</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="image" name="image">
                                        <small data-app-alert="image" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <img src="{{ $privacy->getCover() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="cover">Cover</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="cover" name="cover">
                                        <small data-app-alert="cover" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label">Type*</label>
                                            <input type="text" class="form-control" id="type" name="type" value="{{ $privacy->type }}">
                                            <small data-app-alert="type" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Title*</label>
                                            <input onchange="handlerChangeValue(event)" type="text" class="form-control" id="title" name="title" value="{{ $privacy->title }}">
                                            <small data-app-alert="title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">Slug*</label>
                                            <input type="text" class="form-control" id="slug" name="slug" readonly disabled value="{{ $privacy->slug }}">
                                            <small data-app-alert="slug" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="seo_title" class="form-label">Seo Title</label>
                                            <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ $privacy->seo_title }}">
                                            <small data-app-alert="seo_title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="seo_desc" class="form-label">Seo Desc</label>
                                            <textarea id="seo_desc" name="seo_desc" class="form-control" cols="30" rows="10">{{ $privacy->seo_desc }}</textarea>
                                            <small data-app-alert="seo_desc" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="desc" class="form-label">Desc</label>
                                            <textarea id="desc" name="desc" class="form-control snote" cols="30" rows="10">{{ $privacy->desc }}</textarea>
                                            <small data-app-alert="desc" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Cookies -->
                        <form class="tab-pane fade show" id="cookies" role="tabpanel">
                            <input type="hidden" name="type" id="type" value="cookies">
                            <div class="mb-3 d-flex justify-content-end">
                                <button onclick="handlerPageSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <img src="{{ $cookies->getImage() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="image">Image</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="image" name="image">
                                        <small data-app-alert="image" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <img src="{{ $cookies->getCover() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="cover">Cover</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="cover" name="cover">
                                        <small data-app-alert="cover" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label">Type*</label>
                                            <input type="text" class="form-control" id="type" name="type" value="{{ $cookies->type }}">
                                            <small data-app-alert="type" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Title*</label>
                                            <input onchange="handlerChangeValue(event)" type="text" class="form-control" id="title" name="title" value="{{ $cookies->title }}">
                                            <small data-app-alert="title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">Slug*</label>
                                            <input type="text" class="form-control" id="slug" name="slug" readonly disabled value="{{ $cookies->slug }}">
                                            <small data-app-alert="slug" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="seo_title" class="form-label">Seo Title</label>
                                            <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ $cookies->seo_title }}">
                                            <small data-app-alert="seo_title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="seo_desc" class="form-label">Seo Desc</label>
                                            <textarea id="seo_desc" name="seo_desc" class="form-control" cols="30" rows="10">{{ $cookies->seo_desc }}</textarea>
                                            <small data-app-alert="seo_desc" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="desc" class="form-label">Desc</label>
                                            <textarea id="desc" name="desc" class="form-control snote" cols="30" rows="10">{{ $cookies->desc }}</textarea>
                                            <small data-app-alert="desc" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Refunds -->
                        <form class="tab-pane fade show" id="refunds" role="tabpanel">
                            <input type="hidden" name="type" id="type" value="refunds">
                            <div class="mb-3 d-flex justify-content-end">
                                <button onclick="handlerPageSubmit(event)" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <img src="{{ $refunds->getImage() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="image">Image</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="image" name="image">
                                        <small data-app-alert="image" class="form-text text-danger"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <img src="{{ $refunds->getCover() }}" alt="" style="max-height:250px;object-fit: cover;" class="d-block mx-auto w-100">
                                        <label class="m-0" for="cover">Cover</label>
                                        <input onchange="handlerChangeImage(event)" type="file" class="form-control" id="cover" name="cover">
                                        <small data-app-alert="cover" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label">Type*</label>
                                            <input type="text" class="form-control" id="type" name="type" value="{{ $refunds->type }}">
                                            <small data-app-alert="type" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Title*</label>
                                            <input onchange="handlerChangeValue(event)" type="text" class="form-control" id="title" name="title" value="{{ $refunds->title }}">
                                            <small data-app-alert="title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">Slug*</label>
                                            <input type="text" class="form-control" id="slug" name="slug" readonly disabled value="{{ $refunds->slug }}">
                                            <small data-app-alert="slug" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="seo_title" class="form-label">Seo Title</label>
                                            <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ $refunds->seo_title }}">
                                            <small data-app-alert="seo_title" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="seo_desc" class="form-label">Seo Desc</label>
                                            <textarea id="seo_desc" name="seo_desc" class="form-control" cols="30" rows="10">{{ $refunds->seo_desc }}</textarea>
                                            <small data-app-alert="seo_desc" class="form-text text-danger"></small>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label for="desc" class="form-label">Desc</label>
                                            <textarea id="desc" name="desc" class="form-control snote" cols="30" rows="10">{{ $refunds->desc }}</textarea>
                                            <small data-app-alert="desc" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

        function handlerChangeValue (e) {
            $(e.target).closest("form").find("input#slug").val(
                $(e.target)
                    .val()
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\- ]/g,"")
                    .replace(/[\s-]+/g,"-")
                    .replace(/-$/, "")
            )
        }

        async function handlerPageSubmit (e) {
            try {
                e.preventDefault()

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitFrom({url:"{{ route('admin.page.update') }}",formData})

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