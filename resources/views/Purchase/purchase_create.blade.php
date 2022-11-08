@include('welcome')
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
                <input type="number" class="form-control" name="item_quantity" id="itemqnty">
                <span class="text-danger" id="emailErrorMsg"></span>
            </div>

            <div class="mb-3">
                <label for="InputMobile" class="form-label" style="margin-right:80%;"><b>Unit Price</b></label>
                <input type="number" class="form-control" name="unit_price" id="unit_price">
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

<div class="card-body">

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

            </tr>
        </thead>
        <tbody class="purchasestable">
            @foreach( $purchases as $purchase)
            <tr>
                <th scope="row">{{$i++}}</th>
                <td>{{$purchase->vendor->name}}</td>
                <td>{{$purchase->item_name}}</td>
                <td>{{$purchase->item_quantity}}</td>
                <td>{{$purchase->unit_price}}</td>
                <td>{{$purchase->total_price}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script type="text/javascript">

    $(document).ready(function() {
        var i = 0;
        $('#itemqnty').keyup(function() {
            tot_price();
        })
        $('#unit_price').keyup(function() {
            tot_price();
        })

        function tot_price() {
            let quantity = $('#itemqnty').val();
            let price = $('#unit_price').val();


            console.log(price)
            let tot_price = quantity * price;
            console.log(tot_price);
            $('#totprice').val(tot_price);
        }


        $('#SubmitForm').on('submit', function(e) {
            e.preventDefault();
            jQuery.ajax({
                url: "{{url('/purchase-form')}}",
                type: "POST",
                data: jQuery('#SubmitForm').serialize(),
                success: function(response) {
                    $('#successMsg').show();
                    $('#SubmitForm')[0].reset();
                    if (response.status == true) {
                        console.log(response.data);
                    }


                    $(".purchasestable")
                        .prepend('<tr/>')
                        .children('tr:first')
                        .append("<th>0</th><td>" +
                            response.purchase.vendor.name + "</td><td>" +
                            response.purchase.item_name + "</td><td>" +
                            response.purchase.item_quantity + "</td><td>" +
                            response.purchase.unit_price + "</td><td>" +
                            response.purchase.total_price + "</td>");
                    // location.reload();
                    $(".purchasestable").append(row);

                },

            });
        });


    });
</script>