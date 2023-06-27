<div class='page_wrap'>
<div class="mb-4 mt-3" style='display:flex; align-items: center;'>
    <? $url_back = route('qv.customer.index') ?>
    <? include_view(DMIGHT.'template/move-button.html.php', ['url_back'=> $url_back]) ?>

    <h2 style="margin:0 4rem;"><?l($title)?></h2>
</div>
<? if ($object['name']): ?>
<div style='padding:20px 0px;'>
<h4><?=$object['name'] ?></h4>
</div>
<? endif ?>

<div class="tabs_wrapper">
    <div class="tabs">
        <span class="tab"><?l('Overview')?></span>
        <span class="tab"><?l('Options')?></span>
        <span class="tab"><?l('Activate')?></span>
        <span class="tab"><?l('Visibility')?></span>
        <span class="tab"><?l('Login')?></span>
    </div>
    <? $form->start('customer') ?>
    <div>
        <? $form->errors() ?>
        <div hidden>
            <? $form->row('list') ?>
        </div>
    </div>
    <div class="tab_content">
        <div class="tab_item" style="display: block">
            <div id="success-error-1">
            </div>
            <h3 class="mb-3"><?l('Basic information') ?></h3>
            <div class="row">
                <div class="col-md-6 mb-4">

                    <? $form->row('name') ?>

                    <div class="select_no_search">
                    <? $form->row('group_id') ?>
                    </div>
                    <div class="form-group">
                        <label for="toggl_id"><?l('Accounting ID (take it from your accounting app)')?></label>
                        <? $form->widget('toggl_id')?>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="person"><?l('Contact')?></label>
                        <? $form->widget('person') ?>
                    </div>

                    <div class="form-group">
                        <label for="telephone"><?l('Phone')?></label>
                        <? $form->widget('telephone') ?>
                    </div>
                    <div class="form-group">
                        <label for="address"><?l('Address')?></label>
                        <? $form->widget('address')?>
                    </div>

                </div>
            </div>

            <button id="update-1" type="button" class="btn">
                <? l('Update') ?>
                <svg class="update_icon">
                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                </svg>
            </button>
        </div>
        <div class="tab_item">
            <div id="success-error-2">
            </div>
            <h3><?l('Options')?></h3>
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <? $form->row('pilot') ?>
                    </div>
                    <div class="form-group">
                        <? $form->row('plustaskid') ?>
                    </div>
                    <div class="form-group">
                        <? $form->row('plustaskdate') ?>
                    </div>
                    <div class="form-group">
                        <? $form->row('linktrack') ?>
                    </div>

                    <button id="update-2" type="button" class="btn">
                        <? l('Update') ?>
                        <svg class="update_icon">
                            <use xlink:href="/images/icons/sprite.svg#undo"></use>
                        </svg>
                    </button>

                </div>
            </div>

        </div>
        <div class="tab_item">
            <div id="success-error-3">
            </div>
            <h3><?l('Activation')?></h3>
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="email"><?l('Email')?></label>
                        <? $form->widget('email')?>
                    </div>
                    <div class="form-group">
                        <label for="password0"><?l('Enter password')?></label>
                        <? $form->widget('password0')?>
                    </div>
                    <div class="form-group">
                        <label for="password"><?l('Repeat password')?></label>
                        <? $form->widget('password')?>
                    </div>

                    <button id="update-3" type="button" class="btn">
                        <? l('Update') ?>
                        <svg class="update_icon">
                            <use xlink:href="/images/icons/sprite.svg#undo"></use>
                        </svg>
                    </button>

                </div>
            </div>

        </div>
        <div class="tab_item">
            <div id="success-error-4">
            </div>
            <h3><?l('Visibility')?></h3>
            <div class="row">
                <div class="col-md-6">
                    <div id="user-list">
                        <? foreach($vis_workers as $worker): 
                           $worker_id = $worker['id'] ?>
                        <div class="mt-2" id="worker-<?=$worker_id?>" data-id="<?=$worker_id?>">
                            <i class="del-worker fas fa-user-check pointer" data-id="<?$worker_id?>"></i>
                            <span class="ml-1"><?= $worker['name'] ?></span>
                        </div>
                        <? endforeach ?>
                    </div>
                    <div id="add-user" class="form-group custom_select_wrap mt-3">
                        <label for="adduser"><i class="fas fa-user-plus mr-2"></i><?l('Assign Employee to Customer')?></label>
                        <? $form->widget('adduser') ?>
                    </div>
                </div>
            </div>

            <button id="update-4" type="button" class="btn">
                <? l('Update') ?>
                <svg class="update_icon">
                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                </svg>
            </button>

        <!-- end tab_item -->
        </div>
        <div class="tab_item">
            <div id="success-error-5">
            </div>
            <h3><?l('Customer Login')?></h3>

<? if ($object['hash']): ?>
            <div class="row">
                <div class="col-md-6">
                    <button style="width:65%" id="mail-to" type="button" class="btn green_btn">
                        <?l('Send to the Customer its credentials') ?>
                        <svg class="update_icon">
                            <use xlink:href="/images/icons/sprite.svg#mail"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <a style="width:65%" href="<? path('app_login')?>" type="button" class="btn">
                        <? l('Login as a customer admin user') ?>
                        <svg class="update_icon">
                            <use xlink:href="/images/icons/sprite.svg#undo"></use>
                        </svg>
                    </a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <a style="width:65%" href="<? path('qv.customer.site', ['id'=> $object['hash'] ])?>"  type="button" class="btn">
                        <? l('Customer profile page') ?>
                        <svg class="update_icon">
                            <use xlink:href="/images/icons/sprite.svg#undo"></use>
                        </svg>
                    </a>
                </div>
            </div>
<? endif ?>
        <!-- {# end tab_item #} -->
        </div>
    </div>
    <!-- ========== -->
    <? $form->end() ?>        
</div>
<div class="p-3">
</div>
<div class="p-3"></div>

<? include_view(DMIGHT.'template/move-button.html.php', ['url_back'=> $url_back]) ?>

<div class="p-3"></div>
</div>

<!-- <script src ="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script> -->
<script src="/js/toolskit/tabs-ctrl.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('.custom_select select').select2();
        $('.custom_select_wrap select').select2();
        $('.select_no_search select').select2({
            minimumResultsForSearch: -1
        });

        $("#mail-to").click(function(){
            var form_data = $('form[name="customer"]').serialize();
            $('#success-error-5').load( "<? path('qv.customer.email', ['id' => $object['id'] ]) ?>", form_data );
            return false;
        });

        $("#update-1").click(function(){
            let form_data = $('form[name="customer"]').serialize();
            let url = "<? path('qv.customer.update', ['id'=> $object['id']]) ?>"; 
            // alert('url '+url);
            $.ajax({ method: "POST", dataType: 'json', data: form_data,
                url: "<? path('qv.customer.update',['id'=> $object['id'],'part'=>1]) ?>",
                success: function (result) {
                    // alert(result.mssg);
                    $('#client_id').val(result.client_id);
                    $('#success-error-1').html(result.mssg);
                }
            });
            return false;
        });
        $("#update-2").click(function(){
            var form_data = $('form[name="customer"]').serialize();
            $.ajax({ method: "POST", dataType: 'json', data: form_data,
                url: "<? path('qv.customer.update', ['id'=> $object['id'],'part'=>2] ) ?>",
                success: function (result) {
                    $('#client_id').val(result.client_id);
                    $('#success-error-2').html(result.mssg);
                }
            });
            return false;
        });

        $("#update-3").click(function(){
            var form_data = $('form[name="customer"]').serialize();
            $.ajax({ method: "POST", dataType: 'json', data: form_data,
                url: "<? path('qv.customer.update', ['id'=> $object['id'],'part'=>3]) ?>",
                success: function (result) {
                    $('#client_id').val(result.client_id);
                    $('#success-error-3').html(result.mssg);
                }
            });
            return false;
        });

        $("#update-4").click(function(){
            var list = '';
            $('#user-list').find('.del-worker').each(function(){
                list += $(this).data('id')+',';        
            });
            $('#customer_list_id').val(list);
            var form_data = $('form[name="customer"]').serialize();
            
            $.ajax({ method: "POST", dataType: 'json', data: form_data,
                url: "<? path('qv.customer.update', ['id'=> $object['id'],'part'=>4]) ?>",
                success: function (result) {
                    $('#client_id').val(result.client_id);
                    $('#success-error-4').html(result.mssg);
                }
            });
            return false;
        });

// Start visibility -------------------------------------------
        var list_adduser = '#id_adduser';
        <? include('js/toolskit/visibility.js') ?>
// End visibility -------------------------------------------
    });
</script>
