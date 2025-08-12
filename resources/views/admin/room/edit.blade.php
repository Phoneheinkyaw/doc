@extends('admin.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper mt-2">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Room Edit</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update.room', $room->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="roomName" class="font-weight-bold">Room Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="roomName" name="name" value="{{ old('name', $room->name) }}" required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="roomStatus" class="font-weight-bold">Status</label>
                                <input type="text" class="form-control" id="roomStatus" name="status"
                                    value="{{ old('status', $room->status == 0 ? 'Occupied' : 'Free') }}" disabled>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('list.room') }}" class="btn btn-gray">Back</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
