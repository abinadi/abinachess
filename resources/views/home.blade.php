@extends('layout')

@section('style')
    @parent

    <style type="text/css">
        label {
            font-family: Lustria;
            font-size: 26px;
        }

        input {
            font-size: 26px !important;
            padding: 10px 5px !important;
            height: 48px !important;
            width: 78% !important;
        }

        button {
            font-size: 26px !important;
            height: 48px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <section class="col-md-4 col-md-offset-4">
            <form action="/join" method="post" class="form-inline centered_form">
                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="uid">Join a game</label>
                    <input type="text" name="uid" id="uid" class="form-control" placeholder="ex: p4mf98">
                    <button type="submit" class="btn btn-primary">&raquo;</button>
                </div>
            </form>
        </section>

        <section class="col-md-4 col-md-offset-4">
            <p class="pull-right"><br><br><br>
                Or, <a href="/start" class="btn btn-info">Start a new game</a>
            </p>
        </section>
    </div>
@endsection