@extends('voyager::master')

@section('content')

<div id="app">
<h1 class="page-title">
    <i class="voyager-external"></i>
    Add New Redirect
</h1>
<div id="voyager-notifications"></div>
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add" action="@if(isset($redirect->id)){{ route('voyager.redirects.edit.post') }}@else{{ route('voyager.redirects.add.post') }}@endif" method="POST">

                        @if(isset($redirect->id))
                            <input type="hidden" name="id" value="{{ $redirect->id }}">
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}
                        <div class="panel-body">
                            
                            <div class="form-group  col-md-5">
                                <label for="from">Redirect from (don't include the full URL, only the URI, ex. '/awesome/page')</label>
                                <input required="true" type="text" class="form-control" name="from" placeholder="Redirect from" value="@if(isset($redirect->from)){{ $redirect->from }}@endif">
                            </div>
                            
                            <div class="form-group  col-md-5">
                                <label for="to">Redirect To</label>
                                <input required="true" type="text" class="form-control" name="to" placeholder="Redirect to" value="@if(isset($redirect->to)){{ $redirect->to }}@endif">
                            </div>

                            <div class="form-group  col-md-2">
                                <label for="type" style="display:block;">Type</label>
                                <select name="type" id="type">
                                    <option value="301" @if(isset($redirect->type) && $redirect->type == '301'){{ 'selected' }}@endif>301</option>
                                    <option value="302" @if(isset($redirect->type) && $redirect->type == '302'){{ 'selected' }}@endif>302</option>
                                    <option value="303" @if(isset($redirect->type) && $redirect->type == '303'){{ 'selected' }}@endif>303</option>
                                    <option value="307" @if(isset($redirect->type) && $redirect->type == '307'){{ 'selected' }}@endif>307</option>
                                    <option value="308" @if(isset($redirect->type) && $redirect->type == '308'){{ 'selected' }}@endif>308</option>
                                </select>
                            </div>
                            
                                
                        </div><!-- panel-body -->
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection