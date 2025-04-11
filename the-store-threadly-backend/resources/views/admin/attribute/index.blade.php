@extends("admin.layout.app")
@section("title", "Attribute")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Attribute</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Dashboard</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="attribute-tab" data-toggle="tab" href="#parent" role="tab" aria-controls="parent" aria-selected="true">Parent Attribute</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="name-tab" data-toggle="tab" href="#child" role="tab" aria-controls="name" aria-selected="false">Child Attribute</a>
                                </li>
                            </ul>
                
                            <!-- Tabs Content -->
                            <div class="tab-content" id="myTabContent">
                                <!-- Attribute Form Tab -->
                                <div class="tab-pane fade show active" id="parent" role="tabpanel" aria-labelledby="parent-tab">
                                    <form data-app-form="attribute-store">
                                        <div class="form-group mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                            <small data-app-alert="name" class="form-text text-danger"></small>
                                        </div>
                                        <div data-app-btn="attribute-store" class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                
                                <!-- Name Form Tab -->
                                <div class="tab-pane fade" id="child" role="tabpanel" aria-labelledby="child-tab">
                                    <form data-app-form="attribute-child-store">
                                        <div data-app-select="select-attribute" class="form-group mb-3">
                                            @include("admin.attribute.select")
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Value*</label>
                                            <input type="text" class="form-control" id="value" name="value">
                                            <small data-app-alert="value" class="form-text text-danger"></small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Icon</label>
                                            <input type="text" class="form-control" id="icon" name="icon">
                                            <small data-app-alert="icon" class="form-text text-danger"></small>
                                        </div>
                                        <div data-app-btn="attribute-child-store" class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody data-app-section="table-attribute">
                                        @include("admin.attribute.table")
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
        $(document).ready(function(){
            $(document)
                .on("click","[data-app-btn=attribute-store]",handlerParentSubmit)
                .on("click","[data-app-btn=attribute-delete]",handlerParentDelete)
                .on("click","[data-app-btn=attribute-child-store]",handlerChildSubmit)
                .on("click","[data-app-btn=attribute-child-delete]",handlerChildDelete)


            async function handlerParentSubmit (e) {
                try {
                    e.preventDefault()

                    const formData=new FormData()
                    const form = $("[data-app-form=attribute-store]")

                    const csrf_token=await uptdateCSRFToken()

                    formData.append("_token",csrf_token)
                    formData.append("name",form.find("#name").val())
                        
                    const submit=await submitFrom({url:"{{ route('admin.attribute.store') }}",formData})
                    await fetchTable()
                    await fetchSelect()

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

            async function handlerParentDelete (e) {
                try {
                    e.preventDefault()

                    const formData=new FormData()

                    const csrf_token=await uptdateCSRFToken()

                    formData.append("_token",csrf_token)
                    formData.append("attribute_id",$(this).data("attribute-id"))
                        
                    const submit=await submitFrom({url:"{{ route('admin.attribute.delete') }}",formData})
                    await fetchTable()
                    await fetchSelect()

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

            async function handlerChildSubmit (e) {
                try {
                    e.preventDefault()

                    const formData=new FormData()
                    const form = $("[data-app-form=attribute-child-store]")

                    const csrf_token=await uptdateCSRFToken()

                    formData.append("_token",csrf_token)
                    formData.append("attribute_id",form.find("#attribute_id").val())
                    formData.append("value",form.find("#value").val())
                    formData.append("icon",form.find("#icon").val())
                        
                    const submit=await submitFrom({url:"{{ route('admin.attribute.value.store') }}",formData})
                    await fetchTable()
                    await fetchSelect()

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

            async function handlerChildDelete (e) {
                try {
                    e.preventDefault()

                    const formData=new FormData()

                    const csrf_token=await uptdateCSRFToken()

                    formData.append("_token",csrf_token)
                    formData.append("attribute_id",$(this).data("attribute-id"))
                    formData.append("attribute_child_id",$(this).data("attribute-child-id"))
                        
                    const submit=await submitFrom({url:"{{ route('admin.attribute.value.delete') }}",formData})
                    await fetchTable()
                    await fetchSelect()

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

            function fetchTable(){
                $.ajax({
                    type:"GET",
                    url:"{{ route('admin.attribute.section.table.view') }}",
                    success:function(res){
                        $("[data-app-section=table-attribute]").html(res)
                        reloadJqueryPlugins ()
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON)
                    }
                })
            }

            function fetchSelect(){
                $.ajax({
                    type:"GET",
                    url:"{{ route('admin.attribute.section.select.view') }}",
                    success:function(res){
                        $("[data-app-select=select-attribute]").html(res)
                        // reloadJqueryPlugins ()
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