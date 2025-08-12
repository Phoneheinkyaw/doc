@extends('admin.layout.dashboard')
@section('main-visual')
    <div class="page-wrapper mt-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="page-title">
                                    Department List
                                </div>
                                <ul class="nav float-left">
                                    <li>
                                        <div class="top-nav-search">
                                            <a href="javascript:void(0);" class="responsive-search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <form action="{{ route('search.department') }}" method="GET">
                                                <input class="form-control" type="text" name="search"
                                                    placeholder="Search Here" value="{{ request('search') }}">
                                                <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6 text-sm-right">
                                <div class="mt-sm-0 mt-2">
                                    <a href="{{ route('create.department') }}"class="btn btn-outline-success mr-2">
                                        <i class="fas fa-plus"></i>
                                        <span class="ml-2">Create</span>
                                    </a>
                                    <a href="{{ route('export.department') }}" class="btn btn-outline-success mr-2">
                                        <i class="fas fa-file"></i>
                                        <span class="ml-2">Export</span></a>
                                    <button type="button" class="btn btn-outline-success mr-2" data-toggle="modal"
                                        data-target="#importModal">
                                        <i class="fas fa-file"></i>
                                        <span class="ml-2">Import</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger error-scroll">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table custom-table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th class="w-80 ">Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($departments) > 0)
                                        <?php $i = 1; ?>
                                        @foreach ($departments as $department)
                                            <tr>
                                                <td>{{ $department->id }}</td>
                                                <td>{{ $department->name }}</td>
                                                <td class="w-80">{{ Str::limit($department->description, 50) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.department.view', $department->id) }}"
                                                        class="btn btn-info btn-sm mb-1">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('edit.department', $department->id) }}"
                                                        class="btn btn-primary btn-sm mb-1">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm mb-1"
                                                        onclick="event.preventDefault();
                                                        if(confirm('Are you sure you want to delete this department?')) {
                                                            document.getElementById('delete-form-{{ $department->id }}').submit();
                                                        }">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $department->id }}"
                                                        action="{{ route('destroy.department', $department->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center"> No Result Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $departments->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Departments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('import.department') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Choose Excel File</label>
                        <input type="file" class="form-control" id="file" name="file">
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
