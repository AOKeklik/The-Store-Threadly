@extends("admin.layout.app")
@section("title", "Edit Product")
@section("content")
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Product</h1>
            <div class="ml-auto">
                <a href="{{ route("admin.product.view") }}" class="btn btn-primary"><i class="fas fa-eye"></i> Product</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form data-app-form="profile-update">
                                <input type="hidden" name="id" id="id" value="{{ request("id") }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-5">
                                            <img src="{{ $product->getImage() }}" alt="" class="w_100_p mb-3">
                                            <label class="form-label m-0">Image</label>
                                            <input onchange="handlerChangeImage(event)" type="file" class="form-control mt_10" id="image" name="image">
                                            <small data-app-alert="image" class="form-text text-danger"></small>
                                        </div>
                                        <div class="mb-5">
                                            <img src="{{ $product->getCover() }}" alt="" class="w_100_p mb-3">
                                            <label for="cover" class="form-label m-0">Cover</label>
                                            <input onchange="handlerChangeImage(event)" type="file" class="form-control mt_10" id="cover" name="cover">
                                            <small data-app-alert="cover" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Category*</label>
                                                <select class="form-control select2" id="category_id" name="category_id">
                                                    <option value=""></option>
                                                    @foreach($categories as $cat)
                                                        <option 
                                                            @if($product->category_id == $cat->id) selected @endif
                                                            value="{{  $cat->id }}"
                                                        >{{  $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small data-app-alert="attribute_id" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="gender" class="form-label">Gender*</label>
                                                <select class="form-control select2" id="gender" name="gender">
                                                    <option value=""></option>
                                                    @foreach(["men","women","kids"] as $gender)
                                                        <option 
                                                            @if($gender == $product->gender) selected @endif
                                                            value="{{  $gender }}"
                                                        >{{  $gender }}</option>
                                                    @endforeach
                                                </select>
                                                <small data-app-alert="gender" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Title*</label>
                                                <input onchange="handlerChangeTitle(event)" type="text" class="form-control" id="title" name="title" value="{{ $product->title }}">
                                                <small data-app-alert="title" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Slug*</label>
                                                <input type="text" class="form-control" id="slug" name="slug" readonly disabled value="{{ $product->slug }}"> 
                                                <small data-app-alert="slug" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Price*</label>
                                                <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}">
                                                <small data-app-alert="price" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Offer Price</label>
                                                <input type="text" class="form-control" id="offer_price" name="offer_price" value="{{ $product->offer_price }}">
                                                <small data-app-alert="offer_price" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-12">
                                                <label class="form-label">Stock</label>
                                                <input type="text" class="form-control" id="stock" name="stock" value="{{ $product->stock }}">
                                                <small data-app-alert="stock" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Sku</label>
                                                <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->sku }}">
                                                <small data-app-alert="sku" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Seo Title</label>
                                                <input type="text" class="form-control" id="seo_title" name="seo_title" value="{{ $product->seo_title }}">
                                                <small data-app-alert="seo_title" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="short_desc" class="form-label">Short Desc</label>
                                                <textarea id="short_desc" name="short_desc" class="form-control" cols="30" rows="10">{{ $product->short_desc }}</textarea>
                                                <small data-app-alert="short_desc" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Seo Desc</label>
                                                <textarea id="seo_desc" name="seo_desc" class="form-control" cols="30" rows="100">{{ $product->seo_desc }}</textarea>
                                                <small data-app-alert="seo_desc" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Desc</label>
                                                <textarea id="desc" name="desc" class="form-control snote" cols="30" rows="10">{{ $product->desc }}</textarea>
                                                <small data-app-alert="desc" class="form-text text-danger"></small>
                                            </div>
                                            <div class="col-12 mb-4">
                                                <label class="form-label"></label>
                                                <button onclick="handlerSubmit(event)" type="submit" class="btn btn-primary">Update</button>
                                            </div>
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
        function handlerChangeTitle (e) {
            $("input[name=slug]").val(
                $(e.target)
                    .val()
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\- ]/g,"")
                    .replace(/[\s-]+/g,"-")
                    .replace(/-$/, "")
            )
        }

        function handlerChangeImage (e) {
            $(e.target)
                .closest("div")
                .find("img")
                .attr("src",URL.createObjectURL(e.target.files[0]))
        }

        async function handlerSubmit (e) {
            try {
                e.preventDefault()

                const form = $(e.target).closest("form")
                const formData=new FormData(form[0])

                const csrf_token=await uptdateCSRFToken()

                formData.append("_token",csrf_token)
                    
                const submit=await submitFrom({url:"{{ route('admin.product.update') }}",formData})

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
        }
    </script>
@endpush