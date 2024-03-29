@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new Question</div>

                <div class="card-body">
                  <form action="/questions" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="channel_id">Select a channel:</label>
                        <select class="form-control" name="channel_id" required id="channel_id">
                          <option disabled selected>Select please..</option>
                          @foreach($channels as $channel)
                            <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                              {{ $channel->name }}
                            </option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                      <label for="title">Title:</label>
                      <input type="text" name="title" class="form-control" placeholder="title" value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group">
                        <textarea required name="body" id="body" class="form-control" placeholder="Type a question" rows="8">{{ old('body') }}</textarea>
                    </div>
                    <div class="form-group">
                        {!! NoCaptcha::renderJs('en') !!}
                        {!! NoCaptcha::display() !!}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Publish</button>
                    </div>
                    @if(count($errors))
                    <ul class="alert alert-danger">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                    @endif
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection