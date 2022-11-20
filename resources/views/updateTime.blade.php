@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update Appointment') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('time.update', $time->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Start time') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="time"
                                        class="form-control @error('start_time') is-invalid @enderror" name="start_time"
                                        value="{{ $convert_start_time = date('H:i', strtotime($time->start_time)) }}"
                                        required autocomplete="name" autofocus>

                                    @error('start_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('End Time') }}</label>

                                <div class="col-md-6">
                                    <input id="end_time" type="time"
                                        class="form-control @error('end_time') is-invalid @enderror" name="end_time"
                                        value="{{ $convert_end_time = date('H:i', strtotime($time->end_time)) }}" required
                                        autocomplete="email">

                                    @error('end_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Duration') }}</label>

                                <div class="col-md-6">
                                    <input id="duration" type="text" value={{ $time->duration }}
                                        class="form-control @error('duration') is-invalid @enderror" name="duration"
                                        required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Day') }}</label>

                                <div class="col-md-6">

                                    <input id="day" type="text" value={{ $time->day }}
                                        class="form-control @error('day') is-invalid @enderror" name="day" required>

                                </div>
                            </div>



                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
