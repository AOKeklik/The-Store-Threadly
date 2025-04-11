</div>
</div>

<!--=============================
            LOADER
==============================-->
<div class="overlay-container d-none">
    <div class="overlay">
        <span class="loader"></span>
    </div>
</div>
<!--=============================
            LOADER
==============================-->

<script src="{{ asset("dist/js/scripts.js") }}"></script>
<script src="{{ asset("dist/js/custom.js") }}"></script>


<!-- Session Messages -->
@if(Session::has("error"))
    <script>
            iziToast.show({
            title: "{{ Session::get("error") }}",
            position: "topRight",
            color: "red"
        })
    </script>
@endif
@if(Session::has("success"))
    <script>
            iziToast.show({
            title: "{{ Session::get("success") }}",
            position: "topRight",
            color: "green"
        })
    </script>
@endif


@include("admin.layout.global-jquery")    
@stack("scripts")

</body>
</html>