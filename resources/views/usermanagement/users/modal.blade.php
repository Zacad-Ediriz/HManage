<div id="modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" id="form">
                @csrf
                <input type="hidden" name="id" id="id">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ __('messages.modal_edit') }} {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row col-12">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name">
                                <small class="errors text-danger"></small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email">
                                <small class="errors text-danger"></small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role <span>*</span></label>
                                <select class="form-control modalselect2" name="role" id="role">
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small class="errors text-danger"></small>
                            </div>
                        </div>




                        <div class="col-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span>*</span></label>
                                <input type="password" class="form-control" name="password" id="password">
                                <small class="errors text-danger"></small>
                            </div>
                        </div>



                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="fas fa-times"></i> {{ __('messages.btn_close') }}</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                        {{ __('messages.btn_update') }}</button>
                </div>

            </form>
        </div>
    </div>
</div>
