<form action="{{ route('customers.update') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $data->user_id }}">
    <input type="hidden" name="customer_id" value="{{ $data->customer_id }}">
    <div class="modal-body">
        <div class="mb-3 mt-3">
            <label for="user_name" class="form-label"> Customer Name:</label>
            <input type="text" class="form-control" value="{{ $data->name }}" name="name">
        </div>
        <div class="mb-3 mt-3">
            <label for="phone" class="form-label"> Customer Phone:</label>
            <input type="text" class="form-control" value="{{ $data->phone }}" name="phone">
        </div>

        <div class="mb-3 mt-3">
            <label for="user_email" class="form-label"> Customer email:</label>
            <input type="text" class="form-control" value="{{ $data->email }}" name="email">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

