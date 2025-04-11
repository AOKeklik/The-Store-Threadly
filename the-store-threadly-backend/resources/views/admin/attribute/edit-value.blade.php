@extends("admin.layout.app")
@section("title", "Edit Child Attribute")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Child Attribute</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.attribute.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Attribute</a>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form data-app-form="attribute-child-update">
                                <input type="hidden" name="id" id="id" value="{{ $attributeValue->id }}">
                                <div data-app-select="select-attribute" class="form-group mb-3">
                                    @include("admin.attribute.select")
                                </div>
                                <div class="form-group mb-3">
                                    <label>Value*</label>
                                    <input type="text" class="form-control" id="value" name="value" value="{{ $attributeValue->value }}">
                                    <small data-app-alert="value" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="icon">Icon</label>
                                    <input type="text" class="form-control" id="icon" name="icon" value="{{ $attributeValue->icon }}">
                                    <small data-app-alert="icon" class="form-text text-danger"></small>
                                </div>
                                <div data-app-btn="attribute-child-update" class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
        $(document).ready(function(){
            $(document)
                .on("click","[data-app-btn=attribute-child-update]",handlerSubmit)


            async function handlerSubmit (e) {
                try {
                    e.preventDefault()

                    const formData=new FormData()
                    const form = $("[data-app-form=attribute-child-update]")

                    const csrf_token=await uptdateCSRFToken()

                    formData.append("_token",csrf_token)
                    formData.append("id",form.find("#id").val())
                    formData.append("attribute_id",form.find("#attribute_id").val())
                    formData.append("value",form.find("#value").val())
                    formData.append("icon",form.find("#icon").val())
                        
                    const submit=await submitFrom({url:"{{ route('admin.attribute.value.update') }}",formData})

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
        })
    </script>
@endpush