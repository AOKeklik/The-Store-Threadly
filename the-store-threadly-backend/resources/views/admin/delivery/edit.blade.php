@extends("admin.layout.app")
@section("title", "Edit Delivery")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Delivery</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.delivery.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Delivery</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <input type="hidden" name="id" id="id" value="{{ $delivery->id }}">
                                <div class="form-group mb-3">
                                    <label for="name">Name*</label>
                                    <input onchange="handlerChangeSlug(event)" type="text" class="form-control" id="name" name="name" value="{{ $delivery->name }}">
                                    <small data-app-alert="name" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Slug*</label>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $delivery->slug }}">
                                    <small data-app-alert="slug" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="company">Company</label>
                                    <select class="form-control select2" id="company" name="company">
                                        <option value=""></option>
                                        @foreach(config('list_delivery_company') as $item)
                                            <option  @if(isset($delivery) && $delivery->company == $item) selected @endif value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <small data-app-alert="company" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="type">Type*</label>
                                    <select class="form-control select2" id="type" name="type">
                                        <option value=""></option>
                                        @foreach(config('list_delivery_type') as $item)
                                            <option @if(isset($delivery) && $delivery->type == $item) selected @endif value="{{ $item }}">{{ strtoupper($item) }}</option>
                                        @endforeach
                                    </select>
                                    <small data-app-alert="type" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="desc">Desc</label>
                                    <textarea type="text" class="form-control" id="desc" name="desc">{{ $delivery->desc }}</textarea>
                                    <small data-app-alert="desc" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="price">Price*</label>
                                    <input type="text" class="form-control" id="price" name="price" value="{{ $delivery->price }}">
                                    <small data-app-alert="price" class="form-text text-danger"></small>
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

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitFrom({url:"{{ route('admin.delivery.update') }}",formData})

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