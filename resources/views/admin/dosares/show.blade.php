@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.dosare.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dosares.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.id') }}
                        </th>
                        <td>
                            {{ $dosare->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Dosare::STATUS_SELECT[$dosare->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.name') }}
                        </th>
                        <td>
                            {{ $dosare->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.first_name') }}
                        </th>
                        <td>
                            {{ $dosare->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.email') }}
                        </th>
                        <td>
                            {{ $dosare->email->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.company_name') }}
                        </th>
                        <td>
                            {{ $dosare->company_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.cui') }}
                        </th>
                        <td>
                            {{ $dosare->cui }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.incident_date') }}
                        </th>
                        <td>
                            {{ $dosare->incident_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.id_card') }}
                        </th>
                        <td>
                            @if($dosare->id_card)
                                <a href="{{ $dosare->id_card->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $dosare->id_card->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.asig_paper') }}
                        </th>
                        <td>
                            @if($dosare->asig_paper)
                                <a href="{{ $dosare->asig_paper->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.aditional_files') }}
                        </th>
                        <td>
                            @foreach($dosare->aditional_files as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dosare.fields.aditional_photos') }}
                        </th>
                        <td>
                            @foreach($dosare->aditional_photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dosares.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection