@extends('layout')

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
        <form role="form" action="/game/{{ $game->uid }}/join" method="post" class="col-md-4 col-md-offset-4 centered_form">
            <fieldset>
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Your name:</label>
                    <h1>Choose your name/color:</h1>
                    <label>
                        <input type="radio" name="color" value="white" required>
                        <img src="img/chesspieces/wikipedia/wN.png">
                        <br><span>White: {{ $game->white }}</span>
                    </label>

                    <label>
                        <input type="radio" name="color" value="black">
                        <img src="img/chesspieces/wikipedia/bN.png">
                        <br><span>Black: {{ $game->black }}</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary pull-right">Join the game</button>
            </fieldset>
        </form>
    </div>
@endsection
