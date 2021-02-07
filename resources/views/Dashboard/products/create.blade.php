@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                   <li><a href="{{ route('admin.products') }}"> @lang('site.products')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->

                <div class="box-body">
                    <!-- check all field filled -->
                    @include('partials._errors')

                    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}
                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image" >
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('website') }}" >
                        </div>


                        <div class="form-group">
                            <label>height</label>
                            <input type="number" name="height" class="form-control" value="{{ old('height') }}" >
                        </div>
                        <div class="form-group">
                            <label>width</label>
                            <input type="number" name="width" class="form-control" value="{{ old('width') }}" >
                        </div>
                        <div class="form-group">
                            <label>description</label>
                            <textarea name="description" id="" cols="140" rows="10"></textarea>
                             </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
