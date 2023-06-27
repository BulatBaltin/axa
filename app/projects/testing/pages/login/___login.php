<?
namespace MicrosoftAzure\Storage\Blob;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Queue\QueueRestProxy;
use MicrosoftAzure\Storage\Table\TableRestProxy;
use MicrosoftAzure\Storage\File\FileRestProxy;

$isAADauth = true;
// To create any Microsoft Azure service client you need to use the rest proxy classes, such as BlobRestProxy class:

// $proxy = new BlobRestProxy;
$myAccount = 'bulat.baltin@gmail.com';
$myKey = '';
$token = '';

if($isAADauth) {
// if AAD authentication is used:
    $connectionString = "
    BlobEndpoint=myBlobEndpoint;QueueEndpoint=myQueueEndpoint;TableEndpoint=myTableEndpoint;FileEndpoint=myFileEndpoint;AccountName={$myAccount}
    ";
} else {
    $connectionString = "
    DefaultEndpointsProtocol=[http|https];AccountName={$myAccount};AccountKey={$myKey}
    ";
}

if($isAADauth) {
    $blobClient = BlobRestProxy::createBlobServiceWithTokenCredential($token, $connectionString);
    $queueClient = QueueRestProxy::createQueueServiceWithTokenCredential($token, $connectionString);
} else {
    $blobClient = BlobRestProxy::createBlobService($connectionString);
    $tableClient = TableRestProxy::createTableService($connectionString);
    $queueClient = QueueRestProxy::createQueueService($connectionString);
    $fileClient = FileRestProxy::createFileService($connectionString);
}

$authOk = "Ok";