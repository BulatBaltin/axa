<?

$lang_id    = REQUEST::getParam('id');
$language   = Language::find($lang_id);
$lang = $language['code'];

$lingo      = new LingoStar();
$text1  = $lingo->getKeysTranslation();
$text2  = $lingo->getPhrasesTranslation($lang);

$language['key_words'] = $text1;
$language['phrases_words'] = $text2;

$form = new LanguageType( $language );

$Title  = 'Edit Language';
$object = $language;
$root   = 'qv.language';
$rootindex = 'qv.language.index';

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {

        //     $data = $form->getData();
        //     $text2 = $form->get('text2');
        //     $ucfst = $form->get('ucfst')->getViewData();
        //     $ucfst = $ucfst ? true : false;

        //     // dd($text2->getViewData());
        //     LingoStar::createLingoFile($object->getCode(), $text2->getViewData(), $ucfst);

        //     // $this->getDoctrine()->getManager()->flush();
        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($object);
        //     $em->flush();

        //     return $this->redirectToRoute('language.index');
        // }
    
