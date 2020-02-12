<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * StudentResults Controller
 *
 * @property \App\Model\Table\StudentResultsTable $StudentResults
 *
 * @method \App\Model\Entity\StudentResult[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentResultsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $query = $this->StudentResults->find()
            ->contain(['Users', 'Forms'])
            ->where(['user_id' => $this->Authentication->getIdentity()->getIdentifier()])
            ->where(['published' => true]);
        $studentResults = $this->paginate($query);

        $this->set(compact('studentResults'));
    }

    /**
     * View method
     *
     * @param string|null $id Student Result id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $studentResult = $this->StudentResults->get($id, [
            'contain' => ['Users', 'Forms'],
        ]);

        $this->set('studentResult', $studentResult);
    }
}
