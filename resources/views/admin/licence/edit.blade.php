@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.licence.actions.edit', ['name' => $licence->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <licence-form
                :action="'{{ $licence->resource_url }}'"
                :data="{{ $licence->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.licence.actions.edit', ['name' => $licence->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.licence.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </licence-form>

        </div>
    
</div>

@endsection