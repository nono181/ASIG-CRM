@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('dosare_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.dosares.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.dosare.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.dosare.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Dosare">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.dosare.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.status') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.first_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.email') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.company_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.cui') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.incident_date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.id_card') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.asig_paper') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.aditional_files') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dosare.fields.aditional_photos') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dosares as $key => $dosare)
                                    <tr data-entry-id="{{ $dosare->id }}">
                                        <td>
                                            {{ $dosare->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Dosare::STATUS_SELECT[$dosare->status] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $dosare->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $dosare->first_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $dosare->email->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $dosare->email->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $dosare->company_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $dosare->cui ?? '' }}
                                        </td>
                                        <td>
                                            {{ $dosare->incident_date ?? '' }}
                                        </td>
                                        <td>
                                            @if($dosare->id_card)
                                                <a href="{{ $dosare->id_card->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $dosare->id_card->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($dosare->asig_paper)
                                                <a href="{{ $dosare->asig_paper->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($dosare->aditional_files as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($dosare->aditional_photos as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            @can('dosare_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.dosares.show', $dosare->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('dosare_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.dosares.edit', $dosare->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('dosare_delete')
                                                <form action="{{ route('frontend.dosares.destroy', $dosare->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('dosare_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.dosares.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Dosare:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection