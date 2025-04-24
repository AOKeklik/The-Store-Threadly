@extends("admin.layout.app")
@section("title", "Edit Subscriber")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Subscriber</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.subscriber.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Subscriber</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form>
                        <input type="hidden" id="id" name="id" value="{{ request("id") }}">
                        <div class="form-group mb-3">
                            <label for="ip">Ip*</label>
                            <input type="text" class="form-control" id="ip" name="ip" value="{{ $subscriber->ip }}">
                            <small data-app-alert="ip" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email*</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ $subscriber->email }}">
                            <small data-app-alert="email" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <button onclick="handlerSubmit(event)" type="button" class="btn btn-primary">Submit</button>
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
        async function handlerSubmit (e) {
            try {
                e.preventDefault()

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitFrom({url:"{{ route('admin.subscriber.update') }}",formData})

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