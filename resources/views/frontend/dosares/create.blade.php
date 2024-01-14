@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.dosare.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.dosares.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.dosare.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="first_name">{{ trans('cruds.dosare.fields.first_name') }}</label>
                            <input class="form-control" type="text" name="first_name" id="first_name" value="{{ old('first_name', '') }}" required>
                            @if($errors->has('first_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('first_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.first_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="email_id">{{ trans('cruds.dosare.fields.email') }}</label>
                            <select class="form-control select2" name="email_id" id="email_id" required>
                                @foreach($emails as $id => $entry)
                                    <option value="{{ $id }}" {{ old('email_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="company_name">{{ trans('cruds.dosare.fields.company_name') }}</label>
                            <input class="form-control" type="text" name="company_name" id="company_name" value="{{ old('company_name', '') }}">
                            @if($errors->has('company_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('company_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.company_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="cui">{{ trans('cruds.dosare.fields.cui') }}</label>
                            <input class="form-control" type="number" name="cui" id="cui" value="{{ old('cui', '') }}" step="1" required>
                            @if($errors->has('cui'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cui') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.cui_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="incident_date">{{ trans('cruds.dosare.fields.incident_date') }}</label>
                            <input class="form-control datetime" type="text" name="incident_date" id="incident_date" value="{{ old('incident_date') }}">
                            @if($errors->has('incident_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('incident_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.incident_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="id_card">{{ trans('cruds.dosare.fields.id_card') }}</label>
                            <div class="needsclick dropzone" id="id_card-dropzone">
                            </div>
                            @if($errors->has('id_card'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('id_card') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.id_card_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="asig_paper">{{ trans('cruds.dosare.fields.asig_paper') }}</label>
                            <div class="needsclick dropzone" id="asig_paper-dropzone">
                            </div>
                            @if($errors->has('asig_paper'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('asig_paper') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.asig_paper_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="aditional_files">{{ trans('cruds.dosare.fields.aditional_files') }}</label>
                            <div class="needsclick dropzone" id="aditional_files-dropzone">
                            </div>
                            @if($errors->has('aditional_files'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('aditional_files') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.aditional_files_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="aditional_photos">{{ trans('cruds.dosare.fields.aditional_photos') }}</label>
                            <div class="needsclick dropzone" id="aditional_photos-dropzone">
                            </div>
                            @if($errors->has('aditional_photos'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('aditional_photos') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.dosare.fields.aditional_photos_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.idCardDropzone = {
    url: '{{ route('frontend.dosares.storeMedia') }}',
    maxFilesize: 4, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 4,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="id_card"]').remove()
      $('form').append('<input type="hidden" name="id_card" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="id_card"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($dosare) && $dosare->id_card)
      var file = {!! json_encode($dosare->id_card) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="id_card" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    Dropzone.options.asigPaperDropzone = {
    url: '{{ route('frontend.dosares.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="asig_paper"]').remove()
      $('form').append('<input type="hidden" name="asig_paper" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="asig_paper"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($dosare) && $dosare->asig_paper)
      var file = {!! json_encode($dosare->asig_paper) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="asig_paper" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    var uploadedAditionalFilesMap = {}
Dropzone.options.aditionalFilesDropzone = {
    url: '{{ route('frontend.dosares.storeMedia') }}',
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="aditional_files[]" value="' + response.name + '">')
      uploadedAditionalFilesMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAditionalFilesMap[file.name]
      }
      $('form').find('input[name="aditional_files[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($dosare) && $dosare->aditional_files)
          var files =
            {!! json_encode($dosare->aditional_files) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="aditional_files[]" value="' + file.file_name + '">')
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
<script>
    var uploadedAditionalPhotosMap = {}
Dropzone.options.aditionalPhotosDropzone = {
    url: '{{ route('frontend.dosares.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="aditional_photos[]" value="' + response.name + '">')
      uploadedAditionalPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAditionalPhotosMap[file.name]
      }
      $('form').find('input[name="aditional_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($dosare) && $dosare->aditional_photos)
      var files = {!! json_encode($dosare->aditional_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="aditional_photos[]" value="' + file.file_name + '">')
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