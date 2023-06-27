<div class='page_wrap'>

<div class="mb-4 mt-3" style='display:flex; align-items: center;'>
    <? $url_back = route('qv.project.index') ?>
    <? include_view(DMIGHT.'template/move-button.html.php', ['url_back'=> $url_back]) ?>

    <h2 style="margin:0 4rem;"><? l($Title) ?></h2>
</div>

    <? 
    $button_label = 'Update'; 
    include('include/_form_edit.html.php') 
    ?>

    <div style='margin-top:3rem;'>
        <?include_view(DMIGHT.'template/move-button.html.php',['url_back'=> $url_back]) ?>
    </div>
</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">
$(document).ready(function(){

        $('.custom_select select').select2();
        $('.custom_select_wrap select').select2();
        $('.select_no_search select').select2({
            minimumResultsForSearch: -1
        });


        $('#add-task-to-grid').on('change','#id_task', function(event){
            let task_tid = $(this).val();
            let url = "<? path('qv.project.find-task', ['tid'=>'p-tid']) ?>";
            url = url.replace('p-tid', task_tid);

            $.ajax({
                method: "POST", dataType: 'json', 
                url: url, 
                contentType:false, 
                processData:false, 
                cache:false,

                success: function (result) { 
                    if(result.return=='success') {
                        $('#add-task-to-grid').html(result.taskHtml);
                    }
                }
            });
            return false;
        });

        $('#add-task-to-grid').on('click', '#find_task', function(){
// var form = $(this).parents('form:first');
// $("input[name='somename']",form).val();
            let tid = $('#task_tid_id').val();
            let url = "<? path('qv.project.find-task',['tid'=>'p-tid']) ?>";
            url = url.replace('p-tid', tid);
            $.ajax({
                method: "POST", dataType: 'json', 
                url: url, 
                contentType:false, 
                processData:false, 
                cache:false,

                success: function (result) { 
                    if(result.return=='success') {
                        // alert(result.taskHtml);
                        $('#add-task-to-grid').html(result.taskHtml);
                    }
                }
            });
            return false;
        });
        
        $('#do-add-task').on('click', function(){
            let tid = $('#id_task').val();
            let proj_id = $('#add-row').data('proj');

            let url = "<? path('qv.project.add-task', ['id'=>'proj_id', 'tid'=>'p-tid']) ?>";
            url = url.replace('p-tid', tid);
            url = url.replace('proj_id', proj_id); 
            // alert(tid + ' ' + proj_id+ ' '+url);
            $.ajax({
                method: "POST", 
                dataType: 'json', 
                url: url, 
                contentType:false, 
                processData:false, 
                cache:false,
                success: function (result) { 
                    if(result.return=='success') {
                        $('#_tasks-table').html(result.htmlTasks);
                    }
                }
            });
            return false;

        });

        $('#_tasks-table').on('click', '.do-delete-task', function(){
            let tid = $(this).data('tid');
            let proj_id = $(this).data('projecten_id');
            let task_name = $('#name_'+tid).text();
            let url = "<? path('qv.project.delete-task',['id'=>'proj_id', 'tid'=>'p-tid']) ?>";
            url = url.replace('p-tid', tid);
            url = url.replace('proj_id', proj_id); 
// alert(task_name);

            dmDialog({
'width': "450px",
'left': "calc(50vw - 225px)",
'title': "<?l('Remove task from the list')?>",
'text': "<div style='margin:1rem;'><b>"+task_name+"</b><br><?l('Remove the task from the project task list')?></div>",

            'buttons': {
                'ok': "<?l('Remove task')?>",
            },

            'ok' : function() {
                $.ajax({
                method: "POST", dataType: 'json', 
                url: url, 
                contentType:false, 
                processData:false, 
                cache:false,

                success: function (result) { 
                    if(result.return=='success') {
                        $('#_tasks-table').html(result.htmlTasks);
                    }
                }
                });
            }
            });
// end dialog
            return false;
        });

        $('#do-add-point').on('click', function(){
// var form = $(this).parents('form:first');
// $("input[name='somename']",form).val();
            let name = $('#points_name_id').val();
            let point = $('#points_point_id').val();
            let proj_id = $('#add-row').data('proj');
            let url = "<? path('qv.project.add-point',['id'=>'proj_id']) ?>";
            url = url.replace('proj_id', proj_id); 
            // alert(url + ' ' + name + ' ' + point);
            $.ajax({
                type: "POST",
                dataType: 'json', 
                url: url, 
                data: { name: name, point: point },
                success: function (result) { 
                    if(result.return=='success') {
                        $('#points_name_id').val('');
                        $('#points_point_id').val('');
                        $('#_points-table').html(result.htmlPoints);
                    }
                }
            });
            return false;

        });

        $('#_points-table').on('click', '.do-delete-point', function(){
            let id = $(this).data('id');
            // let proj_id = $(this).data('projecten_id');
            let point_name = $('#name_'+id).text();
            let url = $(this).attr('href'); 
            
            dmDialog({
'width': "450px",
'left': "calc(50vw - 225px)",
'title': "<?l('Remove checkpoint')?>",
'text': "<div style='margin:2rem;'><?l('Remove checkpoint from the list')?><br><b>"+point_name+"</b></div>",

            'buttons': {
                'ok': "<?l('Remove point')?>",
            },

            'ok' : function() {
                $.ajax({
                method: "POST", dataType: 'json', 
                url: url, 
                contentType:false, 
                processData:false, 
                cache:false,

                success: function (result) { 
                    if(result.return=='success') {
                        $('#_points-table').html(result.htmlPoints);
                    }
                }
                });
            }
            });
// end dialog
            return false;
        });

        
    });

</script>

