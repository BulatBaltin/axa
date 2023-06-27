<? include('partials/left-sidebar.view.php') ?>

<div id="main-right" class="container-fluid">
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="/dashboard/roles/create">
                Add Role
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        Role List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div class="dt-buttons"><a class="btn buttons-copy buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Copy</span></a><a class="btn buttons-csv buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>CSV</span></a><a class="btn buttons-excel buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Excel</span></a><a class="btn buttons-pdf buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>PDF</span></a><a class="btn buttons-print btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Print</span></a><a class="btn buttons-collection buttons-colvis btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Column visibility</span></a><a class="btn btn-danger" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Delete selected</span></a></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0"></label></div><div class="dataTables_scroll"><div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;"><div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 879.2px; padding-right: 0px;"><table class="table table-bordered table-striped table-hover datatable datatable-Role dataTable no-footer" role="grid" style="margin-left: 0px; width: 879.2px;"><thead>
                    <tr role="row"><th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10.2px;" aria-label="

                        ">

                        </th><th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 15px;" aria-sort="descending" aria-label="
                            ID
                        : activate to sort column ascending">
                            ID
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 29.4px;" aria-label="
                            Title
                        : activate to sort column ascending">
                            Title
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 572.6px;" aria-label="
                            Permissions
                        : activate to sort column ascending">
                            Permissions
                        </th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30.4px;" aria-label="
                            &amp;nbsp;
                        ">
                            &nbsp;
                        </th></tr>
                </thead></table></div></div><div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;"><table class="table table-bordered table-striped table-hover datatable datatable-Role dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 880px;"><thead>
                    <tr role="row" style="height: 0px;"><th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10.2px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">

                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 15px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            ID
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 29.4px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Title
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 572.6px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Permissions
                        </div></th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 30.4px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            &nbsp;
                        </div></th></tr>
                </thead>
                
                <tbody>
                                            
                                            
                                    <tr data-entry-id="2" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                2
                            </td>
                            <td>
                                User
                            </td>
                            <td>
                                                                    <span class="badge badge-info">expense_management_access</span>
                                                                    <span class="badge badge-info">expense_category_create</span>
                                                                    <span class="badge badge-info">expense_category_edit</span>
                                                                    <span class="badge badge-info">expense_category_show</span>
                                                                    <span class="badge badge-info">expense_category_delete</span>
                                                                    <span class="badge badge-info">expense_category_access</span>
                                                                    <span class="badge badge-info">income_category_create</span>
                                                                    <span class="badge badge-info">income_category_edit</span>
                                                                    <span class="badge badge-info">income_category_show</span>
                                                                    <span class="badge badge-info">income_category_delete</span>
                                                                    <span class="badge badge-info">income_category_access</span>
                                                                    <span class="badge badge-info">expense_create</span>
                                                                    <span class="badge badge-info">expense_edit</span>
                                                                    <span class="badge badge-info">expense_show</span>
                                                                    <span class="badge badge-info">expense_delete</span>
                                                                    <span class="badge badge-info">expense_access</span>
                                                                    <span class="badge badge-info">income_create</span>
                                                                    <span class="badge badge-info">income_edit</span>
                                                                    <span class="badge badge-info">income_show</span>
                                                                    <span class="badge badge-info">income_delete</span>
                                                                    <span class="badge badge-info">income_access</span>
                                                                    <span class="badge badge-info">expense_report_create</span>
                                                                    <span class="badge badge-info">expense_report_edit</span>
                                                                    <span class="badge badge-info">expense_report_show</span>
                                                                    <span class="badge badge-info">expense_report_delete</span>
                                                                    <span class="badge badge-info">expense_report_access</span>
                                                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/roles/2">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/roles/2/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/roles/2" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="3LYsyl82Wu5641WrDRhPSF65VAsJLN8k99kU2WD4">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="1" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                1
                            </td>
                            <td>
                                Admin
                            </td>
                            <td>
                                                                    <span class="badge badge-info">user_management_access</span>
                                                                    <span class="badge badge-info">permission_create</span>
                                                                    <span class="badge badge-info">permission_edit</span>
                                                                    <span class="badge badge-info">permission_show</span>
                                                                    <span class="badge badge-info">permission_delete</span>
                                                                    <span class="badge badge-info">permission_access</span>
                                                                    <span class="badge badge-info">role_create</span>
                                                                    <span class="badge badge-info">role_edit</span>
                                                                    <span class="badge badge-info">role_show</span>
                                                                    <span class="badge badge-info">role_delete</span>
                                                                    <span class="badge badge-info">role_access</span>
                                                                    <span class="badge badge-info">user_create</span>
                                                                    <span class="badge badge-info">user_edit</span>
                                                                    <span class="badge badge-info">user_show</span>
                                                                    <span class="badge badge-info">user_delete</span>
                                                                    <span class="badge badge-info">user_access</span>
                                                                    <span class="badge badge-info">expense_management_access</span>
                                                                    <span class="badge badge-info">expense_category_create</span>
                                                                    <span class="badge badge-info">expense_category_edit</span>
                                                                    <span class="badge badge-info">expense_category_show</span>
                                                                    <span class="badge badge-info">expense_category_delete</span>
                                                                    <span class="badge badge-info">expense_category_access</span>
                                                                    <span class="badge badge-info">income_category_create</span>
                                                                    <span class="badge badge-info">income_category_edit</span>
                                                                    <span class="badge badge-info">income_category_show</span>
                                                                    <span class="badge badge-info">income_category_delete</span>
                                                                    <span class="badge badge-info">income_category_access</span>
                                                                    <span class="badge badge-info">expense_create</span>
                                                                    <span class="badge badge-info">expense_edit</span>
                                                                    <span class="badge badge-info">expense_show</span>
                                                                    <span class="badge badge-info">expense_delete</span>
                                                                    <span class="badge badge-info">expense_access</span>
                                                                    <span class="badge badge-info">income_create</span>
                                                                    <span class="badge badge-info">income_edit</span>
                                                                    <span class="badge badge-info">income_show</span>
                                                                    <span class="badge badge-info">income_delete</span>
                                                                    <span class="badge badge-info">income_access</span>
                                                                    <span class="badge badge-info">expense_report_create</span>
                                                                    <span class="badge badge-info">expense_report_edit</span>
                                                                    <span class="badge badge-info">expense_report_show</span>
                                                                    <span class="badge badge-info">expense_report_delete</span>
                                                                    <span class="badge badge-info">expense_report_access</span>
                                                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/roles/1">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/roles/1/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/roles/1" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="3LYsyl82Wu5641WrDRhPSF65VAsJLN8k99kU2WD4">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr></tbody>
            </table></div></div><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 2 of 2 entries</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class=" previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class=" active"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class=" next disabled" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div><div class="actions"></div></div>
        </div>


    </div>
</div>

            </div>