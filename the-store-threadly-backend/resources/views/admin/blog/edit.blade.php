@extends("admin.layout.app")
@section("title", "Edit Blog")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Blog</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.blog.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Blog</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form class="row">
                        <input type="hidden" id="id" name="id" value="{{ request("id") }}">
                        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <img src="{{ $blog->getImage() }}" alt="" style="max-height:250px;width:100%" class="d-block mx-auto">
                                <label for="image">Image</label>
                                <input onchange="handlerChangeImage(event)" type="file" class="form-control mt_10" id="image" name="image">
                                <small data-app-alert="image" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12  form-group mb-3">
                                    <label for="category_id">Category*</label>
                                    <select class="form-control select2" id="category_id" name="category_id">
                                        <option value=""></option>
                                        @foreach($categories as $cat)
                                            <option @if($blog->category->id == $cat->id) selected @endif value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <small data-app-alert="category_id" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="title">Title*</label>
                                    <input onchange="handlerChangeValue(event)" type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}">
                                    <small data-app-alert="title" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="name">Slug*</label>
                                    <input type="text" class="form-control" id="slug" name="slug" readonly disabled value="{{ $blog->slug }}">
                                    <small data-app-alert="slug" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-12 form-group mb-4">
                                    <label class="form-label">Desc</label>
                                    <textarea id="desc" name="desc" class="form-control snote" cols="30" rows="10">{{ $blog->desc }}</textarea>
                                    <small data-app-alert="desc" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="seo_title">Seo Title</label>
                                    <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ $blog->seo_title }}">
                                    <small data-app-alert="seo_title" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-6 form-group mb-4">
                                    <label for="seo_desc" class="form-label">Seo Desc</label>
                                    <textarea id="seo_desc" name="seo_desc" class="form-control" cols="30" rows="10">{{ $blog->seo_desc }}</textarea>
                                    <small data-app-alert="seo_desc" class="form-text text-danger"></small>
                                </div>
                                <div class="col-md-12 form-group">
                                    <button onclick="handlerSubmit(event)" type="button" class="btn btn-primary">Submit</button>
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

        function handlerChangeImage (e) {
            $(e.target)
                .closest("form")
                .find("img")
                .attr("src",URL.createObjectURL(e.target.files[0]))
        }

        async function handlerSubmit (e) {
            try {
                e.preventDefault()

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitFrom({url:"{{ route('admin.blog.update') }}",formData})

                await showNotification(submit)
                redirect(submit)
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
            console.log(err)
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
            // console.log(res)
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

        function resetForm(formSelector) {
            $("[data-app-alert]").prev().removeClass("is-invalid")

            $(formSelector)[0].reset()
            $(formSelector).find("[data-app-alert]").html("")
        }

        async function redirect(res) {
            // console.log(res);
            if (!res?.redirect) return

            await delay(1000)
            window.location.href = res.redirect
        }

        function showFormErrorMessages(res) {
            if(!res.form_message) return 

            $("[data-app-alert]").html("")
            $("[data-app-alert]").prev().removeClass("is-invalid")

            Object.keys(res.form_message).forEach(key => {
                const message = res.form_message[key][0]
                $("[data-app-alert*="+key+"]").html(message)
                $("[data-app-alert*="+key+"]").prev().addClass("is-invalid")
            })
        }

        function reloadJqueryPlugins () {
            $('.datatable').DataTable()
        }
    </script>
@endpush