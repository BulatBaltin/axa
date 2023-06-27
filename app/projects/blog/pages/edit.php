<?
$id = REQUEST::getParam('id');
$post = Post::find( $id );

// if(REQUEST::getParam('downloadBtn', false)) {
//     $imageUrl = REQUEST::getParam('image-file');
//     $regP = '/\.(jpe?g|png|gif|bmp)$/i';
//     if(preg_match($regP, $imageUrl)) {
//         // dump('* matched *');

//         $download = curl_init($imageUrl);
//         curl_setopt($download, CURLOPT_RETURNTRANSFER, true);

//         // curl_setopt($ch, CURLOPT_HTTPHEADER, ["content-type: application/json"]);
//         // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//         curl_setopt($download, CURLOPT_SSL_VERIFYPEER, false);

//         //execute post
//         $downloadImgLink = curl_exec($download);
//         $err = curl_error($download);
//         curl_close($download);

//         if ($err) {
//             dump( ">>> cURL Error #:" . $err );
//             dump('*',$imageUrl, '*');
//             die;
//         }
//         // $fullFileName = asset('images/') . $post['image_path'];
//         $fullFileName = PUBLIC_HTML . 'images/' . $post['image_path'];
//         $fullFileName = basename($fullFileName);
//         // dump($fullFileName);
//         // die;

//         header('Content-type: image/jpg');
//         header('Content-Disposition: attachment;filename="' . basename($fullFileName) . '";');
//         echo $downloadImgLink;


//     }
// }
