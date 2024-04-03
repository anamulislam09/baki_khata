<form action="{{ route('user.create') }}" method="POST" id="userForm">
    @csrf
    <div class="modal-body">
        <div class="mb-3 mt-3">
            <label for="user_name" class="form-label"> User Name:</label>
            <input type="text" class="form-control" value="" name="name" >
        </div>

        <div class="mb-3 mt-3">
            <label for="phone" class="form-label"> User Phone:</label>
            <input type="text" class="form-control" value="" name="phone" required>
        </div>

        <div class="mb-3 mt-3">
            <label for="user_email" class="form-label"> User email:</label>
            <input type="text" class="form-control" value="" name="email">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>