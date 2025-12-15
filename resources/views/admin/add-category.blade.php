@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Add New Category</h2>
        <a href="{{ route('admin.categories') }}" class="btn-cancel">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>

    <div class="form-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="addCategoryForm" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="categoryName" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="categoryName" placeholder="Enter category name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="categoryDescription" rows="4" placeholder="Enter category description"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="activeStatus" value="active" checked>
                            <label class="form-check-label" for="activeStatus">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="inactiveStatus" value="inactive">
                            <label class="form-check-label" for="inactiveStatus">
                                Inactive
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label class="form-label">Category Icon (Menu/Landing) <span class="text-danger">*</span></label>
                        
                        <div class="image-upload" onclick="document.getElementById('categoryImage').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload icon</p>
                            <small>JPG, PNG, or GIF (Max 2MB)</small>
                            <input type="file" name="image" id="categoryImage" class="file-input" accept="image/*" required onchange="previewImage(this, 'imagePreview')">
                        </div>
                        
                        <img id="imagePreview" class="image-preview" src="#" alt="Preview" style="display:none; max-width: 100%; margin-top: 10px;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category Page Background</label>
                        
                        <div class="image-upload" onclick="document.getElementById('bgImage').click()">
                            <i class="fas fa-image"></i>
                            <p>Click to upload header background</p>
                            <small>JPG, PNG, or GIF (Max 2MB)</small>
                            <input type="file" name="background_image" id="bgImage" class="file-input" accept="image/*" onchange="previewImage(this, 'bgPreview')">
                        </div>
                        
                        <img id="bgPreview" class="image-preview" src="#" alt="Preview" style="display:none; max-width: 100%; margin-top: 10px;">
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn-cancel me-2" onclick="categoryManager.cancelForm()">Cancel</button>
                <button type="submit" class="btn-add">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/addcategoriadmin.js') }}"></script>
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(previewId).style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush