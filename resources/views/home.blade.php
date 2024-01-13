@extends('layouts.app')

@push('style')
<style>
    .form-group {
        margin-bottom: 20px;
    }

    .d-none {
        display: none;
    }
</style>

@endpush
@section('content')
<div class="fluid-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Blogs') }}</div>

                <div class="card-body">
                    <button class="btn btn-success" onclick="addBlogForm(0)">Add Blog</button>
                    <table class="table text-md-nowrap" id="blogTable" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Author</th>
                                <th>Image</th>
                                <th>Content</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal --}}

<div class="modal" id="blogModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Blog</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-12 grid-margin">
                <form class="forms-sample" id="blogForm">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"> Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"> Date <span class="required">*</span></label>
                                <input type="date" class="form-control" id="date" name="date" placeholder="date">
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"> Author <span class="required">*</span></label>
                                <input type="text" class="form-control" id="author" name="author" placeholder="Author">
                            </div>
                        </div>
                        <br>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Content<span class="required">*</span></label>
                                <textarea class="form-control" id="content" name="content" id="content" rows="4"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Add Image<span class="required">*</span></label>
                                <input type="file" name="image" id="image" class="file-upload-default">
                                <div id="showImg">
                                    <img src="" id="imageShow" alt="" style="width: 460px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                </form>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="blogButton" onclick="saveBlog(event)">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')

@include('datatable')
@include('script')

@endsection
