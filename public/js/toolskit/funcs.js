function removeUrlParam( url, param) {
    let name = param.toLowerCase();
    let url2parts = url.split('?');
    url= url2parts[0]+'?';
    let list= url2parts[1].split('&');
    let i;
    for(i = 0; i < list.length; i++ ){
        let part = list[i];
        let parm = part.split('=');
        if(parm[0] != name) {
            url += part + '&';
        }
    }
    url = url.substring(0, url.length - 1);
    return url;
}
function removeEmptyParts (url, aparams, avalues) {
    let len = avalues.length;
    let i;
    for(i = 0; i < len; ++i) {
        if(!avalues[i]) {
            url = removeUrlParam( url, aparams[i]);
        }
    }
    return url;
}

function initSelect2 () {
    $('.custom_select select').select2();
    $('.custom_select_wrap select').select2();
    $('.select_no_search select').select2({
        minimumResultsForSearch: -1
    });
}