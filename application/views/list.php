<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cicrud</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
</head>
<body>


<div class="container">
  <h2>User List</h2>
  <h2><a href="<?php echo base_url();?>user/add" class="btn btn-success pull-right">Add</a></h2>
   <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Birthdate</th>
        <th>Address</th>
        <th>Country</th>
        <th>State</th>
        <th>City</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($user as $row){?>
      <tr>
        <td><?php echo $row->name;?></td>
        <td><?php echo $row->email;?></td>
        <td><?php echo $row->gender;?></td>
        <td><?php echo $row->birthdate;?></td>
        <td><?php echo $row->address;?></td>
        <td><?php echo $row->country;?></td>
        <td><?php echo $row->state;?></td>
        <td><?php echo $row->city;?></td>
        <td><a href="<?php echo base_url();?>user/edit/<?php echo $row->id?>" class="btn btn-primary">Edit</a></td>
        <td><a href="<?php echo base_url();?>user/delete/<?php echo $row->id?>" class="btn btn-danger">Delete</a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>

</body>
</html>

