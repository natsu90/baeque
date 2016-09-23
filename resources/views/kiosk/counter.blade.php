
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Baeque :: List</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/logo-nav.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="img/logo.png" alt="">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default center-block">
                    <div class="panel-heading">Serving Now</div>
                    <div class="panel-body">
                        <center>
                            <h3>Currently Seving Number</h3>
                            <h4>1002</h4>
                            <h3>Queuing count</h3>
                            <h4>{{ count($list) }}</h4>
                            <a href="/markdone/{{ $current->id }}" class="btn btn-primary btn-lg">Done </a>
                        </center>
                    </div>
                </div>

                <div class="panel panel-default center-block">
                    <div class="panel-heading">Queuing now</div>
                    <table class="table table-stripped">
                        <tr>
                        <th>Number</th>
                        <th>Waiting time</th>
                        <th>Action</th>
                        </tr>
                        @foreach ($list as $item) 
                        <tr>
                        <td>{{ $item['queue'] }}</td>
                        <td>{{ $item['waiting_time'] }}</td>
                        <td><a href="/counter/{{ $current->id }}/{{$item['id'] }}">Serve</a></td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
            </div>
            <div class="footer col-md-12 navbar-fixed-bottom center-block">
                    <h5>powered by baeque.com</h5>
                </div>
        </div>

        <div class="row">
            
        </div>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

</body>

</html>
