@include('welcome')
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

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
<div class="card-body">

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
            @foreach( $vendors as $vendor)
            <tr>
                <th scope="row">{{$i++}}</th>
                <td>{{$vendor->name}}</td>
                <td>{{$vendor->email}}</td>
                <td>{{$vendor->phone}}</td>
                <td>{{$vendor->address}}</td>
                <td style="width: 150px">
                    <a class="btn btn-sm btn-info" onclick="vendor_edit('{{$vendor->id}}')" data-toggle="modal" data-target="#editModal">Edit</a>
                    <button class=" btn btn-sm btn-danger deleteRecord" data-id="{{ $vendor->id }}">Delete </button>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Edit Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="UpdateModalForm">
                    @csrf
                    <input type="hidden" id="edit_vendor_id" value="">
                    <div class="mb-3">
                        <label for="InputName" class="form-label" style="margin-right:90%;">Name</label>
                        <input type="text" class="form-control" name="name" id="editInputName">
                        <span class="text-danger" id="nameErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputEmail" class="form-label" style="margin-right:80%;">Email address</label>
                        <input type="email" class="form-control" name="email" id="editInputEmail">
                        <span class="text-danger" id="emailErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputMobile" class="form-label" style="margin-right:80%;">Phone Number</label>
                        <input type="number" class="form-control" name="phone" id="editInputMobile">
                        <span class="text-danger" id="mobileErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputAddress" class="form-label" style="margin-right:80%;">Office Address</label>
                        <input type="text" class="form-control" name="address" id="editInputAddress">
                        <span class="text-danger" id="addressErrorMsg"></span>
                    </div>



                    <button type="submit" class="btn btn-primary">Update</button>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" data-dismiss="modal">Close</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script type="text/javascript">
    function vendor_edit(id) {
        let vendor_id = id;
        $.ajax({
            url: "{{url('/edit-form')}}" + "/" + vendor_id,
            success: function(data) {
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


    }

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
                location.reload();
                // $('#editModal').modal('hide');

            },
            error: function(response) {
                console.log(response);
                $('#nameErrorMsg').text(response.responseJSON.errors.name);
                $('#emailErrorMsg').text(response.responseJSON.errors.email);
                $('#mobileErrorMsg').text(response.responseJSON.errors.phone);
                $('#addressErrorMsg').text(response.responseJSON.errors.address);
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
                if (response.status == true) {
                    console.log(response.data);
                }


                $(".showtable")
                    .prepend('<tr/>')
                    .children('tr:first')
                    .append("<th>0</th><td>" +
                        response.vendor.name + "</td><td>" +
                        response.vendor.email + "</td><td>" +
                        response.vendor.phone + "</td><td>" +
                        response.vendor.address + "</td><td style='width: 150 px'> <a class ='btn-sm btn-info' onclick = 'vendor_edit('" + response.vendor.id + "')'data-toggle ='modal' data-target = '#editModal'> Edit </a> &nbsp&nbsp <button class = 'btn btn-sm btn-danger deleteRecord' data-id ='" + response.vendor.id + "'>Delete</button></td>");
                location.reload();
                $(".showtable").append(row);


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

    $(document).ready(function() {
        $(".deleteRecord").click(function() {
            var id = $(this).data("id");
            // alert(id);
            jQuery.ajax({
                url: "{{url('/delete-form')}}" + "/" + id,
                success: function() {
                    console.log("it Works");
                    location.reload();
                }
            });

        });


    });
</script>