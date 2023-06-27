<? include('partials/left-sidebar.view.php') ?>

<div id="main-right" class="container-fluid">
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/create">
                Add Income
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        Income List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div class="dt-buttons"><a class="btn buttons-copy buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Copy</span></a><a class="btn buttons-csv buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>CSV</span></a><a class="btn buttons-excel buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Excel</span></a><a class="btn buttons-pdf buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>PDF</span></a><a class="btn buttons-print btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Print</span></a><a class="btn buttons-collection buttons-colvis btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Column visibility</span></a><a class="btn btn-danger" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Delete selected</span></a></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0"></label></div><div class="dataTables_scroll"><div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;"><div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 862.4px; padding-right: 17px;"><table class="table table-bordered table-striped table-hover datatable datatable-Income dataTable no-footer" role="grid" style="margin-left: 0px; width: 862.4px;"><thead>
                    <tr role="row"><th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 9.4px;" aria-label="

                        ">

                        </th><th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 23.8px;" aria-sort="descending" aria-label="
                            ID
                        : activate to sort column ascending">
                            ID
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 133.4px;" aria-label="
                            Income Category
                        : activate to sort column ascending">
                            Income Category
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 85.4px;" aria-label="
                            Entry Date
                        : activate to sort column ascending">
                            Entry Date
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 70.2px;" aria-label="
                            Amount
                        : activate to sort column ascending">
                            Amount
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 95px;" aria-label="
                            Description
                        : activate to sort column ascending">
                            Description
                        </th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 125.6px;" aria-label="
                            &amp;nbsp;
                        ">
                            &nbsp;
                        </th></tr>
                </thead></table></div></div><div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;"><table class="table table-bordered table-striped table-hover datatable datatable-Income dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 881px;"><thead>
                    <tr role="row" style="height: 0px;"><th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 9.4px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">

                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 23.8px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            ID
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 133.4px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Income Category
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 85.4px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Entry Date
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 70.2px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Amount
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 95px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Description
                        </div></th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 125.6px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            &nbsp;
                        </div></th></tr>
                </thead>
                
                <tbody>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                    <tr data-entry-id="10" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                10
                            </td>
                            <td>
                                Laudantium.
                            </td>
                            <td>
                                2021-03-16
                            </td>
                            <td>
                                172.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/10">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/10/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/10" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="9" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                9
                            </td>
                            <td>
                                Deleniti.
                            </td>
                            <td>
                                2021-05-10
                            </td>
                            <td>
                                464.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/9">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/9/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/9" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="8" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                8
                            </td>
                            <td>
                                Et nulla.
                            </td>
                            <td>
                                2021-04-26
                            </td>
                            <td>
                                65.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/8">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/8/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/8" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="7" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                7
                            </td>
                            <td>
                                Autem qui.
                            </td>
                            <td>
                                2021-04-14
                            </td>
                            <td>
                                330.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/7">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/7/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/7" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="6" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                6
                            </td>
                            <td>
                                Laudantium.
                            </td>
                            <td>
                                2021-03-17
                            </td>
                            <td>
                                387.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/6">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/6/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/6" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="5" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                5
                            </td>
                            <td>
                                Dolorem ex.
                            </td>
                            <td>
                                2021-03-08
                            </td>
                            <td>
                                169.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/5">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/5/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/5" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="4" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                4
                            </td>
                            <td>
                                Earum veniam.
                            </td>
                            <td>
                                2021-03-22
                            </td>
                            <td>
                                422.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/4">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/4/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/4" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="3" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                3
                            </td>
                            <td>
                                Earum veniam.
                            </td>
                            <td>
                                2021-04-05
                            </td>
                            <td>
                                231.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/3">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/3/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/3" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="2" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                2
                            </td>
                            <td>
                                Dolorem ex.
                            </td>
                            <td>
                                2021-03-13
                            </td>
                            <td>
                                140.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/2">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/2/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/2" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
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
                                Eos.
                            </td>
                            <td>
                                2021-03-19
                            </td>
                            <td>
                                337.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/1">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/incomes/1/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/incomes/1" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr></tbody>
            </table></div></div><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 10 of 10 entries</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class=" previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class=" active"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class=" next disabled" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div><div class="actions"></div></div>
        </div>


    </div>
</div>

            </div>