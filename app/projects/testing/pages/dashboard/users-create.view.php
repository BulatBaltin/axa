<? include('partials/left-sidebar.view.php') ?>

<div id="main-right" class="container-fluid">
                                                
<div class="card">
    <div class="card-header">
        Create User
    </div>

    <div class="card-body">
        <form action="http://demo-expense-manager.quickadminpanel.com/admin/users" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="JbgKjusFjxaDm20leoqhpa48myrifbEI6rEymDph">            <div class="form-group ">
                <label for="name">Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="" required="">
                                <p class="helper-block">
                    
                </p>
            </div>
            <div class="form-group ">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" class="form-control" value="" required="">
                                <p class="helper-block">
                    
                </p>
            </div>
            <div class="form-group ">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required="">
                                <p class="helper-block">
                    
                </p>
            </div>
            <div class="form-group ">
                <label for="roles">Roles*
                    <span class="btn btn-info btn-xs select-all">Select all</span>
                    <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
                <select name="roles[]" id="roles" class="form-control select2 select2-hidden-accessible" multiple="" required="" tabindex="-1" aria-hidden="true">
                                            <option value="1">Admin</option>
                                            <option value="2">User</option>
                                    </select><span class="select2 select2-container select2-container--default select2-container--focus select2-container--open select2-container--above" dir="ltr" style="width: 1234px;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="true" tabindex="-1" aria-owns="select2-roles-results" aria-activedescendant="select2-roles-result-xmuk-2"><ul class="select2-selection__rendered"><li class="select2-selection__choice" title="Admin"><span class="select2-selection__choice__remove" role="presentation">×</span>Admin</li><li class="select2-selection__choice" title="User"><span class="select2-selection__choice__remove" role="presentation">×</span>User</li><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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