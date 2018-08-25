@extends('layouts.master')

@section('content')
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
        <h3 class="box-title">Title</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
            <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
        
        </div>

            <div class="box-body">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Форма</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Юр лицо</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li>
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <task-create></task-create>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <list-legal></list-legal>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        ...
                    </div>
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>

            </div>
        <!-- /.box-body -->
        <div class="box-footer">
        Footer
    </div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->
</section>


@endsection