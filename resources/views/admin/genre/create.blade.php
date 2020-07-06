@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.genre.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <genre-form
            :action="'{{ url('admin/genres') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.genre.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.genre.components.form-elements')

                    <div class="form-group row align-items-center" :class="{'has-danger': errors.has('cover'), 'has-success': fields.cover && fields.cover.valid }">
                        <label for="cover" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'"></label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            @include('brackets/admin-ui::admin.includes.media-uploader', [
                                'mediaCollection' => app(App\Models\Genre::class)->getMediaCollection('cover'),
                                'label' => 'Image'
                            ])
                        </div>
                    </div>
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </genre-form>

        </div>

        </div>

    
@endsection