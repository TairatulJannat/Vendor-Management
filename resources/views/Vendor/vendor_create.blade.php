@include('home')

<div class="card text-center" style="width: 50%;margin-left:300px; margin-top:20px">
    <div class="card-header">
        Vendor Create
    </div>
    <div class="card-body">
        <div class="alert alert-success" role="alert" id="successMsg" style="display: none">
            Successfully Added!
        </div>

        <form id="SubmitForm">
            @csrf
            <div class="mb-3">
                <label for="InputName" class="form-label" style="margin-right:90%;">Name</label>
                <input type="text" class="form-control" name="name" id="InputName">
                <span class="text-danger" id="nameErrorMsg"></span>
            </div>

            <div class="mb-3">
                <label for="InputEmail" class="form-label" style="margin-right:80%;">Email address</label>
                <input type="email" class="form-control" name="email" id="InputEmail">
                <span class="text-danger" id="emailErrorMsg"></span>
            </div>

            <div class="mb-3">
                <label for="InputMobile" class="form-label" style="margin-right:80%;">Phone Number</label>
                <input type="number" class="form-control" name="phone" id="InputMobile">
                <span class="text-danger" id="mobileErrorMsg"></span>
            </div>

            <div class="mb-3">
                <label for="InputAddress" class="form-label" style="margin-right:80%;">Office Address</label>
                <input type="text" class="form-control" name="address" id="InputAddress">
                <span class="text-danger" id="addressErrorMsg"></span>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>


</div>
<div class="card-body" class="card-body" style="margin-block: 5px;padding: 110px;">

    <table class="table table-striped" id="showtable">
        <?php
        $i = 1;
        ?>
        <thead>
            <tr class="table-danger">
                <th scope="col">Serial</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col"> Office Address</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="showtable">


        </tbody>
    </table>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="UpdateModalForm">
                    @csrf
                    <input type="hidden" id="edit_vendor_id" value="">
                    <div class="mb-3">
                        <label for="InputName" class="form-label" style="margin-right:90%;">Name</label>
                        <input type="text" class="form-control" name="name" id="editInputName">
                        <span class="text-danger" id="EditnameErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputEmail" class="form-label" style="margin-right:80%;">Email address</label>
                        <input type="email" class="form-control" name="email" id="editInputEmail">
                        <span class="text-danger" id="EditemailErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputMobile" class="form-label" style="margin-right:80%;">Phone Number</label>
                        <input type="number" class="form-control" name="phone" id="editInputMobile">
                        <span class="text-danger" id="EditmobileErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputAddress" class="form-label" style="margin-right:80%;">Office Address</label>
                        <input type="text" class="form-control" name="address" id="editInputAddress">
                        <span class="text-danger" id="EditaddressErrorMsg"></span>
                    </div>



                    <button type="submit" class="btn btn-primary">Update</button>
                    <!-- <div class="modal-footer">
                        <a class="btn btn-secondary" data-dismiss="modal">Close</a>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        getData();

        function getData() {
            $.ajax({
                url: "{{url('/getVendor')}}",
                type: 'GET',
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    $('.showtable').html('');
                    $.each(res.vendors, function(key, vendor) {
                        $('.showtable').append('<tr>\
                        <th scope="row">' + ++key + '</th>\
                         <td>' + vendor.name + '</td>\
                         <td>' + vendor.email + '</td>\
                         <td>' + vendor.phone + '</td>\
                         <td>' + vendor.address + '</td>\
                         <td> <button type="button" class="btn btn-sm btn-info edit_vendor" value="' + vendor.id + '" data-bs-toggle="modal" data-bs-target="#exampleModal"> Edit </button>\
                          <button type="button" class="btn btn-sm btn-danger delete_vendor" value="' + vendor.id + '" > Delete </button></td>\
                        '

                        )
                    });
                },
                error: function(err) {

                },
            })
        }


        $(document).on('click', '.delete_vendor', function(e) {
            e.preventDefault();
            // alert('Are you sure? ');
            var id = $(this).val();
            // alert(id);
            jQuery.ajax({
                url: "{{url('/delete-form')}}" + "/" + id,
                success: function() {
                    console.log("it Works");
                    getData();
                }
            });
        })

        $(document).on('click', '.edit_vendor', function(e) {
            e.preventDefault;

            var vendor_id = $(this).val();
            // alert(vendor_id);
            $.ajax({
                url: "{{url('/edit-form')}}" + "/" + vendor_id,
                success: function(data) {
                    console.log(data);
                    $('#edit_vendor_id').empty();
                    $('#editInputName').empty();
                    $('#editInputEmail').empty();
                    $('#editInputMobile').empty();
                    $('#editInputAddress').empty();

                    $('#edit_vendor_id').val(vendor_id);
                    $('#editInputName').val(data.vendor.name);
                    $('#editInputEmail').val(data.vendor.email);
                    $('#editInputMobile').val(data.vendor.phone);
                    $('#editInputAddress').val(data.vendor.address);

                }
            });
        })



        $('#UpdateModalForm').submit(function(e) {
            e.preventDefault();
            let id = $('#edit_vendor_id').val();
            let formData = new FormData(this);
            jQuery.ajax({
                type: "POST",
                url: "{{url('/update-form')}}" + "/" + id,
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    $('#UpdateModalForm')[0].reset();
                    $('#EditnameErrorMsg').empty();
                    $('#EditemailErrorMsg').empty();
                    $('#EditmobileErrorMsg').empty();
                    $('#EditaddressErrorMsg').empty();
                    // location.reload();
                    $('#exampleModal').modal('hide');
                    getData();

                },
                error: function(response) {
                    console.log(response);
                    $('#EditnameErrorMsg').text(response.responseJSON.errors.name);
                    $('#EditemailErrorMsg').text(response.responseJSON.errors.email);
                    $('#EditmobileErrorMsg').text(response.responseJSON.errors.phone);
                    $('#EditaddressErrorMsg').text(response.responseJSON.errors.address);
                },
            })
        });


        $('#SubmitForm').on('submit', function(e) {
            e.preventDefault();
            jQuery.ajax({
                url: "{{url('/submit-form')}}",
                type: "POST",
                data: jQuery('#SubmitForm').serialize(),
                success: function(response) {
                    $('#successMsg').show();
                    $('#SubmitForm')[0].reset();
                    $('#nameErrorMsg').empty();
                    $('#emailErrorMsg').empty();
                    $('#mobileErrorMsg').empty();
                    $('#addressErrorMsg').empty();
                    if (response.status == true) {
                        console.log(response.vendor);
                        getData();
                    }





                },
                error: function(response) {
                    console.log(response);
                    $('#nameErrorMsg').text(response.responseJSON.errors.name);
                    $('#emailErrorMsg').text(response.responseJSON.errors.email);
                    $('#mobileErrorMsg').text(response.responseJSON.errors.phone);
                    $('#addressErrorMsg').text(response.responseJSON.errors.address);
                },
            });
        });
    });
</script>