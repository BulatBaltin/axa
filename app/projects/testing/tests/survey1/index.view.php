<div id="box-calc-result">
    <div class="tab-row">
        <? foreach ($quizData as $key => $value) { ?>
            <div class='tab-1' id="tab-<?= $key ?>" data-id="<?= $key ?>">
                <div class="one-num" id="num-<?= $key ?>">
                    <?= $key ?>
                </div>
            </div>
        <? } ?>
    </div>
    <div class='box-content'>
        <? foreach ($quizData as $key => $value) { ?>
            <div hidden id="quiz-<?= $key ?>" data-id="<?= $key ?>" >
                <div class="quiz-text-box">
                    <div class="quiz-text-number">
                        <?= $key.'/'. $limit ?>
                    </div>
                    <div class="quiz-text">
                        <?= $value ?>
                    </div>
                </div>
                <div class='btn-tray-quiz'>
                    <label>
                        <input  class="btn-tray" type="radio" name="answer-<?= $key?>" value="Yes" />
                        Так
                    </label>
                    <label>
                        <input  class="btn-tray" type="radio" name="answer-<?= $key?>" value="No" />
                        Ні
                    </label>
                    <label>
                        <input  class="btn-tray" type="radio" name="answer-<?= $key?>" value="none" />
                        Без відповіді / Невідомо
                    </label>
                </div>
            </div>
        <? } ?>
    </div>
    <div class='btn-navigate'>
        <button  class="btn-move" disabled id='btn-prev'>&#8592; Попередній</button>
        <button class="btn-move" disabled id='btn-next'>Наступний &#8594;</button>
        <button  class="btn-move" hidden id='btn-result'>Подивитися результат</button>
    </div>
</div>
<style>
body {
    font-family: Tahoma,Verdana,Segoe,sans-serif; 
    max-width: 100%;
}
label {
    border: 2px dotted grey;
    border-radius: 6px;
    min-width: 220px;
    padding: 6px;
    display: flex;
    margin: 1rem 2rem;    
}   
.tab-row {
    display: flex; 
    flex-wrap: wrap;    
} 
#box-calc-result {
    margin: 2rem;
}
.quiz-text-box {
    display: flex;
}
@media screen and (max-width: 768px) {
    .tab-row {
        display: none;
    }
    #box-calc-result {
        margin: 0;
    }
    .quiz-text-box {
        flex-wrap:wrap;
    }
}
.btn-navigate {
    display: flex;
    justify-content: center;
}
.tab-1 {
    padding: 2px 6px;
    border: 2px solid lightgrey;
    /* border-bottom: 2px solid white; */
    border-top-right-radius: 8px;
    border-top-left-radius: 8px;
    background-color: #eee;
}
.bk-white {
    background-color: white;
}
.pointer {
    cursor: pointer;
}
.tab-active {
    background-color: aquamarine;
}
.box-content {
    border: 2px solid lightgrey;
    padding: 1rem;
}
.quiz-text-number {
padding: 0 1rem 1rem 1rem;
font-size: 1.5rem;
}
.quiz-text {
    min-height:80px;    
    /* background-color: lightgray; */
}
.btn-tray-quiz {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    /* justify-content: space-around; */
    padding: 1rem;
}
.btn-tray {
    display: flex;
    justify-content: flex-end;
    padding: 0.5rem 1rem;
}
.btn-move {
    margin: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 4px;
}
.one-num {
    margin: 3px;
}
.border-red {
    border-bottom: 2px solid red;
}
</style>
<script src='/js/frontend/jquery.min.js'></script>
<script>
$(document).ready(function() {

    var block1 = 0;
    var block2 = 0;

    var tab = 1;
    var done = 0;
    var limit = <?= count( $quizData ) ?>;
    $('#tab-'+tab).addClass('bk-white');
    $('#tab-'+tab).addClass('tab-active');
    $('#quiz-'+tab).attr('hidden', false);

    $('.tab-1').click(function(){
        let tab_click = $(this).data('id');
        ShowTabs(tab, tab_click)
        ShowNavigate();
    });
    $('.btn-tray').change(function(){
        // if($(this).val() == 'Yes')
        //     $("#num-"+tab).addClass('border-red');
        // else
        //     $("#num-"+tab).removeClass('border-red');
        SetDone();
        ShowNavigate();
    });

    $('#btn-prev').click(function(){
        ShowTabs(tab, --tab)
        ShowNavigate();
    });
    $('#btn-next').click(function(){
        ShowTabs(tab, ++tab)
        ShowNavigate();
    });
    $('#btn-result').click(function(){
        CalcResult();
        $('#box-calc-result').load("/uk/~test/calc-results", 
        { block1: block1, block2: block2 }, 
        function () {}
        );
    });
    function CalcResult() { 
        block1 = 0;
        block2 = 0;
        for (let index = 1; index <= limit; index++) {
            if($("input:radio[name=answer-"+index+"]:checked").val() == "Yes")
            {
                if(index <= 6) ++block1;
                else if(index <= 27) ++block2;
            }
        }
    }
    function SetDone() { 
        if(done < tab) done = tab;
        if(done == limit) {
            $('#btn-result').attr('hidden', false); 
        } else {
            let element = '#tab-'+(done+1);
            $(element).addClass('pointer');
            $(element).addClass('bk-white');
        }
    }
    function ShowTabs(tabLo, tabHi) {
        if (tabLo == tabHi) {
        } else if (tabHi > (done + 1)) {
            // alert('No way');
        } else {
            $('#tab-' + tabLo).removeClass('tab-active');
            $('#quiz-' + tabLo).attr('hidden', true);
            tab = tabHi;
            $('#tab-' + tab).addClass('tab-active');
            $('#quiz-' + tab).attr('hidden', false);
        }
    }
    function ShowNavigate() {

        if(tab > 1) 
            $('#btn-prev').attr('disabled', false); 
        else
            $('#btn-prev').attr('disabled', true); 

        if(tab < limit && tab <= done) 
            $('#btn-next').attr('disabled', false); 
        else
            $('#btn-next').attr('disabled', true); 
    }    
});
</script>
