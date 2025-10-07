@extends('layouts.layout')

@section('content')
    
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editUserForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit-user-id" name="id">

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" id="edit-user-name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" id="edit-user-email" name="email" class="form-control" required>
                </div>

                <div class="form-check mb-3">
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="edit-user-is-inactive"
                    name="is_inactive"
                    value="1">
                <label class="form-check-label" for="edit-user-is-inactive">
                    Inactive
                </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-btn');
    const editForm = document.getElementById('editUserForm');
    const userIdInput = document.getElementById('edit-user-id');
    const nameInput = document.getElementById('edit-user-name');
    const emailInput = document.getElementById('edit-user-email');
    const inactiveCheckbox = document.getElementById('edit-user-is-inactive');

    editButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const email = btn.dataset.email;
            const isInactive = btn.dataset.isInactive; // '1' if inactive, '' or undefined if active


            userIdInput.value = id;
            nameInput.value = name;
            emailInput.value = email;
            inactiveCheckbox.checked = (isInactive === '1');

            // Update form action dynamically
            editForm.action = `/users/${id}/update`;
        });
    });
});
</script>




<div class="card shadow-sm border-success">
    <div class="card-body">
        <h2 class="card-title fw-bold text-success">Manage Users</h2>

        <div class="table-responsive"> 
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date Created</th>
                        <th>Last Updated</th>
                        <th>Role</th>
                        <th>Inactive</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td> {{ $user->email }}</td>
                            <td> {{ $user->created_at }}</td>
                            <td> {{ $user->updated_at }}</td>
                            <td> {{ $user->role? $user->role : 'Not Admin' }}</td>
                            <td class="text-center" style="pointer-events:none"><input 
                                type="checkbox" 
                                name="is_inactive" 
                                value="1"
                                {{ $user->is_inactive ? 'checked' : '' }}>
                            </td>
                            <td class="text-center">
                                <button 
                                    class="btn btn-sm btn-outline-primary edit-btn"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                     data-is-inactive="{{ $user->is_inactive ? 1 : '' }}"
                                    data-bs-toggle="modal" 
                                        data-bs-target="#editUserModal">
                                        Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>

@endsection
