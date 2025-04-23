@extends("admin.layout.app")
@section("title", "Product Wishlist")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Product Wishlist</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.product.view") }}" class="btn btn-primary"><i class="fas fa-plus"></i> Product</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>User</th>
                                        <th>Product</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody data-app-section="table-wishlist">
                                        @include("admin.product-wishlist.table")
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
<script>
    async function handlerDelete (e, id) {
        try {
            e.preventDefault()

            if(!confirm('Are you sure?')) return

            const formData=new FormData()                    
            const csrf_token=await uptdateCSRFToken()

            formData.append("_token",csrf_token)
            formData.append("id",id)
                
            const submit=await submitFrom({url:"{{ route('admin.wishlist.delete') }}",formData})
            await fetchTable()

            showNotification(submit)
        }catch(err){
            showNotification(err)
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
            url:"{{ route('admin.wishlist.section.table.view') }}",
            success:function(res){
                $("[data-app-section=table-wishlist]").html(res)
                reloadJqueryPlugins ()
            },
            error: function(xhr) {
                console.log(xhr.responseJSON)
            }
        })
    }

    function errorHandler (err) {
        // console.log(err)
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

    function reloadJqueryPlugins () {
        $('.datatable').DataTable()
    }
</script>