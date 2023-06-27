<?php

    // /**
    //  * @Route("/", name="index", methods={"GET"})
    //  * @Route("/mssg/{mssg}", name="index-mssg", methods={"GET"})
    //  */
    // public function index(LanguageRepository $Repository, $mssg = null)
    // {
    $Items  = Language::findAll();
    $Fields =
            [
['label' => 'ID',                   'name' => 'id', 'style' => 'width:4rem;'],
['label' => 'Name of the Language', 'name' => 'name'],
['label' => 'Code',                 'name' => 'code']
            ];

    $Title  = 'Language List';
    $mssg   = '';
    $root   = 'qv.language';
    $rootindex = 'qv.language.index';

        // return $this->render('abstract/index.html.twig', $parms);

