<style>
    @media only screen and (max-width: 600px) {
        .menubar {
            display: flex;
            justify-content: space-between;
        }

        .shop_name a {
            font-size: 12px !important;
        }

        .form label {
            font-size: 13px !important;
        }

        .form input {
            font-size: 13px !important;
        }
        .form button {
            font-size: 13px !important;
        }
    }

    @media only screen and (min-width: 600px) {
        .menubar {
            display: flex;
            justify-content: space-between;
        }

        .shop_name a {
            font-size: 12px !important;
        }

        .form label {
            font-size: 13px !important;
        }

        .form input {
            font-size: 13px !important;
        }
        .form button {
            font-size: 13px !important;
        }
    }

    @media only screen and (min-width: 768px) {
        .menubar {
            display: flex;
            justify-content: space-between;
        }

        .shop_name a {
            font-size: 13px !important;
        }

        .form label {
            font-size: 14px !important;
        }

        .form input {
            font-size: 14px !important;
        }
        .form button {
            font-size: 14px !important;
        }
    }

    @media only screen and (min-width: 992px) {
        .menubar {
            display: flex;
            justify-content: space-between;
        }

        .shop_name a {
            font-size: 14px !important;
        }

        .form label {
            font-size: 15px !important;
        }

        .form input {
            font-size: 15px !important;
        }
        .form button {
            font-size: 15px !important;
        }
    }

    @media only screen and (min-width: 1200px) {
        .menubar {
            display: flex;
            justify-content: space-between;
        }

        .shop_name a {
            font-size: 15px !important;
        }

        .form label {
            font-size: 16px !important;
        }

        .form input {
            font-size: 16px !important;
        }
        .form button {
            font-size: 16px !important;
        }
    }
</style>

<form action="{{ route('customers.update') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $data->user_id }}">
    <input type="hidden" name="customer_id" value="{{ $data->customer_id }}">
    <div class="modal-body">
        <div class="mb-3 mt-3 form">
            <label for="user_name" class="form-label"> Customer Name:</label>
            <input type="text" class="form-control" value="{{ $data->name }}" name="name">
        </div>
        <div class="mb-3 mt-3 form">
            <label for="phone" class="form-label"> Customer Phone:</label>
            <input type="text" class="form-control" value="{{ $data->phone }}" name="phone">
        </div>

        <div class="mt-3 form">
            <label for="user_email" class="form-label"> Customer Email:</label>
            <input type="text" class="form-control" value="{{ $data->email }}" name="email">
        </div>
    </div>
    <div class="modal-footer form mb-4">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

