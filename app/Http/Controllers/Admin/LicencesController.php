<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Licence\BulkDestroyLicence;
use App\Http\Requests\Admin\Licence\DestroyLicence;
use App\Http\Requests\Admin\Licence\IndexLicence;
use App\Http\Requests\Admin\Licence\StoreLicence;
use App\Http\Requests\Admin\Licence\UpdateLicence;
use App\Models\Licence;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LicencesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLicence $request
     * @return array|Factory|View
     */
    public function index(IndexLicence $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Licence::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'name', 'descriptions']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.licence.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.licence.create');

        return view('admin.licence.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLicence $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLicence $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Licence
        $licence = Licence::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/licences'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/licences');
    }

    /**
     * Display the specified resource.
     *
     * @param Licence $licence
     * @throws AuthorizationException
     * @return void
     */
    public function show(Licence $licence)
    {
        $this->authorize('admin.licence.show', $licence);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Licence $licence
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Licence $licence)
    {
        $this->authorize('admin.licence.edit', $licence);


        return view('admin.licence.edit', [
            'licence' => $licence,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLicence $request
     * @param Licence $licence
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLicence $request, Licence $licence)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Licence
        $licence->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/licences'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/licences');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLicence $request
     * @param Licence $licence
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLicence $request, Licence $licence)
    {
        $licence->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLicence $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLicence $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Licence::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
