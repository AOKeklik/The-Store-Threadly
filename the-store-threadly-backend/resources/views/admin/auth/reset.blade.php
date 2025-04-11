@extends("admin.layout.auth")
@section("title", "Reset")
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
                        <form data-app-form="reset-submit" method="POST">
                            <input type="hidden" id="email" name="email" value="{{ request("email") }}">
                            <input type="hidden" id="token" name="token" value="{{ request("token") }}">
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autofocus>
                                <small data-app-alert="password" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Retype Password" >
                                <small data-app-alert="confirm-password" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <button data-app-btn="reset-submit" type="submit" class="btn btn-primary btn-lg btn-block">
                                    Submit
                                </button>
                            </div>
                            <div class="form-group">
                                <div>
                                    <a href="{{ route("admin.reset.view") }}">
                                        Back to the reset Page
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
                .on("click","[data-app-btn=reset-submit]",handlerSubmit)


            async function handlerSubmit (e) {
                try {
                    e.preventDefault()

                    const formData=new FormData()
                    const form = $("[data-app-form=reset-submit]")

                    const csrf_token=await uptdateCSRFToken()

                    formData.append("_token",csrf_token)
                    formData.append("password",form.find("#password").val())
                    formData.append("confirm-password",form.find("#confirm-password").val())
                    formData.append("email",form.find("#email").val())
                    formData.append("token",form.find("#token").val())
                        
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
                        url: "{{ route('admin.reset.submit') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                    });

                    return result
                } catch (err) {
                    if (err.status === 422)
                        throw { form_message: err.responseJSON.message }

                    throw { 
                        error_message: err.responseJSON.message, 
                        ...(err.responseJSON?.redirect && { redirect: err.responseJSON.redirect })
                    }
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