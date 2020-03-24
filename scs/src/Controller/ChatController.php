<?php
declare(strict_types=1);

namespace App\Controller;

use \App\Model\Table\FeedsTable;
use \App\Model\Table\UsersTable;

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

            // FILES
            $attachment= $this->request->getData('media');
            $clientFileName = $attachment->getClientFilename();

            $baseFileName = basename($clientFileName);
            $mediaFileType = strtolower(pathinfo($clientFileName,PATHINFO_EXTENSION));
            
            $targetPath = null;
            $projectPath = '/var/www/html/scs';
            if ($mediaFileType == 'jpg' || $mediaFileType == 'png' || $mediaFileType == 'jpeg') {
                $targetPath = 'picture' . $baseFileName;
                $feed->image_file_name = $projectPath . $targetPath;
            } else if ($mediaFileType == 'mp4' || $mediaFileType == 'flv') {
                $targetPath = 'video' . $baseFileName;
                $feed->video_file_name = $projectPath . $targetPath;
            }
            
            if ($targetPath != null) {
                $attachment->moveTo($targetPath);
            } else {
                $this->Flash->error(__('File does not support.'));
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
        if ($this->request->is(['patch', 'post', 'put'])) {
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

}