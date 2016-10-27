<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cicrud</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
</head>
<body>

<div class="container">
    <div class="col-sm-6">
        <h2>Demo form</h2>

        <form name="demoFrom" id="demoFrom" action="<?php echo base_url(); ?>user/save" method="post"
              enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Contact no">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="birthdate" id="birthdate" placeholder="dd/mm/yyyy">
            </div>
            <div class="form-group">
                <input type="radio" name="gender" id="gender" value="male">Male
                <input type="radio" name="gender" id="gender" value="female">Female
            </div>
            <div class="form-group">
                <select class="form-control" name="country_id" id="country_id">
                    <option value="">Select Country</option>
                    <?php foreach ($country as $row) { ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="state_id" id="state_id" disabled>
                    <option value="">Select State</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="city_id" id="city_id" disabled>
                    <option value="">Select City</option>
                </select>
            </div>
            <div class="form-group">
                <textarea type="text" class="form-control" name="address" id="address" cols="5" rows="3"
                          placeholder="Enter address"></textarea>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" name="profile[]" id="profile" multiple>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
            </div>
            <div class="checkbox">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
</div>

</body>
</html>
<script>
    $(document).ready(function () {
        $('#birthdate').datepicker({});
        $("#country_id").on("change", function () {
            var country_id = $(this).val();
            if (country_id != "") {
                $("#state_id").attr("disabled", false);
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url();?>user/getCityState",
                    data: {'id': country_id, 'table': "state"},
                    success: function (data) {
                        $("#state_id").html(data);
                    }
                });
            }
            else {
                $("#state_id").attr("disabled", true);
                $("#city_id").attr("disabled", true);
            }
        });
        $("#state_id").on("change", function () {
            var state_id = $(this).val();
            if (state_id != "") {
                $("#city_id").attr("disabled", false);
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url();?>user/getCityState",
                    data: {'id': state_id, 'table': "city"},
                    success: function (data) {
                        $("#city_id").html(data);
                    }
                });
            }
            else {
                $("#city_id").attr("disabled", true);
            }
        });
        $("#demoFrom").validate({
            rules: {
                name: "required",
                gender: "required",
                phone: {
                    required:true,
                    digits:true
                },
                address: "required",
                country_id: "required",
                state_id: "required",
                city_id: "required",
                email: {
                    required: true,
                    email: true
                },
                birthdate: "required",
                password: {
                    required: true,
                    minlength: 5
                }

            },
            message: {
                name: "Please enter your name",
                gender: "Please specify your gender",
                phone: "Please enter your phone",
                address: "Please enter your address",
                email: "Please enter a valid email address",
                country_id: "Please select Country",
                state_id: "Please select State",
                city_id: "Please select City",
                birthdate: "Please select Birthdate",
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>

