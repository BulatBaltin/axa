<style>
:root {
  --inputBorderColor: #eaeaea;
  --footBarColor: #dbdbdbf5;
  --headBarColor: #888;
  /* --editHeight: 40px; */
}
.dlg-frame{
    display: none;
    position: fixed!important;
    z-index: 300;
}
.dlg-frame-style{
    padding:0.6rem;    
    background: rgba(0, 0, 0, 0.25);
    /* background: rgba(255, 255, 255, 0.25); */
    border: 1px solid #eaeaea;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.2);
    border-radius: 5px;

}
.dlg-frame-layout{
    top: 80px;
    left: calc(50vw - 250px);
    width: 500px;
    min-width: 100px;
    min-height: 100px;
    max-width: calc(100vw - 20px);
    max-height: calc(100vh - 40px);
}
.dlg-frame-layout-confirm{
    top: 100px;
    left: calc(50vw - 225px);
    width: 450px;
    min-width: 100px;
    min-height: 100px;
    max-width: calc(100vw - 20px);
    max-height: calc(100vh - 40px);
}
.dlg-frame-layout-info{
    top: 120px;
    left: calc(50vw - 160px);
    width: 320px;
    min-width: 100px;
    min-height: 50px;
    max-width: calc(100vw - 20px);
    max-height: calc(100vh - 40px);
}
.x-dlg-titlebar {
    display: flex;
    justify-content: space-between;   
    background:var(--headBarColor);
    padding:0.3rem 1rem; 
    cursor: move; 
}
.x-dlg-title {
    font-size: 1.25rem;
    color: white;
    padding-top: 4px;
    /* cursor: move; */
    /* height: 32px; */
}
.x-dlg-titlebar-close {
    cursor: pointer;
    font-size: 1.5rem;
    padding-top: 4px;
    /* margin-right: 0.5rem; */
    /* height: 32px; */
    /* width: 32px; */
}
.x-dlg-content {
    padding: 1rem;
    overflow: auto;
    background-color: whitesmoke;
}
.x-dlg-buttonpane {
    padding: 0.75rem 1rem;
    background:var(--footBarColor);
}
.x-dlg-buttonset{
    display: flex;
    justify-content: space-between;
}
.x-dlg-buttonset-info{
    display: flex;
    justify-content: flex-end;
}
.icon-remove {
    margin:1px 0;
    font-size:1.8rem;
    color:white;
}
</style>
<div id="x-dialog" class="dlg-frame dlg-frame-style dlg-frame-layout">
    <div class="x-dlg-titlebar">
        <div id='x-dlg-title' class="x-dlg-title">
            Dialog title
        </div>
        <div class="x-dlg-titlebar-close action-cancel">
            <i class="icon-remove far fa-window-close big-icon"></i>
        </div>
    </div>
    <div id="x-dlg-content" class="x-dlg-content">
    </div>
    <div class="x-dlg-buttonpane">
        <div class="x-dlg-buttonset">
            <button class="btn btn-primary action-ok" type="submit" style='height:var(--editHeight);'>
                <span id="ok--bttn">
                    <?l('Yes')?>
                </span>
                &nbsp;&nbsp;<i class="far fa-check-circle"></i>
            </button>
            <button class="btn btn-primary close-modal action-cancel" 
            type="submit" 
            style='color:grey;background: rgb(231, 226, 221);height:var(--editHeight);'
            >
                <span id="cancel-button">
                    <?l('Cancel')?>
                </span>
                &nbsp;&nbsp;<i class="fas fa-times-circle"></i>
            </button>

        </div>
    </div>
    <div id="x-dlg-footer">
    </div>
</div>

<div id="x-dialog-confirm" class="dlg-frame dlg-frame-style dlg-frame-layout-confirm">
    <div class="x-dlg-titlebar">
        <div id='x-dlg-title-confirm' class="x-dlg-title">
            Confirm action
        </div>
        <div class="x-dlg-titlebar-close action-cancel">
        <i class="icon-remove far fa-window-close big-icon"></i>
        </div>
    </div>
    <div id="x-dlg-content-confirm" class="x-dlg-content" style="padding: 1.25rem;">
    </div>
    <div class="x-dlg-buttonpane">
        <div class="x-dlg-buttonset">
            <button class="btn btn-primary action-ok" type="submit">
                <span id="ok-confirm"><?l('Yes')?></span>
                &nbsp;&nbsp;<i class="far fa-check-circle"></i>
            </button>
            <button class="btn btn-primary close-modal action-cancel" type="submit" style='color:grey;background: rgb(231, 226, 221);'>
                <span id="cancel-confirm"><?l('Cancel')?></span>
                &nbsp;&nbsp;<i class="fas fa-times-circle"></i>
            </button>

        </div>
    </div>
</div>

<div id="x-dialog-info" class="dlg-frame dlg-frame-style dlg-frame-layout-info">
    <div class="x-dlg-titlebar">
        <div id='x-dlg-title-info' class="x-dlg-title">
            Notice
        </div>
        <div class="x-dlg-titlebar-close action-cancel">
            <i class="icon-remove far fa-window-close big-icon"></i>
        </div>
    </div>
    <div id="x-dlg-content-info" class="x-dlg-content" style="padding: 1.25rem;">
    </div>
    <div class="x-dlg-buttonpane">
        <div class="x-dlg-buttonset-info">
            <button class="btn btn-primary action-cancel" type="submit">
                <span id="ok-info"><?l('Ok')?></span>
                &nbsp;&nbsp;<i class="far fa-check-circle"></i>
            </button>
        </div>
    </div>
</div>

<div id="modal-rack" class="dlg-frame dlg-frame-style dlg-frame-layout">
    <div class="x-dlg-titlebar">
        <div id='x-dlg-title-rack' class="x-dlg-title">
            <span id='dlg-rack-title' style="margin-left:0.5rem;font-size: 1.0rem;color: #555555;"></span>
        </div>
        <div class="x-dlg-titlebar-close action-cancel">
            <i class="icon-remove far fa-window-close big-icon"></i>
        </div>
    </div>
    <div id="x-dlg-content-rack" class="x-dlg-content">
        <div id="modal-rack-warning" class="mt-3"></div>
        <div id="modal-rack-target" class="mt-3"></div>
        <div id="modal-rack-source-caption" class="mt-3"></div>
        <div id="modal-rack-source" class="mt-1 mb-3"></div>
    </div>

    <div class='foot-dlg d-flex justify-content-between' style="padding:10px;">
        <button class="btn btn-primary action-ok" type="submit"><?l('Yes')?>&nbsp;&nbsp;
        <i class="far fa-check-circle"></i>
        </button>
        <button class="btn btn-primary action-cancel" type="submit" style='color:grey;background: rgb(231, 226, 221);'><?l('Cancel') ?>&nbsp;&nbsp;
        <i class="fas fa-times-circle"></i>
        </button>
    </div>
</div>

<!-- <div id="modal-rack-old" class="dlg-frame dlg-frame-style dlg-frame-layout">
    <div class="d-flex bg-bar p-2">
        <div class="flex-fill">
            <div class="close-modal justify-content-between" style='background:var(--footBarColor);padding:3px;'>
                <span id='dlg-rack-title' style="margin-left:0.5rem;font-size: 1.0rem;color: #555555;"></span>
                <i class="far fa-times-circle"></i>
            </div>
            <div id="modal-rack-warning" class="mt-3"></div>
            <div id="modal-rack-target" class="mt-3"></div>
            <div id="modal-rack-source-caption" class="mt-3"></div>
            <div id="modal-rack-source" class="mt-1 mb-3"></div>

            <div class='foot-dlg d-flex justify-content-between' style="padding:10px;">
                <button class="btn btn-primary btn-okay" type="submit"><?l('Yes')?>&nbsp;&nbsp;
                <i class="far fa-check-circle"></i>
                </button>
                <button class="btn btn-primary close-modal" type="submit" style='color:grey;background: rgb(231, 226, 221);'><?l('Cancel') ?>&nbsp;&nbsp;
                <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div> -->

<script type="text/javascript">
    var func_ok;
    var func_cancel;
    var func_load;

    $( ".dlg-frame" ).draggable({
        handle: ".x-dlg-titlebar",
        start: function( event, ui ) { base_flag = true; },
        stop: function( event, ui ) { },
    });
    $( ".dlg-frame" ).resizable({
        alsoResize: '.x-dlg-content'
    });

    $('.action-ok').click(function(){ 
        QuickClose();
        if(func_ok) func_ok() 
    });    

    $('.action-cancel').click(function () {
        QuickClose();
        if(func_cancel) func_cancel();
        return false;
    });

    function dmDialog( layout ) {
        if(layout.hasOwnProperty('title') ) $('#x-dlg-title').html( layout.title );
        if(layout.hasOwnProperty('text') ) $('#x-dlg-content').html( layout.text );
        if(layout.hasOwnProperty('ok') ) func_ok = layout.ok;
        if(layout.hasOwnProperty('cancel') ) func_cancel = layout.cancel;
        if(layout.hasOwnProperty('top')) $('#x-dialog').css('top', layout.top);
        if(layout.hasOwnProperty('left')) $('#x-dialog').css('left', layout.left);
        if(layout.hasOwnProperty('width')) $('#x-dialog').css('width', layout.width);
        if(layout.hasOwnProperty('height')) $('#x-dialog').css('height', layout.height);
        if(layout.hasOwnProperty('buttons')) {
            let buttons = layout.buttons;
            if(buttons.hasOwnProperty('ok'))
                $('#ok--bttn').html(buttons.ok);
            if(buttons.hasOwnProperty('cancel'))
                $('#cancel-button').html(buttons.cancel);
        }
        if(layout.hasOwnProperty('footer')) {
            $('#x-dlg-footer').html(layout.footer);
        } else {
            $('#x-dlg-footer').html("");
        }
        $('#x-dialog').show(200, function() {
            if( layout.hasOwnProperty('load') ) {
                func_load = layout.load;
                func_load();
            }
        } );
    }
    function dmConfirmDialog( layout ) {
        if(layout.hasOwnProperty('title') ) $('#x-dlg-title-confirm').html( layout.title );
        if(layout.hasOwnProperty('text') ) $('#x-dlg-content-confirm').html( layout.text );
        if(layout.hasOwnProperty('ok') ) func_ok = layout.ok;
        if(layout.hasOwnProperty('cancel') ) func_cancel = layout.cancel;
        if(layout.hasOwnProperty('top')) $('#x-dialog-confirm').css('top', layout.top);
        if(layout.hasOwnProperty('left')) $('#x-dialog-confirm').css('left', layout.left);
        if(layout.hasOwnProperty('width')) $('#x-dialog-confirm').css('width', layout.width);
        if(layout.hasOwnProperty('height')) $('#x-dialog-confirm').css('height', layout.height);
        if(layout.hasOwnProperty('buttons')) {
            let buttons = layout.buttons;
            if(buttons.hasOwnProperty('ok'))
                $('#ok-confirm').html(buttons.ok);
            if(buttons.hasOwnProperty('cancel'))
                $('#cancel-confirm').html(buttons.cancel);
        }
        $('#x-dialog-confirm').show(200, function() {
            if( layout.hasOwnProperty('load') ) {
                func_load = layout.load;
                func_load();
            }
        } );
    }
    function dmInfoDialog( layout ) {
        if(layout.hasOwnProperty('title')) $('#x-dlg-title-info').html( layout.title );
        if(layout.hasOwnProperty('text')) $('#x-dlg-content-info').html( layout.text );
        if(layout.hasOwnProperty('top')) $('#x-dialog-info').css('top', layout.top);
        if(layout.hasOwnProperty('left')) $('#x-dialog-info').css('left', layout.left);
        if(layout.hasOwnProperty('width')) $('#x-dialog-info').css('width', layout.width);
        if(layout.hasOwnProperty('height')) $('#x-dialog-info').css('height', layout.height);
        if(layout.hasOwnProperty('buttons')) {
            let buttons = layout.buttons;
            $('#ok-info').html(buttons.ok);
        }
        $('#x-dialog-info').show(200, function() {
            if( layout.hasOwnProperty('load') ) {
                func_load = layout.load;
                func_load();
            }
        } );
    }
    function QuickClose() {
        $('.dlg-frame').hide();
    }
    function ShowProcess() {
        $('#modal-shadow').addClass('visible-yes');
        $('#spinner').show();
    }
    function HideProcess() {
        $('#modal-shadow').removeClass('visible-yes');
        $('#spinner').hide();
    }
</script>
