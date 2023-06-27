<? include('partials/left-sidebar.view.php') ?>

<div id="main-right" class="container-fluid">
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="<? path('admin-expenses-create')?>">
                Add Expense
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        Expense List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div class="dt-buttons"><a class="btn buttons-copy buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Copy</span></a><a class="btn buttons-csv buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>CSV</span></a><a class="btn buttons-excel buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Excel</span></a><a class="btn buttons-pdf buttons-html5 btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>PDF</span></a><a class="btn buttons-print btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Print</span></a><a class="btn buttons-collection buttons-colvis btn-default" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Column visibility</span></a><a class="btn btn-danger" tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Delete selected</span></a></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0"></label></div><div class="dataTables_scroll"><div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;"><div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 862.4px; padding-right: 17px;"><table class="table table-bordered table-striped table-hover datatable datatable-Expense dataTable no-footer" role="grid" style="margin-left: 0px; width: 862.4px;"><thead>
                    <tr role="row"><th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10.2px;" aria-label="

                        ">

                        </th><th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 23px;" aria-sort="descending" aria-label="
                            ID
                        : activate to sort column ascending">
                            ID
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 138.2px;" aria-label="
                            Expense Category
                        : activate to sort column ascending">
                            Expense Category
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 84.6px;" aria-label="
                            Entry Date
                        : activate to sort column ascending">
                            Entry Date
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 67px;" aria-label="
                            Amount
                        : activate to sort column ascending">
                            Amount
                        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 91.8px;" aria-label="
                            Description
                        : activate to sort column ascending">
                            Description
                        </th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 128px;" aria-label="
                            &amp;nbsp;
                        ">
                            &nbsp;
                        </th></tr>
                </thead></table></div></div><div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;"><table class="table table-bordered table-striped table-hover datatable datatable-Expense dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 863px;"><thead>
                    <tr role="row" style="height: 0px;"><th width="10" class="select-checkbox sorting_disabled" rowspan="1" colspan="1" style="width: 10.2px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">

                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 23px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            ID
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 138.2px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Expense Category
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 84.6px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Entry Date
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 67px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Amount
                        </div></th><th class="sorting" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 91.8px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            Description
                        </div></th><th class="sorting_disabled" rowspan="1" colspan="1" style="width: 128px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"><div class="dataTables_sizing" style="height: 0px; overflow: hidden;">
                            &nbsp;
                        </div></th></tr>
                </thead>
                
                <tbody>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                    <tr data-entry-id="15" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                15
                            </td>
                            <td>
                                Ut maxime.
                            </td>
                            <td>
                                2021-04-07
                            </td>
                            <td>
                                347.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/15">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/15/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/15" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="14" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                14
                            </td>
                            <td>
                                Ullam.
                            </td>
                            <td>
                                2021-04-10
                            </td>
                            <td>
                                109.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/14">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/14/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/14" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="13" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                13
                            </td>
                            <td>
                                Corporis.
                            </td>
                            <td>
                                2021-05-02
                            </td>
                            <td>
                                274.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/13">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/13/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/13" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="12" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                12
                            </td>
                            <td>
                                Aliquid quas.
                            </td>
                            <td>
                                2021-04-21
                            </td>
                            <td>
                                273.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/12">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/12/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/12" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="11" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                11
                            </td>
                            <td>
                                Doloribus.
                            </td>
                            <td>
                                2021-04-16
                            </td>
                            <td>
                                254.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/11">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/11/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/11" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="10" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                10
                            </td>
                            <td>
                                Ut maxime.
                            </td>
                            <td>
                                2021-04-25
                            </td>
                            <td>
                                496.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/10">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/10/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/10" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="9" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                9
                            </td>
                            <td>
                                Consequatur.
                            </td>
                            <td>
                                2021-03-13
                            </td>
                            <td>
                                61.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/9">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/9/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/9" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="8" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                8
                            </td>
                            <td>
                                Ut maxime.
                            </td>
                            <td>
                                2021-03-26
                            </td>
                            <td>
                                127.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/8">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/8/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/8" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="7" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                7
                            </td>
                            <td>
                                Quis sint.
                            </td>
                            <td>
                                2021-03-18
                            </td>
                            <td>
                                301.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/7">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/7/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/7" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="6" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                6
                            </td>
                            <td>
                                Ullam.
                            </td>
                            <td>
                                2021-04-23
                            </td>
                            <td>
                                388.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/6">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/6/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/6" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="5" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                5
                            </td>
                            <td>
                                Aliquid quas.
                            </td>
                            <td>
                                2021-03-15
                            </td>
                            <td>
                                241.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/5">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/5/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/5" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="4" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                4
                            </td>
                            <td>
                                Sunt sunt.
                            </td>
                            <td>
                                2021-03-24
                            </td>
                            <td>
                                202.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/4">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/4/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/4" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="3" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                3
                            </td>
                            <td>
                                Ut maxime.
                            </td>
                            <td>
                                2021-03-15
                            </td>
                            <td>
                                391.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/3">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/3/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/3" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="2" role="row" class="even">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                2
                            </td>
                            <td>
                                Aut unde.
                            </td>
                            <td>
                                2021-03-22
                            </td>
                            <td>
                                164.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/2">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/2/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/2" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr><tr data-entry-id="1" role="row" class="odd">
                            <td class=" select-checkbox">

                            </td>
                            <td class="sorting_1">
                                1
                            </td>
                            <td>
                                Aut unde.
                            </td>
                            <td>
                                2021-05-21
                            </td>
                            <td>
                                121.00
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                                                    <a class="btn btn-xs btn-primary" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/1">
                                        View
                                    </a>
                                
                                                                    <a class="btn btn-xs btn-info" href="http://demo-expense-manager.quickadminpanel.com/admin/expenses/1/edit">
                                        Edit
                                    </a>
                                
                                                                    <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses/1" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="SSCKfhfCv1FID35f5ZAuzKZ1rQna4R2TZpyD2doJ">
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                
                            </td>

                        </tr></tbody>
            </table></div></div><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 15 of 15 entries</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class=" previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class=" active"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class=" next disabled" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div><div class="actions"></div></div>
        </div>


    </div>
</div>

            </div>