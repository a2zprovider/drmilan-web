</div>
<!-- / Layout page -->
</div> <!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->
<!--/ Layout Content -->
<!-- Include Scripts -->
<!-- BEGIN: Vendor JS-->

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="" action="" method="POST" id="deleteFormModal">
            {!! csrf_field() !!}
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure to want to Delete This Record ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="" action="" method="POST" id="deleteFormModal">
            {!! csrf_field() !!}
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure to want to Delete This Record ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ url('admin/vendor/libs/jquery/jquery40f4.js') }}"></script>
<script src="{{ url('admin/vendor/libs/popper/popper885d.js') }}"></script>
<script src="{{ url('admin/vendor/js/bootstrap0983.js') }}"></script>
<script src="{{ url('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar4d5e.js') }}"></script>
<script src="{{ url('admin/vendor/libs/hammer/hammerc38e.js') }}"> </script>
<script src="{{ url('admin/vendor/libs/i18n/i18n5fec.js') }}"> </script>
<script src="{{ url('admin/vendor/libs/typeahead-js/typeaheada766.js') }}"></script>
<script src="{{ url('admin/vendor/js/menu7d39.js') }}"> </script>

<script src="{{ url('admin/js/mainc3d7.js') }}"></script>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{ url('admin/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ url('admin/js/extended-ui-sweetalert2.js') }}"></script>


@yield('script')

<script>
    tinymce.init({
        selector: '.editor',
        plugins: "powerpaste , code, link, image, emoticons, lists, charmap, table, fullscreen, preview",
        // paste_as_text: true,
        fontsizeselect: true,
        browser_spellcheck: true,
        menubar: true,
        toolbar: 'bold italic underline strikethrough link | formatselect h1 h2 h3 h4 h5 h6 | table hr superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent removeformat code fullscreen preview',
        branding: false,
        protect: [
            /\<\/?(if|endif)\>/g, // Protect <if> & </endif>
            /\<xsl\:[^>]+\>/g, // Protect <xsl:...>
            /\<script\:[^>]+\>/g, // Protect <xsl:...>
            /<\?php.*?\?>/g // Protect php code
        ],
    });
</script>


<script>
    $(document).ready(function() {
        $("#delete-record").click(function() {
            var form = $(this).closest('form');
            Swal.fire({
                title: "Are you sure?",
                text: "All your data will be reset!",
                icon: "warning",
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form[0].reset();
                    Swal.fire('Reset!', '', 'success')
                }
            })
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('li.menu-item.active').parents('.menu-item').addClass('active open');
    });
</script>

</body>

</html>