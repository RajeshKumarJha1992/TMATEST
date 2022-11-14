<!DOCTYPE html>
<html lang="en">

<head>
    <title>XML Manipulation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <script
    src="https://code.jquery.com/jquery-3.6.1.js"
    integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <section>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#">Test</a>
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('books') }}">Books</a>
                    </li>
                </ul>

            </div>
        </nav>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                @if ($message = Session::get('fail'))
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


            </div>
            <div class="col-md-12" style="margin-top:30px;margin-bottom:30px">
                <h4 class="text-center">Import XML FIle</h4>
                <form method="post" enctype="multipart/form-data" action="{{ route('importXMLFile') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="file" name="file" id="file" class="form-control" accept=".xml" required>
                        </div>
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary" name="action" value="Upload">
                        </div>
                    </div>
                </form>
            </div>


            <div class="col-md-12">
                <table id="books" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Author</th>
                            <th>Book</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Author</th>
                            <th>Book</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#books').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "lengthMenu": [
                        [10, 25, 50, 100, 1000],
                        [10, 25, 50, 100, 1000]
                    ],
                    ajax: {
                        'url': "{{ route('bookList') }}"
                    },
                    "initComplete": function() {

                    },
                    columns: [{
                            data: 'id',
                            orderable: false,
                        },
                        {
                            data: 'author_id'
                        },
                        {
                            data: 'name'
                        }
                    ],
                    order: [
                        [1, "desc"]
                    ],
                    dom: 'lBfrtip',
                    buttons: [{
                            extend: 'colvis',
                            columns: ':not(:first-child)'
                        }
                    ]
                });
                var table = $('#books').DataTable();
        });
    </script>

</body>

</html>
