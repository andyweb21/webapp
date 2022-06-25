<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data User</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/style.css" />
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8">
                        <h1>Data User</h1>
                    </div>
                    <div class="col-lg-4 text-right">
                        <a href="/logout">Logout</a>
                    </div>
                </div>
                <button class="btn btn-primary" onClick="create()">+ Tambah User</button>
                <br/><br/><br/>
                <table class="table table-bordered yajra-datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                
                <!-- <div id="read" class="mt-3"></div> -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="page" class="p-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    $(function () {
        
        
        
    });
    </script>

    <script>
        $(document).ready(function() {
            read()
        });
        // Read Database
        function read() {
            // $.get("{{ url('user/read') }}", {}, function(data, status) {
            //     $("#read").html(data);
            // });
            var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'image', name: 'image', 'render': function (data, type, row, meta) {
                    if(data !== null) {
                        return '<img src="/images/' + data + '" alt="' + data + '"height="auto" width="200"/>';
                    } else {
                        return '<img src="/images/avatar.png" alt="' + data + '"height="auto" width="200"/>';
                    }
                }},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });
        }
        // Untuk modal halaman create
        function create() {
            $.get("{{ url('user/create') }}", {}, function(data, status) {
                $("#userModalLabel").html('Create User')
                $("#page").html(data);
                $("#userModal").modal('show');

            });
        }

        // untuk proses create data
        function store(e, el) {
            e.preventDefault();
            $(el).find('.btn-submit').html('<div class="lds-ring mx-4"><div></div><div></div><div></div><div></div></div>').attr('disabled', true);
            $(el).find('input + small').text('');
            // var name = $("#name").val();
            // var email = $("#email").val();
            // var password = $("#password").val();
            // var password_confirmation = $("#password_confirmation").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            let formData = new FormData(el);

            $.ajax({
                url: "{{ url('user/store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                // data: {
                //     "name": name,
                //     "email": email,
                //     "password": password,
                //     "password_confirmation": password_confirmation,
                //     "_token": "{{ csrf_token() }}"
                // },
                success: function(response) {
                    if(response.status === 'success'){
                        $("#userModal").modal('hide');
                        // read()
                        $('.yajra-datatable').DataTable().ajax.reload();
                    } else {
                        $.each(response.message, function(key, val) {
                            $(el).find("#" + key + "_error").text(val[0]);
                        })
                    }
                    $(el).find('.btn-submit').html('Create').attr('disabled', false);
                }
            });
        }

        // Untuk modal halaman edit show
        function show(id) {
            $.get("{{ url('user/show') }}/" + id, {}, function(data, status) {
                $("#userModalLabel").html('Edit User')
                $("#page").html(data);
                $("#userModal").modal('show');
            });
        }

        // untuk proses update data
        function update(e, el, id) {
            e.preventDefault();
            $(el).find('.btn-submit').html('<div class="lds-ring mx-4"><div></div><div></div><div></div><div></div></div>').attr('disabled', true);
            $(el).find('input + small').text('');
            // var name = $("#name").val();
            // var password = $("#password").val();
            // var image = $("#image").val();
            // var password_confirmation = $("#password_confirmation").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            let formData = new FormData(el);
            $.ajax({
                url: "{{ url('user/update') }}/" + id,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if(response.status === 'success'){
                        $("#userModal").modal('hide');
                        // read()
                        $('.yajra-datatable').DataTable().ajax.reload();
                    } else {
                        $.each(response.message, function(key, val) {
                            $(el).find("#" + key + "_error").text(val[0]);
                        })
                    }
                    $(el).find('.btn-submit').html('Update').attr('disabled', false);
                }
            });
        }

        // untuk delete atau destroy data
        function destroy(id) {

            $.ajax({
                type: "get",
                url: "{{ url('user/destroy') }}/" + id,
                data: "name=" + name,
                success: function(data) {
                    // $(".btn-close").click();
                    // read()
                    $('.yajra-datatable').DataTable().ajax.reload();
                }
            });
        }
    </script>
</body>

</html>