<form action="{{ route('customers.create') }}" method="POST" id="userForm">
    @csrf
    <div class="modal-body">
        <div class="mb-3 mt-3">
            <label for="user_name" class="form-label"> Customer Name:</label>
            <input type="text" class="form-control" value="" placeholder="Enter Customer Name" name="name" >
        </div>

        <div class="mb-3 mt-3">
            <label for="phone" class="form-label"> Customer Phone:</label>
            <input type="text" class="form-control" value="" placeholder="Enter Phone" name="phone" required>
        </div>

        <div class="mb-3 mt-3">
            <label for="user_email" class="form-label"> Customer Email:</label>
            <input type="text" class="form-control" value="" placeholder="Enter Email" name="email">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>