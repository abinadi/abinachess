@extends('layout')

@section('style')
    @parent

    <style type="text/css">
        fieldset {
            display: none;
        }

        label {
            font-family: Lustria;
            font-size: 26px;
        }

        input {
            font-size: 26px !important;
            padding: 10px 5px !important;
            height: 48px !important;
        }

        .step-3 label > input {
            visibility: hidden;
            position: absolute;
        }

        .step-3 label {
            display: inline-block;
            width: 32%;
            cursor: pointer;
        }

        .step-3 label > input + img {
            background-color: transparent;
        }

        .step-3 label > input:checked + img {
            background-color: #888;
        }

        .step-3 label {
            text-align: center;
        }
    </style>
@endsection

@section('script-footer')
    @parent

    <script>
        $(document).ready(function () {
            $('fieldset:first-child').fadeIn('slow');

            // Next step
            $('.btn-next').on('click', function() {
                $(this).parents('fieldset').fadeOut(400, function() {
                    $(this).next().fadeIn();
                });
            });

            // Previous step
            $('.btn-previous').on('click', function() {
                $(this).parents('fieldset').fadeOut(400, function () {
                    $(this).prev().fadeIn();
                });
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <form role="form" action="/game" method="post" class="col-md-4 col-md-offset-4 centered_form">
            <fieldset>
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Your name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <button type="button" class="btn btn-info btn-next pull-right">Next</button>
            </fieldset>

            <fieldset>
                <div class="form-group">
                    <label for="opponent">Opponent name:</label>
                    <input type="text" name="opponent" id="opponent" class="form-control" required>
                </div>

                <button type="button" class="btn btn-info btn-previous pull-left">Previous</button>
                <button type="button" class="btn btn-info btn-next pull-right">Next</button>
            </fieldset>

            <fieldset class="step-3">
                <div class="form-group">
                    <h1>Choose your color:</h1>
                    <label>
                        <input type="radio" name="color" value="white" required>
                        <img src="img/chesspieces/wikipedia/wN.png">
                        <br><span>White</span>
                    </label>

                    <label>
                        <input type="radio" name="color" value="random">
                        <img src="img/chesspieces/wikipedia/rN.png">
                        <br><span>Random</span>
                    </label>

                    <label>
                        <input type="radio" name="color" value="black">
                        <img src="img/chesspieces/wikipedia/bN.png">
                        <br><span>Black</span>
                    </label>
                </div>

                <button type="button" class="btn btn-info btn-previous pull-left">Previous</button>
                <button type="submit" class="btn btn-primary pull-right">Start the game</button>
            </fieldset>
        </form>
    </div>
@endsection
