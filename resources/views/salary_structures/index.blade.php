@extends('layout.index')

@section('home')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Salary Structures</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#salaryStructureModal">
            <i class="bi bi-plus-circle"></i> Add New
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($salaryStructures as $key => $salaryStructure)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $salaryStructure->title }}</td>
                    <td>
                        <span class="badge bg-{{ $salaryStructure->type == 'Add' ? 'success' : 'danger' }}">
                            {{ $salaryStructure->type }}
                        </span>
                    </td>
                    <td>
                        <button class="edit-btn btn btn-sm btn-warning" data-id="{{ $salaryStructure->id }}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <form action="{{ route('salary_structures.destroy', $salaryStructure->id) }}" method="POST"
                            style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No salary structures found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="salaryStructureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="salaryStructureForm" method="POST" action="{{ route('salary_structures.store') }}" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add/Edit Salary Structure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter title" required>
                        <div class="invalid-feedback">Title is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="" disabled selected>Select type</option>
                            <option value="Add">Add</option>
                            <option value="Deduct">Deduct</option>
                        </select>
                        <div class="invalid-feedback">Please select a type.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Enable form validation
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Handle edit button click
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/salary_structures/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#title').value = data.title;
                    document.querySelector('#type').value = data.type;
                    document.querySelector('#salaryStructureForm').action = `/salary_structures/${id}`;
                    document.querySelector('#salaryStructureForm').innerHTML += '<input type="hidden" name="_method" value="PUT">';
                    new bootstrap.Modal(document.querySelector('#salaryStructureModal')).show();
                });
        });
    });
</script>
@endsection
