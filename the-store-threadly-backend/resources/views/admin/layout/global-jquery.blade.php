<script>
    /* //////////////////////////
                LOGOUT
    // ///////////////////////// */
    $(document).ready(function(){
        $(document)
            .on("click","[data-app-btn=signout-submit]",handlerSubmit)


        async function handlerSubmit (e) {
            try {
                e.preventDefault()

                const formData=new FormData()

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitForm(formData)

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
                    url: "{{ route('admin.signout.submit') }}",
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

        async function redirect(res) {
            // console.log(res);
            if (!res?.redirect) return

            await delay(1000)
            window.location.href = res.redirect
        }
    })
</script>