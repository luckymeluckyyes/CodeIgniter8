<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    
       <style>
        body {
            background-color: #eee;
            padding-bottom: 40px;
            padding-top: 40px;
            color: #333;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.42857;
        }
        .table {

        }
    </style>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(function(){
            $('.del').click(function(){
                var d = $(this).data('id');
                if(confirm('Are you sure you want to delete ?')) {
                    if(d == '') {
                        alert('This user cant be deleted');
                        return false;
                    } else {
                        $.ajax({
                            url: "user/delete/"+d,
                            type: "post",
                            data: {
                                del:d
                            },
                            success:function(data) {
                                $('body').html(data);
                            }
                        });
                    }
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if($this->session->flashdata('edit_success')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('edit_success'); ?>
                    </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Users</div>
                    <?php 
                        echo form_open('user/delete_multi');
                     ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($users as $user) {

                                    $id = $user['id'];
                             ?>
                             <tr>
                                 <td><?php echo form_checkbox('ids[]', $user['id']); ?></td>
                                 <td><?php echo $user['id']; ?></td>
                                 <td><?php echo $user['name']; ?></td>
                                 <td><?php echo $user['email']; ?></td>
                                 <td><?php echo $user['phone']; ?></td>
                                 <td><?php echo anchor('user/edit/'.$id, '<i class="glyphicon glyphicon-pencil"></i>'); ?></td>
                                 <!-- <td><?php echo anchor('user/delete/'.$id, '<i class="glyphicon glyphicon-remove"></i>'); ?></td> -->
                                 <td><a href="#!" class="del" data-id="<?= $user['id']; ?>"><i class="glyphicon glyphicon-remove"></i></a></td>
                             </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <th colspan="7">
                                <?php 
                                    $btn_attr = array('name' => 'submit', 'content' => 'Delete Selected', 'class' => 'btn btn-sm btn-primary', 'type' => 'submit');
                                    echo form_button($btn_attr);
                                 ?>
                            </th>
                        </tfoot>
                    </table>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>