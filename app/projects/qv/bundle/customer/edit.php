<?

// use form\customer\ClientType;

// public function updateClient(Request $request, Client $client, UserRepository $repoUsers, $title = "Edit Customer"): Response
// {
$client_id = REQUEST::getParam('id');
$client = Client::find($client_id);    

// $form = $this->createForm(ClientType::class, $client);
$form = new ClientType($client);

// $form->handleRequest($request);
// if ($form->isSubmitted() && $form->isValid()) {
//     $this->getDoctrine()->getManager()->flush();
//     return $this->redirectToRoute($this->rootpages);
// }

$vis_workers_ids = explode(',', $client['visibility'] ?? '');

$workers = [];
foreach ($vis_workers_ids as $worker_id) {
    if($worker_id) {
        $worker = User::find($worker_id);
        if ($worker) {
            $workers[] = $worker;
        }
    }
}
// return $this->render('client/client.html.twig', [
$title = ll('Edit customer');    
$titleplus = '';
$isnew    = false;
$delete   = true; // should be defined
$root     = 'customer';
$vis_workers = $workers;
$rootpages = 'qv.customer.edit';
$rootindex = $rootpages;
$object    = $client;
