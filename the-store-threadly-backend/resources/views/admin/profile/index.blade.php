@extends("admin.layout.app")
@section("title", "Profile")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Profile</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form data-app-form="profile-update">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img data-app-img="avatar" src="{{ auth()->user()->image() }}" alt="" class="profile-photo w_100_p">
                                        <input type="file" class="form-control mt_10" id="image" name="image">
                                        <small data-app-alert="image" class="form-text text-danger"></small>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-4">
                                            <label class="form-label">Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
                                            <small data-app-alert="name" class="form-text text-danger"></small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Email *</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                                            <small data-app-alert="email" class="form-text text-danger"></small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                            <small data-app-alert="password" class="form-text text-danger"></small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Retype Password</label>
                                            <input type="password" class="form-control" id="confirm-password" ame="confirm-password">
                                            <small data-app-alert="confirm-password" class="form-text text-danger"></small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label"></label>
                                            <button data-app-btn="profile-update" type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
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
                .on("click","[data-app-btn=profile-update]",handlerSubmit)
                .on("change","[data-app-form=profile-update] [type=file]",handlerChangeImage)

            function handlerChangeImage (e) {
                const imgs = document.querySelectorAll("[data-app-img=avatar]")
                const files = e.target.files

                if(files.length === 0) return

                imgs.forEach(img => {
                    img.setAttribute("src", URL.createObjectURL(files[0]))
                    img.parentElement.style.display = "block"
                })
            }


            async function handlerSubmit (e) {
                try {
                    e.preventDefault()

                    const formData=new FormData()
                    const form = $("[data-app-form=profile-update]")

                    const csrf_token=await uptdateCSRFToken()

                    formData.append("_token",csrf_token)
                    formData.append("image",form.find("#image")[0].files[0] ?? "")
                    formData.append("name",form.find("#name").val())
                    formData.append("email",form.find("#email").val())
                    formData.append("password",form.find("#password").val())
                    formData.append("confirm-password",form.find("#confirm-password").val())
                        
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
                        url: "{{ route('admin.profile.update') }}",
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

                // $(formSelector)[0].reset()
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