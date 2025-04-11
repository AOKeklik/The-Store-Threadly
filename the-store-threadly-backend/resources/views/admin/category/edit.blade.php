@extends("admin.layout.app")
@section("title", "Edit Category")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Category</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.category.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Category</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <input type="hidden" name="id" id="id" value="{{ $category->id }}">
                                <div class="form-group mb-3">
                                    @include("admin.category.select")
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Name*</label>
                                    <input onchange="handlerChangeSlug(event)" type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                                    <small data-app-alert="name" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Slug*</label>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $category->slug }}">
                                    <small data-app-alert="slug" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <button onclick="handlerUpdate(event)" type="button" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push("scripts")
    <script>
        function handlerChangeSlug (e) {
            $("#slug").val(
                $(e.target)
                    .val()
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\- ]/g,"")
                    .replace(/[\s-]+/g,"-")
                    .replace(/-$/, "")
            )
        }
        
        async function handlerUpdate (e) {
            try {
                e.preventDefault()

                const formData=new FormData()
                const form = $(e.target).closest("form")

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                formData.append("id",form.find("#id").val())
                formData.append("name",form.find("#name").val())
                formData.append("slug",form.find("#slug").val())
                formData.append("parent_id",form.find("#parent_id").val())
                    
                const submit=await submitFrom({url:"{{ route('admin.category.update') }}",formData})

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
            // console.log(res)
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