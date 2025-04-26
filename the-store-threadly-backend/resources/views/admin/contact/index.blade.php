@extends("admin.layout.app")
@section("title", "Contact")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Contact</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Dashboard</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-bordered">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody data-app-section="table-contact">
                                @include("admin.contact.table")
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" data-app-section="detail-contact">
                
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
    <script>
        async function handlerShowDetail (e, id) {
            try {
                e.preventDefault()

                await showOverlay();
                await delay(1000)

                await fetchDetail(id)
                await $('#exampleModal1').modal('show')
                await fetchTable()
                await fetchUnread()
            }catch(err){
                await showFormErrorMessages(err)
                await showNotification(err)
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
                    
                const submit=await submitForm({url:"{{ route('admin.contact.delete') }}",formData})
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

        async function submitForm({ url, formData = null, delayMs = 1000 }) {
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
                url:"{{ route('admin.contact.section.table.view') }}",
                success:function(res){
                    $("[data-app-section=table-contact]").html(res)
                    reloadJqueryPlugins ()
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON)
                }
            })
        }

        function fetchUnread(){
            $.ajax({
                type:"GET",
                url:"{{ route('admin.contact.section.unread.view') }}",
                success:function(res){
                    $("[data-app-section=contact-unread]").html(res)
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON)
                }
            })
        }

        function fetchDetail(id){
            $.ajax({
                type:"GET",
                url:`/admin/contact/detail/${id}`,
                success:function(res){
                    $("[data-app-section=detail-contact]").html(res)
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