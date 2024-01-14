<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDosareRequest;
use App\Http\Requests\StoreDosareRequest;
use App\Http\Requests\UpdateDosareRequest;
use App\Models\Dosare;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class DosareController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('dosare_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dosares = Dosare::with(['email', 'media'])->get();

        return view('admin.dosares.index', compact('dosares'));
    }

    public function create()
    {
        abort_if(Gate::denies('dosare_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emails = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dosares.create', compact('emails'));
    }

    public function store(StoreDosareRequest $request)
    {
        $dosare = Dosare::create($request->all());

        if ($request->input('id_card', false)) {
            $dosare->addMedia(storage_path('tmp/uploads/' . basename($request->input('id_card'))))->toMediaCollection('id_card');
        }

        if ($request->input('asig_paper', false)) {
            $dosare->addMedia(storage_path('tmp/uploads/' . basename($request->input('asig_paper'))))->toMediaCollection('asig_paper');
        }

        foreach ($request->input('aditional_files', []) as $file) {
            $dosare->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('aditional_files');
        }

        foreach ($request->input('aditional_photos', []) as $file) {
            $dosare->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('aditional_photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $dosare->id]);
        }

        return redirect()->route('admin.dosares.index');
    }

    public function edit(Dosare $dosare)
    {
        abort_if(Gate::denies('dosare_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emails = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dosare->load('email');

        return view('admin.dosares.edit', compact('dosare', 'emails'));
    }

    public function update(UpdateDosareRequest $request, Dosare $dosare)
    {
        $dosare->update($request->all());

        if ($request->input('id_card', false)) {
            if (! $dosare->id_card || $request->input('id_card') !== $dosare->id_card->file_name) {
                if ($dosare->id_card) {
                    $dosare->id_card->delete();
                }
                $dosare->addMedia(storage_path('tmp/uploads/' . basename($request->input('id_card'))))->toMediaCollection('id_card');
            }
        } elseif ($dosare->id_card) {
            $dosare->id_card->delete();
        }

        if ($request->input('asig_paper', false)) {
            if (! $dosare->asig_paper || $request->input('asig_paper') !== $dosare->asig_paper->file_name) {
                if ($dosare->asig_paper) {
                    $dosare->asig_paper->delete();
                }
                $dosare->addMedia(storage_path('tmp/uploads/' . basename($request->input('asig_paper'))))->toMediaCollection('asig_paper');
            }
        } elseif ($dosare->asig_paper) {
            $dosare->asig_paper->delete();
        }

        if (count($dosare->aditional_files) > 0) {
            foreach ($dosare->aditional_files as $media) {
                if (! in_array($media->file_name, $request->input('aditional_files', []))) {
                    $media->delete();
                }
            }
        }
        $media = $dosare->aditional_files->pluck('file_name')->toArray();
        foreach ($request->input('aditional_files', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $dosare->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('aditional_files');
            }
        }

        if (count($dosare->aditional_photos) > 0) {
            foreach ($dosare->aditional_photos as $media) {
                if (! in_array($media->file_name, $request->input('aditional_photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $dosare->aditional_photos->pluck('file_name')->toArray();
        foreach ($request->input('aditional_photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $dosare->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('aditional_photos');
            }
        }

        return redirect()->route('admin.dosares.index');
    }

    public function show(Dosare $dosare)
    {
        abort_if(Gate::denies('dosare_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dosare->load('email');

        return view('admin.dosares.show', compact('dosare'));
    }

    public function destroy(Dosare $dosare)
    {
        abort_if(Gate::denies('dosare_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dosare->delete();

        return back();
    }

    public function massDestroy(MassDestroyDosareRequest $request)
    {
        $dosares = Dosare::find(request('ids'));

        foreach ($dosares as $dosare) {
            $dosare->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('dosare_create') && Gate::denies('dosare_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Dosare();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
