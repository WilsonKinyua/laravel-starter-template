@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.inventory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.inventories.update", [$inventory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="vehicle">{{ trans('cruds.inventory.fields.vehicle') }} ID</label>
                <input class="form-control {{ $errors->has('vehicle') ? 'is-invalid' : '' }}" type="text" name="vehicle" id="vehicle" value="{{ old('vehicle', $inventory->vehicle) }}" required>
                @if($errors->has('vehicle'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vehicle') }}
                    </div>
                @endif
                {{-- <span class="help-block">{{ trans('cruds.inventory.fields.vehicle_helper') }}</span> --}}
            </div>
            <div class="form-group">
                <label class="required" for="engine_type">{{ trans('cruds.inventory.fields.engine_type') }}</label>
                <input class="form-control {{ $errors->has('engine_type') ? 'is-invalid' : '' }}" type="text" name="engine_type" id="engine_type" value="{{ old('engine_type', $inventory->engine_type) }}" required>
                @if($errors->has('engine_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('engine_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.inventory.fields.engine_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="transmission">{{ trans('cruds.inventory.fields.transmission') }}</label>
                <input class="form-control {{ $errors->has('transmission') ? 'is-invalid' : '' }}" type="text" name="transmission" id="transmission" value="{{ old('transmission', $inventory->transmission) }}" required>
                @if($errors->has('transmission'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transmission') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.inventory.fields.transmission_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="interior_color">{{ trans('cruds.inventory.fields.interior_color') }}</label>
                <input class="form-control {{ $errors->has('interior_color') ? 'is-invalid' : '' }}" type="text" name="interior_color" id="interior_color" value="{{ old('interior_color', $inventory->interior_color) }}">
                @if($errors->has('interior_color'))
                    <div class="invalid-feedback">
                        {{ $errors->first('interior_color') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.inventory.fields.interior_color_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="exterior_color">{{ trans('cruds.inventory.fields.exterior_color') }}</label>
                <input class="form-control {{ $errors->has('exterior_color') ? 'is-invalid' : '' }}" type="text" name="exterior_color" id="exterior_color" value="{{ old('exterior_color', $inventory->exterior_color) }}">
                @if($errors->has('exterior_color'))
                    <div class="invalid-feedback">
                        {{ $errors->first('exterior_color') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.inventory.fields.exterior_color_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pictures">{{ trans('cruds.inventory.fields.pictures') }}</label>
                <div class="needsclick dropzone {{ $errors->has('pictures') ? 'is-invalid' : '' }}" id="pictures-dropzone">
                </div>
                @if($errors->has('pictures'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pictures') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.inventory.fields.pictures_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    Update Inventory
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    var uploadedPicturesMap = {}
Dropzone.options.picturesDropzone = {
    url: '{{ route('admin.inventories.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="pictures[]" value="' + response.name + '">')
      uploadedPicturesMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPicturesMap[file.name]
      }
      $('form').find('input[name="pictures[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($inventory) && $inventory->pictures)
      var files = {!! json_encode($inventory->pictures) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="pictures[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection
