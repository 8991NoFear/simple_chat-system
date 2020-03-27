<?php
declare(strict_types=1);

namespace App\Controller;

use \App\Model\Table\FeedsTable;
use \App\Model\Table\UsersTable;
use \Cake\Routing\Router;

class ChatController extends AppController
{  
    public function initialize(): void
    {
        parent::initialize();
        
        $this->loadModel('Feeds');
        $this->loadModel('Users');
    }

    public function index()
    {
        $feeds = $this->Feeds->find('all');
        $this->set(compact('feeds'));
    }

    public function post()
    {
        $feed = $this->Feeds->newEmptyEntity();

        if ($this->request->is('post')) {
            $feed = $this->Feeds->patchEntity($feed, $this->request->getData(), ['fields' => ['name', 'message']]);
            $feed->user_id = $this->Authentication->getIdentity()->id;
            $mediaFile = $this->request->getData('media');

            if (!empty($mediaFile->getClientFilename())) {
                $this->uploadMediaFile($feed, $mediaFile);
            }

            if ($this->Feeds->save($feed)) {
                $this->Flash->success(__('Posted success'));
            } else {
                $this->Flash->error(__('Posted Failure'));
            } 

        }

        return $this->redirect(['action' => 'index']);
    }

    public function delete($id = null)
    {
        $feed = $this->Feeds->get($id);

        if ($this->Feeds->delete($feed)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function edit($id = null)
    {
        $feed = $this->Feeds->get($id);

        if ($this->request->is(['post'])) {
            $feed = $this->Feeds->patchEntity($feed, $this->request->getData(), ['fields' => ['name', 'message']]);
            $feed->user_id = $this->Authentication->getIdentity()->id;

            if ($this->Feeds->save($feed)) {
                $this->Flash->success(__('Updated success.'));
            } else {
                $this->Flash->error(__('Updated failure. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    private function checkTypeFile($extension = null)
    {
        $res = null;
        $extension = strtolower($extension);

        if ($extension == 'jpg' || $extension == 'gif' || $extension == 'png' || $extension == 'jpeg') {
            $res = 'photo';
        } else if ($extension == 'mp4' || $extension == 'avi' || $extension == 'wmv' || $extension == 'mov') {
            $res = 'video';
        }
        
        return $res;
    }

    private function uploadMediaFile($feed , $mediaFile): void
    {  
        $targetPath = null;
        $clientFileName = $mediaFile->getClientFilename();
        $baseName = basename($clientFileName);
        $extension = pathinfo($clientFileName, PATHINFO_EXTENSION);
        $baseUrl = Router::fullbaseUrl();
        $vendorUrl = $baseUrl . '/scs/webroot/';
        $feed->image_file_name = null;
        $feed->video_file_name = null;

        if ($this->checkTypeFile($extension) == 'photo') {
            $targetPath = 'photos/' . $baseName;
            $feed->image_file_name = $vendorUrl . $targetPath;
        } else if ($this->checkTypeFile($extension) == 'video') {
            $targetPath = 'videos/' . $baseName;
            $feed->video_file_name = $vendorUrl . $targetPath;
        } else {
            $this->Flash->error(__('File does not support.'));
        }
        
        if ($targetPath != null) {
            $mediaFile->moveTo($targetPath);
            $res = true;
        } else {
            $this->Flash->error(__('Cannot upload that file.'));
        }
    }

}