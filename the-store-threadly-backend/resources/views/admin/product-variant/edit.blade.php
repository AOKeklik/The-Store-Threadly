@extends("admin.layout.app")
@section("title", "Edit Variant")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Variant</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.product.variant.view", $variant->product_id) }}" class="btn btn-primary"><i class="fas fa-eye"></i> Variant</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="form-group mb-3">
                                    <img src="{{ $variant->image() }}" alt="" style="max-height:250px" class="d-block mx-auto">
                                    <input onchange="handlerChangeImage(event)" type="file" class="form-control mt_10" id="image" name="image">
                                    <small data-app-alert="image" class="form-text text-danger"></small>
                                </div>
                                @foreach($attributes as $attribute)
                                    <div class="form-group mb-3">
                                        <label for="attribute_{{ $attribute->id }}">{{ ucfirst($attribute->name) }}</label>
                                        <select class="form-control select2" 
                                            id="attribute_{{ $attribute->id }}" 
                                            name="attributes[{{ $attribute->id }}]"
                                        >
                                            <option value=""></option>
                                            @foreach($attribute->values as $value)
                                                <option 
                                                    @if(in_array($value->id, $variant->attribute_value_ids)) selected @endif 
                                                    value="{{ $value->id }}"
                                                >{{ $value->value }}</option>
                                            @endforeach
                                        </select>
                                        <small data-app-alert="attributes" class="form-text text-danger"></small>
                                    </div>
                                @endforeach
                                <div class="form-group mb-3">
                                    <label for="price">Price*</label>
                                    <input type="text" class="form-control" id="price" name="price" value="{{ $variant->price }}">
                                    <small data-app-alert="price" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="offer_price">Offer Price</label>
                                    <input type="text" class="form-control" id="offer_price" name="offer_price" alue="{{ $variant->offer_price }}">
                                    <small data-app-alert="offer_price" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="stock">Stock</label>
                                    <input type="text" class="form-control" id="stock" name="stock" alue="{{ $variant->stock }}">
                                    <small data-app-alert="stock" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <button onclick="handlerSubmit(event, {{ request('id') }})" type="button" class="btn btn-primary">Submit</button>
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
        function handlerChangeImage (e) {
            $(e.target)
                .closest("form")
                .find("img")
                .attr("src",URL.createObjectURL(e.target.files[0]))
        }

        async function handlerSubmit (e, id) {
            try {
                e.preventDefault()

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                formData.append("id",id)
                    
                const submit=await submitFrom({url:"{{ route('admin.product.variant.update') }}",formData})

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
    </script>
@endpush