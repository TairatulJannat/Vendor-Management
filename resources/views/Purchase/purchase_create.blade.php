@include('home')

<!-- <style>    
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style> -->

<div class="card text-center" style="width: 50%;margin-left:300px; margin-top:20px">
    <div class="card-header">
        Purchase Order
    </div>
    <div class="card-body">
        <div class="alert alert-success" role="alert" id="successMsg" style="display: none">
            Successfully Added!
        </div>

        <form id="SubmitForm">
            @csrf
            <div class="mb-3">
                <label for="InputName" class="form-label" style="margin-right:80%;"><b>Item name</b></label>
                <input type="text" class="form-control" name="item_name" id="itemname">
                <span class="text-danger" id="nameErrorMsg"></span>
            </div>

            <div class="mb-3">
                <label for="InputEmail" class="form-label" style="margin-right:80%;"><b>Item Quantity</b></label>
                <input type="number" class="form-control" name="item_quantity" id="itemqnty" min="0">
                <span class="text-danger" id="emailErrorMsg"></span>
            </div>

            <div class="mb-3">
                <label for="InputMobile" class="form-label" style="margin-right:80%;"><b>Unit Price</b></label>
                <input type="number" class="form-control" name="unit_price" id="unit_price" min="0">
                <span class="text-danger" id="mobileErrorMsg"></span>
            </div>

            <div class="mb-3">
                <label for="InputAddress" class="form-label" style="margin-right:80%;"><b>Total Price</b></label>
                <input type="number" class="form-control results" name="total_price" id="totprice">
                <span class="text-danger" id="addressErrorMsg"></span>
            </div>

            <div class="mb-3">
                <label for="InputAddress" class="form-label" style="margin-right:80%;"><b>Vendor Name</b></label>
                <select class="form-control" name="vendor_id" id="vendorid" aria-label="Default select example" style="margin-right:80%">
                    <option value="">-- Please Select --</option>
                    @foreach($vendors as $vendor)

                    <option value=" {{$vendor->id}}">{{$vendor->name}}</option>

                    @endforeach
                </select>
                <span class="text-danger" id="addressErrorMsg"></span>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>


</div>

<div class="card-body" style="margin-block: 5px;padding: 110px;">

    <table class="table table-striped" id="showtable">
        <?php
        $i = 1;
        ?>
        <thead>
            <tr class="table-danger">
                <th scope="col">Serial</th>
                <th scope="col">Vendor Name</th>
                <th scope="col">Item Name</th>
                <th scope="col">Item Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Total Price</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody class="purchasestable">


        </tbody>
    </table>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="UpdatePurchaseModalForm">
                    @csrf
                    <input type="hidden" id="edit_purchase_id" value="">
                    <div class="mb-3">
                        <label for="InputName" class="form-label" style="margin-right:80%;"><b>Item name</b></label>
                        <input type="text" class="form-control" name="item_name" id="EditItemname">
                        <span class="text-danger" id="nameErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputEmail" class="form-label" style="margin-right:80%;"><b>Item Quantity</b></label>
                        <input type="number" class="form-control" name="item_quantity" id="EditItemqnty" min="0">
                        <span class="text-danger" id="emailErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputMobile" class="form-label" style="margin-right:80%;"><b>Unit Price</b></label>
                        <input type="number" class="form-control" name="unit_price" id="EditUnitPrice" min="0">
                        <span class="text-danger" id="mobileErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputAddress" class="form-label" style="margin-right:80%;"><b>Total Price</b></label>
                        <input type="number" class="form-control results" name="total_price" id="EditTotPrice">
                        <span class="text-danger" id="addressErrorMsg"></span>
                    </div>

                    <div class="mb-3">
                        <label for="InputAddress" class="form-label" style="margin-right:80%;"><b>Vendor Name</b></label>
                        <select class="form-control" name="vendor_id" id="editVendor" aria-label="Default select example" style="margin-right:80%">

                        </select>
                        <span class="text-danger" id="addressErrorMsg"></span>
                    </div>


                    <button type="submit" class="btn btn-primary">Update</button>
                </form>






            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        getData();

        function getData() {
            $.ajax({
                url: "{{url('/getPurchase')}}",
                type: 'GET',
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    $('.purchasestable').html('');
                    $.each(res.purchases, function(key, purchase) {
                        idx = key;
                        $('.purchasestable').append('<tr>\
                        <th scope="row">' + ++key + '</th>\
                         <td>' + purchase.vendor.name + '</td>\
                         <td>' + purchase.item_name + '</td>\
                         <td>' + purchase.item_quantity + '</td>\
                         <td>' + purchase.unit_price + '</td>\
                         <td>' + purchase.total_price + '</td>\
                         <td><button type="button" class="btn btn-sm btn-info edit_purchase" value="' + purchase.id + '" data-bs-toggle="modal" data-bs-target="#exampleModal"> Edit </button>\
                         &nbsp <button type="button" class="btn btn-sm btn-danger deletePurchase" value="' + purchase.id + '" > Delete </button></td>\
                        '

                        )
                    });
                },
                error: function(err) {

                },
            })
        }
        $(document).on('click', '.deletePurchase', function(e) {
            e.preventDefault();
            var id = $(this).val();
            jQuery.ajax({
                url: "{{url('/delete-form-purchase')}}" + "/" + id,
                success: function() {
                    getData();

                }
            });
        })

        $("#itemqnty").on('keyup change', function() {
            tot_price();
        });
        $("#unit_price").on('keyup change', function() {
            tot_price();
        });




        function tot_price() {
            let quantity = $('#itemqnty').val();
            let price = $('#unit_price').val();


            console.log(price)
            let tot_price = quantity * price;
            console.log(tot_price);
            $('#totprice').val(tot_price);
        }


        $(document).on('click', '.edit_purchase', function(e) {
            e.preventDefault();

            var purchase_id = $(this).val();
            // alert(purchase_id);

            $.ajax({
                url: "{{url('/edit-form-purchase')}}" + "/" + purchase_id,
                success: function(data) {
                    console.log(data);
                    $('#edit_purchase_id').empty();
                    $('#EditItemname').empty();
                    $('#EditUnitPrice').empty();
                    $('#EditItemqnty').empty();
                    $('#EditTotPrice').empty();


                    $('#edit_purchase_id').val(purchase_id);
                    $('#EditItemname').val(data.purchase.item_name);
                    $('#EditUnitPrice').val(data.purchase.unit_price);
                    $('#EditItemqnty').val(data.purchase.item_quantity);
                    $('#EditTotPrice').val(data.purchase.total_price);

                    var editvendors = '<option value="' + data.purchase.vendor.id + '" selected >' + data.purchase.vendor.name + '</option>';
                    $.each(data.vendors, function(key, vendorList) {
                        editvendors += '<option value="' + vendorList.id + '" >' + vendorList.name + '</option>';
                    });

                    $('#editVendor').html(editvendors);

                }
            });
        })



        $("#EditItemqnty").on('keyup change', function() {
            tot_price_edit();
        });
        $("#EditUnitPrice").on('keyup change', function() {
            tot_price_edit();
        });

        function tot_price_edit() {
            let quantity = $('#EditItemqnty').val();
            let price = $('#EditUnitPrice').val();


            console.log(price)
            let tot_price = quantity * price;
            console.log(tot_price);
            $('#EditTotPrice').val(tot_price);
        }

        $('#UpdatePurchaseModalForm').submit(function(e) {
            e.preventDefault();
            let id = $('#edit_purchase_id').val();
            console.log(id);
            let formData = new FormData(this);
            jQuery.ajax({
                type: "POST",
                url: "{{url('/update-form-purchase')}}" + "/" + id,
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    console.log(response);
                    $('#UpdatePurchaseModalForm')[0].reset();


                    $('#exampleModal').modal('hide');
                    getData();

                },

            })
        });


        $('#SubmitForm').on('submit', function(e) {
            e.preventDefault();
            jQuery.ajax({
                url: "{{url('/purchase-form')}}",
                type: "POST",
                data: jQuery('#SubmitForm').serialize(),
                success: function(response) {
                    $('#successMsg').show();
                    $('#SubmitForm')[0].reset();
                    getData();


                },

            });
        });


    });
</script>