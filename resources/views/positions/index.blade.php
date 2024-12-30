@extends('layout.index')
@section('home')
<div class="container">
    <h1>Positions</h1>
    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#positionModal">Add Position</button>

    <!-- Table -->
    <table class="table"  id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Position Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($positions as $key => $position)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $position->name }}</td>
                    <td>{{ $position->description }}</td>
                    <td>
                        <button data-id="{{ $position->id }}" class="edit-btn btn btn-warning">Edit</button>
                        <form action="{{ route('positions.destroy', $position->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="positionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('positions.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create/Edit Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')

<script>

$(document).ready(function() {
            $("#table").DataTable();
        });
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        fetch(`/positions/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.querySelector('#name').value = data.name;
                document.querySelector('#description').value = data.description;
                document.querySelector('form').action = `/positions/${id}`;
                document.querySelector('form').innerHTML += '<input type="hidden" name="_method" value="PUT">';
                new bootstrap.Modal(document.querySelector('#positionModal')).show();
            });
    });
});
</script>
@endsection
