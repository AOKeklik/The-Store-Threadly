@extends("admin.layout.auth")
@section("title", "Forget")
@section("content")
<section class="section">
    <div class="container container-login">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary border-box">
                    <div class="card-header card-header-auth">
                        <h4 class="text-center">Reset Password</h4>
                    </div>
                    <div class="card-body card-body-auth">
                        <form data-app-form="forget-submit">
                            <div class="form-group">
                                <input name="email" id="email" type="email" class="form-control" placeholder="Email Address" autofocus>
                                <small data-app-alert="email" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <button data-app-btn="forget-submit" type="submit" class="btn btn-primary btn-lg btn-block">
                                    Send Password Reset Link
                                </button>
                            </div>
                            <div class="form-group">
                                <div>
                                    <a href="{{ route("admin.signin.view") }}">
                                        Back to login page
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push("scripts")
    <script>
        $(document).ready(function(){
            $(document)
                .on("click","[data-app-btn=forget-submit]",handlerSubmit)

            async function handlerSubmit (e) {
                try {
                    e.preventDefault()

                    const formData=new FormData()
                    const form = $("[data-app-form=forget-submit]")

                    const csrf_token=await uptdateCSRFToken()

                    formData.append("_token",csrf_token)
                    formData.append("email",form.find("#email").val())
                        
                    const submit=await submitForm(formData)

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

            async function submitForm(formData){
                try {
                    await showOverlay()
                    await delay(1000)

                    const result = await $.ajax({
                        type: "POST",
                        url: "{{ route('admin.forget.submit') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                    });

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
        })
    </script>
@endpush