<? include('partials/left-sidebar.view.php') ?>

<div id="main-right" class="container-fluid">
                                                
<div class="card">
    <div class="card-header">
        Create Expense
    </div>

    <div class="card-body">
        <form action="http://demo-expense-manager.quickadminpanel.com/admin/expenses" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="xPBZVnlq2QJGlgaah7kidoO7OxiiiLEkTyVssk6m">            <div class="form-group ">
                <label for="expense_category">Expense Category</label>
                <select name="expense_category_id" id="expense_category" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                            <option value="" selected="">Please select</option>
                                            <option value="1">Qui.</option>
                                            <option value="2">Quidem culpa.</option>
                                            <option value="3">Eum non.</option>
                                            <option value="4">Quas.</option>
                                            <option value="5">Delectus.</option>
                                            <option value="6">Nobis omnis.</option>
                                            <option value="7">Id non quod.</option>
                                            <option value="8">Omnis in.</option>
                                            <option value="9">Veritatis.</option>
                                            <option value="10">Officia.</option>
                                    </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 879.6px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-expense_category-container"><span class="select2-selection__rendered" id="select2-expense_category-container" title="Please select">Please select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
            <div class="form-group ">
                <label for="entry_date">Entry Date*</label>
                <input type="text" id="entry_date" name="entry_date" class="form-control date" value="" required="">
                                <p class="helper-block">
                    
                </p>
            </div>
            <div class="form-group ">
                <label for="amount">Amount*</label>
                <input type="number" id="amount" name="amount" class="form-control" value="" step="0.01" required="">
                                <p class="helper-block">
                    
                </p>
            </div>
            <div class="form-group ">
                <label for="description">Description</label>
                <input type="text" id="description" name="description" class="form-control" value="">
                                <p class="helper-block">
                    
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="Save">
            </div>
        </form>


    </div>
</div>

            </div>