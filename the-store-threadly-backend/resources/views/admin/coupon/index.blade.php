@extends("admin.layout.app")
@section("title", "Coupon")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Coupon</h1>
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
                                    <label for="name">Name*</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                    <small data-app-alert="name" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Code*</label>
                                    <input type="text" class="form-control" id="code" name="code">
                                    <small data-app-alert="code" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Quantity</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity">
                                    <small data-app-alert="quantity" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Expire Date</label>
                                    <input type="text" class="form-control datepicker" id="expire_date" name="expire_date" value="">
                                    <small data-app-alert="expire_date" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Min Purchase Amount</label>
                                    <input type="text" class="form-control" id="min_purchase_amount" name="min_purchase_amount">
                                    <small data-app-alert="min_purchase_amount" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="attribute_name">Discount Type*</label>
                                    <select class="form-control select2" id="discount_type" name="discount_type">
                                        <option value=""></option>
                                        <option value="percent">Percent</option>
                                        <option value="amount">Amount</option>
                                    </select>
                                    <small data-app-alert="discount_type" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Discount*</label>
                                    <input type="text" class="form-control" id="discount" name="discount">
                                    <small data-app-alert="discount" class="form-text text-danger"></small>
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
                                        <th>Code</th>
                                        <th>Expire</th>
                                        <th>Discount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody data-app-section="table-coupon">
                                        @include("admin.coupon.table")
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
        async function handlerSubmit (e) {
            try {
                e.preventDefault()

                const formData=new FormData()
                const form = $(e.target).closest("form")

                const csrf_token=await uptdateCSRFToken()

                console.log(form.find("#quantity").val())

                formData.append("_token",csrf_token)
                formData.append("name",form.find("#name").val())
                formData.append("code",form.find("#code").val())
                formData.append("quantity",form.find("#quantity").val())
                formData.append("expire_date",form.find("#expire_date").val())
                formData.append("min_purchase_amount",form.find("#min_purchase_amount").val())
                formData.append("discount_type",form.find("#discount_type").val() ?? "")
                formData.append("discount",form.find("#discount").val())
                    
                const submit=await submitFrom({url:"{{ route('admin.coupon.store') }}",formData})
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
                    
                const submit=await submitFrom({url:"{{ route('admin.coupon.status.update') }}",formData})

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
                    
                const submit=await submitFrom({url:"{{ route('admin.coupon.delete') }}",formData})
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
                url:"{{ route('admin.coupon.section.table.view') }}",
                success:function(res){
                    $("[data-app-section=table-coupon]").html(res)
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