<style>
.btn-smart {
    background: #ddd;
    border-radius: 3px;
    border: 2px solid #aaa;
    padding:0.3rem 0.5rem;
    width:50px;
    margin-right:0.2rem;
    /* box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%); */
    text-decoration: none;
}
.btn-smart:hover {
  text-decoration: none;
  background: #aaa;
  color: white;
}
</style>
<div class='page_wrap'>

    <h1 class="mb-4"><? l($Title)?></h1>

    <div class="table_actions d-flex">
        <div>
            <div class="search-box">
                <input class="" type="search" id="search-go" name="search-fld" placeholder="<? l('Search string') ?>" value="<? $search_string ?>">
                <svg class="search_icon" id="go-search">
                    <use xlink:href="/images/icons/sprite.svg#search"></use>
                </svg>
            </div>
        </div>

        <div>
            <a class='btn green_btn' href="<? path('qv.project.new') ?>"><? l( 'Add projecten') ?>
                <svg class="add_icon">
                    <use xlink:href="/images/icons/sprite.svg#plus"></use>
                </svg>
            </a>
        </div>
    </div>
    <div id="note-grid">
    </div>

    <table id="grid-data" class="full_width fully_mobile mt-4 mb-4">
        <thead>
            <tr class='tr-header-grey'>
                <th style='width:25%'><? l( 'Project') ?></th>
                <th style='width:8%'><? l( 'Budget') ?></th>
                <th style='width:8%'><? l( 'Actual') ?>%</th>
                <th style='width:8%'><? l( 'All hours') ?></th>
                <th style='width:8%'><? l( 'Not invoiced hours') ?></th>
                <th style='width:25%'><? l( 'Customer') ?></th>
                <th><? l( 'Actions') ?></th>
                <th><? l( 'Invoice Actions') ?></th>
            </tr>
        </thead>
        <tbody>
    <? if($projectens) :?>
        <? foreach( $projectens as $projecten ): ?>
            <tr>
                <td><?= $projecten['projecten']['name'] ?></td>
                <td><?= $projecten['projecten']['budget'] ?></td>
                <td 
                <? if ($projecten['percent'] > 100) : ?>
                    style= 'color:red;font-weight:bold;'
                <? endif ?>
                ><?= $projecten['percent'] ?>%</td>
                <td><?= $projecten['hours'] ?></td>
                <td><?= $projecten['hoursleft'] ?></td>
                <td><?= $projecten['projecten']['customer_name']?></td>
                <td>

                <div class="table_label_mobile"><? l('Actions')?></div>
                <a title="<? l('Edit Projecten')?>" href="<? path('qv.project.edit', ['id' => $projecten['projecten']['id'] ]) ?>" class="edit_row_icon">
                    <svg>
                        <use xlink:href="/images/icons/sprite.svg#edit"></use>
                    </svg>
                </a>
                <a class="del-btn text-danger delete_row_icon" data-id="<?= $projecten['projecten']['id'] ?>" href="#"
                data-token="<?= csrf_token('delete'.$projecten['projecten']['id']) ?>"
                data-projecten-name="<?= $projecten['projecten']['name'] ?>"
                >
                    <svg>
                        <use xlink:href="/images/icons/sprite.svg#bin"></use>
                    </svg>
                </a>
                </td>
                
                <td style="width:40%">
                <? 
$url = path('qv.project.add-invoice', ['id'=> $projecten['projecten']['id']]) 
                ?>
                <a class="btn" style="width:3.5rem;padding:0;" href="<? $url ?>"
title='<? l("Create invoice")?>'data-id="<?= $projecten['projecten']['id'] ?>">New
                </a>
                </td>
            </tr>
        <? endforeach ?>
        <? else : ?>
            <tr>
                <td colspan="7"><? l("No records found")?></td>
            </tr>
        <? endif ?>
        </tbody>
    </table>
</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">

    $(document).ready(function(){
        $('.btn-smart--').click(function(){
            alert( $(this).data('href'));
        });

        $('.del-btn').click(function(){
            let title = $(this).data('projecten-name');
            let token = $(this).data('token');
            let proj_id = $(this).data('id');
            let url = "<? path('qv.project.delete', [ 'id'=> 'proj_id']) ?>";
            url = url.replace('proj_id', proj_id);

            dmDialog({
                title: "<? l('Delete projecten') ?>",
                text: "<? l('Delete projecten and update linked data?') ?>"+"<br>"+title,
                ok: function() {
                    ShowProcess();
                    $.ajax({
                        method: "POST", dataType: 'json', 
                        url: url, 
                        data: { token: token},

                        success: function (result) {
                            HideProcess();
                            if(result.return == 'success') {
                                $('#note-grid').html( result.mssg );
                                window.location.href="<?path('qv.project.index')?>";     
                            }
                        }
                    });
                }
            });

            return false;
        });

    });

</script>
