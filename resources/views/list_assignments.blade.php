<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-8">

                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                  </div>
                @endif

                <h3 style="text-align:center;">All Reports</h3>

                <div class="row">
                    <div class="col-9">
                        <input type="text" class="form-control" id="search">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary" id="search">Search</button>
                    </div>
                </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports ?? [] as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td class="report-name">{{ $report->name }}</td>
                                <td class="report-email">{{ $report->email }}</td>
                                <td>{{ $report->company_name }}</td>
                                <td>
                                    <button class="btn btn-primary view-report" data-id="{{ $report->id }}">View</button>
                                    <button class="btn btn-danger delete-report" data-id="{{ $report->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal" id="report" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <h5>Name</h5>
                            <p id="report-name"></p>
                            <h5>Email</h5>
                            <p id="report-email"></p>
                            <h5>company_name</h5>
                            <p id="report-company-name"></p>
                            <h5>Phone Number</h5>
                            <p id="report-phone-number"></p>
                            <h5>Country</h5>
                            <p id="report-country"></p>
                            <h5>Details</h5>
                            <p id="report-details"></p>
                        </div>
                      </div>
                    </div>
                  </div>
                
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document.body).on('click', 'button.view-report', function() {
                const id = this.dataset.id;
                $.ajax({
                    url: `/report/${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status !== 'ok') {
                            alert(response.message);
                            return;
                        }
                        $('#report .modatl-title').text(`Report ID ${response.report.id}`);
                        $('#report #report-name').text(response.report.name);
                        $('#report #report-email').text(response.report.email);
                        $('#report #report-company-name').text(response.report.company_name);
                        $('#report #report-phone-number').text(response.report.phone_number !== null ? response.report.phone_number : '-');
                        $('#report #report-country').text(response.report.country !== null ? response.report.country : '-');
                        $('#report #report-details').text(response.report.details !== null ? response.report.details : '-');
                        $('#report').modal('show');
                    },
                    error: function(jqXHR) {
                        alert('Something went wrong. Please try again after sometime.');
                        console.error(jqXHR);
                        return;
                    }
                });
            });
            $(document.body).on('click', 'button.delete-report', function() {
                const id = this.dataset.id;
                const confirmation = confirm("Are you sure? This process is irreversible.");
                if (!confirmation) return;
                $.ajax({
                    url: `/report/${id}`,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status !== 'ok') {
                            alert(response.message);
                            return;
                        }
                        alert(response.message);
                        location.reload();
                    },
                    error: function(jqXHR) {
                        alert('Something went wrong. Please try again after sometime.');
                        console.error(jqXHR);
                        return;
                    }
                });
            });
            $(document.body).on('click', 'button#search', function() {
                const searchString = $('input#search').val();
                $.each($('tbody > tr'), function(index, row) {
                    const name = $(row).find('.report-name').text();
                    const email = $(row).find('.report-email').text();
                    if (name.indexOf(searchString) > -1) {
                        $(this).show();
                        return;
                    }
                    if (email.indexOf(searchString) > -1) {
                        $(this).show();
                        return;
                    }
                    $(this).hide();
                });
            });
        });
    </script>
</body>
</html>