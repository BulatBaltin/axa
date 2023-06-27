<?
// dd('Module tests');

$routes = new ROUTER;
$routes->
    Project('projects.testing') // 3-d parameter
        ->Module('tests') // 3-d parameter
            ->Prefix('test.tests') // 1-st parameter, adds 'test.'
    ->Add('test-cats', 'test/tests/cats',     'cats.cats')
    ->Add('unit-10-1', 'test/tests/u-10',     'unit-10.unit-10')
    ->Add('unit-10-2', 'test/tests/u-10-2',   'unit-10.unit-10-2')
    ->Add('unit-10-3', 'test/tests/u-10-3',   'unit-10.unit-10-3')
    ->Add('unit-10-4', 'test/tests/u-10-4',   'unit-10.unit-10-4')
    ->Add('unit-10-5', 'test/tests/u-10-5',   'unit-10.unit-10-5')
    ->Add('unit-11-1', 'test/tests/u-11-1',   'unit-11.unit-11-1')
    ->Add('unit-12-1', 'test/tests/u-12-1',   'unit-12.unit-1')
    ->Add('unit-12-2', 'test/tests/u-12-2',   'unit-12.unit-12-2')
    ->Add('paste-img', 'test/tests/paste-img','how-to-image.paste')
    ->Add('unit-13-1', 'test/tests/u-13-1',   'unit-13-BEM.unit-13-1')
    ->Add('unit-13-2', 'test/tests/u-13-2',    'unit-13-BEM.unit-13-2.unit-13-2')
    ->Add('unit-13-3', 'test/tests/u-13-3',   'unit-13-BEM.unit-13-3.unit-13-3')
    ->Add('unit-14-1', 'test/tests/u-14-1',   'u-14.unit-14-1')
    ->Add('unit-14-2', 'test/tests/u-14-2',   'u-14-2.unit-14-2')
    ->Add('unit-16-1', 'test/tests/u-16-1',   'u-16.unit-16-1')
    ->Add('plus-01',   'test/tests/pl-01',    'plus-01.p-01')
    ->Add('plus-01-2', 'test/tests/pl-01-2',  'plus-01.p-02')
    ->Add('plus-03-1', 'test/tests/pl-03-1',  'plus-03.p-01')
    // ->Add('survey-1', 'test/tests/survey-1',  'survey1.index')
    ->Add('php-new',        'test/tests/php-new', 'php-new.code-1')
    ->Add('mail-booking',   'test/tests/mail-booking', 'php-new.mail-01')
    ->Add('img-create',     'test/tests/php/img-create', 'php-new.image-create')
    ->Add('photo-sign',     'test/tests/photo-sign', 'php-new.photo-create')
    ->Add('php-rock1',      'test/tests/php-rock1', 'php-rock.sample1')
    ->Add('mb-contact', 'mb/contact', 'moneybird.bird')
    // ->Add('survey-2', 'test/tests/survey-2',  'survey2.index')
    ->Add('survey-1',       'css/survey-1',   'survey1.index') 
    ->Add('survey-2',       'css/survey-2',  'survey2.index')
    ->Add('css-tricks-01',  'css/css-tricks-01', 'css-tricks.trick-01')
    ->Add('css-tricks-02',  'css/css-tricks-02', 'css-tricks.trick-02')
    ->Add('css-tricks-03',  'css/css-tricks-03', 'css-tricks.trick-03')
    ->Add('css-tricks-04',  'css/css-tricks-04', 'css-tricks.trick-04')
    ->Add('js-trick-1',     'css/js-tricks/trick1', 'js-tricks.trick-01')
    ->Add('js-trick-1',     'test/tests/rich-edit', 'html-edit.edit')
    ; 
