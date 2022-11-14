<!DOCTYPE html>
<html lang="en">

<head>
    <title>XML Manipulation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick-theme.min.css" />

    <style>
        .carousel-item {
            background-color: grey;
            height: 300px;
        }

        .carousel-caption>h5 {
            font-size: 50px !important
        }
    </style>

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
                <h4 class="text-center">Search Book By Author Name</h4>

                <form method="post" action="{{ route('searchByAuthor') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="searchValue" id="searchValue" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <input type="submit" class="btn btn-primary" name="action" value="Search">
                        </div>
                    </div>
                </form>
            </div>


            <div class="col-md-12">
                @if (count($searchResult) > 0)
                    <h3 class="text-center">You Searched For : {{ $key }}</h3>
                    <div class="bd-example">
                        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @for ($i = 0; $i < count($searchResult); $i++)
                                    @if ($i == 0)
                                        <li data-target="#carouselExampleCaptions" data-slide-to="{{ $i }}"
                                            class="active"></li>
                                    @endif
                                    @if ($i > 0)
                                        <li data-target="#carouselExampleCaptions" data-slide-to="{{ $i }}">
                                        </li>
                                    @endif
                                @endfor
                            </ol>
                            <div class="carousel-inner">
                                <?php $j = 0; ?>
                                @foreach ($searchResult as $singleResult)
                                    @if ($j == 0)
                                        <div class="carousel-item active">

                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>{{$singleResult->name}}</h5>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($j > 0)
                                        <div class="carousel-item">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>{{$singleResult->name}}</h5>

                                            </div>
                                        </div>
                                    @endif

                                    <?php $j++; ?>
                                @endforeach



                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                @endif





            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.carousel').carousel({
                interval: 2000
            })
        });
    </script>

</body>

</html>
