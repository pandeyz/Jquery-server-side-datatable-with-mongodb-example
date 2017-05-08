<!DOCTYPE html>
<html>
<head>
    <title>Listing Collection</title>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script>
    $(document).ready(function(){
        $('#datatable_emp_details').dataTable({
            "sServerMethod": "POST", 
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "get_data.php"
        });

        // To add employee
        $('#add_emp').click(function(){
            $('#div_add_emp').dialog({
                title   : 'Add Employee',
                height  : 400,
                width   : 400
            });
        });

        $('#frm_add_emp').submit(function(e){
            e.preventDefault();
        });
        $('#frm_add_emp').validate({
            rules: {
                emp_id      : { required: true },
                first_name   : { required: true },
                last_name   : { required: true },
                position: { required: true },
                email   : { required: true },
                office  : { required: true },
                start_date     : { required: true },
                age     : { required: true },
                salary  : { required: true },
                projects : { required: true }
            },
            messages: {
                emp_id      : { required: '*' },
                first_name   : { required: '*' },
                last_name   : { required: '*' },
                position: { required: '*' },
                email   : { required: '*' },
                office  : { required: '*' },
                start_date     : { required: '*' },
                age     : { required: '*' },
                salary  : { required: '*' },
                projects : { required: '*' }
            }
        });

        // To add employee details
        $('#btn_add_emp').click(function(){
            if( $('#frm_add_emp').valid() )
            {
                $.ajax({
                    url     : 'ajax.php',
                    method  : 'post',
                    data    : 
                    {
                        frmData : $('#frm_add_emp').serialize(),
                        function: 'addEmployee'
                    },
                    success : function(response)
                    {
                        if( response == true )
                        {
                            $('#div_add_emp').dialog('close');
                            alert('Employee added successfully');
                            location.reload();
                        }
                    }
                });
            }
        });

        // To edit the employee details
        $(document).on('click', '.edit_emp', function(){
            var empId   = $(this).attr('id');
            $('#emp_id').val(empId);

            var empFName= $(this).parent('td').parent('tr').find('td').eq(1).html();
            $('#edit_first_name').val(empFName);

            $('#div_edit_emp').dialog({
                title   : 'Edit Employee',
                width   : 320
            });
        });

        $('#frm_edit_emp').submit(function(e){
            e.preventDefault();
        });
        $('#frm_edit_emp').validate({
            rules: {
                edit_first_name : { required: true }
            },
            messages: {
                edit_first_name : { required: '*' }
            }
        });

        // To edit employee details
        $('#btn_edit_emp').click(function(){
            if( $('#frm_edit_emp').valid() )
            {
                $.ajax({
                    url     : 'ajax.php',
                    method  : 'post',
                    data    : 
                    {
                        frmData : $('#frm_edit_emp').serialize(),
                        function: 'editEmployee'
                    },
                    success : function(response)
                    {
                        if( response == true )
                        {
                            $('#div_edit_emp').dialog('close');
                            alert('Employee updated successfully');
                            location.reload();
                        }
                    }
                });
            }
        });

        // To delete the employee details
        $(document).on('click', '.delete_emp', function(){
            var empId = $(this).attr('id');

            if( confirm('Are you sure?') )
            {
                $.ajax({
                    url     : 'ajax.php',
                    method  : 'post',
                    data    : 
                    {
                        empId   : empId,
                        function: 'deleteEmployee'
                    },
                    success : function(response)
                    {
                        if( response == true )
                        {
                            alert('Employee deleted successfully');
                            location.reload();
                        }
                    }
                });
            }
        });
    });
    </script>

    <style type="text/css">
    .odd {
      background-color: #FFF8FB !important;
    }
    .even {
      background-color: #DDEBF8 !important;
    }
    a {
        text-decoration: none;
    }
    .error {
        color: red;
    }
    </style>
</head>
<body>

    <!-- To edit employee -->
    <div id="div_edit_emp" style="display: none;">
        <form name="frm_edit_emp" id="frm_edit_emp" autocomplete="off">
            <table>
                <tr>
                    <td>First Name</td>
                    <td>
                        <input type="text" name="edit_first_name" id="edit_first_name">
                        <input type="hidden" name="emp_id" id="emp_id" value="">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Submit" id="btn_edit_emp">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- To edit employee -->    

    <!-- To add employee -->
    <div id="div_add_emp" style="display: none;">
        <form name="frm_add_emp" id="frm_add_emp">
            <table>
                <tr>
                    <td>Emp Id</td>
                    <td><input type="text" name="emp_id" id="emp_id" value="6"></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type="text" name="first_name" id="first_name" value="Shakti"></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type="text" name="last_name" id="last_name" value="Phartiyal"></td>
                </tr>
                <tr>
                    <td>Position</td>
                    <td><input type="text" name="position" id="position" value="shakti@email.com"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" id="email" value="Full Stack"></td>
                </tr>
                <tr>
                    <td>Office</td>
                    <td><input type="text" name="office" id="office" value="Noida"></td>
                </tr>
                <tr>
                    <td>Joining Date</td>
                    <td><input type="text" name="start_date" id="start_date" value="2016-01-01"></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><input type="text" name="age" id="age" value="26"></td>
                </tr>
                <tr>
                    <td>Salary</td>
                    <td><input type="text" name="salary" id="salary" value="36000"></td>
                </tr>
                <tr>
                    <td>Projects</td>
                    <td><input type="text" name="projects" id="projects" value="Project 1"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Submit" id="btn_add_emp">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- To add employee -->

    <div style="margin: 0 auto;">
        <div style="margin-bottom: 10px;">
            <a href="javascript:void(0);" id="add_emp">Add Employee</a>
        </div>

        <table id="datatable_emp_details">
            <thead>
                <tr>
                    <td>Emp Id</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Position</td>
                    <td>Email</td>
                    <td>Office</td>
                    <td>Joining Date</td>
                    <td>Age</td>
                    <td>Salary</td>
                    <td>Projects</td>
                    <td>Action</td>
                </tr>
            </thead>

            <tbody>
                <!-- Dynamic Data -->
            </tbody>
        </table>
    </div>

</body>
</html>