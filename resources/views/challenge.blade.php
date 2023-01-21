<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

</head>

<body>
    <div class="container-fluid bg-light d-flex p-4 justify-content-center" style="min-height: 100vh;">
        <div class="container row bg-white shadow rounded p-2">
            <div class="col-md-12">
                <button type="button" class="btn btn-sm btn-dark float-end shadow-sm" onclick="location.reload();">New Query</button>
            </div>
            <div class="col-md-12">
                <div class="h3">Result</div>
                <div class="w-100 border border-dark rounded">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Latitude</th>
                                <th scope="col">Longitude</th>
                                <th scope="col">Distance</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalQuery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalQueryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQueryLabel">New Query</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="formSend" action="javascript:void(0)">
                        <label class="form-label">Party Location</label>
                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                        <div class="input-group mb-3">
                            <span for="latitude" class="input-group-text">Latitude</span>
                            <input type="text" class="form-control" placeholder="53.3340285" name="latitude" value="53.3340285" required>
                            <span for="longitude" class="input-group-text">Longitude</span>
                            <input type="text" class="form-control" placeholder="-6.2535495" name="longitude" value="-6.2535495" required>
                        </div>

                        <label class="form-label">Affiliate List</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="affiliateList">Upload</label>
                            <input type="file" class="form-control" id="affiliateList" name="affiliateList" accept=".txt" required>
                        </div>

                        <label class="form-label">Query Scope - <span><input type="number" class="border-0" style="width: 70px;" value="100" id="n-scope" onchange="nScopeChange(this)"></span>&nbsp;Km</label>
                        <div class="d-flex align-items-center mb-3">
                            <label class="form-label">0&nbsp;</label>
                            <input type="range" class="form-range" min="0" max="500" value="100" id="scope" name="scope" oninput="scopeChange(this.value)" required>
                            <label class="form-label">&nbsp;500</label>
                        </div>
                        <button type="submit" class="btn btn-success float-end">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>    
    $(function () {
        $('#modalQuery').modal('show');
    });
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function scopeChange(x) {
            const input = document.getElementById("n-scope");
            input.value = parseInt(x);
        }

        function nScopeChange(x) {
            const input = document.getElementById("scope");
            if (x.value >= 0 && x.value <= 500) {
                input.value = parseInt(x.value);
            } else {
                alert("invalid value!");
                x.value = input.value;
            }
        }

        $('#formSend').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ route('send') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $.each(data, function(key, value) {
                        $("#table tbody").append('<tr>'+
                                                    '<td>'+value.id+'</td>'+
                                                    '<td>'+value.name+'</td>'+
                                                    '<td>'+value.latitude+'</td>'+
                                                    '<td>'+value.longitude+'</td>'+
                                                    '<td>'+value.distance+' Km</td>'+
                                                '</tr>');
                    });
                    $('#table').DataTable();
                    $('#modalQuery').modal('toggle');
                },
                error: function(data) {
                    let msg = "";
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors.errors, function(key, value) {
                        msg += value + "\n";
                    });
                    alert(msg);
                }
            });
        });
    </script>
</body>

</html>