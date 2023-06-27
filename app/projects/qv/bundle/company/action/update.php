<?php


    // /**
    //  * @Route("/new", name="new", methods={"GET","POST"})
    //  */
    // public function new(Request $request, SessionInterface $session, Security $security): Response
    // {
    //     // dd($request);
    //     // $session->remove('user');
    //     // $session->remove('roles');
    //     $user_com = $session['('user'); // This is important when saving
    //     if (!$user_com) { // This is important when saving
    //         $user_com = new User;
    //         // $track = new Timetracking();
    //         // $user_com = new User;
    //         // $session->set('new_user', true);
    //         $session->set('user', $user_com);
    //         $session->set('roles', $user_com['Roles());
    //         // $em = $this['Doctrine()['Manager();
    //         // $em->merge($user_com);
    //         // $em->persist($user_com);
    //     }
    //     return $this->update_data($request, $user_com, $session, $security, true);
    // }

    // /**
    //  * @Route("/profile", name="profile", methods={"GET","POST"})
    //  */
    // public function profile(Request $request, SessionInterface $session, Security $security)
    // {
    //     $user = $this['User();
    //     return $this->update_data($request, $user, $session, $security, false, 'user/profile.html.twig');
    // }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     */
    // It is called from the list
    // public function edit(Request $request, User $user_com, SessionInterface $session, Security $security): Response
    // {
    //     $session->set('user', $user_com);
    //     return $this->update_data($request, $user_com, $session, $security, false);
    // }

    // function update_data(Request $request, User $user_com, SessionInterface $session, Security $security, bool $is_new, string $url_name = "user/profile.html.twig"): Response
    // {

// /**
    //  * @Route("/general", name="general", methods={"GET","POST"})
    //  */
    // public function general(Request $request, TransactionsRepository $repoTrans): Response
    // {
        // $company = $this->getUser()->getCompany();
        
        $form   = new CompanyGeneralType($company);
        $form2  = new CompanyUnmappedType;

        // $archive_year = (new DateTime())->format('Y') - 1;
        // $form2->get('archive_year')->setData( $archive_year );
        // $form2->get('notes_date')->setData( new DateTime());
        // $form2->get('trans_date')->setData( new DateTime());
        // $form2->get('link_date')->setData( new DateTime());
        // $form2->get('hours_date')->setData( new DateTime());
        // $form2->get('action')->setData('1');  // Hello World!
        // $form2->get('phrase')->setData('11278960');  // Hello World!

        // $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }





if ($request->isXmlHttpRequest()) { // Ajax
            $return = "success";
            $mssg = "success";

            // $pressed = $request->request['('button') ? "Apply pressed" : "Button pressed?";
            $pressed = $request['('button') ? "Apply pressed" : "Button pressed?";

            $user_form = $request['('user');
            $company_form = $request['('company_profile');

            $address = $company_form['address'];
            // $sirname = $user_form['sirname'];

            $session = $request['Session();
            // $user_form = $request->query['('user');

            // dd("Blackspot", $user_form, $company_form, $session);

            $upload = $request->files['('upload');
            // $logoimage = $request->files['('user')['('logoimage');
            // $avatarimage = $request->files['('avatarimage');

            $logoimage = $request->files['('company_profile')['logoimage'];
            $avatarimage = $request->files['('user')['avatarimage'];

            dd("Blackspot", $address, $pressed, $request->request, $request->query);

            $content = json_encode(['return' => $return, 'mssg' => $mssg]);
            return new Response($content);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // $em = $this['Doctrine()['Manager();
            dump('Here again');
            dd($request->request['('btn-upload-logo'));

            if ($request->request['('btn-upload-logo') !== null) { // Takes the name Parameters());


                // return $this->redirectToRoute($toRout);
            } elseif ($request->request['('SaveSubmit') !== null) {
            }


            $logoFile = $form['logoimage']['Data();
            if ($logoFile) {
                $originalFilename = pathinfo($logoFile['ClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $logoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $logoFile->move(
                        $this['Parameter('logo_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd("Error: " . $e . '   ' . $this['Parameter('logo_images'), $newFilename);
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                //$newFilename = $this['Parameter('logo_images') . "/" . $newFilename;
                $newFilename = $this['Parameter('logo_folder') . $newFilename;
                $user_com->setLogofile($newFilename);
            }
            $avatarFile = $form['avatarimage']['Data();
            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile['ClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $avatarFile->move(
                        $this['Parameter('logo_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd("Error: " . $e . '   ' . $this['Parameter('logo_images'), $newFilename);
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                //$newFilename = $this['Parameter('logo_images') . "/" . $newFilename;
                $newFilename = $this['Parameter('logo_folder') . $newFilename;
                $user_com->setAvatarfile($newFilename);
            }

            $user_com->setRoles($roles);

            // dd($roles);

            if ($session['('new_pass')) {
                $user_com->setUsername($session['('username'));
                $password = $session['('password');
                $encoded = User::encodePassword($password);
                $user_com->setPassword($encoded);

                $session->remove('new_pass');
                $session->remove('username');
                $session->remove('password');
            }
            $em->persist($user_com);
            $em->flush();

            if ($security['User() === $user_com) {
                new LingoStar($security);
            }

            $toRout = $session['('toRout');
            if ($toRout === null) {
                $toRout = 'user.index';
            } else {
                $session->remove('toRout');
            }
            $session->remove('user');
            $session->remove('roles');
            return $this->redirectToRoute($toRout);
        }
