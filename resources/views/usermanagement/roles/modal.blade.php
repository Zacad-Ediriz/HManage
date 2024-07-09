<div id="modal" class="modal fade" tabindex="-1" data-bs-backdrop="static"  role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="needs-validation" novalidate data-action="{{ route($route . '.create') }}" method="post"
                enctype="multipart/form-data" id="form">
                @csrf
                <input type="hidden" name="id" id="id">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"> {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span>*</span></label>
                        <input type="text" class="form-control" name="name" id="name"
                            required>

                        <div class="invalid-feedback">
                            {{ __('required_field') }} Name
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fas fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                        Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>
