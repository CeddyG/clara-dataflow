@extends('admin/dashboard')

@section('CSS')
    <!-- Select 2 -->
    {!! Html::style('bower_components/select2/dist/css/select2.min.css') !!}
    <style>
        .select2
        {
            width: 100% !important
        }
        
        .input-group
        {
            width: 100% !important
        }
        
        .input-group-addon:hover
        {
            color: black;
        }
        
        .cell-sortable
        {
            width: 30px;
            vertical-align: middle !important;
            cursor: all-scroll;
        }
        
        #add-line-column,
        #add-line-clause
        {
            margin-bottom: 5px;
        }
        
        .del-action
        {
            width: 55px;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <br>
            <div class="box box-info">	
                <div class="box-header with-border">
                    @if(isset($oItem))
                        <h3 class="box-title">Modification</h3>
                    @else
                        <h3 class="box-title">Ajouter</h3>
                    @endif
                </div>
                <div class="box-body"> 
                    <div class="col-sm-12">
                        @if(isset($oItem))
                            {!! BootForm::open()->action( route('admin.dataflow.update', $oItem->id_dataflow) )->put() !!}
                            {!! BootForm::bind($oItem) !!}
                        @else
                            {!! BootForm::open()->action( url('admin/dataflow') )->post() !!}
                        @endif
                        
                        {!! BootForm::text(trans('clara-dataflow::dataflow.name'), 'name') !!}
                        
                        @if(isset($oItem))
                            {!! BootForm::select(trans('clara-dataflow::dataflow.repository'), 'repository')
                                ->class('select2')
                                ->options($aRepositories)
                                ->select($oItem->repository) !!}
                            
                            {!! BootForm::text(trans('clara-dataflow::dataflow.separator_csv_column'), 
                                'separator_csv[]', 
                                str_replace(["\t", "\n", "\r"], ["\\t",  "\\n",  "\\r"], $oItem->separator_csv['colonne'])) !!}
                            {!! BootForm::text(trans('clara-dataflow::dataflow.separator_csv_line'), 
                                'separator_csv[]', 
                                str_replace(["\t", "\n", "\r"], ["\\t",  "\\n",  "\\r"], $oItem->separator_csv['ligne'])) !!}
                            {!! BootForm::text(trans('clara-dataflow::dataflow.separator_csv_text'), 
                                'separator_csv[]', 
                                str_replace(["\t", "\n", "\r"], ["\\t",  "\\n",  "\\r"], $oItem->separator_csv['texte'])) !!}
                        @else
                            {!! BootForm::select(trans('clara-dataflow::dataflow.repository'), 'repository')
                                ->class('select2')
                                ->options($aRepositories) !!}
                                
                            {!! BootForm::text(trans('clara-dataflow::dataflow.separator_csv_column'), 'separator_csv[]') !!}
                            {!! BootForm::text(trans('clara-dataflow::dataflow.separator_csv_line'), 'separator_csv[]') !!}
                            {!! BootForm::text(trans('clara-dataflow::dataflow.separator_csv_text'), 'separator_csv[]') !!}
                        @endif
                        
                        <div class="form-group">
                            <label>
                                {{ trans('clara-dataflow::dataflow.columns') }}
                            </label>
                        
                            <button id="add-line-column" class="btn btn-default pull-right" type="button">
                                <i class="glyphicon glyphicon-plus"></i>
                            </button>

                            <table id="tab-column" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>{{ trans('clara-dataflow::dataflow.head') }}</td>
                                        <td>{{ trans('clara-dataflow::dataflow.column') }}</td>
                                        <td class="del-action"></td>
                                    </tr>
                                </thead>
                                <tbody class="ui-sortable">
                                    @if(isset($oItem))
                                        @foreach($oItem->columns as $sHead => $sColumn)
                                            <tr>
                                                <td class="cell-sortable">
                                                    <span class="handle ui-sortable-handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <input value="{{ $sHead }}" name="column-head[]" class="form-control" type="text" />
                                                </td>
                                                <td>
                                                    <input value="{{ $sColumn }}" name="column-column[]" class="form-control" type="text" />
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger del-column" type="button">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="cell-sortable">
                                                <span class="handle ui-sortable-handle">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </span>
                                            </td>
                                            <td>
                                                <input value="" name="column-head[]" class="form-control" type="text" />
                                            </td>
                                            <td>
                                                <input value="" name="column-column[]" class="form-control" type="text" />
                                            </td>
                                            <td>
                                                <button class="btn btn-danger del-column" type="button">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                {{ trans('clara-dataflow::dataflow.where_clause') }}
                            </label>
                            
                            <button id="add-line-clause" class="btn btn-default pull-right" type="button">
                                <i class="glyphicon glyphicon-plus"></i>
                            </button>
                            
                            <table id="tab-clause" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>{{ trans('clara-dataflow::dataflow.column') }}</td>
                                        <td>{{ trans('clara-dataflow::dataflow.operator') }}</td>
                                        <td>{{ trans('clara-dataflow::dataflow.value') }}</td>
                                        <td class="del-action"></td>
                                    </tr>
                                </thead>
                                <tbody class="ui-sortable">
                                    @if(isset($oItem))
                                        @foreach($oItem->where_clause as $aClause)
                                            <tr>
                                                <td class="cell-sortable">
                                                    <span class="handle ui-sortable-handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <input value="{{ $aClause[0] }}" name="where_clause_column[]" class="form-control" type="text" />
                                                </td>
                                                <td>
                                                    <input value="{{ $aClause[1] }}" name="where_clause_operator[]" class="form-control" type="text" />
                                                </td>
                                                <td>
                                                    <input value="{{ $aClause[2] }}" name="where_clause_value[]" class="form-control" type="text" />
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger del-column" type="button">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="cell-sortable">
                                                <span class="handle ui-sortable-handle">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </span>
                                            </td>
                                            <td>
                                                <input value="" name="where_clause_column[]" class="form-control" type="text" />
                                            </td>
                                            <td>
                                                <input value="" name="where_clause_operator[]" class="form-control" type="text" />
                                            </td>
                                            <td>
                                                <input value="" name="where_clause_value[]" class="form-control" type="text" />
                                            </td>
                                            <td>
                                                <button class="btn btn-danger del-column" type="button">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        {!! BootForm::submit('Envoyer', 'btn-primary')->addClass('pull-right') !!}

                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
            <a href="javascript:history.back()" class="btn btn-primary">
                    <span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
            </a>
        </div>
    </div>
@stop

@section('JS')
    
    <!-- Select 2 -->
    {!! Html::script('bower_components/select2/dist/js/select2.full.min.js') !!}
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script> 

    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            
            $('#add-line-column').on('click', function(){
                $('#tab-column').append(
                    '<tr>'
                    +'<td class="cell-sortable">'
                    +'<span class="handle ui-sortable-handle">'
                    +'<i class="fa fa-ellipsis-v"></i> '
                    +'<i class="fa fa-ellipsis-v"></i>'
                    +'</span>'
                    +'</td>'
                    +'<td>'
                    +'<input value="" name="column-head[]" class="form-control" type="text" />'
                    +'</td>'
                    +'<td>'
                    +'<input value="" name="column-column[]" class="form-control" type="text" />'
                    +'</td>'
                    +'<td>'
                    +'<button class="btn btn-danger del-column" type="button">'
                    +'<i class="glyphicon glyphicon-trash"></i>'
                    +'</button>'
                    +'</td>'
                    +'</tr>'
                );
            });
            
            $('#add-line-clause').on('click', function(){
                $('#tab-clause').append(
                    '<tr>'
                    +'<td class="cell-sortable">'
                    +'<span class="handle ui-sortable-handle">'
                    +'<i class="fa fa-ellipsis-v"></i> '
                    +'<i class="fa fa-ellipsis-v"></i>'
                    +'</span>'
                    +'</td>'
                    +'<td>'
                    +'<input value="" name="where_clause_column[]" class="form-control" type="text" />'
                    +'</td>'
                    +'<td>'
                    +'<input value="" name="where_clause_operator[]" class="form-control" type="text" />'
                    +'</td>'
                    +'<td>'
                    +'<input value="" name="where_clause_value[]" class="form-control" type="text" />'
                    +'</td>'
                    +'<td>'
                    +'<button class="btn btn-danger del-column" type="button">'
                    +'<i class="glyphicon glyphicon-trash"></i>'
                    +'</button>'
                    +'</td>'
                    +'</tr>'
                );
            });
            
            $('.ui-sortable').sortable();
            
            $('body').on('click', '.del-column', function() {
                $(this).parents('tr').remove();
            });
        });
    </script> 

@stop