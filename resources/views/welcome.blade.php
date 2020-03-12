<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <p class="">
                    Well,nothing to look at.  Its going to be a ecommerce template
                </p>
                <div id="custom-templates">
                  <input class="typeahead" type="text" placeholder="Oscar winners for Best Picture">
                </div>


            </div>
        </div>

        <script
              src="https://code.jquery.com/jquery-3.4.1.min.js"
              integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
              crossorigin="anonymous"></script>

        <script type="text/javascript" src="{{asset('typeahead.bundle.js')}}"></script>
        <script type="text/javascript">
            var url = "{{url('product/search')}}";
            function showSpinner()
            {
                console.log("Show spinner");
            }

            function hideSpinner()
            {
                console.log("hideSpinner spinner");
            }
            var movies = new Bloodhound({
                datumTokenizer: function(datum) {
                    return Bloodhound.tokenizers.whitespace(datum.value);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                        wildcard: '%QUERY',
                        url: url+'?q=%QUERY',
                        // beforeSend: function(xhr){
                        //   showSpinner();
                        // },
                        // filter: function(parsedResponse){
                        //     hideSpinner();
                        //     return parsedResponse;
                        // },
                        transform: function(response) {
                          // Map the remote source JSON array to a JavaScript object array
                          console.log(response);
                          return $.map(response, function(movie) {

                            return {
                              value: movie._source.title
                            };
                        });
                    }
                }
            });

            // Instantiate the Typeahead UI
            $('.typeahead').typeahead(null, {
              display: 'value',
              source: movies
            });

        </script>
    </body>
</html>
