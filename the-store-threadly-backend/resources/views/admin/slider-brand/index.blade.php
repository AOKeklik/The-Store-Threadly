@extends("admin.layout.app")
@section("title", "Brand Slider")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Brand Slider</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Dashboard</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">                
                            <form>
                                <div class="form-group mb-3">
                                    <img src="https://placehold.co/600x400?text=Hello+World" alt="" style="max-height:250px" class="d-block mx-auto">
                                    <label for="image">Image*</label>
                                    <input onchange="handlerChangeImage(event)" type="file" class="form-control mt_10" id="image" name="image">
                                    <small data-app-alert="image" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="url">Url</label>
                                    <input type="text" class="form-control" id="url" name="url">
                                    <small data-app-alert="url" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <button onclick="handlerSubmit(event)" type="button" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Img</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody data-app-section="table-slider-brand">
                                        @include("admin.slider-brand.table")
                                    </tbody>
                                </table>
                            </div>
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
                    
                const submit=await submitFrom({url:"{{ route('admin.slider.brand.store') }}",formData})
                await fetchTable()

                await resetForm(form)
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

        async function handlerChange (e, id) {
            try {
                e.preventDefault()

                const formData=new FormData()                    
                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                formData.append("id",id)
                formData.append("status",$(e.target).prop("checked") ? 1 : 0)
                    
                const submit=await submitFrom({url:"{{ route('admin.slider.brand.status.update') }}",formData})

                await showNotification(submit)
            }catch(err){
                await showFormErrorMessages(err)
                await showNotification(err)
                redirect(err)
            }finally{
                hideOverlay()
            }
        }

        async function handlerDelete (e, id) {
            try {
                e.preventDefault()

                if(!confirm('Are you sure?')) return

                const formData=new FormData()                    
                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                formData.append("id",id)
                    
                const submit=await submitFrom({url:"{{ route('admin.slider.brand.delete') }}",formData})
                await fetchTable()

                await showNotification(submit)
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

        function fetchTable(){
            $.ajax({
                type:"GET",
                url:"{{ route('admin.slider.brand.section.table.view') }}",
                success:function(res){
                    $("[data-app-section=table-slider-brand]").html(res)
                    reloadJqueryPlugins ()
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON)
                }
            })
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

            $(form)[0].reset()
            $('.snote').summernote('code', '')
            $('.select2').val(null).trigger('change')
            $(form).find("[data-app-alert]").html("")
            $(form).closest("form")
                .find("img")
                .attr("src","https://placehold.co/600x400?text=Hello+World")
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